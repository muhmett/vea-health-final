<?php
/**
 * The alert that reaches the coordinator's phone.
 *
 * A lead that nobody sees for an hour is a lead that has already gone to
 * whichever clinic answered first. HubSpot does notify, but only after the
 * lead has synced, only through its own app, and only to somebody logged in.
 * This is the direct path: the moment the enquiry is stored, a Telegram
 * message lands on the coordinator's phone with the number already made into
 * a WhatsApp button, so replying is one tap rather than a login.
 *
 * Three rules govern the file, the same three the CRM module holds to.
 *
 * 1. THE VISITOR NEVER WAITS. The alert is sent after the response has been
 *    handed back and the connection closed, so a slow or unreachable Telegram
 *    cannot make the form feel broken.
 *
 * 2. THE TOKEN IS NEVER PRINTED. A Telegram token sits in the request URL
 *    rather than a header, which makes it far easier to leak through an error
 *    string than a bearer token — so every message stored or shown is scrubbed
 *    of it first, and it can live in wp-config.php instead of the database.
 *
 * 3. FAILURES ARE VISIBLE AND RETRYABLE. An alert that did not arrive says so
 *    in the Enquiries list, and a chat that already got it is not sent it twice
 *    when the others are retried.
 *
 * @package VeaHealth
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const VEAHEALTH_TG_API   = 'https://api.telegram.org/bot';
const VEAHEALTH_TG_EVENT = 'veahealth_alert_send';
const VEAHEALTH_TG_TRIES = 3;

/* ==========================================================================
   Credentials
   ========================================================================== */

/**
 * The bot token.
 *
 * A constant in wp-config.php wins over the stored option, for the same reason
 * it does with the CRM: a secret in a file outside the database does not travel
 * in every backup.
 *
 * @return string
 */
function veahealth_tg_token() {
	if ( defined( 'VEAHEALTH_TELEGRAM_TOKEN' ) && VEAHEALTH_TELEGRAM_TOKEN ) {
		return (string) VEAHEALTH_TELEGRAM_TOKEN;
	}
	return (string) get_option( 'veahealth_tg_token', '' );
}

/**
 * Every chat the alert goes to.
 *
 * More than one is the normal case: a coordinator, a second coordinator for
 * the evenings, and often a group so the whole desk sees it at once. Group ids
 * are negative, which is why this is not a digits-only filter.
 *
 * @return string[]
 */
function veahealth_tg_chats() {
	$raw  = (string) get_option( 'veahealth_tg_chats', '' );
	$out  = array();
	foreach ( preg_split( '/[\s,;]+/', $raw ) as $chat ) {
		$chat = trim( $chat );
		if ( '' !== $chat && preg_match( '/^-?\d+$/', $chat ) ) {
			$out[] = $chat;
		}
	}
	return array_values( array_unique( $out ) );
}

/** Is the alert configured end to end? A token with nowhere to send is not. */
function veahealth_tg_ready() {
	return '' !== veahealth_tg_token() && array() !== veahealth_tg_chats();
}

/**
 * Remove the token from anything about to be stored or displayed.
 *
 * Telegram authenticates in the path, so the token is part of every request
 * URL — and a cURL failure will happily quote the URL back at you. Nothing
 * leaves this file without going through here first.
 *
 * @param string $text Text that may contain the token.
 * @return string
 */
function veahealth_tg_scrub( $text ) {
	$token = veahealth_tg_token();
	$text  = (string) $text;
	if ( '' !== $token ) {
		$text = str_replace( $token, '***', $text );
		// The numeric bot id before the colon identifies the bot on its own.
		$bot = strtok( $token, ':' );
		if ( $bot ) {
			$text = str_replace( $bot, '***', $text );
		}
	}
	return $text;
}

/* ==========================================================================
   Transport
   ========================================================================== */

/**
 * One Bot API call.
 *
 * @param string $method  Bot API method name.
 * @param array  $body    Parameters.
 * @param int    $timeout Seconds.
 * @return array{ok:bool,status:int,body:array,error:string}
 */
function veahealth_tg_call( $method, $body = array(), $timeout = 8 ) {
	$token = veahealth_tg_token();
	if ( '' === $token ) {
		return array( 'ok' => false, 'status' => 0, 'body' => array(), 'error' => 'not_configured' );
	}

	$res = wp_remote_post(
		VEAHEALTH_TG_API . $token . '/' . $method,
		array(
			'timeout' => $timeout,
			'headers' => array( 'Content-Type' => 'application/json' ),
			'body'    => wp_json_encode( $body ),
		)
	);

	if ( is_wp_error( $res ) ) {
		// Reduced to the code: a transport message can quote the URL, and the
		// URL is where the token lives.
		return array( 'ok' => false, 'status' => 0, 'body' => array(), 'error' => 'transport:' . $res->get_error_code() );
	}

	$status = (int) wp_remote_retrieve_response_code( $res );
	$parsed = json_decode( wp_remote_retrieve_body( $res ), true );
	$parsed = is_array( $parsed ) ? $parsed : array();
	$ok     = ! empty( $parsed['ok'] );

	$error = '';
	if ( ! $ok ) {
		$error = isset( $parsed['description'] ) ? sanitize_text_field( $parsed['description'] ) : 'http_' . $status;
		$error = veahealth_tg_scrub( $error );
	}

	return array( 'ok' => $ok, 'status' => $status, 'body' => $parsed, 'error' => $error );
}

/**
 * Would this failure pass on its own?
 *
 * A wrong token, a chat that does not exist, a bot the coordinator has blocked
 * — none of those fix themselves, and retrying them just burns the queue. A
 * network drop, a rate limit and a 5xx do fix themselves.
 *
 * @param int $status HTTP status, 0 for a transport failure.
 */
function veahealth_tg_retryable( $status ) {
	return 0 === $status || 429 === $status || $status >= 500;
}

/* ==========================================================================
   The message
   ========================================================================== */

/**
 * Build the alert body.
 *
 * Written to be read on a lock screen: who, where from, what they want, and
 * the number — in that order, because that is the order the coordinator needs
 * them in. The free-text message is trimmed rather than sent whole; the point
 * of the alert is to get somebody to pick up the phone, not to replace the
 * record.
 *
 * @param int $post_id Enquiry post.
 * @return string HTML for Telegram's HTML parse mode.
 */
function veahealth_alert_text( $post_id ) {
	$post = get_post( $post_id );
	$meta = static function ( $key ) use ( $post_id ) {
		return trim( (string) get_post_meta( $post_id, $key, true ) );
	};
	$esc = static function ( $value ) {
		return htmlspecialchars( (string) $value, ENT_NOQUOTES, 'UTF-8' );
	};

	$treat = $meta( '_vh_treatments' );
	$lines = array();

	$lines[] = '🔔 <b>' . $esc( __( 'New enquiry', 'veahealth' ) ) . '</b>'
		. ( $treat ? ' — ' . $esc( $treat ) : '' );
	$lines[] = '';
	$lines[] = '<b>' . $esc( $post ? $post->post_title : '' ) . '</b>';

	if ( $meta( '_vh_country' ) ) {
		$lines[] = $esc( $meta( '_vh_country' ) );
	}
	if ( $meta( '_vh_phone' ) ) {
		$lines[] = '📞 ' . $esc( $meta( '_vh_phone' ) );
	}
	if ( $meta( '_vh_email' ) ) {
		$lines[] = '✉️ ' . $esc( $meta( '_vh_email' ) );
	}

	$lines[] = '';
	if ( $meta( '_vh_timing' ) ) {
		$lines[] = $esc( sprintf( '%s: %s', __( 'Timing', 'veahealth' ), $meta( '_vh_timing' ) ) );
	}
	if ( $meta( '_vh_page' ) ) {
		$lines[] = $esc( sprintf( '%s: %s', __( 'From', 'veahealth' ), $meta( '_vh_page' ) ) );
	}

	$message = $meta( '_vh_message' );
	if ( '' !== $message ) {
		// Telegram caps a message at 4096 characters and the form takes 4000,
		// so this is a real limit, not a stylistic one.
		if ( mb_strlen( $message ) > 600 ) {
			$message = mb_substr( $message, 0, 600 ) . '…';
		}
		$lines[] = '';
		$lines[] = '<i>' . $esc( $message ) . '</i>';
	}

	return implode( "\n", $lines );
}

/**
 * The buttons under the alert.
 *
 * The WhatsApp one is the whole point: the coordinator taps it and is in the
 * conversation, instead of copying a number out of a CRM. Telegram only
 * accepts publicly reachable http(s) URLs in an inline button, so the admin
 * link is offered only when the site actually has one.
 *
 * @param int $post_id Enquiry post.
 * @return array|null reply_markup, or null when there is nothing to show.
 */
function veahealth_alert_buttons( $post_id ) {
	$row   = array();
	$phone = preg_replace( '/\D/', '', (string) get_post_meta( $post_id, '_vh_phone', true ) );

	if ( strlen( $phone ) >= 8 ) {
		$row[] = array(
			'text' => __( 'WhatsApp', 'veahealth' ),
			'url'  => 'https://wa.me/' . $phone,
		);
	}

	/*
	 * Built rather than fetched from get_edit_post_link(), which checks the
	 * current user's capabilities and so returns nothing at all here — the
	 * alert is composed on the tail of an anonymous visitor's request, where
	 * there is no current user. The address is not the secret; opening it
	 * still demands a login and the capability to edit.
	 */
	$edit = admin_url( 'post.php?post=' . (int) $post_id . '&action=edit' );
	if ( wp_http_validate_url( $edit ) ) {
		$row[] = array(
			'text' => __( 'Open the enquiry', 'veahealth' ),
			'url'  => $edit,
		);
	}

	return $row ? array( 'inline_keyboard' => array( $row ) ) : null;
}

/* ==========================================================================
   Sending
   ========================================================================== */

/**
 * Send the alert for one enquiry.
 *
 * @param int $post_id Enquiry post.
 * @param int $attempt Which try this is.
 */
function veahealth_alert_send( $post_id, $attempt = 1 ) {
	$post = get_post( $post_id );
	if ( ! $post || 'vh_enquiry' !== $post->post_type ) {
		return;
	}
	if ( ! veahealth_tg_ready() ) {
		update_post_meta( $post_id, '_vh_tg_status', 'off' );
		return;
	}

	$chats = veahealth_tg_chats();
	// An unset meta reads back as an empty string, which casts to an array
	// holding one empty string — filtered off so the record stays chat ids only.
	$done  = array_filter( (array) get_post_meta( $post_id, '_vh_tg_done', true ) );
	$left  = array_diff( $chats, $done );

	if ( ! $left ) {
		update_post_meta( $post_id, '_vh_tg_status', 'ok' );
		return;
	}

	$text    = veahealth_alert_text( $post_id );
	$markup  = veahealth_alert_buttons( $post_id );
	$error   = '';
	$again   = false;

	foreach ( $left as $chat ) {
		$body = array(
			'chat_id'                  => $chat,
			'text'                     => $text,
			'parse_mode'               => 'HTML',
			'disable_web_page_preview' => true,
		);
		if ( $markup ) {
			$body['reply_markup'] = $markup;
		}

		$res = veahealth_tg_call( 'sendMessage', $body );

		if ( $res['ok'] ) {
			// Recorded per chat, so a retry for one coordinator does not send
			// the same lead twice to another.
			$done[] = $chat;
			continue;
		}

		$error = $res['error'];
		if ( veahealth_tg_retryable( $res['status'] ) ) {
			$again = true;
		}
	}

	update_post_meta( $post_id, '_vh_tg_done', array_values( array_unique( $done ) ) );

	if ( ! array_diff( $chats, $done ) ) {
		update_post_meta( $post_id, '_vh_tg_status', 'ok' );
		delete_post_meta( $post_id, '_vh_tg_error' );
		return;
	}

	update_post_meta( $post_id, '_vh_tg_error', $error );

	if ( $again && $attempt < VEAHEALTH_TG_TRIES ) {
		update_post_meta( $post_id, '_vh_tg_status', 'retrying' );
		wp_schedule_single_event( time() + ( 60 * $attempt ), VEAHEALTH_TG_EVENT, array( $post_id, $attempt + 1 ) );
	} else {
		update_post_meta( $post_id, '_vh_tg_status', 'failed' );
	}
}
add_action( VEAHEALTH_TG_EVENT, 'veahealth_alert_send', 10, 2 );

/**
 * Hand the response back before making the call.
 *
 * WP-Cron would be the tidy answer, but cron on a quiet site fires on the next
 * page view, which can be minutes — and minutes is precisely what this feature
 * exists to remove. So the response is closed off first and the alert goes out
 * on the tail of the same request: the visitor waits for nothing, and the
 * coordinator's phone rings while the visitor is still looking at the thank-you.
 */
function veahealth_alert_flush() {
	if ( function_exists( 'wp_ob_end_flush_all' ) ) {
		wp_ob_end_flush_all();
	}
	flush();
	if ( function_exists( 'fastcgi_finish_request' ) ) {
		fastcgi_finish_request();
	} elseif ( function_exists( 'litespeed_finish_request' ) ) {
		litespeed_finish_request();
	}
}

/**
 * Queue the alert for an enquiry that has just come in.
 *
 * @param int $post_id Enquiry post.
 */
function veahealth_alert_queue( $post_id ) {
	if ( ! veahealth_tg_ready() ) {
		return;
	}
	update_post_meta( $post_id, '_vh_tg_status', 'queued' );
	add_action(
		'shutdown',
		static function () use ( $post_id ) {
			veahealth_alert_flush();
			veahealth_alert_send( $post_id );
		},
		1
	);
}

/* ==========================================================================
   Settings
   ========================================================================== */

function veahealth_tg_menu() {
	add_submenu_page(
		'edit.php?post_type=vh_enquiry',
		__( 'Phone alerts', 'veahealth' ),
		__( 'Phone alerts', 'veahealth' ),
		'manage_options',
		'veahealth-alerts',
		'veahealth_tg_page'
	);
}
add_action( 'admin_menu', 'veahealth_tg_menu' );

function veahealth_tg_register() {
	register_setting( 'veahealth_tg', 'veahealth_tg_token', array( 'type' => 'string', 'sanitize_callback' => 'veahealth_tg_clean_token', 'default' => '' ) );
	register_setting( 'veahealth_tg', 'veahealth_tg_chats', array( 'type' => 'string', 'sanitize_callback' => 'veahealth_tg_clean_chats', 'default' => '' ) );
}
add_action( 'admin_init', 'veahealth_tg_register' );

/** Keep only what a bot token can contain. */
function veahealth_tg_clean_token( $value ) {
	$value = trim( (string) $value );
	return preg_replace( '/[^A-Za-z0-9:_\-]/', '', $value );
}

/** One id per line, groups keep their minus sign, anything else is dropped. */
function veahealth_tg_clean_chats( $value ) {
	$out = array();
	foreach ( preg_split( '/[\s,;]+/', (string) $value ) as $chat ) {
		$chat = trim( $chat );
		if ( '' !== $chat && preg_match( '/^-?\d+$/', $chat ) ) {
			$out[] = $chat;
		}
	}
	return implode( "\n", array_values( array_unique( $out ) ) );
}

function veahealth_tg_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$notice = null;
	$found  = null;

	// A real message to the real phones, because "the token is valid" is not
	// the question anybody is actually asking.
	if ( isset( $_POST['veahealth_tg_test'] ) && check_admin_referer( 'veahealth_tg_test' ) ) {
		if ( '' === veahealth_tg_token() ) {
			$notice = array( false, __( 'No token yet.', 'veahealth' ) );
		} elseif ( ! veahealth_tg_chats() ) {
			$me     = veahealth_tg_call( 'getMe' );
			$notice = $me['ok']
				? array( false, sprintf( __( 'The token works — the bot is @%s. Now add a chat id below.', 'veahealth' ), isset( $me['body']['result']['username'] ) ? $me['body']['result']['username'] : '?' ) )
				: array( false, sprintf( __( 'The token was refused: %s', 'veahealth' ), $me['error'] ) );
		} else {
			$ok   = 0;
			$last = '';
			foreach ( veahealth_tg_chats() as $chat ) {
				$res = veahealth_tg_call(
					'sendMessage',
					array(
						'chat_id'    => $chat,
						'text'       => '🔔 <b>' . esc_html__( 'Test alert', 'veahealth' ) . '</b>' . "\n" . esc_html__( 'Alerts are working. A real enquiry will look like this, with a WhatsApp button.', 'veahealth' ),
						'parse_mode' => 'HTML',
					)
				);
				if ( $res['ok'] ) {
					++$ok;
				} else {
					$last = $res['error'];
				}
			}
			$notice = $ok
				? array( true, sprintf( _n( 'Sent to %d chat. Check the phone.', 'Sent to %d chats. Check the phones.', $ok, 'veahealth' ), $ok ) )
				: array( false, sprintf( __( 'Nothing was delivered: %s', 'veahealth' ), $last ) );
		}
	}

	if ( isset( $_POST['veahealth_tg_find'] ) && check_admin_referer( 'veahealth_tg_find' ) ) {
		$res = veahealth_tg_call( 'getUpdates', array( 'limit' => 20 ) );
		if ( ! $res['ok'] ) {
			$notice = array( false, sprintf( __( 'Could not read the bot: %s', 'veahealth' ), $res['error'] ) );
		} else {
			$found = array();
			foreach ( (array) $res['body']['result'] as $update ) {
				foreach ( array( 'message', 'edited_message', 'channel_post', 'my_chat_member' ) as $key ) {
					if ( isset( $update[ $key ]['chat']['id'] ) ) {
						$chat = $update[ $key ]['chat'];
						$name = isset( $chat['title'] ) ? $chat['title'] : trim( ( isset( $chat['first_name'] ) ? $chat['first_name'] : '' ) . ' ' . ( isset( $chat['last_name'] ) ? $chat['last_name'] : '' ) );
						$found[ (string) $chat['id'] ] = array( $name, isset( $chat['type'] ) ? $chat['type'] : '' );
					}
				}
			}
		}
	}

	$fixed = defined( 'VEAHEALTH_TELEGRAM_TOKEN' ) && VEAHEALTH_TELEGRAM_TOKEN;
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Phone alerts', 'veahealth' ); ?></h1>

		<?php if ( $notice ) : ?>
			<div class="notice notice-<?php echo $notice[0] ? 'success' : 'error'; ?>"><p><?php echo esc_html( $notice[1] ); ?></p></div>
		<?php endif; ?>

		<p style="max-width:70ch">
			<?php esc_html_e( 'Every enquiry rings a Telegram chat the moment it is submitted, with the treatment, the country, the message and a WhatsApp button already carrying the number. It is sent after the visitor has their answer, so a slow Telegram never delays the form, and it does not wait on HubSpot — the coordinator can reply without logging in to anything.', 'veahealth' ); ?>
		</p>

		<h2><?php esc_html_e( 'Setting it up', 'veahealth' ); ?></h2>
		<ol style="max-width:70ch">
			<li><?php esc_html_e( 'In Telegram, open a chat with @BotFather and send /newbot. Give it a name and a username. It replies with a token that looks like 8123456789:AAF-…', 'veahealth' ); ?></li>
			<li><?php esc_html_e( 'Paste the token below and save.', 'veahealth' ); ?></li>
			<li><?php esc_html_e( 'Each coordinator opens the new bot and presses Start. For a whole desk, make a Telegram group instead, add the bot to it, and send one message in the group.', 'veahealth' ); ?></li>
			<li><?php esc_html_e( 'Press Find the chats below, copy the ids into the field, and save.', 'veahealth' ); ?></li>
			<li><?php esc_html_e( 'Press Send a test alert. The phone should buzz.', 'veahealth' ); ?></li>
		</ol>
		<p style="max-width:70ch" class="description">
			<?php esc_html_e( 'Telegram will not let a bot message somebody who has never written to it. That is a rule on their side, not a setting here — which is why step 3 exists.', 'veahealth' ); ?>
		</p>

		<?php if ( $fixed ) : ?>
			<div class="notice notice-info inline"><p>
				<?php esc_html_e( 'A token is set in wp-config.php, which takes priority over anything entered here. That is the more secure place for it.', 'veahealth' ); ?>
			</p></div>
		<?php endif; ?>

		<?php if ( null !== $found ) : ?>
			<h2><?php esc_html_e( 'Chats that have written to the bot', 'veahealth' ); ?></h2>
			<?php if ( ! $found ) : ?>
				<p><?php esc_html_e( 'None yet. Open the bot in Telegram, press Start, then try again.', 'veahealth' ); ?></p>
			<?php else : ?>
				<table class="widefat striped" style="max-width:48rem">
					<thead><tr>
						<th><?php esc_html_e( 'Chat id', 'veahealth' ); ?></th>
						<th><?php esc_html_e( 'Name', 'veahealth' ); ?></th>
						<th><?php esc_html_e( 'Type', 'veahealth' ); ?></th>
					</tr></thead>
					<tbody>
					<?php foreach ( $found as $id => $info ) : ?>
						<tr>
							<td><code><?php echo esc_html( $id ); ?></code></td>
							<td><?php echo esc_html( $info[0] ); ?></td>
							<td><?php echo esc_html( $info[1] ); ?></td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
			<?php endif; ?>
		<?php endif; ?>

		<form method="post" action="options.php">
			<?php settings_fields( 'veahealth_tg' ); ?>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><label for="tg_token"><?php esc_html_e( 'Bot token', 'veahealth' ); ?></label></th>
					<td>
						<input name="veahealth_tg_token" id="tg_token" type="password" class="regular-text"
						       autocomplete="off" value="<?php echo esc_attr( get_option( 'veahealth_tg_token', '' ) ); ?>"
						       placeholder="8123456789:AAF-xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx">
						<p class="description">
							<?php esc_html_e( 'Safer still: put it in wp-config.php as VEAHEALTH_TELEGRAM_TOKEN and leave this blank.', 'veahealth' ); ?>
						</p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="tg_chats"><?php esc_html_e( 'Send alerts to', 'veahealth' ); ?></label></th>
					<td>
						<textarea name="veahealth_tg_chats" id="tg_chats" rows="4" class="regular-text code"
						          placeholder="123456789&#10;-1001234567890"><?php echo esc_textarea( get_option( 'veahealth_tg_chats', '' ) ); ?></textarea>
						<p class="description">
							<?php esc_html_e( 'One chat id per line. A person is a positive number, a group is a negative one. Every id listed gets every enquiry.', 'veahealth' ); ?>
						</p>
					</td>
				</tr>
			</table>
			<?php submit_button(); ?>
		</form>

		<p>
		<form method="post" style="display:inline">
			<?php wp_nonce_field( 'veahealth_tg_find' ); ?>
			<input type="hidden" name="veahealth_tg_find" value="1">
			<?php submit_button( __( 'Find the chats', 'veahealth' ), 'secondary', 'submit', false ); ?>
		</form>
		<form method="post" style="display:inline;margin-left:.5rem">
			<?php wp_nonce_field( 'veahealth_tg_test' ); ?>
			<input type="hidden" name="veahealth_tg_test" value="1">
			<?php submit_button( __( 'Send a test alert', 'veahealth' ), 'secondary', 'submit', false ); ?>
		</form>
		</p>

		<h2><?php esc_html_e( 'What is sent', 'veahealth' ); ?></h2>
		<p style="max-width:70ch">
			<?php esc_html_e( 'The name, country, phone, email, treatment, timing and the first 600 characters of the message go to the chats listed above. Telegram is therefore a processor of enquiry data and belongs in the privacy policy alongside HubSpot. Keep the bot private: anyone added to one of these chats can read every enquiry.', 'veahealth' ); ?>
		</p>
	</div>
	<?php
}

/* ==========================================================================
   Visibility in the enquiries list
   ========================================================================== */

function veahealth_tg_column( $cols ) {
	$cols['vh_tg'] = __( 'Alert', 'veahealth' );
	return $cols;
}
add_filter( 'manage_vh_enquiry_posts_columns', 'veahealth_tg_column' );

function veahealth_tg_column_body( $col, $post_id ) {
	if ( 'vh_tg' !== $col ) {
		return;
	}
	$status = get_post_meta( $post_id, '_vh_tg_status', true );
	$map    = array(
		'ok'       => array( '#157A56', __( 'Delivered', 'veahealth' ) ),
		'queued'   => array( '#9A6212', __( 'Queued', 'veahealth' ) ),
		'retrying' => array( '#9A6212', __( 'Retrying', 'veahealth' ) ),
		'failed'   => array( '#A3291B', __( 'Failed', 'veahealth' ) ),
		'off'      => array( '#6b7280', __( 'Not set up', 'veahealth' ) ),
	);
	if ( ! isset( $map[ $status ] ) ) {
		echo '<span style="color:#6b7280">—</span>';
		return;
	}
	printf( '<span style="color:%s">%s</span>', esc_attr( $map[ $status ][0] ), esc_html( $map[ $status ][1] ) );

	$error = get_post_meta( $post_id, '_vh_tg_error', true );
	if ( $error && in_array( $status, array( 'failed', 'retrying' ), true ) ) {
		printf( '<br><span class="description">%s</span>', esc_html( veahealth_tg_scrub( $error ) ) );
	}
	if ( 'failed' === $status ) {
		printf(
			'<br><a href="%s">%s</a>',
			esc_url( wp_nonce_url( admin_url( 'edit.php?post_type=vh_enquiry&veahealth_tg_retry=' . $post_id ), 'veahealth_tg_retry_' . $post_id ) ),
			esc_html__( 'Send again', 'veahealth' )
		);
	}
}
add_action( 'manage_vh_enquiry_posts_custom_column', 'veahealth_tg_column_body', 10, 2 );

function veahealth_tg_retry() {
	if ( ! isset( $_GET['veahealth_tg_retry'] ) ) {
		return;
	}
	$post_id = (int) $_GET['veahealth_tg_retry'];
	if ( ! current_user_can( 'manage_options' ) || ! check_admin_referer( 'veahealth_tg_retry_' . $post_id ) ) {
		return;
	}
	veahealth_alert_send( $post_id );
	wp_safe_redirect( admin_url( 'edit.php?post_type=vh_enquiry' ) );
	exit;
}
add_action( 'admin_init', 'veahealth_tg_retry' );

/* ==========================================================================
   Privacy
   ========================================================================== */

/**
 * Name Telegram in the privacy policy while it is actually in use.
 *
 * Enquiry details going to a Telegram chat makes Telegram a processor of that
 * data as surely as HubSpot is, so it is disclosed on the same terms — and the
 * paragraph disappears again if the alerts are turned off, so the policy never
 * names a company the clinic is not using.
 *
 * @param string $content Post content.
 * @return string
 */
function veahealth_tg_privacy_note( $content ) {
	if ( ! is_page() || ! veahealth_tg_ready() || is_admin() ) {
		return $content;
	}
	$page = get_post();
	if ( ! $page || 'privacy-policy' !== $page->post_name ) {
		return $content;
	}

	$note = '<p class="vh-processor-note">' . esc_html__(
		'Alerting our coordinators. So that somebody answers you quickly, a summary of your enquiry — your name, country, telephone number, email address, the treatment you asked about and your message — is sent to our coordinators through Telegram, a messaging service, as soon as you submit the form. Telegram carries the message on our instructions; only our own staff can read it. You can ask us to delete it at any time using the contact details above.',
		'veahealth'
	) . '</p>';

	if ( preg_match( '#(<h2[^>]*>\s*Who we share it with\s*</h2>.*?)(<h2)#is', $content, $m ) ) {
		return str_replace( $m[0], $m[1] . $note . $m[2], $content );
	}
	return $content . $note;
}
add_filter( 'the_content', 'veahealth_tg_privacy_note', 21 );

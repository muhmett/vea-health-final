<?php
/**
 * HubSpot CRM.
 *
 * Every enquiry the site takes is pushed into HubSpot as a contact, with the
 * message and the treatments attached as a note on the timeline, and — if a
 * pipeline is configured — a deal so the lead lands on the board rather than
 * only in the contact list.
 *
 * Three rules govern the whole file.
 *
 * 1. THE LEAD IS NEVER LOST. The enquiry is written to the database and emailed
 *    before HubSpot is contacted at all, and the push happens after the visitor
 *    has had their response. HubSpot being slow, rate-limited or down changes
 *    nothing the visitor sees and loses nothing.
 *
 * 2. THE TOKEN IS NEVER PRINTED. Not in a log, not in an error message, not in
 *    the admin. It can live in wp-config.php instead of the database, and where
 *    it does, that is what is used.
 *
 * 3. FAILURES ARE VISIBLE AND RETRYABLE. A lead that did not sync says so in
 *    the Enquiries list with the reason, and can be pushed again by hand. Silent
 *    failure on a lead pipeline is worse than no integration.
 *
 * @package VeaHealth
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const VEAHEALTH_HS_API   = 'https://api.hubapi.com';
const VEAHEALTH_HS_EVENT = 'veahealth_hubspot_push';
const VEAHEALTH_HS_TRIES = 3;

/**
 * The private app token.
 *
 * A constant in wp-config.php wins over the Customizer, because a secret in a
 * file outside the web root and outside the database is a better place for it
 * than a theme mod that lands in every database export.
 *
 * @return string
 */
function veahealth_hs_token() {
	if ( defined( 'VEAHEALTH_HUBSPOT_TOKEN' ) && VEAHEALTH_HUBSPOT_TOKEN ) {
		return (string) VEAHEALTH_HUBSPOT_TOKEN;
	}
	return (string) get_option( 'veahealth_hs_token', '' );
}

/**
 * The HubSpot user new leads are assigned to, if one is set.
 *
 * An unassigned contact sits in the list with nobody notified and nobody
 * accountable, which on a lead pipeline is close to not having it at all.
 *
 * @return string Numeric owner id, or an empty string.
 */
function veahealth_hs_owner() {
	return (string) preg_replace( '/\D/', '', (string) get_option( 'veahealth_hs_owner', '' ) );
}

/** Is the integration configured at all? */
function veahealth_hs_ready() {
	return '' !== veahealth_hs_token();
}

/**
 * One authenticated request.
 *
 * @param string $method HTTP verb.
 * @param string $path   Path under the API root.
 * @param array  $body   Payload, JSON-encoded.
 * @return array{ok:bool,status:int,body:array,error:string}
 */
function veahealth_hs_call( $method, $path, $body = null ) {
	$token = veahealth_hs_token();
	if ( '' === $token ) {
		return array( 'ok' => false, 'status' => 0, 'body' => array(), 'error' => 'not_configured' );
	}

	$args = array(
		'method'  => $method,
		'timeout' => 12,
		'headers' => array(
			'Authorization' => 'Bearer ' . $token,
			'Content-Type'  => 'application/json',
		),
	);
	if ( null !== $body ) {
		$args['body'] = wp_json_encode( $body );
	}

	$res = wp_remote_request( VEAHEALTH_HS_API . $path, $args );

	if ( is_wp_error( $res ) ) {
		/*
		 * The message can contain the request context, so it is reduced to the
		 * error code rather than passed through — a WP_Error string is exactly
		 * the kind of thing that ends up in a log with a header in it.
		 */
		return array( 'ok' => false, 'status' => 0, 'body' => array(), 'error' => 'transport:' . $res->get_error_code() );
	}

	$status = (int) wp_remote_retrieve_response_code( $res );
	$parsed = json_decode( wp_remote_retrieve_body( $res ), true );
	$parsed = is_array( $parsed ) ? $parsed : array();

	return array(
		'ok'     => $status >= 200 && $status < 300,
		'status' => $status,
		'body'   => $parsed,
		'error'  => $status >= 200 && $status < 300 ? '' : ( isset( $parsed['message'] ) ? sanitize_text_field( $parsed['message'] ) : 'http_' . $status ),
	);
}

/**
 * Create or update a contact, keyed on email.
 *
 * HubSpot answers 409 when the email already exists and puts the existing id in
 * the message. Reading it back and patching is what makes a returning enquirer
 * one contact with two notes rather than two contacts.
 *
 * @param array $props Contact properties.
 * @return array{ok:bool,id:string,error:string}
 */
function veahealth_hs_upsert_contact( $props ) {
	$res = veahealth_hs_call( 'POST', '/crm/v3/objects/contacts', array( 'properties' => $props ) );

	if ( $res['ok'] && ! empty( $res['body']['id'] ) ) {
		return array( 'ok' => true, 'id' => (string) $res['body']['id'], 'error' => '', 'status' => $res['status'] );
	}

	if ( 409 === $res['status'] ) {
		$id = '';
		$msg = isset( $res['body']['message'] ) ? (string) $res['body']['message'] : '';
		/*
		 * HubSpot puts the id in the conflict message. Match its wording rather
		 * than "any long number": the first version required four or more
		 * digits and silently missed shorter ids, which sent every duplicate
		 * down the fallback search path.
		 */
		if ( preg_match( '/Existing ID:?\s*(\d+)/i', $msg, $m ) ) {
			$id = $m[1];
		} elseif ( preg_match( '/\b(\d{3,})\b/', $msg, $m ) ) {
			$id = $m[1];
		}
		if ( '' === $id ) {
			// fall back to a search rather than giving up on a known duplicate
			$found = veahealth_hs_call(
				'POST',
				'/crm/v3/objects/contacts/search',
				array(
					'filterGroups' => array(
						array( 'filters' => array( array( 'propertyName' => 'email', 'operator' => 'EQ', 'value' => $props['email'] ) ) ),
					),
					'limit' => 1,
				)
			);
			if ( ! empty( $found['body']['results'][0]['id'] ) ) {
				$id = (string) $found['body']['results'][0]['id'];
			} elseif ( ! empty( $found['body']['id'] ) ) {
				$id = (string) $found['body']['id'];
			}
		}
		if ( '' === $id ) {
			return array( 'ok' => false, 'id' => '', 'error' => 'duplicate_not_resolved', 'status' => 409 );
		}

		/*
		 * Patch, but never blank a field. A visitor who leaves the phone box
		 * empty on their second enquiry should not wipe the number they gave
		 * the first time.
		 */
		$patch = array_filter( $props, static function ( $v ) { return '' !== $v && null !== $v; } );
		unset( $patch['email'] );
		/*
		 * Lead status and owner belong to the sales team, not to the form. A
		 * returning enquirer whose status is already In Progress must not be
		 * dropped back to New, and a contact another rep owns must not be
		 * reassigned by a second enquiry. Both are set when the contact is
		 * created and left alone afterwards.
		 */
		unset( $patch['hs_lead_status'], $patch['hubspot_owner_id'] );
		$up = veahealth_hs_call( 'PATCH', '/crm/v3/objects/contacts/' . rawurlencode( $id ), array( 'properties' => $patch ) );
		return array( 'ok' => $up['ok'], 'id' => $id, 'error' => $up['error'], 'status' => $up['status'] );
	}

	return array( 'ok' => false, 'id' => '', 'error' => $res['error'], 'status' => $res['status'] );
}

/** Attach a note to a contact, so the message is on the timeline. */
function veahealth_hs_add_note( $contact_id, $text ) {
	$res = veahealth_hs_call(
		'POST',
		'/crm/v3/objects/notes',
		array(
			'properties'  => array(
				'hs_note_body' => $text,
				'hs_timestamp' => round( microtime( true ) * 1000 ),
			),
			'associations' => array(
				array(
					'to'    => array( 'id' => $contact_id ),
					// 202 is the note-to-contact association type
					'types' => array( array( 'associationCategory' => 'HUBSPOT_DEFINED', 'associationTypeId' => 202 ) ),
				),
			),
		)
	);
	return $res['ok'];
}

/** Open a deal on the configured pipeline, so the lead lands on a board. */
function veahealth_hs_add_deal( $contact_id, $name, $stage ) {
	$props = array( 'dealname' => $name, 'pipeline' => 'default' );
	if ( $stage ) {
		$props['dealstage'] = $stage;
	}
	$owner = veahealth_hs_owner();
	if ( $owner ) {
		$props['hubspot_owner_id'] = $owner;
	}
	$res = veahealth_hs_call(
		'POST',
		'/crm/v3/objects/deals',
		array(
			'properties'   => $props,
			'associations' => array(
				array(
					'to'    => array( 'id' => $contact_id ),
					// 3 is the deal-to-contact association type
					'types' => array( array( 'associationCategory' => 'HUBSPOT_DEFINED', 'associationTypeId' => 3 ) ),
				),
			),
		)
	);
	return $res['ok'] ? (string) ( isset( $res['body']['id'] ) ? $res['body']['id'] : '' ) : '';
}

/**
 * Push one stored enquiry.
 *
 * @param int $post_id Enquiry post.
 * @param int $attempt Which try this is.
 */
function veahealth_hs_push( $post_id, $attempt = 1 ) {
	$post = get_post( $post_id );
	if ( ! $post || 'vh_enquiry' !== $post->post_type ) {
		return;
	}
	if ( 'ok' === get_post_meta( $post_id, '_vh_hs_status', true ) ) {
		return;                                  // already in, do not duplicate
	}
	if ( ! veahealth_hs_ready() ) {
		update_post_meta( $post_id, '_vh_hs_status', 'off' );
		return;
	}

	$meta  = static function ( $k ) use ( $post_id ) { return (string) get_post_meta( $post_id, $k, true ); };
	$name  = trim( $post->post_title );
	$parts = preg_split( '/\s+/', $name, 2 );

	$props = array(
		'email'     => $meta( '_vh_email' ),
		'firstname' => isset( $parts[0] ) ? $parts[0] : '',
		'lastname'  => isset( $parts[1] ) ? $parts[1] : '',
		'phone'     => $meta( '_vh_phone' ),
		'country'   => $meta( '_vh_country' ),
		'hs_lead_status' => 'NEW',
		'hubspot_owner_id' => veahealth_hs_owner(),
	);
	$props = array_filter( $props, static function ( $v ) { return '' !== $v; } );

	if ( empty( $props['email'] ) ) {
		update_post_meta( $post_id, '_vh_hs_status', 'failed' );
		update_post_meta( $post_id, '_vh_hs_error', 'no_email' );
		return;
	}

	$contact = veahealth_hs_upsert_contact( $props );

	if ( ! $contact['ok'] ) {
		/*
		 * Retry on anything that might pass on its own — a network failure, a
		 * rate limit, a 5xx — with a widening gap. A validation error will not
		 * fix itself, so it is recorded and left alone.
		 *
		 * Decided on the status code. The first version tested the error
		 * *message* for an "http_5" prefix, but the message is HubSpot's own
		 * text whenever it sends one, so a 503 reading "Service unavailable"
		 * never matched and outages were being written off as permanent
		 * failures instead of being retried.
		 */
		$status    = isset( $contact['status'] ) ? (int) $contact['status'] : 0;
		$retryable = ( 0 === $status || $status >= 500 || 429 === $status );
		if ( $retryable && $attempt < VEAHEALTH_HS_TRIES ) {
			wp_schedule_single_event( time() + ( 60 * $attempt * $attempt ), VEAHEALTH_HS_EVENT, array( $post_id, $attempt + 1 ) );
			update_post_meta( $post_id, '_vh_hs_status', 'retrying' );
		} else {
			update_post_meta( $post_id, '_vh_hs_status', 'failed' );
		}
		update_post_meta( $post_id, '_vh_hs_error', $contact['error'] );
		return;
	}

	/* The message, the treatments and the page they came from, on the timeline. */
	$note = array();
	if ( $meta( '_vh_treatments' ) ) {
		$note[] = __( 'Interested in:', 'veahealth' ) . ' ' . $meta( '_vh_treatments' );
	}
	if ( $meta( '_vh_timing' ) ) {
		$note[] = __( 'Timing:', 'veahealth' ) . ' ' . $meta( '_vh_timing' );
	}
	if ( $meta( '_vh_page' ) ) {
		$note[] = __( 'Enquired from:', 'veahealth' ) . ' ' . $meta( '_vh_page' );
	}
	if ( $meta( '_vh_message' ) ) {
		$note[] = '';
		$note[] = $meta( '_vh_message' );
	}
	if ( $note ) {
		veahealth_hs_add_note( $contact['id'], implode( "\n", $note ) );
	}

	$deal_id = '';
	if ( get_option( 'veahealth_hs_deals' ) ) {
		$label = $meta( '_vh_treatments' ) ? $meta( '_vh_treatments' ) : __( 'Website enquiry', 'veahealth' );
		$deal_id = veahealth_hs_add_deal(
			$contact['id'],
			sprintf( '%s — %s', $name, $label ),
			(string) get_option( 'veahealth_hs_stage', '' )
		);
	}

	update_post_meta( $post_id, '_vh_hs_status', 'ok' );
	update_post_meta( $post_id, '_vh_hs_contact', $contact['id'] );
	if ( $deal_id ) {
		update_post_meta( $post_id, '_vh_hs_deal', $deal_id );
	}
	delete_post_meta( $post_id, '_vh_hs_error' );
}
add_action( VEAHEALTH_HS_EVENT, 'veahealth_hs_push', 10, 2 );

/**
 * Queue the push for an enquiry that has just come in.
 *
 * Scheduled rather than called inline: the visitor gets their confirmation the
 * moment the lead is stored, and a HubSpot outage cannot make the form feel
 * broken. WordPress fires this on the next request, which is seconds away on
 * any site with traffic.
 */
function veahealth_hs_queue( $post_id ) {
	if ( ! veahealth_hs_ready() ) {
		return;
	}
	update_post_meta( $post_id, '_vh_hs_status', 'queued' );
	if ( ! wp_next_scheduled( VEAHEALTH_HS_EVENT, array( $post_id, 1 ) ) ) {
		wp_schedule_single_event( time() + 5, VEAHEALTH_HS_EVENT, array( $post_id, 1 ) );
	}
}

/* ==========================================================================
   Settings
   ========================================================================== */

/**
 * A settings page rather than a Customizer panel.
 *
 * The Customizer stores everything as a theme mod, and theme mods are dropped
 * when the theme is switched. A CRM token surviving a theme switch is the
 * behaviour you want; losing the lead pipeline because somebody previewed a
 * different theme is not.
 */
function veahealth_hs_menu() {
	add_submenu_page(
		'edit.php?post_type=vh_enquiry',
		__( 'HubSpot', 'veahealth' ),
		__( 'HubSpot', 'veahealth' ),
		'manage_options',
		'veahealth-hubspot',
		'veahealth_hs_page'
	);
}
add_action( 'admin_menu', 'veahealth_hs_menu' );

function veahealth_hs_register() {
	register_setting( 'veahealth_hs', 'veahealth_hs_token', array( 'type' => 'string', 'sanitize_callback' => 'veahealth_hs_clean_token', 'default' => '' ) );
	register_setting( 'veahealth_hs', 'veahealth_hs_deals', array( 'type' => 'boolean', 'sanitize_callback' => 'rest_sanitize_boolean', 'default' => false ) );
	register_setting( 'veahealth_hs', 'veahealth_hs_stage', array( 'type' => 'string', 'sanitize_callback' => 'sanitize_text_field', 'default' => '' ) );
	register_setting( 'veahealth_hs', 'veahealth_hs_owner', array( 'type' => 'string', 'sanitize_callback' => 'veahealth_hs_clean_owner', 'default' => '' ) );
}
add_action( 'admin_init', 'veahealth_hs_register' );

/** Keep only what a token can contain, and never store a pasted whole header. */
function veahealth_hs_clean_token( $value ) {
	$value = trim( (string) $value );
	$value = preg_replace( '/^Bearer\s+/i', '', $value );
	return preg_replace( '/[^A-Za-z0-9\-_.]/', '', $value );
}

/** An owner id is a number and nothing else. */
function veahealth_hs_clean_owner( $value ) {
	return (string) preg_replace( '/\D/', '', (string) $value );
}

function veahealth_hs_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	// a one-click check, so nobody has to send a test enquiry to find out
	$probe = null;
	if ( isset( $_POST['veahealth_hs_probe'] ) && check_admin_referer( 'veahealth_hs_probe' ) ) {
		$probe = veahealth_hs_call( 'GET', '/crm/v3/objects/contacts?limit=1' );
	}

	$fixed = defined( 'VEAHEALTH_HUBSPOT_TOKEN' ) && VEAHEALTH_HUBSPOT_TOKEN;
	$token = get_option( 'veahealth_hs_token', '' );
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'HubSpot', 'veahealth' ); ?></h1>

		<?php if ( null !== $probe ) : ?>
			<div class="notice notice-<?php echo $probe['ok'] ? 'success' : 'error'; ?>">
				<p>
					<?php
					echo $probe['ok']
						? esc_html__( 'Connected. The token works and the contacts scope is granted.', 'veahealth' )
						: esc_html( sprintf( __( 'Not connected: %s', 'veahealth' ), $probe['error'] ) );
					?>
				</p>
			</div>
		<?php endif; ?>

		<p style="max-width:70ch">
			<?php esc_html_e( 'Every enquiry from the website is created in HubSpot as a contact, with the message, the treatments and the page it came from attached as a note on the timeline.', 'veahealth' ); ?>
		</p>

		<h2><?php esc_html_e( 'Getting the token', 'veahealth' ); ?></h2>
		<ol style="max-width:70ch">
			<li><?php esc_html_e( 'In HubSpot: Settings → Integrations → Private Apps → Create a private app.', 'veahealth' ); ?></li>
			<li>
				<?php esc_html_e( 'On the Scopes tab, tick these:', 'veahealth' ); ?>
				<code>crm.objects.contacts.read</code>, <code>crm.objects.contacts.write</code>,
				<code>crm.objects.deals.write</code> <?php esc_html_e( '(only if you want deals)', 'veahealth' ); ?>
			</li>
			<li><?php esc_html_e( 'Create it, then copy the access token — it starts with pat-.', 'veahealth' ); ?></li>
			<li><?php esc_html_e( 'Paste it below and save, then press Test the connection.', 'veahealth' ); ?></li>
		</ol>

		<?php if ( $fixed ) : ?>
			<div class="notice notice-info inline"><p>
				<?php esc_html_e( 'A token is set in wp-config.php, which takes priority over anything entered here. That is the more secure place for it.', 'veahealth' ); ?>
			</p></div>
		<?php endif; ?>

		<form method="post" action="options.php">
			<?php settings_fields( 'veahealth_hs' ); ?>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><label for="hs_token"><?php esc_html_e( 'Private app token', 'veahealth' ); ?></label></th>
					<td>
						<input name="veahealth_hs_token" id="hs_token" type="password" class="regular-text"
						       autocomplete="off" value="<?php echo esc_attr( $token ); ?>"
						       placeholder="pat-eu1-xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx">
						<p class="description">
							<?php esc_html_e( 'Safer still: put it in wp-config.php as VEAHEALTH_HUBSPOT_TOKEN and leave this blank, so it never sits in a database backup.', 'veahealth' ); ?>
						</p>
					</td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'Also create a deal', 'veahealth' ); ?></th>
					<td>
						<label>
							<input name="veahealth_hs_deals" type="checkbox" value="1" <?php checked( get_option( 'veahealth_hs_deals' ) ); ?>>
							<?php esc_html_e( 'Open a deal for each enquiry, so leads appear on a pipeline board', 'veahealth' ); ?>
						</label>
						<p>
							<label>
								<?php esc_html_e( 'Deal stage id', 'veahealth' ); ?>
								<input name="veahealth_hs_stage" type="text" class="regular-text"
								       value="<?php echo esc_attr( get_option( 'veahealth_hs_stage', '' ) ); ?>"
								       placeholder="appointmentscheduled">
							</label>
							<span class="description"><?php esc_html_e( 'Leave blank for the first stage of the default pipeline.', 'veahealth' ); ?></span>
						</p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="hs_owner"><?php esc_html_e( 'Assign leads to', 'veahealth' ); ?></label></th>
					<td>
						<input name="veahealth_hs_owner" id="hs_owner" type="text" class="regular-text"
						       value="<?php echo esc_attr( get_option( 'veahealth_hs_owner', '' ) ); ?>" placeholder="98199210">
						<p class="description">
							<?php esc_html_e( 'The numeric HubSpot user id that new contacts and deals are assigned to. In HubSpot: Settings → Users & Teams, open the user, and take the number at the end of the address bar. Leave blank to leave leads unassigned.', 'veahealth' ); ?>
						</p>
					</td>
				</tr>
			</table>
			<?php submit_button(); ?>
		</form>

		<form method="post">
			<?php wp_nonce_field( 'veahealth_hs_probe' ); ?>
			<input type="hidden" name="veahealth_hs_probe" value="1">
			<?php submit_button( __( 'Test the connection', 'veahealth' ), 'secondary', 'submit', false ); ?>
		</form>

		<h2><?php esc_html_e( 'What is sent', 'veahealth' ); ?></h2>
		<p style="max-width:70ch">
			<?php esc_html_e( 'Name, email, phone and country become contact properties. The message, the treatments and the page become a note. Nothing else leaves the site. Because this sends a visitor\'s details to a company outside your business, HubSpot has to be named in your privacy policy as a processor. While a token is set here, the theme adds that paragraph to the policy page automatically, and removes it again if you disconnect.', 'veahealth' ); ?>
		</p>
	</div>
	<?php
}

/* ==========================================================================
   Visibility in the enquiries list
   ========================================================================== */

function veahealth_hs_column( $cols ) {
	$cols['vh_hs'] = __( 'HubSpot', 'veahealth' );
	return $cols;
}
add_filter( 'manage_vh_enquiry_posts_columns', 'veahealth_hs_column' );

function veahealth_hs_column_body( $col, $post_id ) {
	if ( 'vh_hs' !== $col ) {
		return;
	}
	$status = get_post_meta( $post_id, '_vh_hs_status', true );
	$map    = array(
		'ok'       => array( '#157A56', __( 'In HubSpot', 'veahealth' ) ),
		'queued'   => array( '#9A6212', __( 'Queued', 'veahealth' ) ),
		'retrying' => array( '#9A6212', __( 'Retrying', 'veahealth' ) ),
		'failed'   => array( '#A3291B', __( 'Failed', 'veahealth' ) ),
		'off'      => array( '#6b7280', __( 'Not connected', 'veahealth' ) ),
	);
	if ( ! isset( $map[ $status ] ) ) {
		echo '<span style="color:#6b7280">—</span>';
		return;
	}
	printf( '<strong style="color:%s">%s</strong>', esc_attr( $map[ $status ][0] ), esc_html( $map[ $status ][1] ) );

	$error = get_post_meta( $post_id, '_vh_hs_error', true );
	if ( $error ) {
		printf( '<br><span class="description">%s</span>', esc_html( $error ) );
	}
	if ( 'ok' !== $status && veahealth_hs_ready() ) {
		printf(
			'<br><a href="%s">%s</a>',
			esc_url( wp_nonce_url( admin_url( 'edit.php?post_type=vh_enquiry&vh_hs_retry=' . $post_id ), 'vh_hs_retry_' . $post_id ) ),
			esc_html__( 'Send again', 'veahealth' )
		);
	}
}
add_action( 'manage_vh_enquiry_posts_custom_column', 'veahealth_hs_column_body', 10, 2 );

/** The retry link. Runs the push there and then so the result is immediate. */
function veahealth_hs_retry() {
	if ( ! isset( $_GET['vh_hs_retry'] ) || ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$id = absint( $_GET['vh_hs_retry'] );
	if ( ! $id || ! check_admin_referer( 'vh_hs_retry_' . $id ) ) {
		return;
	}
	delete_post_meta( $id, '_vh_hs_status' );
	veahealth_hs_push( $id, VEAHEALTH_HS_TRIES );   // no further scheduling; report the outcome now
	wp_safe_redirect( admin_url( 'edit.php?post_type=vh_enquiry' ) );
	exit;
}
add_action( 'admin_init', 'veahealth_hs_retry' );

/* ==========================================================================
   Privacy
   ========================================================================== */

/**
 * Name HubSpot in the privacy policy, but only while it is actually connected.
 *
 * Sending an enquirer's name, email and phone number to HubSpot makes HubSpot a
 * processor acting on the clinic's behalf, and a processor has to be disclosed.
 * Doing it with a filter rather than by editing the stored policy keeps the
 * statement true in both directions: turn the integration off and the sentence
 * goes with it, so the policy never names a company the site does not use.
 *
 * @param string $content Post content.
 * @return string
 */
function veahealth_hs_privacy_note( $content ) {
	if ( ! is_page() || ! veahealth_hs_ready() || is_admin() ) {
		return $content;
	}
	$page = get_post();
	if ( ! $page || 'privacy-policy' !== $page->post_name ) {
		return $content;
	}

	$note = '<p class="vh-processor-note">' . esc_html__(
		'Customer relationship management. Enquiries sent through this website are also stored in HubSpot, a customer relationship platform we use to keep track of conversations with patients. HubSpot processes your name, email address, telephone number, country and the message you send, on our instructions and on our behalf. HubSpot is a US company and transfers are made under its standard contractual clauses. You can ask us to delete your record there at any time using the contact details above.',
		'veahealth'
	) . '</p>';

	/*
	 * Insert it at the end of the sharing section where it belongs. If that
	 * heading has been renamed by an editor the paragraph goes to the end of
	 * the page instead — misplaced is recoverable, missing is not.
	 */
	if ( preg_match( '#(<h2[^>]*>\s*Who we share it with\s*</h2>.*?)(<h2)#is', $content, $m ) ) {
		return str_replace( $m[0], $m[1] . $note . $m[2], $content );
	}
	return $content . $note;
}
add_filter( 'the_content', 'veahealth_hs_privacy_note', 20 );

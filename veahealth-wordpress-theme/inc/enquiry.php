<?php
/**
 * The enquiry form.
 *
 * The old site's form had no action, no method and no server handler: it opened
 * WhatsApp and nothing else, and it never asked for an email address or a phone
 * number. Every lead that did not complete the WhatsApp hand-off was lost with
 * no way to follow up.
 *
 * Here the submission is stored as a post first and emailed second, so a lead
 * survives a mail failure, and WhatsApp is offered afterwards as a second
 * channel rather than as the only one.
 *
 * @package VeaHealth
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function veahealth_register_enquiry_route() {
	register_rest_route(
		'veahealth/v1',
		'/enquiry',
		array(
			'methods'             => 'POST',
			'callback'            => 'veahealth_handle_enquiry',
			'permission_callback' => '__return_true',
		)
	);
}
add_action( 'rest_api_init', 'veahealth_register_enquiry_route' );

function veahealth_handle_enquiry( WP_REST_Request $request ) {
	$data = $request->get_json_params();
	if ( ! is_array( $data ) ) {
		$data = $request->get_params();
	}

	// Honeypot: a field hidden from people and irresistible to bots.
	if ( ! empty( $data['company'] ) ) {
		return new WP_REST_Response( array( 'ok' => true ), 200 );
	}

	$get = static function ( $key, $max = 400 ) use ( $data ) {
		$value = isset( $data[ $key ] ) ? $data[ $key ] : '';
		if ( is_array( $value ) ) {
			$value = implode( ', ', array_map( 'sanitize_text_field', $value ) );
		}
		return mb_substr( sanitize_text_field( (string) $value ), 0, $max );
	};

	$first   = $get( 'firstName', 80 );
	$last    = $get( 'lastName', 80 );
	$email   = sanitize_email( $get( 'email', 160 ) );
	$phone   = $get( 'phone', 40 );
	$country = $get( 'country', 80 );
	$timing  = $get( 'timing', 80 );
	$treat   = $get( 'treatments', 400 );
	$page    = $get( 'page', 200 );
	$message = mb_substr( sanitize_textarea_field( isset( $data['message'] ) ? (string) $data['message'] : '' ), 0, 4000 );

	if ( '' === $first || '' === $phone || ! is_email( $email ) ) {
		return new WP_REST_Response(
			array( 'ok' => false, 'error' => 'validation_failed' ),
			422
		);
	}

	/* 1. Never lose the lead: store it before anything can fail. */
	$post_id = wp_insert_post(
		array(
			'post_type'   => 'vh_enquiry',
			'post_status' => 'publish',
			'post_title'  => trim( $first . ' ' . $last ),
			'post_author' => 0,
			'meta_input'  => array(
				'_vh_email'      => $email,
				'_vh_phone'      => $phone,
				'_vh_country'    => $country,
				'_vh_treatments' => $treat,
				'_vh_timing'     => $timing,
				'_vh_message'    => $message,
				'_vh_page'       => $page,
				'_vh_ip'         => isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '',
			),
		),
		true
	);

	if ( is_wp_error( $post_id ) ) {
		return new WP_REST_Response( array( 'ok' => false, 'error' => 'store_failed' ), 500 );
	}

	/*
	 * 2. Ring the coordinator's phone. Registered first because it is the one
	 * step where seconds matter — the lead has already gone to whoever answers
	 * first — but it runs after the response is closed, so it costs the visitor
	 * nothing.
	 */
	if ( function_exists( 'veahealth_alert_queue' ) ) {
		veahealth_alert_queue( $post_id );
	}

	/* 3. The email, as the record and the fallback. */
	$to = veahealth_option( 'enquiry_to' );
	if ( ! is_email( $to ) ) {
		$to = get_option( 'admin_email' );
	}

	$subject = sprintf(
		/* translators: 1: first name, 2: last name, 3: country */
		__( 'Website enquiry — %1$s %2$s (%3$s)', 'veahealth' ),
		$first,
		$last,
		$country
	);

	$lines = array(
		__( 'New enquiry from the website.', 'veahealth' ),
		'',
		sprintf( '%s: %s %s', __( 'Name', 'veahealth' ), $first, $last ),
		sprintf( '%s: %s', __( 'Email', 'veahealth' ), $email ),
		sprintf( '%s: %s', __( 'Phone', 'veahealth' ), $phone ),
		sprintf( '%s: %s', __( 'Country', 'veahealth' ), $country ),
		sprintf( '%s: %s', __( 'Treatments', 'veahealth' ), $treat ),
		sprintf( '%s: %s', __( 'Timing', 'veahealth' ), $timing ),
		sprintf( '%s: %s', __( 'Sent from', 'veahealth' ), $page ),
		'',
		__( 'Message:', 'veahealth' ),
		$message,
		'',
		sprintf( '%s: %s', __( 'Open in the admin', 'veahealth' ), get_edit_post_link( $post_id, '' ) ),
	);

	$sent = wp_mail(
		$to,
		$subject,
		implode( "\n", $lines ),
		array(
			'Content-Type: text/plain; charset=UTF-8',
			sprintf( 'Reply-To: %s <%s>', trim( $first . ' ' . $last ), $email ),
		)
	);

	update_post_meta( $post_id, '_vh_mailed', $sent ? 'yes' : 'no' );

	/*
	 * 4. Hand it to the CRM — queued, not called. The visitor already has their
	 * lead stored and the coordinator already has the email; HubSpot being slow
	 * or down must not delay this response or fail the submission.
	 */
	if ( function_exists( 'veahealth_hs_queue' ) ) {
		veahealth_hs_queue( $post_id );
	}

	return new WP_REST_Response( array( 'ok' => true, 'mailed' => (bool) $sent ), 200 );
}

/**
 * The form markup. Used by the contact page template.
 */
function veahealth_enquiry_form() {
	$treatments = array();
	$posts      = get_posts(
		array(
			'post_type'      => 'service',
			'posts_per_page' => 40,
			'orderby'        => array( 'menu_order' => 'ASC', 'title' => 'ASC' ),
		)
	);
	foreach ( $posts as $p ) {
		$treatments[] = get_the_title( $p );
	}
	if ( ! $treatments ) {
		$treatments = array( __( 'Dental implants', 'veahealth' ), __( 'Crowns and veneers', 'veahealth' ), __( 'Hair transplant', 'veahealth' ) );
	}
	$treatments = array_slice( $treatments, 0, 10 );
	$treatments[] = __( 'Not sure yet', 'veahealth' );
	?>
	<form id="enquiry-form" novalidate
	      data-endpoint="<?php echo esc_url( rest_url( 'veahealth/v1/enquiry' ) ); ?>"
	      data-whatsapp="<?php echo esc_url( veahealth_whatsapp_url() ); ?>">

		<div class="form-steps" aria-hidden="true">
			<span class="fs is-active"></span><span class="fs"></span><span class="fs"></span>
		</div>

		<div class="hp" aria-hidden="true">
			<label><?php esc_html_e( 'Company', 'veahealth' ); ?>
				<input type="text" name="company" tabindex="-1" autocomplete="off">
			</label>
		</div>

		<fieldset class="form-step is-active" style="border:0;padding:0;margin:0">
			<h2 style="font-size:var(--step-2)"><?php esc_html_e( 'How can we reach you?', 'veahealth' ); ?></h2>
			<p class="muted" style="font-size:.9rem;margin:8px 0 22px">
				<?php esc_html_e( 'We need an email and a phone number so a coordinator can send your plan and follow up — even if WhatsApp does not open on your device.', 'veahealth' ); ?>
			</p>
			<div class="row-2">
				<div class="field">
					<label for="firstName"><?php esc_html_e( 'First name', 'veahealth' ); ?> <span class="req">*</span></label>
					<input class="input" id="firstName" name="firstName" type="text" autocomplete="given-name" required>
					<span class="field-error" role="alert"></span>
				</div>
				<div class="field">
					<label for="lastName"><?php esc_html_e( 'Last name', 'veahealth' ); ?> <span class="req">*</span></label>
					<input class="input" id="lastName" name="lastName" type="text" autocomplete="family-name" required>
					<span class="field-error" role="alert"></span>
				</div>
			</div>
			<div class="field">
				<label for="email"><?php esc_html_e( 'Email', 'veahealth' ); ?> <span class="req">*</span></label>
				<input class="input" id="email" name="email" type="email" autocomplete="email" required placeholder="name@example.com">
				<span class="field-error" role="alert"></span>
			</div>
			<div class="row-2">
				<div class="field">
					<label for="phone"><?php esc_html_e( 'Phone, with country code', 'veahealth' ); ?> <span class="req">*</span></label>
					<input class="input" id="phone" name="phone" type="tel" autocomplete="tel" required placeholder="+44 7700 900000">
					<span class="field-error" role="alert"></span>
				</div>
				<div class="field">
					<label for="country"><?php esc_html_e( 'Country', 'veahealth' ); ?> <span class="req">*</span></label>
					<input class="input" id="country" name="country" type="text" autocomplete="country-name" required>
					<span class="field-error" role="alert"></span>
				</div>
			</div>
			<button class="btn btn--primary btn--block" type="button" data-step="next">
				<?php esc_html_e( 'Continue', 'veahealth' ); ?> <?php echo veahealth_icon( 'arrow' ); ?>
			</button>
		</fieldset>

		<fieldset class="form-step" style="border:0;padding:0;margin:0">
			<h2 style="font-size:var(--step-2)"><?php esc_html_e( 'What are you considering?', 'veahealth' ); ?></h2>
			<p class="muted" style="font-size:.9rem;margin:8px 0 22px">
				<?php esc_html_e( 'Pick anything that applies, or “not sure yet” — the assessment will tell you what is actually indicated.', 'veahealth' ); ?>
			</p>
			<div class="chip-grid">
				<?php foreach ( $treatments as $t ) : ?>
					<label class="chip">
						<input type="checkbox" name="treatments" value="<?php echo esc_attr( $t ); ?>">
						<?php echo esc_html( $t ); ?>
					</label>
				<?php endforeach; ?>
			</div>
			<div class="field" style="margin-top:26px">
				<label for="timing"><?php esc_html_e( 'When are you planning to travel?', 'veahealth' ); ?></label>
				<select class="select" id="timing" name="timing">
					<option><?php esc_html_e( 'As soon as possible', 'veahealth' ); ?></option>
					<option selected><?php esc_html_e( 'In 1–3 months', 'veahealth' ); ?></option>
					<option><?php esc_html_e( 'In 3–6 months', 'veahealth' ); ?></option>
					<option><?php esc_html_e( 'Later than 6 months', 'veahealth' ); ?></option>
					<option><?php esc_html_e( 'Just researching for now', 'veahealth' ); ?></option>
				</select>
			</div>
			<div style="display:flex;gap:10px;flex-wrap:wrap">
				<button class="btn btn--ghost" type="button" data-step="prev"><?php esc_html_e( 'Back', 'veahealth' ); ?></button>
				<button class="btn btn--primary" style="flex:1" type="button" data-step="next">
					<?php esc_html_e( 'Continue', 'veahealth' ); ?> <?php echo veahealth_icon( 'arrow' ); ?>
				</button>
			</div>
		</fieldset>

		<fieldset class="form-step" style="border:0;padding:0;margin:0">
			<h2 style="font-size:var(--step-2)"><?php esc_html_e( 'Anything you want us to know?', 'veahealth' ); ?></h2>
			<p class="muted" style="font-size:.9rem;margin:8px 0 22px">
				<?php
				printf(
					/* translators: %s: email address link */
					esc_html__( 'Existing dental work, past surgery, medical conditions, medication — anything that helps the dentist assess your case. You can also email photographs to %s.', 'veahealth' ),
					'<a href="mailto:' . esc_attr( veahealth_option( 'email' ) ) . '">' . esc_html( veahealth_option( 'email' ) ) . '</a>'
				);
				?>
			</p>
			<div class="field">
				<label for="message"><?php esc_html_e( 'Your message', 'veahealth' ); ?></label>
				<textarea class="textarea" id="message" name="message" rows="5"
				          placeholder="<?php esc_attr_e( 'For example: upper molars missing for two years, considering implants.', 'veahealth' ); ?>"></textarea>
			</div>
			<label class="consent">
				<input type="checkbox" name="consent" required>
				<span>
					<?php
					/*
					 * The theme's own page first, because it is the one that
					 * exists in four languages — get_privacy_policy_url()
					 * returns the single page set in Settings, which is the
					 * English one, and consent shown in Arabic has to link to
					 * the text the visitor can actually read.
					 */
					$p       = veahealth_page( 'privacy-policy' );
					$privacy = $p ? get_permalink( $p ) : get_privacy_policy_url();
					if ( ! $privacy ) {
						$privacy = home_url( '/privacy-policy/' );
					}
					printf(
						/* translators: %s: privacy policy link */
						esc_html__( 'I agree that my details may be stored and used to answer this enquiry, as described in the %s.', 'veahealth' ),
						'<a href="' . esc_url( $privacy ) . '">' . esc_html__( 'privacy policy', 'veahealth' ) . '</a>'
					);
					?>
					<span class="req">*</span>
				</span>
			</label>
			<div style="display:flex;gap:10px;flex-wrap:wrap">
				<button class="btn btn--ghost" type="button" data-step="prev"><?php esc_html_e( 'Back', 'veahealth' ); ?></button>
				<button class="btn btn--primary" style="flex:1" type="submit">
					<?php esc_html_e( 'Send my enquiry', 'veahealth' ); ?> <?php echo veahealth_icon( 'arrow' ); ?>
				</button>
			</div>
			<p class="form-note">
				<?php esc_html_e( 'Your details go to the clinic coordinator and are stored in this site’s admin. We do not sell or share them. WhatsApp opens afterwards as a second channel — your enquiry is already recorded either way.', 'veahealth' ); ?>
			</p>
			<div class="form-status" role="status" aria-live="polite"></div>
		</fieldset>
	</form>
	<?php
}

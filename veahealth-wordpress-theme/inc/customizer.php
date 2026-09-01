<?php
/**
 * Customizer settings: everything a coordinator needs to change without
 * touching a template.
 *
 * @package VeaHealth
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Defaults, so the theme renders correctly before anything is configured. */
function veahealth_defaults() {
	return array(
		'email'        => 'info@veahealthturkey.com',
		'phone'        => '+90 531 432 92 15',
		'whatsapp'     => '+905314329215',
		'street'       => 'Merkez, Hasat Sk. No:52',
		'postcode'     => '34381',
		'district'     => 'Şişli',
		'city'         => 'Istanbul',
		'hours'        => "Monday – Saturday · 09:00 – 18:00\nSunday · closed\nWhatsApp answered seven days a week",
		'facebook'     => '',
		'instagram'    => '',
		'youtube'      => '',
		'ga_id'        => '',
		'enquiry_to'   => get_option( 'admin_email' ),
		'hero_title'   => "Dental and hair restoration\nin Istanbul, coordinated\nfrom first message to\nthe flight home.",
		'hero_text'    => 'VeaHealth works with verified Istanbul clinics. You get a written treatment plan and a fixed price before you travel, airport transfers and a hotel arranged around your appointments, and a coordinator who stays reachable after you fly home.',
	);
}

/** One accessor for every themed option. */
function veahealth_option( $key ) {
	$defaults = veahealth_defaults();
	$default  = isset( $defaults[ $key ] ) ? $defaults[ $key ] : '';
	/*
	 * Filtered so the language layer can offer a translation of a default the
	 * clinic has not overridden — and only of a default: anything they typed
	 * themselves is their words in every language.
	 */
	return apply_filters( 'veahealth_option', get_theme_mod( 'veahealth_' . $key, $default ), $key );
}

/** The WhatsApp link, built from the number in the Customizer. */
function veahealth_whatsapp_url() {
	$number = preg_replace( '/[^\d]/', '', veahealth_option( 'whatsapp' ) );
	return $number ? 'https://wa.me/' . $number : '';
}

function veahealth_customize( $wp_customize ) {

	$wp_customize->add_panel(
		'veahealth',
		array(
			'title'    => __( 'VeaHealth', 'veahealth' ),
			'priority' => 20,
		)
	);

	/* ---------------- contact ---------------- */
	$wp_customize->add_section(
		'veahealth_contact',
		array(
			'title'       => __( 'Contact details', 'veahealth' ),
			'panel'       => 'veahealth',
			'description' => __( 'Used in the top bar, the footer, the enquiry page and the structured data Google reads.', 'veahealth' ),
		)
	);

	$fields = array(
		'email'    => array( __( 'Email address', 'veahealth' ), 'sanitize_email' ),
		'phone'    => array( __( 'Phone, as displayed', 'veahealth' ), 'sanitize_text_field' ),
		'whatsapp' => array( __( 'WhatsApp number, digits and + only', 'veahealth' ), 'sanitize_text_field' ),
		'street'   => array( __( 'Street address', 'veahealth' ), 'sanitize_text_field' ),
		'postcode' => array( __( 'Postcode', 'veahealth' ), 'sanitize_text_field' ),
		'district' => array( __( 'District', 'veahealth' ), 'sanitize_text_field' ),
		'city'     => array( __( 'City', 'veahealth' ), 'sanitize_text_field' ),
	);
	foreach ( $fields as $key => $meta ) {
		$wp_customize->add_setting(
			'veahealth_' . $key,
			array(
				'default'           => veahealth_defaults()[ $key ],
				'sanitize_callback' => $meta[1],
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control( 'veahealth_' . $key, array( 'label' => $meta[0], 'section' => 'veahealth_contact', 'type' => 'text' ) );
	}

	$wp_customize->add_setting(
		'veahealth_hours',
		array( 'default' => veahealth_defaults()['hours'], 'sanitize_callback' => 'sanitize_textarea_field' )
	);
	$wp_customize->add_control(
		'veahealth_hours',
		array( 'label' => __( 'Opening hours, one line each', 'veahealth' ), 'section' => 'veahealth_contact', 'type' => 'textarea' )
	);

	/* ---------------- social ---------------- */
	$wp_customize->add_section(
		'veahealth_social',
		array(
			'title'       => __( 'Social profiles', 'veahealth' ),
			'panel'       => 'veahealth',
			'description' => __( 'Leave a field empty to hide that icon. These also feed the sameAs property in your structured data, so use the real profile URLs.', 'veahealth' ),
		)
	);
	foreach ( array( 'facebook' => 'Facebook', 'instagram' => 'Instagram', 'youtube' => 'YouTube' ) as $key => $label ) {
		$wp_customize->add_setting( 'veahealth_' . $key, array( 'default' => '', 'sanitize_callback' => 'esc_url_raw' ) );
		$wp_customize->add_control( 'veahealth_' . $key, array( 'label' => $label, 'section' => 'veahealth_social', 'type' => 'url' ) );
	}

	/* ---------------- enquiries ---------------- */
	$wp_customize->add_section(
		'veahealth_enquiry',
		array(
			'title'       => __( 'Enquiries', 'veahealth' ),
			'panel'       => 'veahealth',
			'description' => __( 'Every enquiry is saved under Enquiries in the admin before any email is sent, so a lead is never lost if mail delivery fails.', 'veahealth' ),
		)
	);
	$wp_customize->add_setting(
		'veahealth_enquiry_to',
		array( 'default' => get_option( 'admin_email' ), 'sanitize_callback' => 'sanitize_email' )
	);
	$wp_customize->add_control(
		'veahealth_enquiry_to',
		array( 'label' => __( 'Send notifications to', 'veahealth' ), 'section' => 'veahealth_enquiry', 'type' => 'email' )
	);

	/* ---------------- analytics ---------------- */
	$wp_customize->add_section(
		'veahealth_analytics',
		array(
			'title'       => __( 'Analytics', 'veahealth' ),
			'panel'       => 'veahealth',
			'description' => __( 'Paste your Google tag ID, for example G-XXXXXXXXXX. Nothing loads until a visitor accepts analytics cookies — leave it empty and no tag is added at all.', 'veahealth' ),
		)
	);
	$wp_customize->add_setting( 'veahealth_ga_id', array( 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ) );
	$wp_customize->add_control( 'veahealth_ga_id', array( 'label' => __( 'Google tag ID', 'veahealth' ), 'section' => 'veahealth_analytics', 'type' => 'text' ) );

	/* ---------------- homepage hero ---------------- */
	$wp_customize->add_section(
		'veahealth_hero',
		array( 'title' => __( 'Homepage hero', 'veahealth' ), 'panel' => 'veahealth' )
	);
	$wp_customize->add_setting(
		'veahealth_hero_title',
		array( 'default' => veahealth_defaults()['hero_title'], 'sanitize_callback' => 'sanitize_textarea_field' )
	);
	$wp_customize->add_control(
		'veahealth_hero_title',
		array(
			'label'       => __( 'Headline', 'veahealth' ),
			'description' => __( 'One line per row. Each row animates up on load.', 'veahealth' ),
			'section'     => 'veahealth_hero',
			'type'        => 'textarea',
		)
	);
	$wp_customize->add_setting(
		'veahealth_hero_text',
		array( 'default' => veahealth_defaults()['hero_text'], 'sanitize_callback' => 'sanitize_textarea_field' )
	);
	$wp_customize->add_control(
		'veahealth_hero_text',
		array( 'label' => __( 'Introduction', 'veahealth' ), 'section' => 'veahealth_hero', 'type' => 'textarea' )
	);
	$wp_customize->add_setting( 'veahealth_hero_image', array( 'sanitize_callback' => 'absint' ) );
	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'veahealth_hero_image',
			array(
				'label'       => __( 'Background image', 'veahealth' ),
				'description' => __( 'Leave empty to keep the supplied Istanbul photograph.', 'veahealth' ),
				'section'     => 'veahealth_hero',
				'mime_type'   => 'image',
			)
		)
	);
}
add_action( 'customize_register', 'veahealth_customize' );

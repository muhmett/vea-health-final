<?php
/**
 * Styles and scripts.
 *
 * @package VeaHealth
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function veahealth_assets() {
	$ver = VEAHEALTH_VERSION;

	// Self-hosted webfonts. The Google Fonts CDN receives every visitor's IP
	// address, which German courts have held to breach the GDPR, and it costs
	// an extra DNS lookup and TLS handshake before any text can render.
	wp_enqueue_style( 'veahealth-fonts', VEAHEALTH_URI . '/assets/fonts/fonts.css', array(), $ver );
	wp_enqueue_style( 'veahealth', VEAHEALTH_URI . '/assets/css/site.css', array( 'veahealth-fonts' ), $ver );

	/*
	 * Treatment pages used to load a stylesheet of their own — one per
	 * treatment, 384 KB across sixteen files, because each page had been
	 * pasted into the old site as a complete HTML document. They now render
	 * through the theme's components, so there is one stylesheet for all of
	 * them and it is 19 KB.
	 */
	if ( is_singular( 'service' ) ) {
		wp_enqueue_style( 'veahealth-treatment', VEAHEALTH_URI . '/assets/css/treatment.css', array( 'veahealth' ), $ver );
		wp_enqueue_script( 'veahealth-treatment', VEAHEALTH_URI . '/assets/js/treatment.js', array(), $ver, true );
	}

	// The motion layer's own stylesheet. Small, and harmless when motion.js
	// decides not to run — none of its classes get applied.
	wp_enqueue_style( 'veahealth-motion', VEAHEALTH_URI . '/assets/css/motion.css', array( 'veahealth' ), $ver );

	wp_enqueue_script( 'veahealth', VEAHEALTH_URI . '/assets/js/site.js', array(), $ver, true );

	/*
	 * motion.js is a ~9 KB loader. It fetches GSAP, ScrollTrigger and Lenis
	 * itself, and only after checking that the visit can use them: a visitor
	 * who has asked for reduced motion never downloads the 133 KB of libraries.
	 */
	wp_enqueue_script( 'veahealth-motion', VEAHEALTH_URI . '/assets/js/motion.js', array( 'veahealth' ), $ver, true );
	wp_localize_script(
		'veahealth-motion',
		'VH_MOTION',
		array( 'base' => VEAHEALTH_URI . '/assets' )
	);
	wp_localize_script(
		'veahealth',
		'veaHealth',
		array(
			'endpoint' => esc_url_raw( rest_url( 'veahealth/v1/enquiry' ) ),
			'nonce'    => wp_create_nonce( 'wp_rest' ),
		)
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'veahealth_assets' );

/**
 * Preload the two faces that paint first, so headings and body copy do not
 * swap after the page appears.
 */
function veahealth_preload_fonts() {
	$fonts = array(
		'/assets/fonts/outfit-variable-latin.woff2',
		'/assets/fonts/cormorantgaramond-variable-latin.woff2',
	);
	foreach ( $fonts as $f ) {
		printf(
			'<link rel="preload" as="font" type="font/woff2" href="%s" crossorigin>' . "\n",
			esc_url( VEAHEALTH_URI . $f )
		);
	}
	// The Google tag is injected by site.js only after the visitor consents.
	$ga = veahealth_option( 'ga_id' );
	if ( $ga ) {
		printf( "<script>document.documentElement.setAttribute('data-ga',%s);</script>\n", wp_json_encode( $ga ) );
	}
}
add_action( 'wp_head', 'veahealth_preload_fonts', 1 );

/** The homepage hero image is the LCP element — tell the browser early. */
function veahealth_preload_hero() {
	if ( ! is_front_page() ) {
		return;
	}
	printf(
		'<link rel="preload" as="image" href="%s" fetchpriority="high">' . "\n",
		esc_url( VEAHEALTH_URI . '/assets/img/art/hero-istanbul-bosphorus-1600.webp' )
	);
}
add_action( 'wp_head', 'veahealth_preload_hero', 2 );

/** No emoji script, no jQuery Migrate, no oEmbed discovery: none are used. */
function veahealth_trim_head() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'wp_shortlink_wp_head' );
}
add_action( 'init', 'veahealth_trim_head' );

/** Give every content image lazy loading and async decoding. */
function veahealth_image_attrs( $attr ) {
	if ( empty( $attr['loading'] ) ) {
		$attr['loading'] = 'lazy';
	}
	$attr['decoding'] = 'async';
	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'veahealth_image_attrs' );

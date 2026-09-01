<?php
/**
 * Styles and scripts.
 *
 * @package VeaHealth
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * A cache-busting version for one asset.
 *
 * The theme version alone is not enough, and this cost a live site a day of
 * looking broken: the journal shipped with new rules appended to site.css, the
 * constant was not bumped, and so every browser and the host's page cache went
 * on serving the previous stylesheet at the same ?ver=. The markup updated, the
 * CSS did not, and the result was unstyled tables and contents lists on a
 * production site.
 *
 * Deriving the suffix from the file's modification time removes the step a
 * human has to remember. The constant still identifies the release; the mtime
 * guarantees that a changed file is a changed URL.
 *
 * @param string $rel Path relative to the theme root, with a leading slash.
 * @return string
 */
function veahealth_asset_version( $rel ) {
	$file = VEAHEALTH_DIR . $rel;
	$time = file_exists( $file ) ? filemtime( $file ) : 0;
	return $time ? VEAHEALTH_VERSION . '.' . $time : VEAHEALTH_VERSION;
}

function veahealth_assets() {
	$ver = VEAHEALTH_VERSION;

	// Self-hosted webfonts. The Google Fonts CDN receives every visitor's IP
	// address, which German courts have held to breach the GDPR, and it costs
	// an extra DNS lookup and TLS handshake before any text can render.
	wp_enqueue_style( 'veahealth-fonts', VEAHEALTH_URI . '/assets/fonts/fonts.css', array(), veahealth_asset_version( '/assets/fonts/fonts.css' ) );
	wp_enqueue_style( 'veahealth', VEAHEALTH_URI . '/assets/css/site.css', array( 'veahealth-fonts' ), veahealth_asset_version( '/assets/css/site.css' ) );

	/*
	 * Arabic only. The mirroring itself is done by dir="rtl" against logical
	 * properties, so this carries just the typeface and the few graphics that
	 * are physical rather than directional — which keeps it small enough that
	 * no other language pays for it.
	 */
	// The journey lift, on the one template that has floors to stop at.
	if ( is_page_template( 'page-templates/journey.php' ) ) {
		wp_enqueue_style( 'veahealth-lift', VEAHEALTH_URI . '/assets/css/lift.css', array( 'veahealth' ), veahealth_asset_version( '/assets/css/lift.css' ) );
		wp_enqueue_script( 'veahealth-lift', VEAHEALTH_URI . '/assets/js/lift.js', array(), veahealth_asset_version( '/assets/js/lift.js' ), true );
	}

	if ( function_exists( 'veahealth_lang' ) && 'ar' === veahealth_lang() ) {
		wp_enqueue_style( 'veahealth-rtl', VEAHEALTH_URI . '/assets/css/rtl.css', array( 'veahealth' ), veahealth_asset_version( '/assets/css/rtl.css' ) );
	}

	/*
	 * Treatment pages used to load a stylesheet of their own — one per
	 * treatment, 384 KB across sixteen files, because each page had been
	 * pasted into the old site as a complete HTML document. They now render
	 * through the theme's components, so there is one stylesheet for all of
	 * them and it is 19 KB.
	 */
	if ( is_singular( 'service' ) ) {
		wp_enqueue_style( 'veahealth-treatment', VEAHEALTH_URI . '/assets/css/treatment.css', array( 'veahealth' ), veahealth_asset_version( '/assets/css/treatment.css' ) );
		wp_enqueue_script( 'veahealth-treatment', VEAHEALTH_URI . '/assets/js/treatment.js', array(), veahealth_asset_version( '/assets/js/treatment.js' ), true );

		// The room. Only where the treatment has enough behind it to fill one.
		if ( veahealth_has_room( get_queried_object_id() ) ) {
			wp_enqueue_style( 'veahealth-room', VEAHEALTH_URI . '/assets/css/room.css', array( 'veahealth-treatment' ), veahealth_asset_version( '/assets/css/room.css' ) );
			wp_enqueue_script( 'veahealth-room', VEAHEALTH_URI . '/assets/js/room.js', array(), veahealth_asset_version( '/assets/js/room.js' ), true );
		}
	}

	/*
	 * Reading. Articles get their own surface, type scale and scroll behaviour;
	 * a page of marketing sections and 1,500 words of prose are not the same
	 * design problem.
	 */
	if ( is_singular( 'post' ) ) {
		wp_enqueue_style( 'veahealth-reading', VEAHEALTH_URI . '/assets/css/reading.css', array( 'veahealth' ), veahealth_asset_version( '/assets/css/reading.css' ) );
		wp_enqueue_script( 'veahealth-reading', VEAHEALTH_URI . '/assets/js/reading.js', array(), veahealth_asset_version( '/assets/js/reading.js' ), true );
	}

	/*
	 * The particle field. Loaded on every page, and it removes itself on the
	 * spot for reduced motion or Save-Data.
	 */
	wp_enqueue_script( 'veahealth-particles', VEAHEALTH_URI . '/assets/js/particles.js', array(), veahealth_asset_version( '/assets/js/particles.js' ), true );

	// The motion layer's own stylesheet. Small, and harmless when motion.js
	// decides not to run — none of its classes get applied.
	wp_enqueue_style( 'veahealth-motion', VEAHEALTH_URI . '/assets/css/motion.css', array( 'veahealth' ), veahealth_asset_version( '/assets/css/motion.css' ) );

	wp_enqueue_script( 'veahealth', VEAHEALTH_URI . '/assets/js/site.js', array(), veahealth_asset_version( '/assets/js/site.js' ), true );

	/*
	 * motion.js is a ~9 KB loader. It fetches GSAP, ScrollTrigger and Lenis
	 * itself, and only after checking that the visit can use them: a visitor
	 * who has asked for reduced motion never downloads the 133 KB of libraries.
	 */
	wp_enqueue_script( 'veahealth-motion', VEAHEALTH_URI . '/assets/js/motion.js', array( 'veahealth' ), veahealth_asset_version( '/assets/js/motion.js' ), true );
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
	/*
	 * Preload what this page will actually draw with. An Arabic page renders
	 * almost none of its text in the Latin faces, and a Latin page renders none
	 * of it in the Arabic one — preloading both would make every visitor wait
	 * on 40 KB they were never going to see.
	 */
	if ( function_exists( 'veahealth_lang' ) && 'ar' === veahealth_lang() ) {
		$fonts = array(
			'/assets/fonts/ibmplexsansarabic-400-normal-arabic.woff2',
			'/assets/fonts/ibmplexsansarabic-600-normal-arabic.woff2',
		);
	} else {
		$fonts = array(
			'/assets/fonts/outfit-variable-latin.woff2',
			'/assets/fonts/cormorantgaramond-variable-latin.woff2',
		);
	}
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

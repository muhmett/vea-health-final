<?php
/**
 * Theme supports, menus and image sizes.
 *
 * @package VeaHealth
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function veahealth_setup() {
	load_theme_textdomain( 'veahealth', VEAHEALTH_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/site.css' );
	add_theme_support(
		'html5',
		array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' )
	);
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 72,
			'width'       => 260,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	register_nav_menus(
		array(
			'primary' => __( 'Primary menu', 'veahealth' ),
			'footer'  => __( 'Footer — company', 'veahealth' ),
			'legal'   => __( 'Footer — legal', 'veahealth' ),
		)
	);

	add_image_size( 'veahealth-card', 800, 520, true );
	add_image_size( 'veahealth-wide', 1600, 900, true );
	add_image_size( 'veahealth-result', 900, 0, false );
}
add_action( 'after_setup_theme', 'veahealth_setup' );

/**
 * Treatment content is hand-written HTML with its own sections and grids.
 * wpautop would insert stray <p> tags inside it, so it is disabled for the
 * treatment post type only — ordinary posts and pages keep it.
 */
function veahealth_content_filters() {
	if ( is_singular( 'service' ) ) {
		remove_filter( 'the_content', 'wpautop' );
		remove_filter( 'the_content', 'wptexturize' );
	}
}
add_action( 'wp', 'veahealth_content_filters' );

function veahealth_content_width() {
	$GLOBALS['content_width'] = 1240;
}
add_action( 'after_setup_theme', 'veahealth_content_width', 0 );

/**
 * The old site leaked the administrator's username through the REST users
 * endpoint, ?author=1 and the author archives. Close all three.
 */
function veahealth_block_user_enumeration( $response, $handler, $request ) {
	if ( is_user_logged_in() ) {
		return $response;
	}
	$route = $request->get_route();
	if ( preg_match( '#^/wp/v2/users#', $route ) ) {
		return new WP_Error( 'rest_user_cannot_view', __( 'Not available.', 'veahealth' ), array( 'status' => 401 ) );
	}
	return $response;
}
add_filter( 'rest_request_before_callbacks', 'veahealth_block_user_enumeration', 10, 3 );

function veahealth_block_author_scan() {
	if ( is_admin() || is_user_logged_in() ) {
		return;
	}
	if ( isset( $_GET['author'] ) || is_author() ) {
		wp_safe_redirect( home_url( '/' ), 301 );
		exit;
	}
}
add_action( 'template_redirect', 'veahealth_block_author_scan' );

/** Stop WordPress advertising its exact version. */
remove_action( 'wp_head', 'wp_generator' );
add_filter( 'the_generator', '__return_empty_string' );

/** XML-RPC is not used here and is a standard brute-force target. */
add_filter( 'xmlrpc_enabled', '__return_false' );

/** Security headers, for hosts that do not set them at the server level. */
function veahealth_security_headers( $headers ) {
	$headers['X-Content-Type-Options'] = 'nosniff';
	$headers['Referrer-Policy']        = 'strict-origin-when-cross-origin';
	$headers['X-Frame-Options']        = 'SAMEORIGIN';
	$headers['Permissions-Policy']     = 'geolocation=(), microphone=(), camera=()';
	return $headers;
}
add_filter( 'wp_headers', 'veahealth_security_headers' );

/**
 * Redirect the URLs the old site used so no inbound link or ranking is lost.
 */
function veahealth_legacy_redirects() {
	if ( is_admin() ) {
		return;
	}
	$path = trim( wp_parse_url( add_query_arg( array() ), PHP_URL_PATH ), '/' );
	if ( '' === $path ) {
		return;
	}

	$map = array(
		'service'                              => '/services/',
		'about-us'                             => '/about/',
		'contact-us'                           => '/contact/',
		'the-journey'                          => '/journey/',
		'portail'                              => '/services/',
		'home'                                 => '/',
		'services/immediate_dental_implants'   => '/services/immediate-dental-implants/',
		'services/Hybrid-Prosthesis-Porcelain' => '/services/hybrid-prosthesis-porcelain/',
	);

	if ( isset( $map[ $path ] ) ) {
		wp_safe_redirect( home_url( $map[ $path ] ), 301 );
		exit;
	}
	if ( 0 === strpos( $path, 'services_category/' ) ) {
		wp_safe_redirect( home_url( '/services/' ), 301 );
		exit;
	}
}
add_action( 'template_redirect', 'veahealth_legacy_redirects', 1 );

/** Trim the default excerpt and give it a readable ellipsis. */
add_filter( 'excerpt_length', function () { return 28; } );
add_filter( 'excerpt_more', function () { return '…'; } );

/**
 * The old site had no /privacy-policy/, /terms/ or /cookie-policy/ page while
 * Google Tag Manager loaded unconditionally. The importer creates all three;
 * this points WordPress's own privacy-policy setting at ours.
 */
function veahealth_register_privacy_page( $page_id ) {
	if ( $page_id && ! get_option( 'wp_page_for_privacy_policy' ) ) {
		update_option( 'wp_page_for_privacy_policy', $page_id );
	}
}

/**
 * Rebuild the permalink rules when the theme is activated, so the
 * /services/<slug>/ URLs work without a manual visit to Settings → Permalinks.
 */
function veahealth_activate() {
	veahealth_register_types();
	flush_rewrite_rules( true );

	/*
	 * Install the content on activation rather than waiting for someone to find
	 * a button. Without it the treatment cards, results and journey sections
	 * have nothing to render and the homepage looks broken — which is exactly
	 * what happened the first time this shipped.
	 *
	 * The installer is idempotent and non-destructive: entries are matched by
	 * slug and anything that already exists is left alone. It can still be
	 * re-run by hand from Appearance -> VeaHealth setup.
	 */
	if ( ! get_option( 'veahealth_installed' ) && function_exists( 'veahealth_install_content' ) ) {
		try {
			$log = veahealth_install_content( false );
			set_transient( 'veahealth_autoinstall_log', $log, HOUR_IN_SECONDS );
		} catch ( Throwable $e ) {
			// Never let a content problem white-screen theme activation.
			set_transient( 'veahealth_autoinstall_error', $e->getMessage(), HOUR_IN_SECONDS );
		}
	}
}
add_action( 'after_switch_theme', 'veahealth_activate' );

/**
 * A safety net: if the treatment rules are missing for any reason — a plugin
 * flushed them, a migration dropped them — rebuild them once.
 */
function veahealth_verify_rules() {
	if ( ! get_option( 'permalink_structure' ) ) {
		return;
	}
	$rules = get_option( 'rewrite_rules' );
	if ( is_array( $rules ) && ! preg_grep( '#^services/#', array_keys( $rules ) ) ) {
		flush_rewrite_rules( true );
	}
}
add_action( 'wp_loaded', 'veahealth_verify_rules' );

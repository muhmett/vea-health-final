<?php
/**
 * Four languages, one theme.
 *
 * English keeps the root — every URL the site has already earned in Google
 * stays exactly where it is — and the other three sit behind /fr/, /ar/ and
 * /es/. No plugin: the content is generated from this theme's own data files,
 * so the language belongs here with it, and the ZIP stays the whole install.
 *
 * How it works, in one paragraph. The prefix is taken off REQUEST_URI before
 * WordPress parses the request, so WordPress resolves /fr/traitements/x/ by
 * looking up traitements/x/ exactly as it would in English — no second router,
 * no rules to keep in sync. The language it stripped is remembered, the locale
 * filter points gettext at the right .mo, and every link is put back together
 * with the prefix belonging to the *linked* thing rather than the current page,
 * so a link from an Arabic page to a French one comes out right.
 *
 * A translated post is an ordinary post carrying two pieces of meta: _vh_lang,
 * its language, and _vh_tr, the group it shares with its siblings. A post with
 * neither is English, which is what makes every existing post correct without
 * being touched.
 *
 * @package VeaHealth
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const VEAHEALTH_LANG_META  = '_vh_lang';
const VEAHEALTH_GROUP_META = '_vh_tr';

/**
 * The languages the site speaks.
 *
 * `prefix` empty means the root. `locale` is what WordPress loads its
 * translations from. `dir` drives both the html attribute and the stylesheet.
 *
 * @return array<string,array{name:string,native:string,locale:string,dir:string,prefix:string}>
 */
function veahealth_languages() {
	return array(
		'en' => array( 'name' => 'English', 'native' => 'English',  'locale' => 'en_US', 'dir' => 'ltr', 'prefix' => '' ),
		'fr' => array( 'name' => 'French',  'native' => 'Français', 'locale' => 'fr_FR', 'dir' => 'ltr', 'prefix' => 'fr' ),
		'ar' => array( 'name' => 'Arabic',  'native' => 'العربية',  'locale' => 'ar',    'dir' => 'rtl', 'prefix' => 'ar' ),
		'es' => array( 'name' => 'Spanish', 'native' => 'Español',  'locale' => 'es_ES', 'dir' => 'ltr', 'prefix' => 'es' ),
	);
}

/** The language codes, in menu order. */
function veahealth_lang_codes() {
	return array_keys( veahealth_languages() );
}

/** The one language that lives at the root. */
function veahealth_lang_default() {
	return 'en';
}

/** Is this a code we actually speak? */
function veahealth_lang_valid( $code ) {
	return is_string( $code ) && isset( veahealth_languages()[ $code ] );
}

/**
 * The site address with no language on it.
 *
 * home_url() is filtered further down to carry the current prefix, and almost
 * everything in this file needs the opposite: the plain address, to measure
 * paths against and to build prefixed URLs from. Asking the filtered one would
 * both stack prefixes and — because working out the language reads the home
 * path — call the filter from inside itself.
 *
 * @return string Home URL with a trailing slash.
 */
function veahealth_home_raw() {
	static $home = null;
	if ( null === $home ) {
		remove_filter( 'home_url', 'veahealth_lang_home_url', 10 );
		$home = home_url( '/' );
		add_filter( 'home_url', 'veahealth_lang_home_url', 10, 2 );
	}
	return $home;
}

/* ==========================================================================
   Which language is this request?
   ========================================================================== */

/**
 * The language of the current request.
 *
 * Resolved once from the URL, before WordPress has parsed anything, because
 * the locale filter runs earlier than the query does.
 *
 * @return string
 */
function veahealth_lang() {
	static $lang = null;
	if ( null !== $lang ) {
		return $lang;
	}
	// Set before resolving, not after: anything reached on the way here that
	// asks again gets the default instead of recursing into this function.
	$lang = veahealth_lang_default();
	$lang = veahealth_lang_from_uri( isset( $_SERVER['REQUEST_URI'] ) ? (string) wp_unslash( $_SERVER['REQUEST_URI'] ) : '' );
	return $lang;
}

/**
 * Read the language prefix off a request path.
 *
 * The site may live in a subdirectory, so the home path is taken off first —
 * otherwise a site at /clinic/ would never match its own prefixes.
 *
 * @param string $uri Request URI.
 * @return string Language code; the default when there is no prefix.
 */
function veahealth_lang_from_uri( $uri ) {
	$path = (string) wp_parse_url( $uri, PHP_URL_PATH );
	$home = (string) wp_parse_url( veahealth_home_raw(), PHP_URL_PATH );
	if ( '' !== $home && '/' !== $home && 0 === strpos( $path, $home ) ) {
		$path = substr( $path, strlen( $home ) - 1 );
	}
	$first = strtok( ltrim( $path, '/' ), '/' );

	foreach ( veahealth_languages() as $code => $lang ) {
		if ( '' !== $lang['prefix'] && $first === $lang['prefix'] ) {
			return $code;
		}
	}
	return veahealth_lang_default();
}

/** Is this a front-end request we should be routing at all? */
function veahealth_lang_routing() {
	if ( is_admin() || wp_doing_ajax() || wp_doing_cron() ) {
		return false;
	}
	if ( defined( 'REST_REQUEST' ) && REST_REQUEST ) {
		return false;
	}
	// The REST route is decided after this runs, so the path is checked too:
	// the enquiry form posts to /wp-json/ and must never be rewritten.
	$path = isset( $_SERVER['REQUEST_URI'] ) ? (string) wp_parse_url( wp_unslash( $_SERVER['REQUEST_URI'] ), PHP_URL_PATH ) : '';
	return false === strpos( $path, '/wp-json/' ) && false === strpos( $path, '/wp-admin/' );
}

/**
 * Take the prefix off before WordPress parses the request.
 *
 * This is the whole routing layer. WordPress then matches /fr/x/ against its
 * ordinary rules as if it were /x/, which means permalinks, pagination, feeds
 * and every rewrite the site already has keep working with nothing added.
 */
function veahealth_lang_strip_prefix() {
	static $done = false;
	if ( $done || ! veahealth_lang_routing() ) {
		return;
	}
	$done = true;
	$lang = veahealth_lang();
	if ( veahealth_lang_default() === $lang ) {
		return;
	}
	$prefix = veahealth_languages()[ $lang ]['prefix'];
	$home   = (string) wp_parse_url( veahealth_home_raw(), PHP_URL_PATH );
	$base   = ( '' !== $home && '/' !== $home ) ? rtrim( $home, '/' ) : '';

	/*
	 * Both of them. WordPress reads the path from PATH_INFO when the server
	 * sets it and falls back to REQUEST_URI when it does not — Apache with the
	 * usual rewrite leaves PATH_INFO unset, the PHP dev server sets it — so
	 * stripping only one works on exactly half of the servers this could run
	 * on, and 404s on the other half. PATH_INFO starts after the script, so it
	 * never carries the subdirectory a REQUEST_URI does.
	 */
	if ( isset( $_SERVER['REQUEST_URI'] ) ) {
		$_SERVER['REQUEST_URI'] = veahealth_lang_strip_one( (string) wp_unslash( $_SERVER['REQUEST_URI'] ), $base, $prefix );
	}
	foreach ( array( 'PATH_INFO', 'ORIG_PATH_INFO' ) as $key ) {
		if ( isset( $_SERVER[ $key ] ) ) {
			$_SERVER[ $key ] = veahealth_lang_strip_one( (string) wp_unslash( $_SERVER[ $key ] ), '', $prefix );
		}
	}
}

/**
 * Take one leading language prefix off one path.
 *
 * @param string $value  Path, possibly with a query string.
 * @param string $base   Subdirectory the site lives in, or an empty string.
 * @param string $prefix Language prefix to remove.
 * @return string
 */
function veahealth_lang_strip_one( $value, $base, $prefix ) {
	/*
	 * A lookahead, so what follows the prefix is only inspected and never
	 * consumed — consuming it and putting it back is what produced a doubled
	 * slash on /fr/x/, and WordPress answers //x/ with a canonical redirect
	 * that throws the language away.
	 */
	$new = preg_replace(
		'#^' . preg_quote( $base, '#' ) . '/' . preg_quote( $prefix, '#' ) . '(?=/|$|\?)#',
		$base,
		$value,
		1
	);

	// /fr and /fr?x=1 leave nothing where the slash was; put it back.
	if ( 0 !== strpos( $new, $base . '/' ) ) {
		$new = $base . '/' . ltrim( (string) substr( $new, strlen( $base ) ), '/' );
	}
	return $new;
}
/*
 * Called outright rather than hooked. A theme is loaded after plugins_loaded
 * has already fired, so hooking it there would mean this never ran at all —
 * and the only deadline that matters is parse_request, which is still several
 * steps away. init at priority 0 backs it up in case this file is ever loaded
 * from somewhere earlier; the static guard keeps the second call harmless.
 */
veahealth_lang_strip_prefix();
add_action( 'init', 'veahealth_lang_strip_prefix', 0 );

/** Point gettext at the right .mo for this request. */
function veahealth_lang_locale( $locale ) {
	if ( is_admin() ) {
		return $locale;
	}
	$lang = veahealth_lang();
	return veahealth_languages()[ $lang ]['locale'];
}
add_filter( 'locale', 'veahealth_lang_locale' );

/**
 * Stop WordPress redirecting a language away from itself.
 *
 * redirect_canonical compares the address that was asked for against the one
 * it considers correct. It is handed the request with the prefix already
 * stripped, while home_url() hands it back a prefixed answer — so on /fr/ it
 * sees "/" asked for and "/fr/" as correct, redirects there, and the router
 * strips it again. That is an infinite loop, and it swallowed the front page
 * of every language but English.
 *
 * Both sides are reduced to their language-free form here: if that is all that
 * differed, there is nothing to correct. A genuine canonical fix — a missing
 * trailing slash, the wrong slug — still differs and still redirects.
 *
 * @param string|false $redirect  Where WordPress wants to send the visitor.
 * @param string       $requested What they asked for.
 * @return string|false
 */
function veahealth_lang_canonical( $redirect, $requested ) {
	if ( ! $redirect ) {
		return $redirect;
	}
	$bare = static function ( $url ) {
		return untrailingslashit( veahealth_lang_url( $url, veahealth_lang_default() ) );
	};
	return $bare( $redirect ) === $bare( $requested ) ? false : $redirect;
}
add_filter( 'redirect_canonical', 'veahealth_lang_canonical', 10, 2 );

/* ==========================================================================
   Building URLs
   ========================================================================== */

/**
 * Put a language prefix into a URL on this site.
 *
 * @param string $url  Absolute URL.
 * @param string $lang Language code.
 * @return string
 */
function veahealth_lang_url( $url, $lang ) {
	if ( ! veahealth_lang_valid( $lang ) ) {
		return $url;
	}
	$prefix = veahealth_languages()[ $lang ]['prefix'];
	$home   = veahealth_home_raw();

	if ( 0 !== strpos( $url, $home ) ) {
		return $url;                                     // not ours to touch
	}

	$rest = substr( $url, strlen( $home ) );
	$rest = veahealth_lang_unprefix( $rest );

	return '' === $prefix ? $home . $rest : $home . $prefix . '/' . $rest;
}

/** Remove any language prefix already on a path, so prefixes never stack. */
function veahealth_lang_unprefix( $path ) {
	foreach ( veahealth_languages() as $lang ) {
		if ( '' === $lang['prefix'] ) {
			continue;
		}
		$p = $lang['prefix'];
		if ( $path === $p || 0 === strpos( $path, $p . '/' ) || 0 === strpos( $path, $p . '?' ) ) {
			return (string) substr( $path, strlen( $p ) + 1 );
		}
	}
	return $path;
}

/**
 * Keep the visitor inside their language.
 *
 * Filtering home_url is what makes the menu, pagination, the search form and
 * everything else built from it stay in the language being read, without each
 * of those having to know a language exists.
 */
function veahealth_lang_home_url( $url, $path ) {
	if ( ! veahealth_lang_routing() ) {
		return $url;
	}
	$lang = veahealth_lang();
	if ( veahealth_lang_default() === $lang ) {
		return $url;
	}
	// Files and endpoints are not pages and must not be moved.
	if ( preg_match( '#(^|/)(wp-content|wp-includes|wp-admin|wp-json|wp-login\.php|xmlrpc\.php)#', (string) $path ) ) {
		return $url;
	}
	return veahealth_lang_url( $url, $lang );
}
add_filter( 'home_url', 'veahealth_lang_home_url', 10, 2 );

/**
 * A post's own language decides its link, not the page it is linked from.
 *
 * Without this, the language switcher could not link out of the language it is
 * standing in — every link it made would be dragged back by the home_url
 * filter above.
 */
function veahealth_lang_post_link( $url, $post ) {
	$post = get_post( $post );
	if ( ! $post ) {
		return $url;
	}
	return veahealth_lang_url( $url, veahealth_post_lang( $post->ID ) );
}
add_filter( 'post_link', 'veahealth_lang_post_link', 20, 2 );
add_filter( 'page_link', 'veahealth_lang_post_link', 20, 2 );
add_filter( 'post_type_link', 'veahealth_lang_post_link', 20, 2 );

/* ==========================================================================
   Which language does a post belong to?
   ========================================================================== */

/**
 * A post's language.
 *
 * No meta means English, which is what leaves every post written before this
 * existed correct without a migration.
 *
 * @param int $post_id Post.
 * @return string
 */
function veahealth_post_lang( $post_id ) {
	$lang = get_post_meta( $post_id, VEAHEALTH_LANG_META, true );
	return veahealth_lang_valid( $lang ) ? $lang : veahealth_lang_default();
}

/**
 * The group a post shares with its translations.
 *
 * Falls back to the post's own id, so an untranslated post is a group of one
 * rather than a special case every caller has to check for.
 *
 * @param int $post_id Post.
 * @return string
 */
function veahealth_post_group( $post_id ) {
	$group = (string) get_post_meta( $post_id, VEAHEALTH_GROUP_META, true );
	return '' !== $group ? $group : (string) $post_id;
}

/**
 * Every translation of a post, keyed by language.
 *
 * @param int $post_id Post.
 * @return array<string,int>
 */
function veahealth_post_translations( $post_id ) {
	$group = veahealth_post_group( $post_id );
	$found = array( veahealth_post_lang( $post_id ) => (int) $post_id );

	$siblings = get_posts(
		array(
			'post_type'        => get_post_type( $post_id ),
			'post_status'      => 'publish',
			'posts_per_page'   => count( veahealth_lang_codes() ),
			'post__not_in'     => array( (int) $post_id ),
			'suppress_filters' => false,
			'no_found_rows'    => true,
			'lang'             => 'any',
			'meta_query'       => array(
				array( 'key' => VEAHEALTH_GROUP_META, 'value' => $group ),
			),
		)
	);
	foreach ( $siblings as $post ) {
		$found[ veahealth_post_lang( $post->ID ) ] = (int) $post->ID;
	}
	return $found;
}

/**
 * Show only the language being read.
 *
 * English is the awkward one: its posts carry no language meta at all, so
 * "is English" has to mean "meta says en, or there is no meta" rather than a
 * plain equality — otherwise every pre-existing post would vanish from its own
 * site the moment this file was added.
 */
function veahealth_lang_filter_query( $query ) {
	if ( is_admin() || ! $query->is_main_query() || 'any' === $query->get( 'lang' ) ) {
		return;
	}
	if ( $query->is_singular() ) {
		return;                                  // a permalink is unambiguous
	}

	$lang = veahealth_lang();
	$meta = (array) $query->get( 'meta_query' );

	if ( veahealth_lang_default() === $lang ) {
		$meta[] = array(
			'relation' => 'OR',
			array( 'key' => VEAHEALTH_LANG_META, 'compare' => 'NOT EXISTS' ),
			array( 'key' => VEAHEALTH_LANG_META, 'value' => $lang ),
		);
	} else {
		$meta[] = array( 'key' => VEAHEALTH_LANG_META, 'value' => $lang );
	}

	$query->set( 'meta_query', $meta );
}
add_action( 'pre_get_posts', 'veahealth_lang_filter_query' );

/**
 * The path being viewed, relative to home, with no language prefix on it.
 *
 * By the time anything asks, the prefix has already been taken off
 * REQUEST_URI by the router above — so this is simply the path as English
 * would spell it, which is exactly what the switcher and hreflang need in
 * order to rebuild the same page in another language.
 *
 * @return string Path with no leading slash, query string dropped.
 */
function veahealth_lang_current_path() {
	$path = (string) wp_parse_url( isset( $_SERVER['REQUEST_URI'] ) ? (string) wp_unslash( $_SERVER['REQUEST_URI'] ) : '/', PHP_URL_PATH );
	$home = (string) wp_parse_url( veahealth_home_raw(), PHP_URL_PATH );
	if ( '/' !== $home && 0 === strpos( $path, $home ) ) {
		$path = substr( $path, strlen( $home ) - 1 );
	}
	return ltrim( veahealth_lang_unprefix( ltrim( $path, '/' ) ), '/' );
}

/* ==========================================================================
   What the browser and Google are told
   ========================================================================== */

/** The right lang and dir on <html>, so screen readers and browsers agree. */
function veahealth_lang_attributes( $output ) {
	$lang = veahealth_lang();
	$conf = veahealth_languages()[ $lang ];
	return sprintf( 'lang="%s" dir="%s"', esc_attr( $lang ), esc_attr( $conf['dir'] ) );
}
add_filter( 'language_attributes', 'veahealth_lang_attributes' );

/** So stylesheets can key off the language without asking PHP. */
function veahealth_lang_body_class( $classes ) {
	$lang    = veahealth_lang();
	$classes[] = 'lang-' . $lang;
	$classes[] = 'dir-' . veahealth_languages()[ $lang ]['dir'];
	return $classes;
}
add_filter( 'body_class', 'veahealth_lang_body_class' );

/**
 * hreflang for the whole translation group.
 *
 * Without these, Google treats the four versions as competing duplicates and
 * picks one; with them it serves the right language to the right searcher.
 * x-default points at English, which is the one a visitor with no matching
 * language should land on.
 */
function veahealth_lang_hreflang() {
	if ( is_404() || is_search() ) {
		return;
	}

	$urls = array();
	if ( is_singular() && ! is_front_page() ) {
		foreach ( veahealth_post_translations( get_queried_object_id() ) as $code => $id ) {
			$urls[ $code ] = get_permalink( $id );
		}
	} else {
		// An archive answers at the same path in every language.
		$path = veahealth_lang_current_path();
		foreach ( veahealth_lang_codes() as $code ) {
			$urls[ $code ] = veahealth_lang_url( veahealth_home_raw() . $path, $code );
		}
	}

	if ( count( $urls ) < 2 ) {
		return;
	}
	foreach ( $urls as $code => $url ) {
		printf( '<link rel="alternate" hreflang="%s" href="%s">' . "\n", esc_attr( $code ), esc_url( $url ) );
	}
	if ( isset( $urls[ veahealth_lang_default() ] ) ) {
		printf( '<link rel="alternate" hreflang="x-default" href="%s">' . "\n", esc_url( $urls[ veahealth_lang_default() ] ) );
	}
}
add_action( 'wp_head', 'veahealth_lang_hreflang', 5 );

/**
 * Never serve one language's content under another language's URL.
 *
 * /fr/services/immediate-dental-implants/ resolves — the slug is real, the
 * prefix is only a routing detail — and without this it would answer with the
 * English page wearing lang="fr". That is duplicate content in Google's eyes
 * and a broken promise in the reader's, so the visitor is sent to the address
 * that actually belongs to what they are reading.
 *
 * Archives are exempt: /fr/services/ is a genuine French page that happens to
 * list French posts.
 */
function veahealth_lang_guard_singular() {
	/*
	 * The front page is exempt. It is a singular page like any other, so
	 * without this the guard reads /ar/ as "the English front page under an
	 * Arabic address" and redirects it away — taking the Arabic home page with
	 * it. Every language has a front page by definition, translated or not.
	 */
	if ( ! is_singular() || is_preview() || is_front_page() ) {
		return;
	}
	$id   = get_queried_object_id();
	$lang = veahealth_post_lang( $id );
	if ( $lang === veahealth_lang() ) {
		return;
	}
	$url = get_permalink( $id );
	if ( $url ) {
		wp_safe_redirect( $url, 301 );
		exit;
	}
}
add_action( 'template_redirect', 'veahealth_lang_guard_singular', 9 );

/* ==========================================================================
   The switcher
   ========================================================================== */

/**
 * Links to this same page in the other languages.
 *
 * A language a page has no translation for is dropped rather than pointed at
 * the home page: sending somebody who wanted this treatment in Arabic to an
 * Arabic front page is a dead end dressed up as a link.
 *
 * @return array<string,array{url:string,native:string,current:bool}>
 */
function veahealth_lang_links() {
	$current = veahealth_lang();
	$out     = array();

	if ( is_singular() && ! is_front_page() ) {
		$found = veahealth_post_translations( get_queried_object_id() );
		foreach ( veahealth_languages() as $code => $conf ) {
			if ( ! isset( $found[ $code ] ) ) {
				continue;
			}
			$out[ $code ] = array(
				'url'     => get_permalink( $found[ $code ] ),
				'native'  => $conf['native'],
				'current' => $code === $current,
			);
		}
		return $out;
	}

	$path = veahealth_lang_current_path();
	foreach ( veahealth_languages() as $code => $conf ) {
		$out[ $code ] = array(
			'url'     => veahealth_lang_url( veahealth_home_raw() . $path, $code ),
			'native'  => $conf['native'],
			'current' => $code === $current,
		);
	}
	return $out;
}

/** The switcher markup. */
function veahealth_lang_switcher() {
	$links = veahealth_lang_links();
	if ( count( $links ) < 2 ) {
		return '';
	}
	$out = '<nav class="langs" aria-label="' . esc_attr__( 'Language', 'veahealth' ) . '">';
	foreach ( $links as $code => $link ) {
		$out .= sprintf(
			'<a href="%s" hreflang="%s" lang="%s"%s>%s</a>',
			esc_url( $link['url'] ),
			esc_attr( $code ),
			esc_attr( $code ),
			$link['current'] ? ' aria-current="true"' : '',
			esc_html( $link['native'] )
		);
	}
	return $out . '</nav>';
}

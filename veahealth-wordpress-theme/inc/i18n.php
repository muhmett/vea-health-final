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
	/*
	 * An explicit override wins over the request. Building a French treatment
	 * page from a request that has no prefix on it — the importer, WP-CLI, an
	 * admin screen — is the whole reason this exists: without it the locale
	 * filter below hands back the request's language and quietly overrules
	 * switch_to_locale(), which is how a translated page ended up with English
	 * table headings baked into it.
	 */
	$forced = veahealth_lang_forced();
	if ( '' !== $forced ) {
		return $forced;
	}

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
 * Render as a given language, whatever the request says.
 *
 * Call with a code to switch, with '' to stop. Returns the code in force.
 * Paired with switch_to_locale() by the callers that build content for a
 * language other than the one being requested.
 *
 * @param string|null $set Language code to force, '' to clear, null to read.
 * @return string
 */
function veahealth_lang_forced( $set = null ) {
	static $forced = '';
	if ( null !== $set ) {
		$forced = ( '' !== $set && veahealth_lang_valid( $set ) ) ? $set : '';
	}
	return $forced;
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
	if ( is_admin() || 'any' === $query->get( 'lang' ) ) {
		return;
	}
	if ( $query->is_main_query() && $query->is_singular() ) {
		return;                                  // a permalink is unambiguous
	}

	/*
	 * Secondary queries are filtered too, which is not fussiness: the related
	 * treatments rail, the navigation's treatment list and the archive are all
	 * get_posts() calls, and every one of them was offering the English page
	 * as a related treatment at the bottom of the Arabic one. Filtering here
	 * rather than at each call site also covers the next one somebody writes.
	 *
	 * Only the post types that have translations — anything else, a query for
	 * attachments or a menu, is left alone rather than being made to carry a
	 * meta condition it can never satisfy.
	 */
	$types      = (array) $query->get( 'post_type' );
	$translated = array( 'page', 'post', 'service' );
	if ( ! $query->is_main_query() ) {
		if ( ! $types || ! array_intersect( $types, $translated ) ) {
			return;
		}
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
   Creating the translated pages
   ========================================================================== */

/**
 * The translation of a post in one language, if it exists.
 *
 * @param int    $post_id Any post in the group.
 * @param string $lang    Language wanted.
 * @return int Post id, or 0.
 */
function veahealth_post_in( $post_id, $lang ) {
	$found = veahealth_post_translations( $post_id );
	return isset( $found[ $lang ] ) ? (int) $found[ $lang ] : 0;
}

/**
 * Create or update the company pages in every language.
 *
 * Idempotent, and matched on the translation group rather than the slug: run
 * it twice and it edits rather than duplicates, and an editor who renames a
 * translated page keeps their title instead of having it overwritten on the
 * next import.
 *
 * @return int How many pages were created.
 */
function veahealth_lang_sync_pages() {
	if ( ! function_exists( 'veahealth_pages_i18n' ) ) {
		return 0;
	}
	$made = 0;

	foreach ( veahealth_pages_i18n() as $slug => $langs ) {
		$source = get_page_by_path( $slug );
		if ( ! $source ) {
			continue;
		}
		$group = (string) $source->ID;
		update_post_meta( $source->ID, VEAHEALTH_GROUP_META, $group );

		foreach ( $langs as $lang => $t ) {
			$existing = get_posts(
				array(
					'post_type'        => 'page',
					'post_status'      => 'any',
					'posts_per_page'   => 1,
					'no_found_rows'    => true,
					'suppress_filters' => false,
					'lang'             => 'any',
					'meta_query'       => array(
						'relation' => 'AND',
						array( 'key' => VEAHEALTH_GROUP_META, 'value' => $group ),
						array( 'key' => VEAHEALTH_LANG_META, 'value' => $lang ),
					),
				)
			);
			if ( $existing ) {
				continue;                    // already there; leave the editor's copy alone
			}

			$id = wp_insert_post(
				array(
					'post_type'    => 'page',
					'post_status'  => 'publish',
					'post_title'   => $t['title'],
					'post_name'    => $t['slug'],
					'post_excerpt' => $t['excerpt'],
					/*
					 * Most of these pages carry no body of their own — their
					 * prose is in the template and is translated through
					 * gettext, so copying the English body copies nothing but
					 * the wrapper. The legal pages are the exception: their
					 * text is stored, so a translation has to supply it.
					 */
					'post_content' => isset( $t['content'] ) ? $t['content'] : $source->post_content,
					'menu_order'   => $source->menu_order,
					'meta_input'   => array(
						VEAHEALTH_LANG_META  => $lang,
						VEAHEALTH_GROUP_META => $group,
					),
				),
				true
			);
			if ( is_wp_error( $id ) ) {
				continue;
			}

			// The template is what makes the page render at all — a translated
			// About with no template is a blank page, not a translated one.
			$tpl = get_page_template_slug( $source );
			if ( $tpl ) {
				update_post_meta( $id, '_wp_page_template', $tpl );
			}
			++$made;
		}
	}
	return $made;
}

/**
 * A date in the language being read, without depending on a language pack.
 *
 * date_i18n() takes its month names from WordPress core's own translations,
 * which are a separate download: on a site where the Arabic pack has not been
 * installed, an Arabic page dated "September 1, 2026" is the result, and
 * nothing in the theme can tell that it happened. The twelve names are small
 * enough to carry here, so the theme's dates never depend on what else the
 * site has installed.
 *
 * @param int|string $when   Timestamp, or anything strtotime() understands.
 * @param string     $format Date format for the default language only, where
 *                           the site's own setting is the long one and a card
 *                           wants "27 Aug 2026". The other three read the same
 *                           either way — day, month name, year — so they
 *                           ignore it.
 * @return string
 */
function veahealth_lang_date( $when, $format = '' ) {
	$time = is_numeric( $when ) ? (int) $when : strtotime( (string) $when );
	if ( ! $time ) {
		return '';
	}
	$lang = veahealth_lang();
	if ( veahealth_lang_default() === $lang ) {
		return date_i18n( $format ? $format : get_option( 'date_format' ), $time );
	}

	$months = array(
		'fr' => array( 'janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre' ),
		'ar' => array( 'يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو', 'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر' ),
		'es' => array( 'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre' ),
	);
	if ( ! isset( $months[ $lang ] ) ) {
		return date_i18n( $format ? $format : get_option( 'date_format' ), $time );
	}

	$day   = (int) gmdate( 'j', $time );
	$month = $months[ $lang ][ (int) gmdate( 'n', $time ) - 1 ];
	$year  = gmdate( 'Y', $time );

	// Spanish writes the day and the year with "de"; the other two do not.
	return 'es' === $lang
		? sprintf( '%d de %s de %s', $day, $month, $year )
		: sprintf( '%d %s %s', $day, $month, $year );
}

/**
 * Run something as if the site were being read in a given language.
 *
 * Two things have to move together and neither is enough alone. switch_to_locale()
 * changes which .mo gettext reads, and the theme's own language — the one the
 * router derived from the URL — has to change with it, or the locale filter
 * puts the request's language straight back.
 *
 * The textdomain is unloaded and loaded again around the switch because a
 * domain already in memory stays in memory: without this the second language
 * built in one run would come out in the first one's words.
 *
 * @param string   $lang     Language code.
 * @param callable $callback What to run.
 * @return mixed Whatever the callback returns.
 */
function veahealth_lang_render_as( $lang, $callback ) {
	$locale = isset( veahealth_languages()[ $lang ] ) ? veahealth_languages()[ $lang ]['locale'] : '';
	if ( ! $locale ) {
		return $callback();
	}

	$was    = veahealth_lang_forced();
	$switch = switch_to_locale( $locale );
	veahealth_lang_forced( $lang );
	/*
	 * The second argument is what makes this work more than once. Without it
	 * WordPress remembers the domain as deliberately unloaded and refuses to
	 * load it again, so the first language in a run came out translated and
	 * every one after it came out English.
	 */
	unload_textdomain( 'veahealth', true );
	load_theme_textdomain( 'veahealth', VEAHEALTH_DIR . '/languages' );

	$out = $callback();

	veahealth_lang_forced( $was );
	if ( $switch ) {
		restore_previous_locale();
	}
	unload_textdomain( 'veahealth', true );
	load_theme_textdomain( 'veahealth', VEAHEALTH_DIR . '/languages' );

	return $out;
}

/**
 * Create the treatment pages in every language.
 *
 * Same contract as the company pages: idempotent, matched on the translation
 * group rather than the slug, and it never touches a translated post that
 * already exists — an owner who rewrote a paragraph in the editor keeps their
 * words the next time the importer runs.
 *
 * A treatment with no translation for a language is skipped entirely. The
 * alternative is a page with an English body on an Arabic URL, which is worse
 * for a reader than a treatment that is simply not there yet, and worse for
 * search engines than a page that does not exist.
 *
 * The body is built inside switch_to_locale() because the treatment page is
 * two kinds of text at once: the clinical prose, which comes from the
 * translation file, and the furniture around it — section headings, table
 * captions, the word for "Excellent" — which the renderers emit through
 * gettext. Without the switch the second kind would come out English.
 *
 * @return int How many treatments were created.
 */
function veahealth_lang_sync_services() {
	if ( ! function_exists( 'veahealth_service_meta_in' ) ) {
		return 0;
	}
	$made = 0;

	foreach ( veahealth_service_data() as $slug => $unused ) {
		$source = get_page_by_path( $slug, OBJECT, 'service' );
		if ( ! $source ) {
			continue;
		}
		$group = (string) $source->ID;
		update_post_meta( $source->ID, VEAHEALTH_GROUP_META, $group );

		foreach ( veahealth_lang_codes() as $lang ) {
			if ( veahealth_lang_default() === $lang ) {
				continue;
			}
			$meta = veahealth_service_meta_in( $slug, $lang );
			if ( ! $meta || empty( $meta['title'] ) || empty( $meta['slug'] ) ) {
				continue;                    // not translated yet
			}

			$existing = get_posts(
				array(
					'post_type'        => 'service',
					'post_status'      => 'any',
					'posts_per_page'   => 1,
					'no_found_rows'    => true,
					'suppress_filters' => false,
					'lang'             => 'any',
					'meta_query'       => array(
						'relation' => 'AND',
						array( 'key' => VEAHEALTH_GROUP_META, 'value' => $group ),
						array( 'key' => VEAHEALTH_LANG_META, 'value' => $lang ),
					),
				)
			);
			if ( $existing ) {
				continue;
			}

			$body = veahealth_lang_render_as(
				$lang,
				static function () use ( $slug, $lang ) {
					return veahealth_service_body_html( $slug, $lang );
				}
			);
			if ( ! $body ) {
				continue;
			}

			$id = wp_insert_post(
				array(
					'post_type'    => 'service',
					'post_status'  => 'publish',
					'post_title'   => $meta['title'],
					'post_name'    => $meta['slug'],
					'post_excerpt' => isset( $meta['excerpt'] ) ? $meta['excerpt'] : '',
					'post_content' => $body,
					'menu_order'   => $source->menu_order,
					'meta_input'   => array(
						VEAHEALTH_LANG_META  => $lang,
						VEAHEALTH_GROUP_META => $group,
					),
				),
				true
			);
			if ( is_wp_error( $id ) ) {
				continue;
			}

			/*
			 * The meta a treatment page reads: the illustration is shared with
			 * the English page, its alt text and the schema fields are not.
			 * Anything the translation does not supply falls back to the
			 * English value rather than being left empty — an empty alt is a
			 * picture with no description, not a translated one.
			 */
			$carry = array(
				'_vh_art'            => get_post_meta( $source->ID, '_vh_art', true ),
				'_vh_alt'            => isset( $meta['alt'] ) ? $meta['alt'] : get_post_meta( $source->ID, '_vh_alt', true ),
				'_vh_seo_title'      => isset( $meta['seo_title'] ) ? $meta['seo_title'] : $meta['title'],
				'_vh_procedure_type' => isset( $meta['procedure_type'] ) ? $meta['procedure_type'] : get_post_meta( $source->ID, '_vh_procedure_type', true ),
				'_vh_body_location'  => isset( $meta['body_location'] ) ? $meta['body_location'] : get_post_meta( $source->ID, '_vh_body_location', true ),
				'_vh_how_performed'  => isset( $meta['how_performed'] ) ? $meta['how_performed'] : get_post_meta( $source->ID, '_vh_how_performed', true ),
				'_vh_preparation'    => isset( $meta['preparation'] ) ? $meta['preparation'] : get_post_meta( $source->ID, '_vh_preparation', true ),
				'_vh_followup'       => isset( $meta['followup'] ) ? $meta['followup'] : get_post_meta( $source->ID, '_vh_followup', true ),
			);
			foreach ( $carry as $key => $value ) {
				if ( '' !== $value && null !== $value ) {
					update_post_meta( $id, $key, $value );
				}
			}

			/*
			 * Keep the translation in the same group as the English page. The
			 * group names are translated on the way out, in the archive and in
			 * the navigation, rather than by splitting one taxonomy into four:
			 * three duplicate terms per group would divide the archive instead
			 * of translating it.
			 */
			$terms = wp_get_object_terms( $source->ID, 'service_category', array( 'fields' => 'ids' ) );
			if ( $terms && ! is_wp_error( $terms ) ) {
				wp_set_object_terms( $id, $terms, 'service_category' );
			}

			++$made;
		}
	}
	return $made;
}

/**
 * Create the journal articles in every language.
 *
 * Same contract as the pages and the treatments: idempotent, matched on the
 * translation group, and it never touches a translated post that already
 * exists. An article with no translation for a language is skipped rather than
 * created in English on a translated URL.
 *
 * Unlike a treatment, an article's body is stored whole rather than assembled
 * from parts, so there is no locale to switch for — the prose in the file is
 * the prose on the page.
 *
 * @return int How many articles were created.
 */
function veahealth_lang_sync_articles() {
	if ( ! function_exists( 'veahealth_article_in' ) || ! function_exists( 'veahealth_blog_articles' ) ) {
		return 0;
	}
	$made = 0;

	foreach ( veahealth_blog_articles() as $article ) {
		$source = get_page_by_path( $article['slug'], OBJECT, 'post' );
		if ( ! $source ) {
			continue;
		}
		$group = (string) $source->ID;
		update_post_meta( $source->ID, VEAHEALTH_GROUP_META, $group );

		foreach ( veahealth_lang_codes() as $lang ) {
			if ( veahealth_lang_default() === $lang ) {
				continue;
			}
			$t = veahealth_article_in( $article['slug'], $lang );
			if ( empty( $t['title'] ) || empty( $t['slug'] ) || empty( $t['content'] ) ) {
				continue;                    // not translated yet
			}

			$existing = get_posts(
				array(
					'post_type'        => 'post',
					'post_status'      => 'any',
					'posts_per_page'   => 1,
					'no_found_rows'    => true,
					'suppress_filters' => false,
					'lang'             => 'any',
					'meta_query'       => array(
						'relation' => 'AND',
						array( 'key' => VEAHEALTH_GROUP_META, 'value' => $group ),
						array( 'key' => VEAHEALTH_LANG_META, 'value' => $lang ),
					),
				)
			);
			if ( $existing ) {
				continue;
			}

			$id = wp_insert_post(
				array(
					'post_type'    => 'post',
					'post_status'  => 'publish',
					'post_title'   => $t['title'],
					'post_name'    => $t['slug'],
					'post_excerpt' => isset( $t['excerpt'] ) ? $t['excerpt'] : '',
					'post_content' => $t['content'],
					// The same date as the English article. A translation is
					// the same piece of writing, and dating it "today" would
					// put the whole journal in the wrong order in three
					// languages at once.
					'post_date'    => $source->post_date,
					'post_date_gmt' => $source->post_date_gmt,
					'meta_input'   => array(
						VEAHEALTH_LANG_META  => $lang,
						VEAHEALTH_GROUP_META => $group,
					),
				),
				true
			);
			if ( is_wp_error( $id ) ) {
				continue;
			}

			/*
			 * The cover image and the reading time are shared with the English
			 * article; the standfirst and the key points are not. A photograph
			 * credit is a person's name and stays as it is.
			 */
			$carry = array(
				'_vh_dek'        => isset( $t['dek'] ) ? $t['dek'] : get_post_meta( $source->ID, '_vh_dek', true ),
				'_vh_read'       => get_post_meta( $source->ID, '_vh_read', true ),
				'_vh_cover'      => get_post_meta( $source->ID, '_vh_cover', true ),
				'_vh_credit'     => get_post_meta( $source->ID, '_vh_credit', true ),
				'_vh_credit_url' => get_post_meta( $source->ID, '_vh_credit_url', true ),
			);
			foreach ( $carry as $key => $value ) {
				if ( '' !== $value && null !== $value ) {
					update_post_meta( $id, $key, $value );
				}
			}
			update_post_meta( $id, '_vh_keys', isset( $t['keys'] ) ? $t['keys'] : array() );

			$cats = wp_get_post_categories( $source->ID );
			if ( $cats ) {
				wp_set_post_categories( $id, $cats, false );
			}

			++$made;
		}
	}
	return $made;
}

/* ==========================================================================
   Content that is stored, not written in the templates
   ========================================================================== */

/**
 * Translate navigation labels.
 *
 * Menu items are rows in the database, so gettext never sees them and the
 * navigation stayed in English while everything around it changed. The labels
 * themselves are a small fixed set the importer already created through __(),
 * so they are in the catalogue — this looks them up at render time.
 *
 * translate() rather than __() to be explicit that the string is a variable:
 * the lookup is real, but no extractor could have found it here.
 *
 * A treatment name is not in the catalogue and comes back unchanged, which is
 * correct — those are translated with their pages, not as interface.
 */
/**
 * Translate the treatment group names.
 *
 * The three groups are one taxonomy shared by every language rather than four
 * sets of terms, so that a treatment belongs to "Hair restoration" once and
 * appears under it in all four languages. That leaves the name itself to be
 * translated on the way out, which is what this does — in the navigation, in
 * the archive, in the footer and in the breadcrumb, from a single place.
 *
 * @param WP_Term|mixed $term     The term.
 * @param string        $taxonomy Its taxonomy.
 * @return WP_Term|mixed
 */
function veahealth_lang_term_name( $term, $taxonomy ) {
	if ( is_admin() || ! isset( $term->name ) ) {
		return $term;
	}
	$lang = veahealth_lang();
	if ( veahealth_lang_default() === $lang ) {
		return $term;
	}

	if ( 'service_category' === $taxonomy && function_exists( 'veahealth_service_group_in' ) ) {
		$term->name = veahealth_service_group_in( $term->name, $lang );
		return $term;
	}

	/*
	 * The journal's five categories, the same way: one taxonomy shared by all
	 * four languages, with the name translated on the way out. The description
	 * is translated too — it is printed under the heading on a category
	 * archive, where an English sentence over Arabic articles is conspicuous.
	 */
	if ( 'category' === $taxonomy && function_exists( 'veahealth_article_cat_in' ) ) {
		$found = veahealth_article_cat_in( $term->name, $lang );
		$term->name = $found['name'];
		if ( ! empty( $found['description'] ) ) {
			$term->description = $found['description'];
		}
	}
	return $term;
}
add_filter( 'get_term', 'veahealth_lang_term_name', 10, 2 );

/**
 * The same, for the calls that hand back a list.
 *
 * get_term is the filter for one term fetched by id, and the template that
 * builds the breadcrumb does not use it: wp_get_post_terms( ..., 'names' )
 * returns plain strings straight from the object cache, which is how the
 * treatment page ended up with a French title under an English group heading.
 * A list can hold term objects or, with the fields argument, names or slugs —
 * only the first two are ours to touch.
 *
 * @param mixed $terms    Terms, names, slugs or ids.
 * @param mixed $taxonomy Taxonomy, or the object ids depending on the filter.
 * @return mixed
 */
function veahealth_lang_term_names( $terms, $taxonomy = null ) {
	if ( ! is_array( $terms ) || is_admin() ) {
		return $terms;
	}
	$lang = veahealth_lang();
	if ( veahealth_lang_default() === $lang || ! function_exists( 'veahealth_service_group_in' ) ) {
		return $terms;
	}

	foreach ( $terms as $key => $term ) {
		if ( is_object( $term ) && isset( $term->taxonomy, $term->name ) ) {
			if ( 'service_category' === $term->taxonomy ) {
				$terms[ $key ]->name = veahealth_service_group_in( $term->name, $lang );
				continue;
			}
			if ( 'category' === $term->taxonomy && function_exists( 'veahealth_article_cat_in' ) ) {
				$found = veahealth_article_cat_in( $term->name, $lang );
				$terms[ $key ]->name = $found['name'];
				if ( ! empty( $found['description'] ) ) {
					$terms[ $key ]->description = $found['description'];
				}
				continue;
			}
		}
		/*
		 * A bare string is only translated when it is one of the three group
		 * names. Anything else in the list is a slug or another taxonomy's
		 * name and comes back untouched.
		 */
		if ( is_string( $term ) ) {
			$translated = veahealth_service_group_in( $term, $lang );
			if ( $translated !== $term ) {
				$terms[ $key ] = $translated;
			}
		}
	}
	return $terms;
}
add_filter( 'get_terms', 'veahealth_lang_term_names', 10, 2 );
add_filter( 'wp_get_object_terms', 'veahealth_lang_term_names', 10, 2 );
add_filter( 'get_the_terms', 'veahealth_lang_term_names', 10, 2 );

function veahealth_lang_menu_title( $title ) {
	if ( veahealth_lang_default() === veahealth_lang() ) {
		return $title;
	}
	return translate( $title, 'veahealth' );
}
add_filter( 'nav_menu_item_title', 'veahealth_lang_menu_title' );
add_filter( 'the_title', 'veahealth_lang_menu_title' );

/**
 * Point each menu item at the page in the language being read.
 *
 * Translating the label alone gets you an Arabic word linking to an English
 * page — which then does not even redirect, because an English page under an
 * English URL is perfectly correct. The link has to move too.
 *
 * An item with no translation keeps its own URL rather than being dropped: a
 * visitor following it lands on a real page in another language, which is a
 * better outcome than a menu with holes in it.
 */
function veahealth_lang_menu_links( $items ) {
	$lang = veahealth_lang();
	if ( veahealth_lang_default() === $lang ) {
		return $items;
	}
	foreach ( $items as $item ) {
		if ( 'post_type' === $item->type && ! empty( $item->object_id ) ) {
			$id = veahealth_post_in( (int) $item->object_id, $lang );
			if ( $id ) {
				$item->url = get_permalink( $id );

				/*
				 * Take the label from the translated page too. Most menu
				 * labels are short interface words that the catalogue already
				 * carries, which is why the navigation looked translated — but
				 * "Privacy policy" is a page title, not interface, and the
				 * legal row stayed in English while pointing at Arabic pages.
				 *
				 * Only where the label is still the page's own title: a label
				 * an editor typed is their words, and a translation of a page
				 * has no claim on it.
				 */
				$source = get_post( (int) $item->object_id );
				if ( $source && $item->title === $source->post_title ) {
					$item->title = get_the_title( $id );
				}
			}
			continue;
		}
		/*
		 * Home and the treatments archive are custom links, not pages, so the
		 * lookup above never sees them and they were the two items still
		 * pointing at English. They have no translation to find — they only
		 * need the prefix, and an address that is not ours comes back
		 * untouched.
		 */
		if ( ! empty( $item->url ) ) {
			$item->url = veahealth_lang_url( $item->url, $lang );
		}
	}
	return $items;
}
add_filter( 'wp_nav_menu_objects', 'veahealth_lang_menu_links' );

/**
 * Serve each language its own front page.
 *
 * WordPress resolves the front page from one stored id, so without this every
 * language would render the English home page's title and description — which
 * is what search engines read.
 */
function veahealth_lang_front_page( $id ) {
	/*
	 * Guarded against itself. Finding the translation runs a query, a query
	 * reads page_on_front, and reading it calls this filter again — which is
	 * an infinite loop, and one that shows up as a request that never returns
	 * rather than as an error anybody can read.
	 */
	static $busy = false;
	if ( $busy || is_admin() || ! $id || veahealth_lang_default() === veahealth_lang() ) {
		return $id;
	}
	$busy = true;
	$tr   = veahealth_post_in( (int) $id, veahealth_lang() );
	$busy = false;

	return $tr ? $tr : $id;
}
add_filter( 'option_page_on_front', 'veahealth_lang_front_page' );

/**
 * Serve each language its own journal index.
 *
 * The same problem as the front page, and it was worse: WordPress recognises
 * exactly one posts page, so /fr/journal/ was an ordinary page with nothing on
 * it — hero, footer, and not one of the twenty French articles. They existed
 * and were reachable only by a direct link. Pointing the option at the
 * translation makes WordPress treat that page as the index it is, and the loop
 * on it is already filtered to the language being read.
 *
 * @param mixed $id Stored posts page id.
 * @return mixed
 */
function veahealth_lang_posts_page( $id ) {
	static $busy = false;
	if ( $busy || is_admin() || ! $id || veahealth_lang_default() === veahealth_lang() ) {
		return $id;
	}
	$busy = true;
	$tr   = veahealth_post_in( (int) $id, veahealth_lang() );
	$busy = false;

	return $tr ? $tr : $id;
}
add_filter( 'option_page_for_posts', 'veahealth_lang_posts_page' );

/**
 * Translate a Customizer value the clinic has not overridden.
 *
 * The headline and the strapline ship as defaults in English. Once somebody
 * edits one it is their words and must be left exactly as typed — so only a
 * value still identical to the default is looked up, and anything the clinic
 * wrote survives every language.
 *
 * @param mixed  $value Stored or default value.
 * @param string $key   Option key.
 * @return mixed
 */
function veahealth_lang_option( $value, $key ) {
	if ( veahealth_lang_default() === veahealth_lang() || ! is_string( $value ) || '' === $value ) {
		return $value;
	}
	$defaults = function_exists( 'veahealth_defaults' ) ? veahealth_defaults() : array();
	if ( ! isset( $defaults[ $key ] ) || $defaults[ $key ] !== $value ) {
		return $value;                       // the clinic's own words
	}
	return translate( $value, 'veahealth' );
}
add_filter( 'veahealth_option', 'veahealth_lang_option', 10, 2 );

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

/**
 * The switcher: one button, not a row of four.
 *
 * Four language names sitting in the header ate as much room as the navigation
 * itself and pushed the menu around at every breakpoint — for a control most
 * visitors use once, if ever. A globe and the current code hold one slot; the
 * names appear when asked for.
 *
 * A disclosure, not a role="menu": these are ordinary links to ordinary pages,
 * and menu semantics would promise arrow-key application behaviour that a list
 * of links should not have. The button carries aria-expanded, the panel is
 * hidden with the hidden attribute, and the whole thing works from the keyboard
 * with nothing else.
 */
function veahealth_lang_switcher() {
	$links = veahealth_lang_links();
	if ( count( $links ) < 2 ) {
		return '';
	}

	// Two switchers render per page — the header and the drawer — so the id
	// that ties the button to its panel has to differ between them.
	static $n = 0;
	++$n;
	$id = 'lang-menu-' . $n;

	$current = veahealth_lang();
	$conf    = veahealth_languages();
	$label   = isset( $conf[ $current ] ) ? $conf[ $current ]['native'] : $current;

	$out  = '<div class="lang" data-lang>';
	$out .= sprintf(
		'<button class="lang-btn" type="button" aria-expanded="false" aria-controls="%s" aria-label="%s">',
		esc_attr( $id ),
		/* translators: %s: the language currently being read, in its own name. */
		esc_attr( sprintf( __( 'Language: %s. Choose another.', 'veahealth' ), $label ) )
	);
	$out .= veahealth_icon( 'globe' );
	$out .= '<span class="lang-btn__code">' . esc_html( strtoupper( $current ) ) . '</span>';
	$out .= '<span class="lang-btn__caret" aria-hidden="true">' . veahealth_icon( 'caret' ) . '</span>';
	$out .= '</button>';

	$out .= sprintf( '<ul class="lang-menu" id="%s" hidden>', esc_attr( $id ) );
	foreach ( $links as $code => $link ) {
		$out .= sprintf(
			'<li><a href="%s" hreflang="%s" lang="%s"%s><span>%s</span>%s</a></li>',
			esc_url( $link['url'] ),
			esc_attr( $code ),
			esc_attr( $code ),
			$link['current'] ? ' aria-current="true"' : '',
			esc_html( $link['native'] ),
			$link['current'] ? '<span class="lang-menu__tick" aria-hidden="true">' . veahealth_icon( 'check' ) . '</span>' : ''
		);
	}
	$out .= '</ul></div>';

	return $out;
}

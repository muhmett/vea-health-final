<?php
/**
 * The sitemap, in four languages.
 *
 * WordPress builds a perfectly good sitemap and then shows Google a quarter of
 * this site. Two reasons, both structural rather than accidental:
 *
 * The theme filters every query to the language being read, and a request for
 * /wp-sitemap.xml carries no language prefix, so it is read as English and the
 * 153 translated posts, pages and treatments are filtered out of their own
 * sitemap. They are still discoverable — hreflang sits in the head of every
 * page and the switcher links across — but discovery by inference is not the
 * same as being listed, and it is the translated pages that need the help.
 *
 * And a term archive exists once per language at a prefixed path, while
 * WordPress knows one URL per term, so /fr/category/costs-and-money/ and its
 * two siblings were in no sitemap at all.
 *
 * Both are fixed here rather than by replacing the core sitemap, so the theme
 * keeps core's pagination, its lastmod dates, its XSL stylesheet and its
 * robots.txt line.
 *
 * @package VeaHealth
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Let the sitemap see every language.
 *
 * This one argument is what puts the other three languages back: 'any' is the
 * escape hatch veahealth_lang_filter_query() already honours, and every
 * permalink comes out correctly prefixed on its own, because a post's link is
 * built from the post's language and not from the request's.
 *
 * @param array $args WP_Query arguments.
 * @return array
 */
function veahealth_sitemap_query_args( $args ) {
	$args['lang'] = 'any';
	return $args;
}
add_filter( 'wp_sitemaps_posts_query_args', 'veahealth_sitemap_query_args' );

/**
 * List each front page at the address it actually answers on.
 *
 * A static front page has two addresses — /home/ and / — and WordPress puts
 * the first one in the sitemap, where it is a redirect. Search Console reports
 * those as "Page with redirect", and with four languages that is the four most
 * important URLs on the site reported as errors. The canonical address is the
 * language root.
 *
 * @param array   $entry     Sitemap entry.
 * @param WP_Post $post      The post.
 * @param string  $post_type Post type name.
 * @return array
 */
function veahealth_sitemap_front_page_entry( $entry, $post, $post_type ) {
	if ( 'page' !== $post_type || ! function_exists( 'veahealth_lang_url' ) ) {
		return $entry;
	}

	$front = (int) get_option( 'page_on_front' );
	if ( ! $front ) {
		return $entry;
	}

	// Matched on the translation group, so all four front pages are caught by
	// one comparison rather than by looking each language up separately.
	$group = (string) get_post_meta( $front, VEAHEALTH_GROUP_META, true );
	$mine  = (string) get_post_meta( $post->ID, VEAHEALTH_GROUP_META, true );
	if ( (int) $post->ID !== $front && ( '' === $group || $mine !== $group ) ) {
		return $entry;
	}

	$entry['loc'] = veahealth_lang_url( veahealth_home_raw(), veahealth_post_lang( $post->ID ) );
	return $entry;
}
add_filter( 'wp_sitemaps_posts_entry', 'veahealth_sitemap_front_page_entry', 10, 3 );

/*
 * The provider below extends a core class. It is declared conditionally
 * because a site can switch sitemaps off, and a theme that fatals when it is
 * off is worse than a theme with no sitemap.
 */
if ( class_exists( 'WP_Sitemaps_Provider' ) ) {

	/**
	 * The term archives that only exist under a language prefix.
	 *
	 * Terms are shared by all four languages — an article belongs to "Costs and
	 * money" once and appears under it everywhere — so WordPress lists each term
	 * once, at its unprefixed address. That address is the English archive. The
	 * other three are real pages with translated names, descriptions and posts,
	 * and this is what lists them.
	 */
	class VeaHealth_Translated_Terms_Sitemap extends WP_Sitemaps_Provider {

		/**
		 * Sets up the provider.
		 */
		public function __construct() {
			/*
			 * One lowercase word, no hyphen. Core routes a sitemap page with
			 * ^wp-sitemap-([a-z]+?)-(\d+?)\.xml$, and it tries the
			 * provider-plus-subtype rule first — so a two-word name is read as
			 * a provider that does not exist plus a subtype, and the page
			 * comes back empty while the index still advertises it.
			 */
			$this->name        = 'translations';
			$this->object_type = 'translations';
		}

		/**
		 * Every prefixed term archive on the site.
		 *
		 * The default language is skipped: core already lists it, and a URL in
		 * two sitemaps is a URL Google has to work out is one page.
		 *
		 * @return array[] Sitemap entries.
		 */
		private function all_urls() {
			static $urls = null;
			if ( null !== $urls ) {
				return $urls;
			}
			$urls = array();

			if ( ! function_exists( 'veahealth_lang_codes' ) ) {
				return $urls;
			}

			foreach ( array( 'category', 'service_category' ) as $taxonomy ) {
				$terms = get_terms(
					array(
						'taxonomy'   => $taxonomy,
						'hide_empty' => true,
					)
				);
				if ( is_wp_error( $terms ) ) {
					continue;
				}
				foreach ( $terms as $term ) {
					$link = get_term_link( $term, $taxonomy );
					if ( is_wp_error( $link ) ) {
						continue;
					}
					foreach ( veahealth_lang_codes() as $lang ) {
						if ( veahealth_lang_default() === $lang ) {
							continue;
						}
						$urls[] = array( 'loc' => veahealth_lang_url( $link, $lang ) );
					}
				}
			}
			return $urls;
		}

		/**
		 * One page of the list.
		 *
		 * @param int    $page_num       Page of results, from 1.
		 * @param string $object_subtype Unused; this provider has no subtypes.
		 * @return array[]
		 */
		public function get_url_list( $page_num, $object_subtype = '' ) {
			$per  = wp_sitemaps_get_max_urls( $this->object_type );
			$page = max( 1, (int) $page_num );
			return array_slice( $this->all_urls(), ( $page - 1 ) * $per, $per );
		}

		/**
		 * How many pages the list runs to.
		 *
		 * @param string $object_subtype Unused; this provider has no subtypes.
		 * @return int
		 */
		public function get_max_num_pages( $object_subtype = '' ) {
			$count = count( $this->all_urls() );
			if ( ! $count ) {
				return 0;
			}
			return (int) ceil( $count / wp_sitemaps_get_max_urls( $this->object_type ) );
		}
	}

	/**
	 * Register it once the sitemap server exists.
	 */
	function veahealth_sitemap_register_terms() {
		if ( function_exists( 'wp_register_sitemap_provider' ) ) {
			wp_register_sitemap_provider( 'translations', new VeaHealth_Translated_Terms_Sitemap() );
		}
	}
	add_action( 'init', 'veahealth_sitemap_register_terms', 20 );
}

<?php
/**
 * The journal, in every language.
 *
 * Same arrangement as the treatments: one file per language, loaded only when
 * a translated article is being created, never on a front-end request. What
 * differs is the shape of what is stored. A treatment is a structure of short
 * fields, so those are keyed by the English string each replaces and shared
 * across pages. An article is one piece of prose that appears once, so the
 * body is stored whole.
 *
 * Cross-links inside an article point at treatment pages, and they are
 * rewritten to the translated slug when the file is built rather than by hand.
 * A "read next" link that lands on the English page is the same failure as an
 * English page under an Arabic URL, and it is the easiest one to miss.
 *
 * @package VeaHealth
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Everything stored for one language.
 *
 * @param string $lang Language code.
 * @return array{cats:array<string,array{name:string,description:string}>,posts:array<string,array>}
 */
function veahealth_article_i18n( $lang ) {
	static $cache = array();
	if ( isset( $cache[ $lang ] ) ) {
		return $cache[ $lang ];
	}

	$empty = array( 'cats' => array(), 'posts' => array() );
	$file  = VEAHEALTH_DIR . '/inc/articles-i18n/' . $lang . '.php';
	if ( ! preg_match( '/^[a-z_]{2,8}$/', $lang ) || ! is_readable( $file ) ) {
		$cache[ $lang ] = $empty;
		return $empty;
	}

	$data = require $file;
	if ( ! is_array( $data ) ) {
		$data = array();
	}
	$cache[ $lang ] = array_merge( $empty, $data );
	return $cache[ $lang ];
}

/**
 * One article's title, slug, standfirst, key points and body in one language.
 *
 * Empty where the article has not been translated, and the caller creates
 * nothing rather than an English article on a translated URL.
 *
 * @param string $slug English slug.
 * @param string $lang Language code.
 * @return array
 */
function veahealth_article_in( $slug, $lang ) {
	$map = veahealth_article_i18n( $lang );
	return isset( $map['posts'][ $slug ] ) ? $map['posts'][ $slug ] : array();
}

/**
 * A journal category's name and description in one language.
 *
 * The five categories are one taxonomy shared by every language, like the
 * treatment groups — an article belongs to "Costs and money" once and appears
 * under it in all four. Only the name shown is translated.
 *
 * @param string $name English category name.
 * @param string $lang Language code.
 * @return array{name:string,description:string} Falls back to the English name.
 */
function veahealth_article_cat_in( $name, $lang ) {
	$map = veahealth_article_i18n( $lang );
	if ( isset( $map['cats'][ $name ] ) ) {
		return $map['cats'][ $name ];
	}
	// Term names are stored sanitised, so "Costs & money" comes back as an
	// entity and never matches the key it was written from.
	$decoded = html_entity_decode( $name, ENT_QUOTES, 'UTF-8' );
	return isset( $map['cats'][ $decoded ] )
		? $map['cats'][ $decoded ]
		: array( 'name' => $name, 'description' => '' );
}

/**
 * How many articles are translated into a language.
 *
 * @param string $lang Language code.
 * @return array{done:int,total:int}
 */
function veahealth_article_i18n_coverage( $lang ) {
	$total = function_exists( 'veahealth_blog_articles' ) ? count( veahealth_blog_articles() ) : 0;
	$map   = veahealth_article_i18n( $lang );
	return array( 'done' => count( $map['posts'] ), 'total' => $total );
}

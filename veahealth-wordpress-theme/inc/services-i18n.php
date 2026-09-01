<?php
/**
 * The treatments, in every language.
 *
 * A treatment page is not interface text. It is roughly 1,200 words of
 * clinical prose per treatment, and 21 of them, which is why none of it is in
 * the gettext catalogue: a .mo file that carried it would be loaded on every
 * request to a site that needs it once, when the pages are created.
 *
 * So the translations live in one file per language, keyed by the English
 * string they replace, and nothing reads them until a translated treatment is
 * being built. Keying by the source string rather than by a path through the
 * data means a phrase that appears in eleven treatments — "Is the warranty
 * valid internationally?" — is translated once and is the same sentence on all
 * eleven pages, which is what a reader comparing two treatments expects.
 *
 * The clinical vocabulary itself is fixed in glossary.php and every
 * translation here uses it: a graft is a طُعم, never a بُصيلة, and the sapphire
 * is the blade rather than the graft. Getting that wrong in Arabic is not a
 * style problem — it is telling a patient something untrue about what is being
 * put into their head.
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
 * @return array{strings:array<string,string>,meta:array<string,array>,groups:array<string,string>}
 */
function veahealth_service_i18n( $lang ) {
	static $cache = array();
	if ( isset( $cache[ $lang ] ) ) {
		return $cache[ $lang ];
	}

	$empty = array( 'strings' => array(), 'meta' => array(), 'groups' => array() );
	$file  = VEAHEALTH_DIR . '/inc/services-i18n/' . $lang . '.php';
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
 * Keys whose values are never prose.
 *
 * Identifiers, filenames and flags obviously. Also three that look like text
 * and are not: a citation is a list of author names and a year, a figure is a
 * number, and a price is a currency amount — translating any of them would be
 * inventing a source, a statistic or a price.
 *
 * @return string[]
 */
function veahealth_service_i18n_skip() {
	return array( 'slug', 'image', 'good', 'bad', 'n', 'price', 'art', 'alt' );
}

/**
 * Keys translated where a translation exists, and never required.
 *
 * A citation is "Chen & Buser (2009) · ITI Consensus Statements" — author
 * names and a journal, which stay as they are in every language, and inventing
 * an Arabic version of a paper's title would be inventing a source. But the
 * same field sometimes holds a plain description of a body of work rather than
 * a reference, and a headline figure is sometimes a word ("Superior") rather
 * than a number. So both are translated when the translation file says so, and
 * neither is counted against a treatment when it does not.
 *
 * @return string[]
 */
function veahealth_service_i18n_optional() {
	return array( 'figure', 'source' );
}

/**
 * One treatment's structured body, translated.
 *
 * A string with no translation is left in English rather than dropped. A half
 * translated page is poor; a page with a hole in it is broken, and on a
 * treatment page a hole is a missing warning or a missing step.
 *
 * @param string $slug Treatment slug.
 * @param string $lang Language code.
 * @return array
 */
function veahealth_service_parts_in( $slug, $lang ) {
	$parts = veahealth_service_parts( $slug );
	if ( ! $parts ) {
		return array();
	}
	$map = veahealth_service_i18n( $lang );
	if ( ! $map['strings'] ) {
		return $parts;
	}
	return veahealth_service_i18n_walk( $parts, $map['strings'], veahealth_service_i18n_skip() );
}

/**
 * Replace every prose string in a structure, leaving its shape alone.
 *
 * @param mixed    $value Structure or string.
 * @param string[] $map   English string => translation.
 * @param string[] $skip  Keys never translated.
 * @return mixed
 */
function veahealth_service_i18n_walk( $value, $map, $skip ) {
	if ( is_array( $value ) ) {
		$out = array();
		foreach ( $value as $key => $item ) {
			$out[ $key ] = ( is_string( $key ) && in_array( $key, $skip, true ) )
				? $item
				: veahealth_service_i18n_walk( $item, $map, $skip );
		}
		return $out;
	}
	if ( is_string( $value ) && isset( $map[ $value ] ) ) {
		return $map[ $value ];
	}
	return $value;
}

/**
 * A treatment's title, slug, excerpt and search description in one language.
 *
 * Returns an empty array where the treatment has not been translated yet, and
 * the caller creates nothing rather than a page with an English title on an
 * Arabic URL.
 *
 * @param string $slug Treatment slug in English.
 * @param string $lang Language code.
 * @return array
 */
function veahealth_service_meta_in( $slug, $lang ) {
	$map = veahealth_service_i18n( $lang );
	return isset( $map['meta'][ $slug ] ) ? $map['meta'][ $slug ] : array();
}

/**
 * A treatment group's name in one language.
 *
 * @param string $name English group name.
 * @param string $lang Language code.
 * @return string Translated name, or the English one.
 */
function veahealth_service_group_in( $name, $lang ) {
	$map = veahealth_service_i18n( $lang );
	if ( isset( $map['groups'][ $name ] ) ) {
		return $map['groups'][ $name ];
	}
	/*
	 * "Oral surgery & implants" is stored by WordPress as "Oral surgery &amp;
	 * implants" — term names are sanitised on the way in. Looking up the
	 * ampersand as written is what left the group heading in English on an
	 * otherwise French page, and it is invisible until you print the bytes.
	 */
	$decoded = html_entity_decode( $name, ENT_QUOTES, 'UTF-8' );
	return isset( $map['groups'][ $decoded ] ) ? $map['groups'][ $decoded ] : $name;
}

/**
 * Which treatments are translated into a language, and how completely.
 *
 * The admin needs to be able to say "sixteen of twenty-one", and the sync
 * needs to skip the rest. Completeness is measured against the strings the
 * treatment actually uses, not against the file.
 *
 * @param string $lang Language code.
 * @return array<string,array{done:int,total:int}> Keyed by treatment slug.
 */
function veahealth_service_i18n_coverage( $lang ) {
	$map  = veahealth_service_i18n( $lang );
	$skip = veahealth_service_i18n_skip();
	$out  = array();

	foreach ( veahealth_service_data() as $slug => $parts ) {
		$found = array();
		veahealth_service_i18n_collect( $parts, $skip, $found );
		$done = 0;
		foreach ( $found as $string ) {
			if ( isset( $map['strings'][ $string ] ) ) {
				++$done;
			}
		}
		$out[ $slug ] = array(
			'done'  => $done,
			'total' => count( $found ),
			'meta'  => (bool) veahealth_service_meta_in( $slug, $lang ),
		);
	}
	return $out;
}

/**
 * Every prose string in a structure, deduplicated.
 *
 * @param mixed    $value Structure or string.
 * @param string[] $skip  Keys never translated.
 * @param array    $out   Collected strings, by reference.
 * @return void
 */
function veahealth_service_i18n_collect( $value, $skip, &$out ) {
	$optional = veahealth_service_i18n_optional();
	if ( is_array( $value ) ) {
		foreach ( $value as $key => $item ) {
			if ( is_string( $key ) && ( in_array( $key, $skip, true ) || in_array( $key, $optional, true ) ) ) {
				continue;
			}
			veahealth_service_i18n_collect( $item, $skip, $out );
		}
		return;
	}
	/*
	 * A string with no letter in it is a number, a price or a symbol — "90–96%",
	 * "€500 – €900", "1–2". Those are the same in every language, and counting
	 * them as untranslated would report a finished treatment as 137 of 144.
	 */
	if ( is_string( $value ) && '' !== trim( $value ) && preg_match( '/\p{L}/u', $value ) ) {
		$out[ $value ] = $value;
	}
}

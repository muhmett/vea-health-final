<?php
/**
 * Verify the generated journal translations against the English source:
 * every article present, every field filled, and an HTML structure that
 * matches the English tag for tag and heading id for heading id.
 *
 * Run from this directory:  php check.php
 */
define( 'ABSPATH', 1 );
function add_filter() {}
function __( $s, $d = '' ) { return $s; }
require __DIR__ . '/../../blog-data.php';

/** Count the opening tags in a body, so two bodies can be compared. */
function veahealth_check_tags( $html ) {
	preg_match_all( '/<(\/?)([a-z0-9]+)/i', $html, $m );
	$counts = array();
	foreach ( $m[2] as $i => $tag ) {
		if ( '' === $m[1][ $i ] ) {
			$counts[ $tag ] = ( $counts[ $tag ] ?? 0 ) + 1;
		}
	}
	ksort( $counts );
	return $counts;
}

/** The heading anchors, which stay in English and must stay in order. */
function veahealth_check_ids( $html ) {
	preg_match_all( '/id="([^"]+)"/', $html, $m );
	return $m[1];
}

$english = array();
foreach ( veahealth_blog_articles() as $article ) {
	$english[ $article['slug'] ] = $article;
}

$problems = 0;
foreach ( array( 'fr', 'ar', 'es' ) as $lang ) {
	$data = include __DIR__ . '/../' . $lang . '.php';

	foreach ( array_diff( array_keys( $english ), array_keys( $data['posts'] ) ) as $missing ) {
		echo "$lang: no translation for $missing\n";
		$problems++;
	}
	foreach ( array_diff( array_keys( $data['posts'] ), array_keys( $english ) ) as $extra ) {
		echo "$lang: $extra is translated but no longer exists in English\n";
		$problems++;
	}

	$slugs = array();
	foreach ( $data['posts'] as $slug => $post ) {
		foreach ( array( 'title', 'slug', 'excerpt', 'dek', 'keys', 'content' ) as $field ) {
			if ( empty( $post[ $field ] ) ) {
				echo "$lang/$slug: $field is empty\n";
				$problems++;
			}
		}
		if ( isset( $slugs[ $post['slug'] ] ) ) {
			echo "$lang/$slug: slug collides with " . $slugs[ $post['slug'] ] . "\n";
			$problems++;
		}
		$slugs[ $post['slug'] ] = $slug;

		if ( ! isset( $english[ $slug ] ) ) {
			continue;
		}
		if ( veahealth_check_tags( $english[ $slug ]['content'] ) !== veahealth_check_tags( $post['content'] ) ) {
			echo "$lang/$slug: HTML tags do not match the English body\n";
			$problems++;
		}
		if ( veahealth_check_ids( $english[ $slug ]['content'] ) !== veahealth_check_ids( $post['content'] ) ) {
			echo "$lang/$slug: heading ids do not match the English body\n";
			$problems++;
		}
	}

	// Every treatment cross-link must resolve to a slug that language has.
	$treatments = include __DIR__ . '/../../services-i18n/' . $lang . '.php';
	$known      = array();
	foreach ( $treatments['meta'] as $meta ) {
		$known[ $meta['slug'] ] = true;
	}
	foreach ( $data['posts'] as $slug => $post ) {
		preg_match_all( '~%VH_HOME%/services/([^/]+)/~u', $post['content'], $m );
		foreach ( $m[1] as $linked ) {
			if ( ! isset( $known[ $linked ] ) ) {
				echo "$lang/$slug: links to /services/$linked/, which is not a $lang treatment slug\n";
				$problems++;
			}
		}
	}
}

echo $problems ? "\n$problems problem(s)\n" : "60 bodies check out against the English.\n";
exit( $problems ? 1 : 0 );

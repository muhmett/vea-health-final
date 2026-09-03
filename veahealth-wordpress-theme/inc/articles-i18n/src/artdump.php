<?php
/**
 * Print the English journal articles as plain text, one block each, so a
 * translator works from the source rather than from a rendered page — the page
 * adds chrome that does not belong in the stored body.
 *
 * Run from this directory:  php artdump.php [slug]
 */
if ( 'cli' !== PHP_SAPI ) {
	/*
	 * Build tooling, not a page. It ships inside the theme so the translations
	 * stay correctable, but nothing should be able to run it over HTTP — and
	 * it cannot rely on the usual ABSPATH guard, because it defines ABSPATH
	 * itself in order to load the data file.
	 */
	http_response_code( 404 );
	exit;
}

define( 'ABSPATH', 1 );
function add_filter() {}
function __( $s, $d = '' ) { return $s; }
require __DIR__ . '/../../blog-data.php';

$slug = $argv[1] ?? null;
foreach ( veahealth_blog_articles() as $a ) {
	if ( $slug && $a['slug'] !== $slug ) {
		continue;
	}
	echo '===== ', $a['slug'], '  [', $a['cat'], ']  read=', $a['read'], "\n";
	echo 'TITLE: ', $a['title'], "\n";
	echo 'EXCERPT: ', $a['excerpt'], "\n";
	echo 'DEK: ', $a['dek'], "\n";
	foreach ( $a['keys'] as $i => $k ) {
		echo 'KEY', $i, ': ', $k, "\n";
	}
	echo "CONTENT:\n", str_replace( '><', ">\n<", $a['content'] ), "\n\n";
}

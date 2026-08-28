<?php
/**
 * Structured data.
 *
 * The old site published only WebPage, BreadcrumbList and WebSite — no clinic
 * identity, no procedures, no FAQ. This emits the full graph.
 *
 * @package VeaHealth
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function veahealth_org_node() {
	$same_as = array_values(
		array_filter(
			array(
				veahealth_option( 'facebook' ),
				veahealth_option( 'instagram' ),
				veahealth_option( 'youtube' ),
			)
		)
	);

	$hours = array();
	foreach ( preg_split( '/\r\n|\r|\n/', (string) veahealth_option( 'hours' ) ) as $line ) {
		if ( preg_match( '/(\d{1,2}:\d{2}).*?(\d{1,2}:\d{2})/', $line, $m ) ) {
			$hours[] = array(
				'@type'     => 'OpeningHoursSpecification',
				'dayOfWeek' => array( 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday' ),
				'opens'     => $m[1],
				'closes'    => $m[2],
			);
			break;
		}
	}

	$node = array(
		'@type'            => array( 'Organization', 'MedicalBusiness' ),
		'@id'              => home_url( '/#organization' ),
		'name'             => get_bloginfo( 'name' ),
		'url'              => home_url( '/' ),
		'email'            => veahealth_option( 'email' ),
		'telephone'        => veahealth_option( 'phone' ),
		'medicalSpecialty' => array( 'Dentistry', 'PlasticSurgery' ),
		'address'          => array(
			'@type'           => 'PostalAddress',
			'streetAddress'   => veahealth_option( 'street' ),
			'addressLocality' => veahealth_option( 'district' ),
			'addressRegion'   => veahealth_option( 'city' ),
			'postalCode'      => veahealth_option( 'postcode' ),
			'addressCountry'  => 'TR',
		),
		'areaServed'       => array( 'GB', 'IE', 'DE', 'FR', 'NL', 'BE', 'IT', 'ES', 'US', 'CA', 'MA', 'DZ', 'TN' ),
	);

	if ( $same_as ) {
		$node['sameAs'] = $same_as;
	}
	if ( $hours ) {
		$node['openingHoursSpecification'] = $hours;
	}

	$logo = has_custom_logo() ? wp_get_attachment_image_url( get_theme_mod( 'custom_logo' ), 'full' ) : VEAHEALTH_URI . '/assets/img/logo.svg';
	$node['logo'] = array(
		'@type'      => 'ImageObject',
		'@id'        => home_url( '/#logo' ),
		'url'        => $logo,
		'contentUrl' => $logo,
	);

	return $node;
}

function veahealth_website_node() {
	return array(
		'@type'      => 'WebSite',
		'@id'        => home_url( '/#website' ),
		'url'        => home_url( '/' ),
		'name'       => get_bloginfo( 'name' ),
		'publisher'  => array( '@id' => home_url( '/#organization' ) ),
		'inLanguage' => get_bloginfo( 'language' ),
		'potentialAction' => array(
			'@type'       => 'SearchAction',
			'target'      => array(
				'@type'       => 'EntryPoint',
				'urlTemplate' => home_url( '/?s={search_term_string}' ),
			),
			'query-input' => 'required name=search_term_string',
		),
	);
}

function veahealth_breadcrumb_node( $url ) {
	$items = array();
	$i     = 1;
	foreach ( veahealth_current_trail() as $label => $link ) {
		$item = array(
			'@type'    => 'ListItem',
			'position' => $i++,
			'name'     => $label,
		);
		if ( $link ) {
			$item['item'] = $link;
		}
		$items[] = $item;
	}
	return array(
		'@type'           => 'BreadcrumbList',
		'@id'             => $url . '#breadcrumb',
		'itemListElement' => $items,
	);
}

/**
 * Pull the questions and answers out of a treatment's own markup, so the FAQ
 * schema stays in step with the page when an editor changes the copy.
 */
function veahealth_extract_faqs( $html ) {
	$faqs = array();
	if ( ! preg_match_all( '#<details[^>]*class="[^"]*faq-item[^"]*"[^>]*>\s*<summary[^>]*>(.*?)</summary>(.*?)</details>#s', $html, $m, PREG_SET_ORDER ) ) {
		return $faqs;
	}
	foreach ( $m as $set ) {
		$q = trim( wp_strip_all_tags( $set[1] ) );
		$a = trim( wp_strip_all_tags( $set[2] ) );
		if ( $q && $a ) {
			$faqs[] = array( $q, $a );
		}
	}
	return $faqs;
}

function veahealth_json_ld() {
	if ( is_admin() ) {
		return;
	}

	$url   = trailingslashit( home_url( add_query_arg( array() ) ) );
	$graph = array( veahealth_org_node(), veahealth_website_node() );

	$type = 'WebPage';
	$name = wp_get_document_title();
	$desc = get_bloginfo( 'description' );

	if ( is_singular() ) {
		$post = get_queried_object();
		$url  = get_permalink( $post );
		$name = get_the_title( $post );
		$desc = has_excerpt( $post ) ? get_the_excerpt( $post ) : wp_trim_words( wp_strip_all_tags( $post->post_content ), 30 );

		if ( is_singular( 'service' ) ) {
			$type = 'MedicalWebPage';

			$graph[] = array_filter(
				array(
					'@type'         => 'MedicalProcedure',
					'@id'           => $url . '#procedure',
					'name'          => get_the_title( $post ),
					'description'   => $desc,
					'procedureType' => get_post_meta( $post->ID, '_vh_procedure_type', true ),
					'bodyLocation'  => get_post_meta( $post->ID, '_vh_body_location', true ),
					'howPerformed'  => get_post_meta( $post->ID, '_vh_how_performed', true ),
					'preparation'   => get_post_meta( $post->ID, '_vh_preparation', true ),
					'followup'      => get_post_meta( $post->ID, '_vh_followup', true ),
					'provider'      => array( '@id' => home_url( '/#organization' ) ),
					'url'           => $url,
				)
			);

			$faqs = veahealth_extract_faqs( $post->post_content );
			if ( $faqs ) {
				$entities = array();
				foreach ( $faqs as $faq ) {
					$entities[] = array(
						'@type'          => 'Question',
						'name'           => $faq[0],
						'acceptedAnswer' => array( '@type' => 'Answer', 'text' => $faq[1] ),
					);
				}
				$graph[] = array(
					'@type'      => 'FAQPage',
					'@id'        => $url . '#faq',
					'mainEntity' => $entities,
				);
			}
		} elseif ( is_singular( 'post' ) ) {
			$type    = 'Article';
			$graph[] = array(
				'@type'            => 'Article',
				'@id'              => $url . '#article',
				'headline'         => get_the_title( $post ),
				'description'      => $desc,
				'datePublished'    => get_the_date( 'c', $post ),
				'dateModified'     => get_the_modified_date( 'c', $post ),
				'author'           => array( '@id' => home_url( '/#organization' ) ),
				'publisher'        => array( '@id' => home_url( '/#organization' ) ),
				'mainEntityOfPage' => $url,
				'image'            => get_the_post_thumbnail_url( $post, 'veahealth-wide' ),
			);
		}
	} elseif ( is_post_type_archive( 'service' ) ) {
		$url  = get_post_type_archive_link( 'service' );
		$type = 'CollectionPage';
		$name = post_type_archive_title( '', false );
	}

	$page = array(
		'@type'      => $type,
		'@id'        => $url . '#webpage',
		'url'        => $url,
		'name'       => $name,
		'description'=> $desc,
		'isPartOf'   => array( '@id' => home_url( '/#website' ) ),
		'about'      => array( '@id' => home_url( '/#organization' ) ),
		'breadcrumb' => array( '@id' => $url . '#breadcrumb' ),
		'inLanguage' => get_bloginfo( 'language' ),
	);

	$graph[] = $page;
	$graph[] = veahealth_breadcrumb_node( $url );

	printf(
		'<script type="application/ld+json">%s</script>' . "\n",
		wp_json_encode(
			array( '@context' => 'https://schema.org', '@graph' => $graph ),
			JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
		)
	);
}
add_action( 'wp_head', 'veahealth_json_ld', 20 );

/**
 * Open Graph and Twitter tags. WordPress emits none by default and the old
 * site's pages carried two competing sets.
 */
function veahealth_social_meta() {
	if ( is_admin() ) {
		return;
	}

	$title = wp_get_document_title();
	$desc  = get_bloginfo( 'description' );
	$image = VEAHEALTH_URI . '/assets/img/clinic/vea-health-clinic-lounge-istanbul.webp';
	$url   = home_url( add_query_arg( array() ) );

	if ( is_singular() ) {
		$post = get_queried_object();
		$url  = get_permalink( $post );
		$desc = has_excerpt( $post ) ? get_the_excerpt( $post ) : wp_trim_words( wp_strip_all_tags( $post->post_content ), 30 );
		if ( has_post_thumbnail( $post ) ) {
			$image = get_the_post_thumbnail_url( $post, 'veahealth-wide' );
		} elseif ( is_singular( 'service' ) ) {
			$image = veahealth_service_image( $post->ID, 'full' );
		}
	} elseif ( is_front_page() ) {
		$image = VEAHEALTH_URI . '/assets/img/art/hero-istanbul-bosphorus-1600.webp';
	}

	$tags = array(
		'og:type'        => is_singular( 'post' ) ? 'article' : 'website',
		'og:site_name'   => get_bloginfo( 'name' ),
		'og:locale'      => get_bloginfo( 'language' ),
		'og:title'       => $title,
		'og:description' => $desc,
		'og:url'         => $url,
		'og:image'       => $image,
	);
	foreach ( $tags as $property => $content ) {
		printf( '<meta property="%s" content="%s">' . "\n", esc_attr( $property ), esc_attr( $content ) );
	}
	echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
	printf( '<meta name="description" content="%s">' . "\n", esc_attr( $desc ) );
	printf( '<link rel="canonical" href="%s">' . "\n", esc_url( $url ) );
}
add_action( 'wp_head', 'veahealth_social_meta', 3 );

/** WordPress also prints a canonical; ours is the single source of truth. */
remove_action( 'wp_head', 'rel_canonical' );

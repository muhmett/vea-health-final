<?php
/**
 * Custom post types and taxonomies.
 *
 * `service` keeps the /services/<slug>/ URL shape the old site used, so every
 * existing inbound link and ranking keeps working.
 *
 * @package VeaHealth
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function veahealth_register_types() {

	register_post_type(
		'service',
		array(
			'labels'        => array(
				'name'               => __( 'Treatments', 'veahealth' ),
				'singular_name'      => __( 'Treatment', 'veahealth' ),
				'add_new_item'       => __( 'Add treatment', 'veahealth' ),
				'edit_item'          => __( 'Edit treatment', 'veahealth' ),
				'new_item'           => __( 'New treatment', 'veahealth' ),
				'view_item'          => __( 'View treatment', 'veahealth' ),
				'search_items'       => __( 'Search treatments', 'veahealth' ),
				'not_found'          => __( 'No treatments yet', 'veahealth' ),
				'all_items'          => __( 'All treatments', 'veahealth' ),
				'menu_name'          => __( 'Treatments', 'veahealth' ),
			),
			'public'        => true,
			'has_archive'   => 'services',
			'rewrite'       => array( 'slug' => 'services', 'with_front' => false ),
			'menu_icon'     => 'dashicons-heart',
			'menu_position' => 20,
			'supports'      => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes', 'revisions', 'custom-fields' ),
			'show_in_rest'  => true,
			'taxonomies'    => array( 'service_category' ),
		)
	);

	register_taxonomy(
		'service_category',
		'service',
		array(
			'labels'            => array(
				'name'          => __( 'Treatment groups', 'veahealth' ),
				'singular_name' => __( 'Treatment group', 'veahealth' ),
				'menu_name'     => __( 'Groups', 'veahealth' ),
			),
			'hierarchical'      => true,
			'public'            => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'rewrite'           => array( 'slug' => 'treatment-group', 'with_front' => false ),
		)
	);

	/**
	 * Enquiries. Not public, not searchable: this is where leads land so they
	 * are visible in the admin even if email delivery fails.
	 */
	register_post_type(
		'vh_enquiry',
		array(
			'labels'            => array(
				'name'          => __( 'Enquiries', 'veahealth' ),
				'singular_name' => __( 'Enquiry', 'veahealth' ),
				'menu_name'     => __( 'Enquiries', 'veahealth' ),
				'not_found'     => __( 'No enquiries yet', 'veahealth' ),
			),
			'public'            => false,
			'show_ui'           => true,
			'show_in_menu'      => true,
			'menu_icon'         => 'dashicons-email-alt',
			'menu_position'     => 21,
			'capability_type'   => 'post',
			'capabilities'      => array( 'create_posts' => 'do_not_allow' ),
			'map_meta_cap'      => true,
			'supports'          => array( 'title' ),
			'has_archive'       => false,
			'rewrite'           => false,
			'exclude_from_search' => true,
		)
	);
}
add_action( 'init', 'veahealth_register_types' );

/**
 * Show the useful fields straight in the enquiries list, so a coordinator can
 * work from the list screen without opening each one.
 */
function veahealth_enquiry_columns( $columns ) {
	return array(
		'cb'         => $columns['cb'],
		'title'      => __( 'Name', 'veahealth' ),
		'vh_email'   => __( 'Email', 'veahealth' ),
		'vh_phone'   => __( 'Phone', 'veahealth' ),
		'vh_country' => __( 'Country', 'veahealth' ),
		'vh_treat'   => __( 'Treatments', 'veahealth' ),
		'vh_timing'  => __( 'Timing', 'veahealth' ),
		'date'       => __( 'Received', 'veahealth' ),
	);
}
add_filter( 'manage_vh_enquiry_posts_columns', 'veahealth_enquiry_columns' );

function veahealth_enquiry_column( $column, $post_id ) {
	$map = array(
		'vh_email'   => 'email',
		'vh_phone'   => 'phone',
		'vh_country' => 'country',
		'vh_treat'   => 'treatments',
		'vh_timing'  => 'timing',
	);
	if ( ! isset( $map[ $column ] ) ) {
		return;
	}
	$value = get_post_meta( $post_id, '_vh_' . $map[ $column ], true );
	if ( 'vh_email' === $column && $value ) {
		printf( '<a href="mailto:%1$s">%1$s</a>', esc_attr( $value ) );
		return;
	}
	if ( 'vh_phone' === $column && $value ) {
		printf( '<a href="tel:%1$s">%1$s</a>', esc_attr( preg_replace( '/[^\d+]/', '', $value ) ) );
		return;
	}
	echo esc_html( $value );
}
add_action( 'manage_vh_enquiry_posts_custom_column', 'veahealth_enquiry_column', 10, 2 );

/** The full message and page of origin, shown on the enquiry edit screen. */
function veahealth_enquiry_metabox() {
	add_meta_box(
		'vh-enquiry-detail',
		__( 'Enquiry details', 'veahealth' ),
		function ( $post ) {
			$fields = array(
				'email'      => __( 'Email', 'veahealth' ),
				'phone'      => __( 'Phone', 'veahealth' ),
				'country'    => __( 'Country', 'veahealth' ),
				'treatments' => __( 'Treatments', 'veahealth' ),
				'timing'     => __( 'Timing', 'veahealth' ),
				'page'       => __( 'Sent from', 'veahealth' ),
				'message'    => __( 'Message', 'veahealth' ),
			);
			echo '<table class="widefat striped"><tbody>';
			foreach ( $fields as $key => $label ) {
				printf(
					'<tr><th style="width:150px">%s</th><td>%s</td></tr>',
					esc_html( $label ),
					nl2br( esc_html( get_post_meta( $post->ID, '_vh_' . $key, true ) ) )
				);
			}
			echo '</tbody></table>';
		},
		'vh_enquiry',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'veahealth_enquiry_metabox' );

/** A badge on the Enquiries menu item for anything not yet opened. */
function veahealth_enquiry_badge() {
	global $menu;
	$new = get_posts(
		array(
			'post_type'      => 'vh_enquiry',
			'post_status'    => 'publish',
			'meta_key'       => '_vh_read',
			'meta_compare'   => 'NOT EXISTS',
			'fields'         => 'ids',
			'posts_per_page' => 50,
		)
	);
	$count = count( $new );
	if ( ! $count ) {
		return;
	}
	foreach ( $menu as $i => $item ) {
		if ( isset( $item[2] ) && 'edit.php?post_type=vh_enquiry' === $item[2] ) {
			$menu[ $i ][0] .= sprintf(
				' <span class="update-plugins count-%1$d"><span class="plugin-count">%1$d</span></span>',
				$count
			);
			break;
		}
	}
}
add_action( 'admin_menu', 'veahealth_enquiry_badge', 999 );

function veahealth_mark_enquiry_read() {
	global $post;
	if ( is_admin() && $post && 'vh_enquiry' === $post->post_type && get_current_screen() && 'post' === get_current_screen()->base ) {
		update_post_meta( $post->ID, '_vh_read', current_time( 'mysql' ) );
	}
}
add_action( 'admin_head', 'veahealth_mark_enquiry_read' );

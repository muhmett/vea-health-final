<?php
/**
 * VeaHealth Turkey theme.
 *
 * @package VeaHealth
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'VEAHEALTH_VERSION', '1.2.0' );
define( 'VEAHEALTH_DIR', get_template_directory() );
define( 'VEAHEALTH_URI', get_template_directory_uri() );

require_once VEAHEALTH_DIR . '/inc/setup.php';
require_once VEAHEALTH_DIR . '/inc/enqueue.php';
require_once VEAHEALTH_DIR . '/inc/cpt.php';
require_once VEAHEALTH_DIR . '/inc/customizer.php';
require_once VEAHEALTH_DIR . '/inc/data.php';
require_once VEAHEALTH_DIR . '/inc/template-tags.php';
require_once VEAHEALTH_DIR . '/inc/schema.php';
require_once VEAHEALTH_DIR . '/inc/enquiry.php';
require_once VEAHEALTH_DIR . '/inc/hubspot.php';
require_once VEAHEALTH_DIR . '/inc/content.php';
require_once VEAHEALTH_DIR . '/inc/service-data.php';
require_once VEAHEALTH_DIR . '/inc/service-parts.php';
require_once VEAHEALTH_DIR . '/inc/room.php';
require_once VEAHEALTH_DIR . '/inc/blog-data.php';
require_once VEAHEALTH_DIR . '/inc/importer.php';

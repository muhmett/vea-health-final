<?php
/**
 * One-click content installer.
 *
 * Creates the treatment groups, the 21 treatment pages, the company pages, the
 * two articles and the navigation menus, then sets the front page, the posts
 * page and the permalink structure.
 *
 * Safe to run more than once: everything is matched by slug and updated rather
 * than duplicated, and existing edits to a page are left alone unless the
 * "overwrite" box is ticked.
 *
 * @package VeaHealth
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** The company pages, with the template each one uses. */
function veahealth_page_blueprint() {
	return array(
		'home'         => array(
			'title'    => __( 'Home', 'veahealth' ),
			'template' => '',
			'excerpt'  => __( 'VeaHealth coordinates dental and hair restoration treatment in Istanbul: a written plan and a fixed price before you travel, transfers and hotel arranged, and aftercare once you are home.', 'veahealth' ),
			'content'  => '',
		),
		'journey'      => array(
			'title'    => __( 'The journey', 'veahealth' ),
			'template' => 'page-templates/journey.php',
			'excerpt'  => __( 'How treatment in Istanbul actually works: remote assessment, written quote, airport transfer, hotel, treatment and aftercare once you are home.', 'veahealth' ),
			'content'  => '',
		),
		'before-after' => array(
			'title'    => __( 'Before &amp; after', 'veahealth' ),
			'template' => 'page-templates/results.php',
			'excerpt'  => __( 'Before and after photographs of VeaHealth patients treated in Istanbul, with a drag-to-compare slider.', 'veahealth' ),
			'content'  => '',
		),
		'gallery'      => array(
			'title'    => __( 'Clinic &amp; facilities', 'veahealth' ),
			'template' => 'page-templates/gallery.php',
			'excerpt'  => __( 'Photographs and film from the VeaHealth partner clinic in Istanbul: treatment rooms, laboratory and patient areas.', 'veahealth' ),
			'content'  => '',
		),
		'about'        => array(
			'title'    => __( 'About', 'veahealth' ),
			'template' => 'page-templates/about.php',
			'excerpt'  => __( 'VeaHealth is a medical tourism coordinator in Istanbul working with licensed partner clinics. What we do, what we do not do, and the questions worth asking any coordinator.', 'veahealth' ),
			'content'  => '',
		),
		'contact'      => array(
			'title'    => __( 'Free assessment', 'veahealth' ),
			'template' => 'page-templates/contact.php',
			'excerpt'  => __( 'Send photographs and any recent X-rays for a free assessment. A partner dentist returns an itemised treatment plan with a fixed price, in writing.', 'veahealth' ),
			'content'  => '',
		),
		'blog'         => array(
			'title'    => __( 'Journal', 'veahealth' ),
			'template' => '',
			'excerpt'  => __( 'Notes on treatment, travel and judgement, for patients deciding whether to travel.', 'veahealth' ),
			'content'  => '',
		),
	);
}

/** Find a post of any type by slug. */
function veahealth_find( $slug, $type ) {
	$found = get_posts(
		array(
			'name'           => $slug,
			'post_type'      => $type,
			'post_status'    => array( 'publish', 'draft', 'pending', 'private' ),
			'posts_per_page' => 1,
			'fields'         => 'ids',
		)
	);
	return $found ? (int) $found[0] : 0;
}

/** Create or update one entry. */
function veahealth_upsert( $args, $type, $slug, $overwrite ) {
	$existing = veahealth_find( $slug, $type );

	if ( $existing && ! $overwrite ) {
		/*
		 * WordPress reserves the privacy-policy slug and creates that page as a
		 * draft during installation. Keeping the editor's content is right, but
		 * leaving it unpublished would 404, so publish anything still in draft
		 * and fill an empty one with ours.
		 */
		$post = get_post( $existing );
		if ( $post && 'publish' !== $post->post_status ) {
			$update = array( 'ID' => $existing, 'post_status' => 'publish' );
			if ( '' === trim( wp_strip_all_tags( $post->post_content ) ) ) {
				$update['post_content'] = $args['post_content'];
				$update['post_excerpt'] = $args['post_excerpt'];
			}
			wp_update_post( $update );
			return array( $existing, 'published' );
		}
		return array( $existing, 'kept' );
	}

	$args['post_type']   = $type;
	$args['post_name']   = $slug;
	$args['post_status'] = 'publish';

	if ( $existing ) {
		$args['ID'] = $existing;
		$id         = wp_update_post( $args, true );
		$action     = 'updated';
	} else {
		$id     = wp_insert_post( $args, true );
		$action = 'created';
	}

	if ( is_wp_error( $id ) ) {
		return array( 0, $id->get_error_message() );
	}
	return array( (int) $id, $action );
}

/**
 * Run the install.
 *
 * @param bool $overwrite Replace the content of entries that already exist.
 * @return array Human-readable log lines.
 */
function veahealth_install_content( $overwrite = false ) {
	$log = array();

	/*
	 * Write the content past KSES, the way WordPress's own importer does.
	 *
	 * KSES sanitises post content on insert for anyone without the
	 * unfiltered_html capability, and activation runs with no logged-in user at
	 * all — so every inline <svg> in the treatment pages was being stripped on
	 * the way in. Forty-eight icons a page: the tick beside each step of the
	 * procedure, the marker on each question. This is the theme's own markup,
	 * not anything a visitor supplied, and it is restored below whatever
	 * happens.
	 */
	$kses_was_on = has_filter( 'content_save_pre', 'wp_filter_post_kses' );
	if ( $kses_was_on ) {
		kses_remove_filters();
	}

	try {
		$log = veahealth_install_run( $overwrite );
	} finally {
		if ( $kses_was_on ) {
			kses_init_filters();
		}
	}
	return $log;
}

/**
 * The installer proper. Called by veahealth_install_content() with the content
 * sanitiser suspended; call that rather than this.
 *
 * @param bool $overwrite Replace pages that already exist.
 * @return string[] Log lines.
 */
function veahealth_install_run( $overwrite = false ) {
	$log = array();

	/* ---- permalinks: /services/<slug>/ needs pretty permalinks ---- */
	if ( ! get_option( 'permalink_structure' ) ) {
		global $wp_rewrite;
		$wp_rewrite->set_permalink_structure( '/%postname%/' );
		update_option( 'rewrite_rules', '' );
		$log[] = __( 'Permalinks set to “Post name”.', 'veahealth' );
	}

	/* ---- treatment groups ---- */
	$terms = array();
	foreach ( veahealth_content_groups() as $name ) {
		$term = term_exists( $name, 'service_category' );
		if ( ! $term ) {
			$term = wp_insert_term( $name, 'service_category' );
		}
		if ( ! is_wp_error( $term ) ) {
			$terms[ $name ] = (int) $term['term_id'];
		}
	}
	$log[] = sprintf( _n( '%d treatment group ready.', '%d treatment groups ready.', count( $terms ), 'veahealth' ), count( $terms ) );

	/* ---- treatments ---- */
	$counts = array( 'created' => 0, 'updated' => 0, 'kept' => 0, 'published' => 0 );
	foreach ( veahealth_content_services() as $s ) {
		/*
		 * The body is built from the structured data, not from the HTML the old
		 * site carried. Those pages were complete standalone documents pasted
		 * into the editor — that is what produced the duplicate canonicals and
		 * the 384 KB of page-specific CSS. The words survive; the markup does
		 * not. If a treatment has no structured entry the original is still
		 * used, so nothing can end up with an empty page.
		 */
		$body = veahealth_service_body_html( $s['slug'] );
		if ( ! $body ) {
			$body = $s['content'];
		}
		list( $id, $action ) = veahealth_upsert(
			array(
				'post_title'   => $s['title'],
				'post_content' => $body,
				'post_excerpt' => $s['excerpt'],
				'menu_order'   => $s['order'],
			),
			'service',
			$s['slug'],
			$overwrite
		);
		if ( ! $id ) {
			$log[] = sprintf( __( 'Could not save %1$s: %2$s', 'veahealth' ), $s['slug'], $action );
			continue;
		}
		if ( isset( $counts[ $action ] ) ) {
			$counts[ $action ]++;
		}

		update_post_meta( $id, '_vh_art', $s['art'] );
		update_post_meta( $id, '_vh_alt', $s['alt'] );
		update_post_meta( $id, '_vh_seo_title', $s['seo_title'] );
		update_post_meta( $id, '_vh_procedure_type', $s['procedure_type'] );
		update_post_meta( $id, '_vh_body_location', $s['body_location'] );
		update_post_meta( $id, '_vh_how_performed', $s['how_performed'] );
		update_post_meta( $id, '_vh_preparation', $s['preparation'] );
		update_post_meta( $id, '_vh_followup', $s['followup'] );

		if ( isset( $terms[ $s['group'] ] ) ) {
			wp_set_object_terms( $id, array( $terms[ $s['group'] ] ), 'service_category' );
		}
	}
	$log[] = sprintf(
		__( 'Treatments: %1$d created, %2$d updated, %3$d left as they were.', 'veahealth' ),
		$counts['created'],
		$counts['updated'],
		$counts['kept']
	);

	/* ---- company pages ---- */
	$pages = array();
	$order = 10;
	foreach ( veahealth_page_blueprint() as $slug => $p ) {
		list( $id, $action ) = veahealth_upsert(
			array(
				'post_title'   => $p['title'],
				'post_content' => $p['content'],
				'post_excerpt' => $p['excerpt'],
				'menu_order'   => $order,
			),
			'page',
			$slug,
			$overwrite
		);
		$order += 10;
		if ( $id ) {
			$pages[ $slug ] = $id;
			if ( $p['template'] ) {
				update_post_meta( $id, '_wp_page_template', $p['template'] );
			}
		}
	}

	/* ---- legal pages ---- */
	foreach ( veahealth_content_legal() as $p ) {
		list( $id ) = veahealth_upsert(
			array(
				'post_title'   => $p['title'],
				'post_content' => $p['content'],
				'post_excerpt' => $p['excerpt'],
			),
			'page',
			$p['slug'],
			$overwrite
		);
		if ( $id ) {
			$pages[ $p['slug'] ] = $id;
		}
	}
	$log[] = sprintf( __( 'Pages ready: %d.', 'veahealth' ), count( $pages ) );

	if ( isset( $pages['privacy-policy'] ) ) {
		veahealth_register_privacy_page( $pages['privacy-policy'] );
	}

	/* ---- articles ---- */
	foreach ( veahealth_content_posts() as $p ) {
		veahealth_upsert(
			array(
				'post_title'   => $p['title'],
				'post_content' => $p['content'],
				'post_excerpt' => $p['excerpt'],
				'post_date'    => $p['date'] . ' 09:00:00',
			),
			'post',
			$p['slug'],
			$overwrite
		);
	}
	$log[] = sprintf( __( 'Articles ready: %d.', 'veahealth' ), count( veahealth_content_posts() ) );

	/* ---- front page and posts page ---- */
	if ( isset( $pages['home'] ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $pages['home'] );
		$log[] = __( 'Homepage set to a static page — it was a blog feed before.', 'veahealth' );
	}
	if ( isset( $pages['blog'] ) ) {
		update_option( 'page_for_posts', $pages['blog'] );
	}

	/* ---- menus ---- */
	veahealth_build_menus( $pages );
	$log[] = __( 'Primary and footer menus built and assigned.', 'veahealth' );

	/* ---- a couple of sensible defaults ---- */
	update_option( 'blog_public', 1 );
	if ( 'Just another WordPress site' === get_option( 'blogdescription' ) ) {
		update_option( 'blogdescription', __( 'Dental and hair restoration in Istanbul, coordinated end to end', 'veahealth' ) );
	}

	/*
	 * Rebuild the rewrite rules from scratch. A soft flush is not enough here:
	 * the permalink structure may have changed in this same request, and the
	 * treatment post type registers its /services/ rules on init, so the rules
	 * cached before this point do not know about them yet.
	 */
	veahealth_register_types();
	global $wp_rewrite;
	$wp_rewrite->init();
	flush_rewrite_rules( true );

	update_option( 'veahealth_installed', VEAHEALTH_VERSION );

	return $log;
}

/** Build the primary and footer menus. */
function veahealth_build_menus( $pages ) {
	$menus = array(
		'primary' => __( 'Primary menu', 'veahealth' ),
		'footer'  => __( 'Footer — company', 'veahealth' ),
		'legal'   => __( 'Footer — legal', 'veahealth' ),
	);
	$locations = get_theme_mod( 'nav_menu_locations', array() );

	foreach ( $menus as $location => $name ) {
		$menu = wp_get_nav_menu_object( $name );
		if ( ! $menu ) {
			$menu_id = wp_create_nav_menu( $name );
			if ( is_wp_error( $menu_id ) ) {
				continue;
			}
		} else {
			$menu_id = (int) $menu->term_id;
			foreach ( wp_get_nav_menu_items( $menu_id ) as $item ) {
				wp_delete_post( $item->ID, true );
			}
		}
		$locations[ $location ] = $menu_id;

		if ( 'primary' === $location ) {
			wp_update_nav_menu_item( $menu_id, 0, array(
				'menu-item-title'  => __( 'Home', 'veahealth' ),
				'menu-item-url'    => home_url( '/' ),
				'menu-item-status' => 'publish',
			) );
			$parent = wp_update_nav_menu_item( $menu_id, 0, array(
				'menu-item-title'  => __( 'Treatments', 'veahealth' ),
				'menu-item-url'    => get_post_type_archive_link( 'service' ),
				'menu-item-status' => 'publish',
			) );
			foreach ( get_posts( array( 'post_type' => 'service', 'posts_per_page' => 40, 'orderby' => 'menu_order', 'order' => 'ASC' ) ) as $svc ) {
				wp_update_nav_menu_item( $menu_id, 0, array(
					'menu-item-title'     => get_the_title( $svc ),
					'menu-item-object'    => 'service',
					'menu-item-object-id' => $svc->ID,
					'menu-item-type'      => 'post_type',
					'menu-item-parent-id' => $parent,
					'menu-item-status'    => 'publish',
				) );
			}
			foreach ( array( 'journey', 'before-after', 'gallery', 'about', 'blog' ) as $slug ) {
				if ( isset( $pages[ $slug ] ) ) {
					wp_update_nav_menu_item( $menu_id, 0, array(
						'menu-item-object'    => 'page',
						'menu-item-object-id' => $pages[ $slug ],
						'menu-item-type'      => 'post_type',
						'menu-item-status'    => 'publish',
					) );
				}
			}
		} elseif ( 'footer' === $location ) {
			foreach ( array( 'journey', 'before-after', 'gallery', 'about', 'blog', 'contact' ) as $slug ) {
				if ( isset( $pages[ $slug ] ) ) {
					wp_update_nav_menu_item( $menu_id, 0, array(
						'menu-item-object'    => 'page',
						'menu-item-object-id' => $pages[ $slug ],
						'menu-item-type'      => 'post_type',
						'menu-item-status'    => 'publish',
					) );
				}
			}
		} else {
			foreach ( array( 'privacy-policy', 'cookie-policy', 'terms' ) as $slug ) {
				if ( isset( $pages[ $slug ] ) ) {
					wp_update_nav_menu_item( $menu_id, 0, array(
						'menu-item-object'    => 'page',
						'menu-item-object-id' => $pages[ $slug ],
						'menu-item-type'      => 'post_type',
						'menu-item-status'    => 'publish',
					) );
				}
			}
		}
	}

	set_theme_mod( 'nav_menu_locations', $locations );
}

/* ==========================================================================
   Admin screen
   ========================================================================== */

function veahealth_admin_menu() {
	add_theme_page(
		__( 'VeaHealth setup', 'veahealth' ),
		__( 'VeaHealth setup', 'veahealth' ),
		'edit_theme_options',
		'veahealth-setup',
		'veahealth_setup_screen'
	);
}
add_action( 'admin_menu', 'veahealth_admin_menu' );

function veahealth_setup_screen() {
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		wp_die( esc_html__( 'You do not have permission to do this.', 'veahealth' ) );
	}

	$log = array();
	if ( isset( $_POST['veahealth_install'] ) && check_admin_referer( 'veahealth_install' ) ) {
		$overwrite = ! empty( $_POST['veahealth_overwrite'] );
		$log       = veahealth_install_content( $overwrite );
	}

	$installed = get_option( 'veahealth_installed' );
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'VeaHealth setup', 'veahealth' ); ?></h1>

		<?php if ( $log ) : ?>
			<div class="notice notice-success">
				<p><strong><?php esc_html_e( 'Done.', 'veahealth' ); ?></strong></p>
				<ul style="list-style:disc;margin-left:20px">
					<?php foreach ( $log as $line ) : ?>
						<li><?php echo esc_html( $line ); ?></li>
					<?php endforeach; ?>
				</ul>
				<p>
					<a class="button button-primary" href="<?php echo esc_url( home_url( '/' ) ); ?>" target="_blank">
						<?php esc_html_e( 'View the site', 'veahealth' ); ?>
					</a>
					<a class="button" href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>">
						<?php esc_html_e( 'Set your contact details', 'veahealth' ); ?>
					</a>
				</p>
			</div>
		<?php endif; ?>

		<div class="card" style="max-width:760px;padding:8px 22px 22px">
			<h2><?php esc_html_e( 'Install the content', 'veahealth' ); ?></h2>
			<p>
				<?php esc_html_e( 'This creates everything the site needs in one step:', 'veahealth' ); ?>
			</p>
			<ul style="list-style:disc;margin-left:20px">
				<li><?php esc_html_e( '21 treatment pages, with the full long-form content', 'veahealth' ); ?></li>
				<li><?php esc_html_e( 'Home, The journey, Before &amp; after, Clinic, About, Free assessment and Journal pages', 'veahealth' ); ?></li>
				<li><?php esc_html_e( 'Privacy policy, cookie policy and terms of use', 'veahealth' ); ?></li>
				<li><?php esc_html_e( 'Two articles carried over from the old blog', 'veahealth' ); ?></li>
				<li><?php esc_html_e( 'Primary and footer menus, and the static homepage setting', 'veahealth' ); ?></li>
			</ul>
			<p class="description">
				<?php esc_html_e( 'Nothing already on your site is deleted. Entries that exist are matched by slug and left alone unless you tick the box below.', 'veahealth' ); ?>
			</p>

			<form method="post">
				<?php wp_nonce_field( 'veahealth_install' ); ?>
				<?php if ( $installed ) : ?>
					<p>
						<label>
							<input type="checkbox" name="veahealth_overwrite" value="1">
							<?php esc_html_e( 'Overwrite pages that already exist — this replaces any edits you have made to them.', 'veahealth' ); ?>
						</label>
					</p>
				<?php endif; ?>
				<p>
					<button class="button button-primary button-hero" name="veahealth_install" value="1">
						<?php echo $installed ? esc_html__( 'Run again', 'veahealth' ) : esc_html__( 'Install the content', 'veahealth' ); ?>
					</button>
				</p>
			</form>
		</div>

		<div class="card" style="max-width:760px;padding:8px 22px 22px;margin-top:20px">
			<h2><?php esc_html_e( 'After installing', 'veahealth' ); ?></h2>
			<ol>
				<li>
					<a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>"><?php esc_html_e( 'Customizer → VeaHealth', 'veahealth' ); ?></a>
					— <?php esc_html_e( 'your email, phone, WhatsApp number, address and social profiles.', 'veahealth' ); ?>
				</li>
				<li>
					<?php esc_html_e( 'Send yourself a test enquiry from the Free assessment page and check it appears under Enquiries.', 'veahealth' ); ?>
				</li>
				<li>
					<?php esc_html_e( 'Add your Google tag ID in the Customizer if you use Analytics. Nothing loads until a visitor accepts cookies.', 'veahealth' ); ?>
				</li>
				<li>
					<?php esc_html_e( 'Check the prices on the treatment pages are current before you publish.', 'veahealth' ); ?>
				</li>
			</ol>
		</div>
	</div>
	<?php
}

/**
 * Tell the owner what happened on activation, or — if the automatic install did
 * not run for any reason — put an unmissable prompt in front of them.
 */
function veahealth_setup_notice() {
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}

	$error = get_transient( 'veahealth_autoinstall_error' );
	if ( $error ) {
		delete_transient( 'veahealth_autoinstall_error' );
		printf(
			'<div class="notice notice-error"><p><strong>%s</strong> %s</p><p><a class="button button-primary" href="%s">%s</a></p></div>',
			esc_html__( 'VeaHealth could not install its content automatically.', 'veahealth' ),
			esc_html( $error ),
			esc_url( admin_url( 'themes.php?page=veahealth-setup' ) ),
			esc_html__( 'Try again', 'veahealth' )
		);
		return;
	}

	$log = get_transient( 'veahealth_autoinstall_log' );
	if ( $log ) {
		delete_transient( 'veahealth_autoinstall_log' );
		printf(
			'<div class="notice notice-success is-dismissible"><p><strong>%s</strong></p><ul style="list-style:disc;margin-left:20px">%s</ul><p>'
				. '<a class="button button-primary" href="%s" target="_blank">%s</a> '
				. '<a class="button" href="%s">%s</a></p></div>',
			esc_html__( 'VeaHealth is installed. Your site is ready.', 'veahealth' ),
			implode( '', array_map( static function ( $line ) { return '<li>' . esc_html( $line ) . '</li>'; }, (array) $log ) ),
			esc_url( home_url( '/' ) ),
			esc_html__( 'View the site', 'veahealth' ),
			esc_url( admin_url( 'customize.php' ) ),
			esc_html__( 'Set your contact details', 'veahealth' )
		);
		return;
	}

	if ( get_option( 'veahealth_installed' ) ) {
		return;
	}
	$screen = get_current_screen();
	if ( $screen && 'appearance_page_veahealth-setup' === $screen->id ) {
		return;
	}
	printf(
		'<div class="notice notice-warning" style="border-left-width:6px;padding:14px 16px">'
			. '<h2 style="margin:0 0 6px;font-size:16px">%s</h2><p style="margin:0 0 12px">%s</p>'
			. '<p style="margin:0"><a class="button button-primary button-hero" href="%s">%s</a></p></div>',
		esc_html__( 'One step left: install the VeaHealth content', 'veahealth' ),
		esc_html__( 'The treatment pages, company pages and menus have not been created yet, so the homepage will look empty. This takes a few seconds.', 'veahealth' ),
		esc_url( admin_url( 'themes.php?page=veahealth-setup' ) ),
		esc_html__( 'Install the content now', 'veahealth' )
	);
}
add_action( 'admin_notices', 'veahealth_setup_notice' );

/**
 * If the content is missing, say so on the front end too — but only to a logged
 * in administrator, never to a visitor.
 */
function veahealth_frontend_setup_hint() {
	if ( get_option( 'veahealth_installed' ) || ! current_user_can( 'edit_theme_options' ) || is_admin() ) {
		return;
	}
	printf(
		'<div style="position:fixed;left:0;right:0;bottom:0;z-index:9999;background:#8a2e00;color:#fff;'
			. 'padding:14px 20px;font:500 14px/1.5 system-ui,sans-serif;display:flex;gap:16px;'
			. 'align-items:center;justify-content:center;flex-wrap:wrap">'
			. '<span>%s</span><a href="%s" style="background:#fff;color:#8a2e00;padding:8px 16px;'
			. 'border-radius:999px;text-decoration:none;font-weight:600">%s</a></div>',
		esc_html__( 'Only you can see this: the VeaHealth content has not been installed yet, so these sections are empty.', 'veahealth' ),
		esc_url( admin_url( 'themes.php?page=veahealth-setup' ) ),
		esc_html__( 'Install it now', 'veahealth' )
	);
}
add_action( 'wp_footer', 'veahealth_frontend_setup_hint', 99 );

<?php
/**
 * Reusable markup: icons, navigation, cards, before/after sliders, CTAs.
 *
 * @package VeaHealth
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Inline SVG icons. Inline so they inherit currentColor and cost no request. */
function veahealth_icon( $name ) {
	$icons = array(
		'pin'     => '<path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5A2.5 2.5 0 1 1 12 6.5a2.5 2.5 0 0 1 0 5z"/>',
		'mail'    => '<path fill="none" stroke="currentColor" stroke-width="1.8" d="M3 8l7.89 5.26a2 2 0 0 0 2.22 0L21 8M5 19h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2z"/>',
		'phone'   => '<path fill="none" stroke="currentColor" stroke-width="1.8" d="M3 5a2 2 0 0 1 2-2h3.28a1 1 0 0 1 .95.68l1.5 4.5a1 1 0 0 1-.51 1.2l-2.26 1.13a11 11 0 0 0 5.52 5.52l1.13-2.26a1 1 0 0 1 1.2-.5l4.5 1.49a1 1 0 0 1 .69.95V19a2 2 0 0 1-2 2h-1C9.72 21 3 14.28 3 6V5z"/>',
		'wa'      => '<path d="M12.05 21.5h-.02a9.4 9.4 0 0 1-4.79-1.31l-.34-.2-3.56.93.95-3.47-.22-.36a9.38 9.38 0 0 1-1.44-5.01c0-5.19 4.23-9.41 9.43-9.41 2.52 0 4.88.98 6.66 2.76a9.35 9.35 0 0 1 2.76 6.66c0 5.19-4.23 9.41-9.43 9.41zM20.5 3.49A11.32 11.32 0 0 0 12.05 0C5.8 0 .72 5.08.72 11.32c0 2 .52 3.94 1.51 5.66L.63 24l7.18-1.88a11.3 11.3 0 0 0 4.24.83h.01c6.24 0 11.32-5.08 11.32-11.32 0-3.03-1.18-5.87-3.32-8.01zM17.47 14.38c-.3-.15-1.76-.87-2.03-.97-.27-.1-.47-.15-.67.15-.2.3-.77.96-.94 1.16-.17.2-.35.22-.65.08-.3-.15-1.26-.47-2.4-1.48-.89-.79-1.49-1.77-1.66-2.07-.17-.3-.02-.46.13-.61.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.08-.15-.67-1.61-.92-2.21-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.07-.79.37-.27.3-1.04 1.01-1.04 2.46s1.07 2.86 1.22 3.06c.15.2 2.1 3.2 5.08 4.49 2.98 1.28 2.98.86 3.52.8.54-.05 1.76-.72 2-1.41.25-.7.25-1.29.17-1.42-.07-.13-.27-.2-.57-.35z"/>',
		'arrow'   => '<path fill="none" stroke="currentColor" stroke-width="2" d="M5 12h14M12 5l7 7-7 7"/>',
		'check'   => '<path fill="none" stroke="currentColor" stroke-width="2.2" d="M20 6L9 17l-5-5"/>',
		'compare' => '<path fill="none" stroke="currentColor" stroke-width="2" d="M9 6L4 12l5 6M15 6l5 6-5 6"/>',
		// the FAQ marker: CSS rotates the vertical stroke away when the answer opens
		'plus'    => '<path fill="none" stroke="currentColor" stroke-width="2" d="M5 12h14"/><path class="i-v" fill="none" stroke="currentColor" stroke-width="2" d="M12 5v14"/>',
		'clock'   => '<g fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3.5 2"/></g>',
		'tag'     => '<g fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 12V4h8l9 9-8 8-9-9z"/><circle cx="7.5" cy="7.5" r="1.4"/></g>',
		'shield'  => '<path fill="none" stroke="currentColor" stroke-width="1.8" d="M12 3l7 3v6c0 4.4-2.9 7.8-7 9-4.1-1.2-7-4.6-7-9V6l7-3z"/>',
		// A globe reads as "language" in every language, which is the whole job.
		'globe'   => '<g fill="none" stroke="currentColor" stroke-width="1.7"><circle cx="12" cy="12" r="9"/><path d="M3 12h18"/><path d="M12 3a14 14 0 0 1 0 18 14 14 0 0 1 0-18z"/></g>',
		'caret'   => '<path fill="none" stroke="currentColor" stroke-width="2" d="M6 9l6 6 6-6"/>',
		'fb'      => '<path d="M14 9h3V6h-3c-2.2 0-4 1.8-4 4v2H8v3h2v7h3v-7h3l1-3h-4v-2c0-.55.45-1 1-1z"/>',
		'ig'      => '<g fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="3.6"/></g><circle cx="17.2" cy="6.8" r="1"/>',
		'yt'      => '<path d="M21.6 7.2s-.2-1.4-.8-2c-.75-.8-1.6-.8-2-.85C16 4.1 12 4.1 12 4.1h-.01s-4 0-6.8.25c-.4.05-1.25.05-2 .85-.6.6-.8 2-.8 2S2.2 8.8 2.2 10.5v1.6c0 1.65.2 3.3.2 3.3s.2 1.4.8 2c.75.8 1.75.75 2.2.85 1.6.15 6.8.2 6.8.2s4 0 6.8-.25c.4-.05 1.25-.05 2-.85.6-.6.8-2 .8-2s.2-1.65.2-3.3v-1.6c0-1.65-.2-3.3-.2-3.3zM10 14.6V9.1l5.2 2.75L10 14.6z"/>',
	);
	if ( ! isset( $icons[ $name ] ) ) {
		return '';
	}
	return '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" focusable="false">' . $icons[ $name ] . '</svg>';
}

/** The brand lockup, honouring a custom logo if one is set. */
function veahealth_brand( $class = 'brand' ) {
	$out = sprintf(
		'<a class="%s" href="%s" aria-label="%s">',
		esc_attr( $class ),
		esc_url( home_url( '/' ) ),
		esc_attr( sprintf( __( '%s — home', 'veahealth' ), get_bloginfo( 'name' ) ) )
	);

	if ( has_custom_logo() ) {
		$id  = get_theme_mod( 'custom_logo' );
		$img = wp_get_attachment_image( $id, 'full', false, array( 'alt' => get_bloginfo( 'name' ), 'style' => 'height:38px;width:auto' ) );
		$out .= $img;
	} else {
		/*
		 * The mark is a raster because that is what it is — it was drawn as
		 * artwork, not built as a shape, and pretending otherwise by tracing it
		 * badly would look worse than shipping the pixels. Twice the display
		 * size so it stays sharp on a retina screen, decoding async so it never
		 * holds up the header, and given width and height so it reserves its
		 * own space instead of shifting the navigation when it arrives.
		 */
		$out .= sprintf(
			'<img class="brand-mark" src="%s" alt="" width="40" height="38" decoding="async" fetchpriority="high">',
			esc_url( VEAHEALTH_URI . '/assets/img/brand/mark.png' )
		);
		$out .= '<span><span class="brand-name">Vea<span>Health</span></span>'
			. '<span class="brand-sub">' . esc_html( veahealth_option( 'city' ) ) . ' · ' . esc_html__( 'Türkiye', 'veahealth' ) . '</span></span>';
	}

	return $out . '</a>';
}

/**
 * The primary menu. Falls back to a generated treatment menu so the theme is
 * usable the moment it is activated, before any menu has been assigned.
 */
function veahealth_primary_nav() {
	if ( has_nav_menu( 'primary' ) ) {
		wp_nav_menu(
			array(
				'theme_location' => 'primary',
				'container'      => false,
				'menu_class'     => 'nav',
				'depth'          => 2,
				'fallback_cb'    => false,
				'walker'         => new VeaHealth_Nav_Walker(),
			)
		);
		return;
	}
	echo '<ul class="nav">';
	printf( '<li><a href="%s">%s</a></li>', esc_url( home_url( '/' ) ), esc_html__( 'Home', 'veahealth' ) );
	printf(
		'<li class="has-sub"><a href="%s">%s</a><div class="subnav subnav--wide">%s</div></li>',
		esc_url( get_post_type_archive_link( 'service' ) ),
		esc_html__( 'Treatments', 'veahealth' ),
		veahealth_treatment_links()
	);
	foreach ( veahealth_default_pages() as $slug => $label ) {
		$page = get_page_by_path( $slug );
		if ( $page ) {
			printf( '<li><a href="%s">%s</a></li>', esc_url( get_permalink( $page ) ), esc_html( $label ) );
		}
	}
	echo '</ul>';
}

/** The company pages the importer creates, in menu order. */
function veahealth_default_pages() {
	return array(
		'journey'      => __( 'The journey', 'veahealth' ),
		'before-after' => __( 'Results', 'veahealth' ),
		'gallery'      => __( 'Clinic', 'veahealth' ),
		'about'        => __( 'About', 'veahealth' ),
	);
}

/** Treatment links grouped by their taxonomy term. */
function veahealth_treatment_links( $mobile = false ) {
	$terms = get_terms(
		array(
			'taxonomy'   => 'service_category',
			'hide_empty' => true,
			'orderby'    => 'term_order',
		)
	);
	if ( is_wp_error( $terms ) || ! $terms ) {
		return '';
	}
	$out = '';
	foreach ( $terms as $term ) {
		$items = get_posts(
			array(
				'post_type'      => 'service',
				'posts_per_page' => 40,
				'orderby'        => array( 'menu_order' => 'ASC', 'title' => 'ASC' ),
				'tax_query'      => array( array( 'taxonomy' => 'service_category', 'field' => 'term_id', 'terms' => $term->term_id ) ),
			)
		);
		if ( ! $items ) {
			continue;
		}
		$out .= $mobile
			? '<p class="m-group">' . esc_html( $term->name ) . '</p><div class="m-sub">'
			: '<p class="group-label">' . esc_html( $term->name ) . '</p>';
		foreach ( $items as $item ) {
			$out .= sprintf(
				'<a href="%s">%s</a>',
				esc_url( get_permalink( $item ) ),
				esc_html( get_the_title( $item ) )
			);
		}
		if ( $mobile ) {
			$out .= '</div>';
		}
	}
	return $out;
}

/** Adds the submenu wrapper the stylesheet expects. */
class VeaHealth_Nav_Walker extends Walker_Nav_Menu {
	public function start_lvl( &$output, $depth = 0, $args = null ) {
		$output .= '<div class="subnav">';
	}
	public function end_lvl( &$output, $depth = 0, $args = null ) {
		$output .= '</div>';
	}
	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		if ( in_array( 'menu-item-has-children', $classes, true ) ) {
			$classes[] = 'has-sub';
		}
		$current = in_array( 'current-menu-item', $classes, true ) ? ' aria-current="page"' : '';
		if ( 0 === $depth ) {
			$output .= '<li class="' . esc_attr( implode( ' ', array_filter( $classes ) ) ) . '">';
		}
		$output .= sprintf(
			'<a href="%s"%s>%s</a>',
			esc_url( $item->url ),
			$current,
			/*
			 * Through the filter, not straight off the object. A custom walker
			 * that reads $item->title bypasses nav_menu_item_title, which is
			 * where the language layer translates a stored menu label — so the
			 * navigation stayed in English while the page around it changed.
			 */
			esc_html( apply_filters( 'nav_menu_item_title', $item->title, $item, $args, $depth ) )
		);
	}
	public function end_el( &$output, $item, $depth = 0, $args = null ) {
		if ( 0 === $depth ) {
			$output .= '</li>';
		}
	}
}

/** Breadcrumb trail, output as markup and reused by the schema graph. */
function veahealth_crumbs( $trail ) {
	$out = '<nav aria-label="' . esc_attr__( 'Breadcrumb', 'veahealth' ) . '"><ol class="crumbs">';
	foreach ( $trail as $label => $url ) {
		$out .= $url
			? sprintf( '<li><a href="%s">%s</a></li>', esc_url( $url ), esc_html( $label ) )
			: sprintf( '<li><span aria-current="page">%s</span></li>', esc_html( $label ) );
	}
	return $out . '</ol></nav>';
}

/** The trail for the page currently being rendered. */
function veahealth_current_trail() {
	$trail = array( __( 'Home', 'veahealth' ) => home_url( '/' ) );

	if ( is_singular( 'service' ) ) {
		$trail[ __( 'Treatments', 'veahealth' ) ] = get_post_type_archive_link( 'service' );
		$trail[ get_the_title() ]                 = '';
	} elseif ( is_post_type_archive( 'service' ) ) {
		$trail[ __( 'Treatments', 'veahealth' ) ] = '';
	} elseif ( is_singular( 'post' ) ) {
		$blog = get_option( 'page_for_posts' );
		if ( $blog ) {
			$trail[ get_the_title( $blog ) ] = get_permalink( $blog );
		}
		$trail[ get_the_title() ] = '';
	} elseif ( is_page() ) {
		$trail[ get_the_title() ] = '';
	} elseif ( is_home() ) {
		$trail[ single_post_title( '', false ) ] = '';
	} elseif ( is_search() ) {
		$trail[ __( 'Search results', 'veahealth' ) ] = '';
	} elseif ( is_404() ) {
		$trail[ __( 'Not found', 'veahealth' ) ] = '';
	}
	return $trail;
}

/** A section heading block: eyebrow, title, optional introduction. */
function veahealth_section_head( $eyebrow, $title, $lede = '' ) {
	printf(
		'<div class="sec-head"><p class="eyebrow" data-anim="fade">%s</p><h2 data-anim="up">%s</h2>%s</div>',
		esc_html( $eyebrow ),
		esc_html( $title ),
		$lede ? '<p class="lede" data-anim="up">' . esc_html( $lede ) . '</p>' : ''
	);
}

/** One treatment card. */
function veahealth_service_card( $post, $show_group = true ) {
	$img   = veahealth_service_image( $post->ID, '800' );
	$alt   = get_post_meta( $post->ID, '_vh_alt', true );
	$terms = get_the_terms( $post->ID, 'service_category' );
	$group = ( $show_group && $terms && ! is_wp_error( $terms ) ) ? $terms[0]->name : '';
	?>
	<a class="card svc-card" href="<?php echo esc_url( get_permalink( $post ) ); ?>" data-anim="up">
		<div class="svc-media">
			<img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( $alt ); ?>"
			     width="800" height="520" loading="lazy" decoding="async">
		</div>
		<div class="svc-body">
			<?php if ( $group ) : ?>
				<p class="svc-tag"><?php echo esc_html( $group ); ?></p>
			<?php endif; ?>
			<h3><?php echo esc_html( get_the_title( $post ) ); ?></h3>
			<p><?php echo esc_html( get_the_excerpt( $post ) ); ?></p>
			<span class="card-arrow"><?php esc_html_e( 'Read the full guide', 'veahealth' ); ?> <?php echo veahealth_icon( 'arrow' ); ?></span>
		</div>
	</a>
	<?php
}

/**
 * A treatment's illustration. Uses the featured image when the editor has set
 * one, otherwise the bundled artwork recorded at import.
 */
function veahealth_service_image( $post_id, $size = '800' ) {
	if ( has_post_thumbnail( $post_id ) ) {
		$url = get_the_post_thumbnail_url( $post_id, '800' === $size ? 'veahealth-card' : 'full' );
		if ( $url ) {
			return $url;
		}
	}
	$art = get_post_meta( $post_id, '_vh_art', true );
	if ( ! $art ) {
		$art = 'dental-implant-zirconia-crown-macro';
	}
	$suffix = ( '800' === $size ) ? '-800' : '';
	return VEAHEALTH_URI . '/assets/img/art/' . $art . $suffix . '.webp';
}

/**
 * A before/after figure the visitor uncovers themselves.
 *
 * The two photographs are registered onto each other beforehand — same scale,
 * same position, cropped to the same frame — so that moving between them reads
 * as one face changing rather than two photographs swapping. Unregistered, the
 * head jumps and the collar changes, and the eye reads that as a cut: exactly
 * what a result photograph must never look like.
 *
 * Two ways in, one state underneath. A mouse gets a lens that follows the
 * pointer, because the interesting part is the mouth and a lens lets you put it
 * there. A finger gets the divider, because hover does not exist on a phone.
 * Underneath both is a real range input, so it is operable from the keyboard
 * and announced to screen readers with no extra ARIA.
 *
 * Nothing here is generated or retouched. These are the clinic's own patient
 * photographs, split and aligned, and never anything else.
 */
function veahealth_before_after( $result ) {
	$dir  = VEAHEALTH_DIR . '/assets/img/reveal/';
	$uri  = VEAHEALTH_URI . '/assets/img/reveal/';
	$slug = $result['img'];

	// A case whose pair has not been aligned still appears, as the original
	// side-by-side photograph — missing is worse than merely less clever.
	if ( ! file_exists( $dir . $slug . '-before-546.webp' ) || ! file_exists( $dir . $slug . '-after-546.webp' ) ) {
		veahealth_before_after_plain( $result );
		return;
	}

	$before   = $uri . $slug . '-before-546.webp';
	$after    = $uri . $slug . '-after-546.webp';
	$before_s = $uri . $slug . '-before-273.webp';
	$after_s  = $uri . $slug . '-after-273.webp';
	?>
	<figure data-anim="up">
		<div class="ba" data-ba role="group"
		     aria-label="<?php echo esc_attr( sprintf( __( 'Before and after: %s', 'veahealth' ), $result['title'] ) ); ?>">
			<img class="ba-img" src="<?php echo esc_url( $before ); ?>"
			     srcset="<?php echo esc_attr( $before_s . ' 273w, ' . $before . ' 546w' ); ?>"
			     sizes="(min-width: 900px) 50vw, 100vw" width="546" height="682"
			     alt="<?php echo esc_attr( $result['alt'] ); ?>" loading="lazy" decoding="async">
			<div class="ba-top">
				<img src="<?php echo esc_url( $after ); ?>"
				     srcset="<?php echo esc_attr( $after_s . ' 273w, ' . $after . ' 546w' ); ?>"
				     sizes="(min-width: 900px) 50vw, 100vw" width="546" height="682"
				     alt="" aria-hidden="true" loading="lazy" decoding="async">
			</div>
			<input class="ba-range" type="range" min="0" max="100" value="50" step="0.1"
			       aria-label="<?php echo esc_attr( sprintf( __( 'Reveal the result for %s', 'veahealth' ), $result['title'] ) ); ?>">
			<div class="ba-handle" aria-hidden="true"><span class="ba-knob"><?php echo veahealth_icon( 'compare' ); ?></span></div>
			<span class="ba-label ba-label--l"><?php esc_html_e( 'Before', 'veahealth' ); ?></span>
			<span class="ba-label ba-label--r"><?php esc_html_e( 'After', 'veahealth' ); ?></span>
			<span class="ba-hint" aria-hidden="true"><?php esc_html_e( 'Move across the smile', 'veahealth' ); ?></span>
		</div>
		<figcaption class="ba-caption">
			<b><?php echo esc_html( $result['title'] ); ?></b> — <?php echo esc_html( $result['meta'] ); ?> · <?php echo esc_html( $result['detail'] ); ?>
		</figcaption>
	</figure>
	<?php
}

/**
 * The unaligned original, for a case with no prepared pair.
 *
 * The whole side-by-side photograph, shown as one image with both states
 * visible at once. No slider: sliding between two photographs that do not line
 * up is worse than simply showing them side by side and saying so.
 */
function veahealth_before_after_plain( $result ) {
	$base = VEAHEALTH_URI . '/assets/img/results/' . $result['img'];
	?>
	<figure data-anim="up">
		<div class="ba ba--plain">
			<img class="ba-img" src="<?php echo esc_url( $base . '-900.webp' ); ?>"
			     srcset="<?php echo esc_attr( $base . '-500.webp 500w, ' . $base . '-900.webp 900w' ); ?>"
			     sizes="(min-width: 900px) 50vw, 100vw"
			     alt="<?php echo esc_attr( $result['alt'] ); ?>" loading="lazy" decoding="async">
			<span class="ba-label ba-label--l"><?php esc_html_e( 'Before', 'veahealth' ); ?></span>
			<span class="ba-label ba-label--r"><?php esc_html_e( 'After', 'veahealth' ); ?></span>
		</div>
		<figcaption class="ba-caption">
			<b><?php echo esc_html( $result['title'] ); ?></b> — <?php echo esc_html( $result['meta'] ); ?> · <?php echo esc_html( $result['detail'] ); ?>
		</figcaption>
	</figure>
	<?php
}

/** The dark call-to-action band that closes most pages. */
function veahealth_cta_band( $title, $text, $note = '' ) {
	$contact = veahealth_contact_url();
	?>
	<section class="section">
		<div class="shell">
			<div class="cta-band" data-anim="up">
				<h2><?php echo esc_html( $title ); ?></h2>
				<p><?php echo esc_html( $text ); ?></p>
				<div class="hero-actions">
					<a class="btn btn--primary btn--lg magnet" href="<?php echo esc_url( $contact ); ?>">
						<?php esc_html_e( 'Get a free assessment', 'veahealth' ); ?> <?php echo veahealth_icon( 'arrow' ); ?>
					</a>
					<?php if ( veahealth_whatsapp_url() ) : ?>
						<a class="btn btn--wa btn--lg" href="<?php echo esc_url( veahealth_whatsapp_url() ); ?>" rel="noopener">
							<?php echo veahealth_icon( 'wa' ); ?> <?php esc_html_e( 'WhatsApp us', 'veahealth' ); ?>
						</a>
					<?php endif; ?>
				</div>
				<?php if ( $note ) : ?>
					<p style="font-size:.84rem;margin-top:20px"><?php echo esc_html( $note ); ?></p>
				<?php endif; ?>
			</div>
		</div>
	</section>
	<?php
}

/** URL of the enquiry page, with a sensible fallback. */
function veahealth_contact_url() {
	$page = get_page_by_path( 'contact' );
	return $page ? get_permalink( $page ) : home_url( '/contact/' );
}

/** The scrolling trust strip. */
function veahealth_marquee() {
	$items = array(
		__( 'Verified partner clinics in Istanbul', 'veahealth' ),
		__( 'Written quote before you travel', 'veahealth' ),
		__( 'Airport transfers and hotel coordinated', 'veahealth' ),
		__( 'English-speaking patient coordinator', 'veahealth' ),
		__( 'Premium implant systems', 'veahealth' ),
		__( 'Aftercare support once you are home', 'veahealth' ),
	);
	$row = '';
	foreach ( $items as $i ) {
		$row .= '<span class="marquee-item">' . veahealth_icon( 'check' ) . ' ' . esc_html( $i ) . '</span>';
	}
	echo '<div class="marquee" aria-hidden="true"><div class="marquee-track">' . $row . $row . '</div></div>';
}

/** A simple page hero for inner pages. */
function veahealth_page_hero( $eyebrow, $title, $lede = '' ) {
	?>
	<section class="page-hero">
		<div class="shell">
			<?php echo veahealth_crumbs( veahealth_current_trail() ); ?>
			<p class="eyebrow" data-anim="fade"><?php echo esc_html( $eyebrow ); ?></p>
			<h1 data-anim="up"><?php echo esc_html( $title ); ?></h1>
			<?php if ( $lede ) : ?>
				<p class="lede" data-anim="up" style="--d:90ms"><?php echo esc_html( $lede ); ?></p>
			<?php endif; ?>
		</div>
	</section>
	<?php
}

/** Renders a menu as bare links — used for the legal row in the footer. */
class VeaHealth_Plain_Links extends Walker_Nav_Menu {
	public function start_lvl( &$output, $depth = 0, $args = null ) {}
	public function end_lvl( &$output, $depth = 0, $args = null ) {}
	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$output .= sprintf( '<a href="%s">%s</a>', esc_url( $item->url ), esc_html( $item->title ) );
	}
	public function end_el( &$output, $item, $depth = 0, $args = null ) {}
}

/**
 * More from the journal, at the end of an article.
 *
 * Prefers the same category, then falls back to recent — an article that is the
 * only one in its category should still not dead-end the reader.
 */
function veahealth_related_articles( $post_id, $limit = 3 ) {
	$cats = wp_get_post_categories( $post_id );
	$args = array(
		'post_type'      => 'post',
		'posts_per_page' => $limit,
		'post__not_in'   => array( $post_id ),
		'ignore_sticky_posts' => true,
	);
	if ( $cats ) {
		$args['category__in'] = $cats;
	}
	$posts = get_posts( $args );
	if ( count( $posts ) < $limit ) {
		$posts = array_merge( $posts, get_posts( array(
			'post_type'      => 'post',
			'posts_per_page' => $limit - count( $posts ),
			'post__not_in'   => array_merge( array( $post_id ), wp_list_pluck( $posts, 'ID' ) ),
			'ignore_sticky_posts' => true,
		) ) );
	}
	if ( ! $posts ) {
		return;
	}
	?>
	<section class="section section--tint">
		<div class="shell">
			<?php
			veahealth_section_head(
				__( 'More from the journal', 'veahealth' ),
				__( 'Written for the questions people ask before they book.', 'veahealth' )
			);
			?>
			<div class="grid g-3" data-stagger="90">
				<?php
				global $post;
				foreach ( $posts as $post ) {
					setup_postdata( $post );
					get_template_part( 'template-parts/card', 'post' );
				}
				wp_reset_postdata();
				?>
			</div>
		</div>
	</section>
	<?php
}

/** An article's cover, wherever it is needed. */
function veahealth_post_cover( $post_id, $size = '900' ) {
	$thumb = get_the_post_thumbnail_url( $post_id, 'veahealth-card' );
	if ( $thumb ) {
		return $thumb;
	}
	$slug = get_post_meta( $post_id, '_vh_cover', true );
	if ( $slug && file_exists( VEAHEALTH_DIR . '/assets/img/blog/' . $slug . '-' . $size . '.webp' ) ) {
		return VEAHEALTH_URI . '/assets/img/blog/' . $slug . '-' . $size . '.webp';
	}
	return VEAHEALTH_URI . '/assets/img/art/blog-cover-dental-ceramic-sand-900.webp';
}

/**
 * A contents list, built from the headings in the article itself.
 *
 * Reading it out of the saved content rather than storing it separately means
 * it cannot go stale: an editor who renames a heading in the admin renames it
 * here too, and one who deletes a section removes its entry.
 *
 * @param string $content Rendered post content.
 * @param int    $min     Below this many headings a contents list is noise.
 * @return string
 */
function veahealth_post_toc( $content, $min = 4 ) {
	if ( ! preg_match_all( '#<h2[^>]*id="([^"]+)"[^>]*>(.*?)</h2>#is', $content, $m, PREG_SET_ORDER ) ) {
		return '';
	}
	if ( count( $m ) < $min ) {
		return '';
	}

	$items = '';
	foreach ( $m as $h ) {
		$items .= sprintf(
			'<li><a href="#%s">%s</a></li>',
			esc_attr( $h[1] ),
			esc_html( trim( wp_strip_all_tags( $h[2] ) ) )
		);
	}

	/*
	 * A <details> on small screens and a plain nav on large ones. Using the
	 * element rather than a class means the fold works before any script runs,
	 * and the stylesheet decides which of the two it looks like.
	 */
	/*
	 * Shipped closed. On a phone an open contents list is the whole first
	 * screen, which is the opposite of helping somebody read; the script opens
	 * it where there is a rail to put it in. With no script it stays a fold,
	 * which still works.
	 */
	return sprintf(
		'<details class="post-toc"><summary>%s</summary><ol>%s</ol></details>',
		esc_html__( 'In this article', 'veahealth' ),
		$items
	);
}

/** The three lines that give the answer before the article does. */
function veahealth_post_keys( $post_id ) {
	$keys = get_post_meta( $post_id, '_vh_keys', true );
	if ( ! is_array( $keys ) || ! $keys ) {
		return;
	}
	?>
	<aside class="post-key">
		<p class="post-key__k"><?php esc_html_e( 'The short answer', 'veahealth' ); ?></p>
		<ul>
			<?php foreach ( $keys as $k ) : ?>
				<li><?php echo esc_html( $k ); ?></li>
			<?php endforeach; ?>
		</ul>
	</aside>
	<?php
}

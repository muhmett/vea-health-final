<?php
/**
 * A single treatment page.
 *
 * The old version of this template did one thing: it printed the post content,
 * which was a complete HTML document somebody had pasted into the editor along
 * with its own stylesheet. Every treatment page therefore looked like a
 * different website.
 *
 * This renders the same words from structure instead — the same components on
 * all twenty-one treatments, with a contents rail built from the sections the
 * page actually has and an enquiry bar that follows you down it.
 *
 * @package VeaHealth
 */

get_header();

while ( have_posts() ) :
	the_post();

	$slug     = get_post_field( 'post_name', get_the_ID() );
	$p        = function_exists( 'veahealth_service_parts' ) ? veahealth_service_parts( $slug ) : array();
	$sections = $p ? veahealth_service_sections( $p ) : array();
	$img      = veahealth_service_image( get_the_ID(), 'full' );
	$group    = wp_get_post_terms( get_the_ID(), 'service_category', array( 'fields' => 'names' ) );
	$price    = isset( $p['price'] ) ? $p['price'] : '';
	?>

<article <?php post_class( 'treatment' ); ?>>

	<!-- ------------------------------------------------------------------ -->
	<!-- Hero                                                                -->
	<!-- ------------------------------------------------------------------ -->
	<section class="tp-hero" data-surface="dark">
		<div class="tp-hero__media" aria-hidden="true">
			<img src="<?php echo esc_url( $img ); ?>" alt=""
			     width="1400" height="910" fetchpriority="high" decoding="async">
		</div>

		<div class="shell tp-hero__inner">
			<div class="tp-hero__copy">
				<?php echo veahealth_crumbs( veahealth_current_trail() ); ?>

				<?php if ( ! empty( $group[0] ) ) : ?>
					<p class="eyebrow" data-anim="fade"><?php echo esc_html( $group[0] ); ?></p>
				<?php endif; ?>

				<h1 data-lines><?php echo esc_html( isset( $p['h1'] ) ? $p['h1'] : get_the_title() ); ?></h1>

				<?php if ( ! empty( $p['lead'] ) ) : ?>
					<p class="lede" data-anim="up" style="--d:160ms"><?php echo esc_html( $p['lead'] ); ?></p>
				<?php endif; ?>

				<?php if ( ! empty( $p['trust'] ) ) : ?>
					<ul class="tp-hero__trust" data-anim="up" style="--d:260ms">
						<?php foreach ( array_slice( $p['trust'], 0, 4 ) as $t ) : ?>
							<li><?php echo veahealth_icon( 'check' ); ?> <?php echo esc_html( $t ); ?></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>

				<div class="tp-hero__actions" data-anim="up" style="--d:360ms">
					<a class="btn btn--primary btn--lg magnet" href="<?php echo esc_url( veahealth_contact_url() ); ?>" data-cursor="link">
						<?php esc_html_e( 'Get a written quote', 'veahealth' ); ?> <?php echo veahealth_icon( 'arrow' ); ?>
					</a>
					<?php if ( isset( $sections['procedure'] ) ) : ?>
						<a class="btn btn--ghost btn--lg" href="#procedure" data-cursor="link">
							<?php esc_html_e( 'See how it works', 'veahealth' ); ?>
						</a>
					<?php endif; ?>
				</div>
			</div>

			<?php if ( $price || ! empty( $p['stats'] ) ) : ?>
				<aside class="tp-hero__card" data-anim="scale" style="--d:240ms">
					<?php if ( $price ) : ?>
						<p class="tp-hero__card-k"><?php esc_html_e( 'Istanbul, from', 'veahealth' ); ?></p>
						<p class="tp-hero__card-v"><?php echo esc_html( $price ); ?></p>
						<?php if ( ! empty( $p['price_note'] ) ) : ?>
							<p class="tp-hero__card-note"><?php echo esc_html( $p['price_note'] ); ?></p>
						<?php endif; ?>
					<?php endif; ?>

					<?php if ( ! empty( $p['stats'] ) ) : ?>
						<dl class="tp-hero__stats">
							<?php foreach ( array_slice( $p['stats'], 0, 2 ) as $s ) : ?>
								<div>
									<dt><?php echo esc_html( $s['k'] ); ?></dt>
									<dd><?php echo esc_html( $s['v'] ); ?></dd>
								</div>
							<?php endforeach; ?>
						</dl>
					<?php endif; ?>

					<p class="tp-hero__card-fine">
						<?php esc_html_e( 'Your own price is fixed in writing before you travel.', 'veahealth' ); ?>
					</p>
				</aside>
			<?php endif; ?>
		</div>
	</section>

	<!-- ------------------------------------------------------------------ -->
	<!-- Key facts. What a patient wants inside three seconds.               -->
	<!-- ------------------------------------------------------------------ -->
	<?php veahealth_treatment_facts( get_the_ID(), $p ); ?>

	<!-- ------------------------------------------------------------------ -->
	<!-- Body, with the contents rail beside it                              -->
	<!-- ------------------------------------------------------------------ -->
	<div class="shell tp-body">

		<?php if ( count( $sections ) > 2 ) : ?>
			<nav class="tp-rail" aria-label="<?php esc_attr_e( 'On this page', 'veahealth' ); ?>">
				<div class="tp-rail__inner">
					<p class="tp-rail__k"><?php esc_html_e( 'On this page', 'veahealth' ); ?></p>
					<ol class="tp-rail__list">
						<?php foreach ( $sections as $id => $label ) : ?>
							<li>
								<a href="#<?php echo esc_attr( $id ); ?>" data-spy="<?php echo esc_attr( $id ); ?>">
									<span class="tp-rail__dot" aria-hidden="true"></span>
									<?php echo esc_html( $label ); ?>
								</a>
							</li>
						<?php endforeach; ?>
					</ol>
					<a class="tp-rail__cta btn btn--primary" href="<?php echo esc_url( veahealth_contact_url() ); ?>">
						<?php esc_html_e( 'Free assessment', 'veahealth' ); ?>
					</a>
				</div>
			</nav>
		<?php endif; ?>

		<div class="tp-main">
			<?php
			/*
			 * The body is the post content: the installer wrote the sections
			 * there so they can be edited in the admin like anything else. If
			 * somebody empties the post, the structured source is rendered
			 * instead rather than leaving a treatment page with no treatment
			 * on it.
			 */
			if ( trim( get_the_content() ) ) {
				the_content();
			} elseif ( $p ) {
				echo veahealth_service_body_html( $slug ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- built from escaped parts above.
			}
			?>
		</div>
	</div>

	<?php veahealth_related_treatments( get_the_ID() ); ?>

	<!-- The enquiry bar: appears once the hero has gone, on every screen size. -->
	<div class="tp-bar" data-tp-bar hidden>
		<div class="shell tp-bar__inner">
			<div class="tp-bar__what">
				<p class="tp-bar__title"><?php echo esc_html( get_the_title() ); ?></p>
				<?php if ( $price ) : ?>
					<p class="tp-bar__price"><?php echo esc_html( sprintf( __( 'Istanbul, from %s', 'veahealth' ), $price ) ); ?></p>
				<?php endif; ?>
			</div>
			<div class="tp-bar__do">
				<a class="btn btn--ghost tp-bar__wa" href="<?php echo esc_url( veahealth_whatsapp_url() ); ?>" rel="noopener">
					<?php echo veahealth_icon( 'wa' ); ?> <?php esc_html_e( 'WhatsApp', 'veahealth' ); ?>
				</a>
				<a class="btn btn--primary" href="<?php echo esc_url( veahealth_contact_url() ); ?>">
					<?php esc_html_e( 'Get a written quote', 'veahealth' ); ?>
				</a>
			</div>
		</div>
	</div>

</article>

	<?php
endwhile;

veahealth_cta_band(
	__( 'Ready to see what this would cost in your case?', 'veahealth' ),
	__( 'Send photographs and any recent X-rays. A partner dentist reviews them and returns an itemised plan with a fixed price — no charge, no obligation.', 'veahealth' )
);

get_footer();

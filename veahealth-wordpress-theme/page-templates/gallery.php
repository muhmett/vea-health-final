<?php
/**
 * Template Name: Clinic &amp; facilities
 *
 * @package VeaHealth
 */

get_header();

while ( have_posts() ) :
	the_post();
	veahealth_page_hero(
		__( 'Clinic & facilities', 'veahealth' ),
		__( 'Where you will actually be treated.', 'veahealth' ),
		has_excerpt() ? get_the_excerpt() : ''
	);
endwhile;
?>

<section class="section">
	<div class="shell">
		<div class="media-frame" data-anim="scale" style="margin-bottom:clamp(28px,4vw,48px)">
			<video controls preload="none" playsinline width="1280" height="720"
			       poster="<?php echo esc_url( VEAHEALTH_URI . '/assets/img/film/clinic-film-poster.webp' ); ?>"
			       aria-label="<?php esc_attr_e( 'Walkthrough film of the partner clinic in Istanbul', 'veahealth' ); ?>">
				<source src="<?php echo esc_url( VEAHEALTH_URI . '/assets/video/veahealth-clinic-film.mp4' ); ?>" type="video/mp4">
			</video>
		</div>

		<div class="masonry">
			<?php foreach ( veahealth_clinic_images() as $c ) : ?>
				<?php $base = VEAHEALTH_URI . '/assets/img/clinic/' . $c['img']; ?>
				<figure data-anim="up">
					<img src="<?php echo esc_url( $base . '-900.webp' ); ?>"
					     srcset="<?php echo esc_attr( $base . '-500.webp 500w, ' . $base . '-900.webp 900w, ' . $base . '.webp 1600w' ); ?>"
					     sizes="(min-width:900px) 33vw, 100vw"
					     alt="<?php echo esc_attr( $c['alt'] ); ?>" loading="lazy" decoding="async">
					<figcaption><?php echo esc_html( $c['alt'] ); ?></figcaption>
				</figure>
			<?php endforeach; ?>

			<?php
			$extra = array(
				'dsd-consultation-room'         => __( 'Consultation room with digital smile design on screen', 'veahealth' ),
				'journey-hotel-bosphorus-suite' => __( 'Partner hotel suite overlooking the Bosphorus', 'veahealth' ),
				'journey-vip-transfer-istanbul' => __( 'Private transfer waiting at Istanbul Airport', 'veahealth' ),
			);
			foreach ( $extra as $file => $alt ) :
				?>
				<figure data-anim="up">
					<img src="<?php echo esc_url( VEAHEALTH_URI . '/assets/img/art/' . $file . '-900.webp' ); ?>"
					     alt="<?php echo esc_attr( $alt ); ?>" loading="lazy" decoding="async">
					<figcaption><?php echo esc_html( $alt ); ?> — <?php esc_html_e( 'illustration', 'veahealth' ); ?></figcaption>
				</figure>
			<?php endforeach; ?>
		</div>

		<p class="mt-32" style="font-size:.84rem;color:var(--ink-3);max-width:70ch">
			<?php esc_html_e( 'Images marked “illustration” depict the standard of accommodation and transfer arranged for patients; the clinic photographs and the film are of the partner facility itself.', 'veahealth' ); ?>
		</p>
	</div>
</section>

<?php
veahealth_cta_band(
	__( 'Want to see it live before you decide?', 'veahealth' ),
	__( 'Your coordinator can walk you through the clinic on a video call, in English, at a time that suits you — before any deposit and before any booking.', 'veahealth' )
);
get_footer();

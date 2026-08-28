<?php
/**
 * The homepage.
 *
 * @package VeaHealth
 */

get_header();

$hero_image = get_theme_mod( 'veahealth_hero_image' );
$hero_src   = $hero_image ? wp_get_attachment_image_url( $hero_image, 'full' ) : VEAHEALTH_URI . '/assets/img/art/hero-istanbul-bosphorus-1600.webp';
$services   = get_posts( array( 'post_type' => 'service', 'posts_per_page' => 6, 'orderby' => 'menu_order', 'order' => 'ASC' ) );
$results    = veahealth_results();
$journey    = veahealth_journey();
$svc_count  = (int) wp_count_posts( 'service' )->publish;
?>

<section class="hero hero--film">
	<div class="hero-film">
		<!--
			The still is what everyone sees first and what search engines index.
			The film fades in only once it has buffered enough to be scrubbed,
			and its playback position is driven by scroll, never by autoplay.
		-->
		<img src="<?php echo esc_url( $hero_src ); ?>"
		     alt="<?php esc_attr_e( 'The Bosphorus at dawn with the Istanbul skyline in the distance', 'veahealth' ); ?>"
		     width="2400" height="1005" fetchpriority="high" decoding="async">
		<?php
		/*
		 * Four candidate encodes, no <source> children: motion.js picks one
		 * and assigns it. Sources in the markup would have the browser start
		 * fetching before the choice is made, and the clip would arrive twice.
		 * H.264 is preferred — it is the smaller file here — with VP9 for
		 * builds without proprietary codecs, at two widths each.
		 */
		?>
		<video muted playsinline preload="none" aria-hidden="true" tabindex="-1"
		       data-src-wide="<?php echo esc_url( VEAHEALTH_URI . '/assets/video/hero-scrub-1440.mp4' ); ?>"
		       data-src-narrow="<?php echo esc_url( VEAHEALTH_URI . '/assets/video/hero-scrub-900.mp4' ); ?>"
		       data-webm-wide="<?php echo esc_url( VEAHEALTH_URI . '/assets/video/hero-scrub-1440.webm' ); ?>"
		       data-webm-narrow="<?php echo esc_url( VEAHEALTH_URI . '/assets/video/hero-scrub-900.webm' ); ?>"
		       poster="<?php echo esc_url( VEAHEALTH_URI . '/assets/img/film/hero-scrub-poster.webp' ); ?>"></video>
	</div>

	<div class="shell">
		<div class="hero-inner">
			<p class="eyebrow" data-anim="fade"><?php echo esc_html( veahealth_option( 'city' ) ); ?> · <?php esc_html_e( 'Türkiye', 'veahealth' ); ?></p>
			<h1 data-lines><?php echo esc_html( str_replace( "\n", ' ', veahealth_option( 'hero_title' ) ) ); ?></h1>
			<p class="lede" data-anim="up" style="--d:200ms"><?php echo esc_html( veahealth_option( 'hero_text' ) ); ?></p>

			<div class="hero-actions" data-anim="up" style="--d:320ms">
				<a class="btn btn--primary btn--lg magnet" href="<?php echo esc_url( veahealth_contact_url() ); ?>" data-cursor="link">
					<?php esc_html_e( 'Get a free assessment', 'veahealth' ); ?> <?php echo veahealth_icon( 'arrow' ); ?>
				</a>
				<?php $results_page = get_page_by_path( 'before-after' ); ?>
				<?php if ( $results_page ) : ?>
					<a class="btn btn--ghost btn--lg" href="<?php echo esc_url( get_permalink( $results_page ) ); ?>" data-cursor="link">
						<?php esc_html_e( 'See patient results', 'veahealth' ); ?>
					</a>
				<?php endif; ?>
			</div>

			<div class="hero-stats" data-anim="fade" style="--d:440ms">
				<div class="hero-stat">
					<div class="v num"><span data-count="<?php echo esc_attr( $svc_count ); ?>">0</span></div>
					<div class="k"><?php esc_html_e( 'Treatments documented', 'veahealth' ); ?></div>
				</div>
				<div class="hero-stat">
					<div class="v num"><span data-count="70" data-suffix="%">0</span></div>
					<div class="k"><?php esc_html_e( 'Typical saving vs UK', 'veahealth' ); ?></div>
				</div>
				<div class="hero-stat">
					<div class="v num">7/24</div>
					<div class="k"><?php esc_html_e( 'WhatsApp coordination', 'veahealth' ); ?></div>
				</div>
			</div>
		</div>
	</div>

	<div class="hero-scrub" aria-hidden="true"><span></span></div>
</section>

<?php veahealth_marquee(); ?>

<section class="section">
	<div class="shell">
		<?php
		veahealth_section_head(
			__( 'What we coordinate', 'veahealth' ),
			__( 'Two disciplines, one coordinator, one plan.', 'veahealth' ),
			__( 'Every treatment page carries the full protocol — technique, materials, day-by-day procedure, recovery timeline, published evidence and the price in writing. Read them before you enquire; that is what they are for.', 'veahealth' )
		);
		?>
		<div class="grid g-3" data-stagger="90">
			<?php foreach ( $services as $svc ) { veahealth_service_card( $svc ); } ?>
		</div>
		<p class="mt-32">
			<a class="btn btn--ghost" href="<?php echo esc_url( get_post_type_archive_link( 'service' ) ); ?>">
				<?php
				/* translators: %d: number of treatments */
				printf( esc_html__( 'All %d treatments', 'veahealth' ), (int) $svc_count );
				?>
				<?php echo veahealth_icon( 'arrow' ); ?>
			</a>
		</p>
	</div>
</section>

<?php if ( $results ) : ?>
<section class="section section--tint">
	<div class="shell">
		<?php
		veahealth_section_head(
			__( 'Real patients', 'veahealth' ),
			__( 'Results from the clinic, not from a stock library.', 'veahealth' ),
			__( 'Drag the handle to compare. Every photograph on this site was taken at a VeaHealth partner clinic and published with the patient’s permission.', 'veahealth' )
		);
		?>
		<div class="grid g-2" data-stagger="120">
			<?php foreach ( array_slice( $results, 0, 2 ) as $r ) { veahealth_before_after( $r ); } ?>
		</div>
		<?php if ( $results_page ) : ?>
			<p class="mt-32">
				<a class="btn btn--ghost" href="<?php echo esc_url( get_permalink( $results_page ) ); ?>">
					<?php esc_html_e( 'See every documented case', 'veahealth' ); ?> <?php echo veahealth_icon( 'arrow' ); ?>
				</a>
			</p>
		<?php endif; ?>
	</div>
</section>
<?php endif; ?>

<section class="section">
	<div class="shell">
		<div class="grid g-2" style="align-items:center;gap:clamp(32px,6vw,72px)">
			<div>
				<p class="eyebrow" data-anim="fade"><?php esc_html_e( 'Inside the clinic', 'veahealth' ); ?></p>
				<h2 data-anim="up"><?php esc_html_e( 'A one-minute walk through the facilities.', 'veahealth' ); ?></h2>
				<p class="lede mt-24" data-anim="up">
					<?php esc_html_e( 'Filmed at the partner clinic in Istanbul — treatment rooms, sterilisation, the laboratory and the patient areas. No narration, no music bed over a slideshow of somebody else’s clinic.', 'veahealth' ); ?>
				</p>
				<ul class="checklist mt-24" data-anim="up">
					<li><?php echo veahealth_icon( 'check' ); ?> <?php esc_html_e( 'Filmed on site, unedited walkthrough', 'veahealth' ); ?></li>
					<li><?php echo veahealth_icon( 'check' ); ?> <?php esc_html_e( 'The rooms you will actually be treated in', 'veahealth' ); ?></li>
					<li><?php echo veahealth_icon( 'check' ); ?> <?php esc_html_e( 'Ask your coordinator for a live video tour any time', 'veahealth' ); ?></li>
				</ul>
			</div>
			<div class="media-frame" data-anim="scale">
				<video controls preload="none" playsinline width="1280" height="720"
				       poster="<?php echo esc_url( VEAHEALTH_URI . '/assets/img/film/clinic-film-poster.webp' ); ?>"
				       aria-label="<?php esc_attr_e( 'Walkthrough film of the partner clinic in Istanbul', 'veahealth' ); ?>">
					<source src="<?php echo esc_url( VEAHEALTH_URI . '/assets/video/veahealth-clinic-film.mp4' ); ?>" type="video/mp4">
				</video>
			</div>
		</div>
	</div>
</section>

<section class="section section--sand journey-rail">
	<div class="shell">
		<?php
		veahealth_section_head(
			__( 'The journey', 'veahealth' ),
			__( 'What actually happens, in order.', 'veahealth' ),
			__( 'No treatment is booked before you have a written plan and a fixed price. Everything after that is logistics, and the logistics are ours.', 'veahealth' )
		);
		?>
	</div>

	<div class="journey-track">
		<?php foreach ( $journey as $j_i => $j ) : ?>
			<article class="journey-card">
				<div class="journey-card__media">
					<img src="<?php echo esc_url( VEAHEALTH_URI . '/assets/img/art/' . $j['img'] . '-900.webp' ); ?>"
					     alt="<?php echo esc_attr( $j['alt'] ); ?>" width="900" height="562" loading="lazy" decoding="async">
				</div>
				<p class="journey-card__n"><?php echo esc_html( sprintf( '%02d', $j_i + 1 ) ); ?> · <?php echo esc_html( $j['meta'] ); ?></p>
				<h3><?php echo esc_html( $j['title'] ); ?></h3>
				<p><?php echo esc_html( $j['text'] ); ?></p>
			</article>
		<?php endforeach; ?>
	</div>

	<div class="journey-progress" aria-hidden="true"><span></span></div>

	<div class="shell">
		<?php $journey_page = get_page_by_path( 'journey' ); ?>
		<?php if ( $journey_page ) : ?>
			<p class="mt-32">
				<a class="btn btn--ghost" href="<?php echo esc_url( get_permalink( $journey_page ) ); ?>" data-cursor="link">
					<?php esc_html_e( 'The journey in detail', 'veahealth' ); ?> <?php echo veahealth_icon( 'arrow' ); ?>
				</a>
			</p>
		<?php endif; ?>
	</div>
</section>

<?php
veahealth_cta_band(
	__( 'Send your photographs. Get a written plan.', 'veahealth' ),
	__( 'A partner dentist reviews your photographs and any recent X-rays, then returns an itemised treatment plan with a fixed price. There is no charge for the assessment and no obligation afterwards.', 'veahealth' ),
	__( 'We reply to every enquiry within one working day.', 'veahealth' )
);

get_footer();

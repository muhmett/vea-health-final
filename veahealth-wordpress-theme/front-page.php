<?php
/**
 * The homepage.
 *
 * @package VeaHealth
 */

get_header();

$hero_image = get_theme_mod( 'veahealth_hero_image' );
$hero_src   = $hero_image ? wp_get_attachment_image_url( $hero_image, 'full' ) : VEAHEALTH_URI . '/assets/img/art/hero-istanbul-bosphorus-1600.webp';
$hero_lines = array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', (string) veahealth_option( 'hero_title' ) ) ) );
$services   = get_posts( array( 'post_type' => 'service', 'posts_per_page' => 6, 'orderby' => 'menu_order', 'order' => 'ASC' ) );
$results    = veahealth_results();
$journey    = veahealth_journey();
$svc_count  = (int) wp_count_posts( 'service' )->publish;
?>

<section class="hero">
	<div class="hero-media">
		<?php if ( $hero_image ) : ?>
			<img src="<?php echo esc_url( $hero_src ); ?>" alt="" width="2400" height="1005" fetchpriority="high" decoding="async">
		<?php else : ?>
			<img src="<?php echo esc_url( VEAHEALTH_URI . '/assets/img/art/hero-istanbul-bosphorus-1600.webp' ); ?>"
			     srcset="<?php echo esc_attr( VEAHEALTH_URI . '/assets/img/art/hero-istanbul-bosphorus-1100.webp 1100w, ' . VEAHEALTH_URI . '/assets/img/art/hero-istanbul-bosphorus-1600.webp 1600w, ' . VEAHEALTH_URI . '/assets/img/art/hero-istanbul-bosphorus.webp 2400w' ); ?>"
			     sizes="100vw"
			     alt="<?php esc_attr_e( 'The Bosphorus at dawn with the Istanbul skyline in the distance', 'veahealth' ); ?>"
			     width="2400" height="1005" fetchpriority="high" decoding="async">
		<?php endif; ?>
	</div>

	<div class="shell">
		<div class="hero-inner">
			<p class="eyebrow" data-anim="fade"><?php echo esc_html( veahealth_option( 'city' ) ); ?> · <?php esc_html_e( 'Türkiye', 'veahealth' ); ?></p>
			<h1 class="reveal-lines"><?php echo wp_kses_post( implode( '<br>', array_map( 'esc_html', $hero_lines ) ) ); ?></h1>
			<p class="lede" data-anim="up" style="--d:520ms"><?php echo esc_html( veahealth_option( 'hero_text' ) ); ?></p>

			<div class="hero-actions" data-anim="up" style="--d:640ms">
				<a class="btn btn--primary btn--lg magnet" href="<?php echo esc_url( veahealth_contact_url() ); ?>">
					<?php esc_html_e( 'Get a free assessment', 'veahealth' ); ?> <?php echo veahealth_icon( 'arrow' ); ?>
				</a>
				<?php $results_page = get_page_by_path( 'before-after' ); ?>
				<?php if ( $results_page ) : ?>
					<a class="btn btn--ghost btn--lg" href="<?php echo esc_url( get_permalink( $results_page ) ); ?>">
						<?php esc_html_e( 'See patient results', 'veahealth' ); ?>
					</a>
				<?php endif; ?>
			</div>

			<div class="hero-stats" data-anim="fade" style="--d:760ms">
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

<section class="section section--sand">
	<div class="shell">
		<?php
		veahealth_section_head(
			__( 'The journey', 'veahealth' ),
			__( 'What actually happens, in order.', 'veahealth' ),
			__( 'No treatment is booked before you have a written plan and a fixed price. Everything after that is logistics, and the logistics are ours.', 'veahealth' )
		);
		?>
		<div class="steps">
			<?php foreach ( $journey as $j ) : ?>
				<article class="step" data-anim="up">
					<div class="step-n"></div>
					<div>
						<p class="step-meta"><?php echo esc_html( $j['meta'] ); ?></p>
						<h3><?php echo esc_html( $j['title'] ); ?></h3>
						<p><?php echo esc_html( $j['text'] ); ?></p>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
		<?php $journey_page = get_page_by_path( 'journey' ); ?>
		<?php if ( $journey_page ) : ?>
			<p class="mt-32">
				<a class="btn btn--ghost" href="<?php echo esc_url( get_permalink( $journey_page ) ); ?>">
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

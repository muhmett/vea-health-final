<?php
/**
 * A single article.
 *
 * @package VeaHealth
 */

get_header();

while ( have_posts() ) :
	the_post();
	$cover = get_the_post_thumbnail_url( get_the_ID(), 'veahealth-wide' );
	if ( ! $cover ) {
		$cover = VEAHEALTH_URI . '/assets/img/art/blog-cover-dental-ceramic-sand-900.webp';
	}
	?>
	<article <?php post_class(); ?>>
		<section class="page-hero">
			<div class="shell">
				<?php echo veahealth_crumbs( veahealth_current_trail() ); ?>
				<p class="eyebrow" data-anim="fade">
					<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
				</p>
				<h1 data-anim="up"><?php the_title(); ?></h1>
				<?php if ( has_excerpt() ) : ?>
					<p class="lede mt-24" data-anim="up"><?php echo esc_html( get_the_excerpt() ); ?></p>
				<?php endif; ?>
			</div>
		</section>

		<section class="section">
			<div class="shell shell-narrow">
				<div class="media-frame ratio-16-9" data-anim="scale">
					<img src="<?php echo esc_url( $cover ); ?>" alt="" width="900" height="506" loading="lazy" decoding="async">
				</div>
				<div class="entry mt-48"><?php the_content(); ?></div>
				<p class="mt-48" style="font-size:.84rem;color:var(--ink-3)">
					<?php esc_html_e( 'This article is general information and is not a diagnosis or a treatment plan. Whether a treatment suits you can only be determined by a clinician who has examined you.', 'veahealth' ); ?>
				</p>
			</div>
		</section>
	</article>
	<?php
endwhile;

veahealth_cta_band(
	__( 'Have a question about your own case?', 'veahealth' ),
	__( 'Send photographs and a partner dentist will tell you what is indicated.', 'veahealth' )
);
get_footer();

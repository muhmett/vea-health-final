<?php
/**
 * A single article.
 *
 * @package VeaHealth
 */

get_header();

while ( have_posts() ) :
	the_post();

	$id     = get_the_ID();
	$dek    = get_post_meta( $id, '_vh_dek', true );
	$read   = (int) get_post_meta( $id, '_vh_read', true );
	$slug   = get_post_meta( $id, '_vh_cover', true );
	$credit = get_post_meta( $id, '_vh_credit', true );
	$curl   = get_post_meta( $id, '_vh_credit_url', true );
	$cats   = get_the_category();

	// A featured image set in the admin always wins; otherwise the cover the
	// installer assigned; otherwise the generic one.
	$cover = get_the_post_thumbnail_url( $id, 'veahealth-wide' );
	if ( ! $cover ) {
		$cover = $slug
			? VEAHEALTH_URI . '/assets/img/blog/' . $slug . '-1600.webp'
			: VEAHEALTH_URI . '/assets/img/art/blog-cover-dental-ceramic-sand-900.webp';
	}
	if ( ! $read ) {
		// 220 words a minute is about right for considered reading rather than skimming
		$read = max( 1, (int) ceil( str_word_count( wp_strip_all_tags( get_the_content() ) ) / 220 ) );
	}
	?>
	<article <?php post_class( 'post-single' ); ?>>

		<section class="page-hero post-hero">
			<div class="shell">
				<?php echo veahealth_crumbs( veahealth_current_trail() ); ?>

				<p class="eyebrow post-meta" data-anim="fade">
					<?php if ( $cats ) : ?>
						<a href="<?php echo esc_url( get_category_link( $cats[0]->term_id ) ); ?>"><?php echo esc_html( $cats[0]->name ); ?></a>
						<span aria-hidden="true">·</span>
					<?php endif; ?>
					<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
					<span aria-hidden="true">·</span>
					<?php
					/* translators: %d: minutes to read */
					printf( esc_html__( '%d min read', 'veahealth' ), (int) $read );
					?>
				</p>

				<h1 data-lines><?php the_title(); ?></h1>

				<?php if ( $dek ) : ?>
					<p class="lede mt-24" data-anim="up"><?php echo esc_html( $dek ); ?></p>
				<?php endif; ?>
			</div>
		</section>

		<section class="section section--flush">
			<div class="shell">
				<figure class="post-cover" data-anim="scale">
					<img src="<?php echo esc_url( $cover ); ?>"
					     alt="<?php echo esc_attr( get_the_title() ); ?>"
					     width="1600" height="900" fetchpriority="high" decoding="async">
					<?php if ( $credit ) : ?>
						<figcaption>
							<?php if ( $curl ) : ?>
								<a href="<?php echo esc_url( $curl ); ?>" rel="nofollow noopener" target="_blank"><?php echo esc_html( $credit ); ?></a>
							<?php else : ?>
								<?php echo esc_html( $credit ); ?>
							<?php endif; ?>
						</figcaption>
					<?php endif; ?>
				</figure>
			</div>
		</section>

		<section class="section">
			<div class="shell shell-narrow">
				<div class="entry post-body"><?php the_content(); ?></div>

				<p class="post-disclaimer">
					<?php esc_html_e( 'This article is general information and is not a diagnosis or a treatment plan. Whether a treatment suits you can only be determined by a clinician who has examined you.', 'veahealth' ); ?>
				</p>
			</div>
		</section>

	</article>

	<?php veahealth_related_articles( $id ); ?>

	<?php
endwhile;

veahealth_cta_band(
	__( 'Have a question about your own case?', 'veahealth' ),
	__( 'Send photographs and a partner dentist will tell you what is indicated.', 'veahealth' )
);
get_footer();

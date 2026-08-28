<?php
/**
 * Search results.
 *
 * @package VeaHealth
 */

get_header();
veahealth_page_hero(
	__( 'Search', 'veahealth' ),
	sprintf( __( 'Results for “%s”', 'veahealth' ), get_search_query() ),
	sprintf(
		/* translators: %d: number of results */
		_n( '%d page matched.', '%d pages matched.', (int) $GLOBALS['wp_query']->found_posts, 'veahealth' ),
		(int) $GLOBALS['wp_query']->found_posts
	)
);
?>
<section class="section">
	<div class="shell">
		<?php if ( have_posts() ) : ?>
			<div class="grid g-2" data-stagger="80">
				<?php while ( have_posts() ) : the_post(); ?>
					<a class="card" href="<?php the_permalink(); ?>" data-anim="up">
						<p class="svc-tag"><?php echo esc_html( get_post_type_object( get_post_type() )->labels->singular_name ); ?></p>
						<h3><?php the_title(); ?></h3>
						<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 26 ) ); ?></p>
						<span class="card-arrow"><?php esc_html_e( 'Open', 'veahealth' ); ?> <?php echo veahealth_icon( 'arrow' ); ?></span>
					</a>
				<?php endwhile; ?>
			</div>
			<div class="mt-48"><?php the_posts_pagination( array( 'mid_size' => 2 ) ); ?></div>
		<?php else : ?>
			<p class="lede"><?php esc_html_e( 'Nothing matched that search. Try a treatment name, or browse all treatments.', 'veahealth' ); ?></p>
			<p class="mt-24">
				<a class="btn btn--primary" href="<?php echo esc_url( get_post_type_archive_link( 'service' ) ); ?>">
					<?php esc_html_e( 'All treatments', 'veahealth' ); ?> <?php echo veahealth_icon( 'arrow' ); ?>
				</a>
			</p>
		<?php endif; ?>
	</div>
</section>
<?php
get_footer();

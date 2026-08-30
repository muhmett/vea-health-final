<?php
/**
 * Category, tag and date archives.
 *
 * @package VeaHealth
 */

get_header();
veahealth_page_hero( __( 'Journal', 'veahealth' ), get_the_archive_title(), wp_strip_all_tags( get_the_archive_description() ) );
?>
<section class="section">
	<div class="shell">
		<?php if ( have_posts() ) : ?>
			<?php
			/*
			 * The cards are h3s. On pages where they sit under a section
			 * heading that is correct; on an archive there is nothing between
			 * the page h1 and them, so the level jumps and a screen reader
			 * announces a missing level. This is that level.
			 */
			?>
			<h2 class="screen-reader-text"><?php esc_html_e( 'Articles', 'veahealth' ); ?></h2>
			<div class="grid g-2" data-stagger="90">
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/card', 'post' );
				endwhile;
				?>
			</div>
			<div class="mt-48"><?php the_posts_pagination( array( 'mid_size' => 2 ) ); ?></div>
		<?php else : ?>
			<p class="lede"><?php esc_html_e( 'Nothing here yet.', 'veahealth' ); ?></p>
		<?php endif; ?>
	</div>
</section>
<?php
get_footer();

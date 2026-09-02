<?php
/**
 * Category, tag and date archives.
 *
 * @package VeaHealth
 */

get_header();

/*
 * Not get_the_archive_title(): it returns markup — "Category: <span>Costs and
 * money</span>" — and the hero escapes what it is given, so every archive
 * heading printed its own tags. The prefix is redundant here anyway, since the
 * eyebrow above it already says which section this is.
 */
$vh_title = is_category() || is_tag() || is_tax()
	? single_term_title( '', false )
	: wp_strip_all_tags( get_the_archive_title() );

veahealth_page_hero( __( 'Journal', 'veahealth' ), $vh_title, wp_strip_all_tags( get_the_archive_description() ) );
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

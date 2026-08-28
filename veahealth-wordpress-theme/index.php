<?php
/**
 * Fallback template, and the blog listing.
 *
 * @package VeaHealth
 */

get_header();

$blog_page = get_option( 'page_for_posts' );
$title     = is_home() && $blog_page ? get_the_title( $blog_page ) : __( 'Journal', 'veahealth' );
$lede      = is_home() && $blog_page ? get_the_excerpt( $blog_page ) : '';

veahealth_page_hero( __( 'Journal', 'veahealth' ), $title, $lede );
?>

<section class="section">
	<div class="shell">
		<h2 class="visually-hidden"><?php esc_html_e( 'Latest articles', 'veahealth' ); ?></h2>
		<?php if ( have_posts() ) : ?>
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
			<p class="lede"><?php esc_html_e( 'Nothing published here yet.', 'veahealth' ); ?></p>
		<?php endif; ?>
	</div>
</section>

<?php
veahealth_cta_band(
	__( 'Have a question the journal does not answer?', 'veahealth' ),
	__( 'Send it to your coordinator. If it is a clinical question, a partner dentist answers it.', 'veahealth' )
);
get_footer();

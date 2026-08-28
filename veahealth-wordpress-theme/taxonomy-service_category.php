<?php
/**
 * One treatment group.
 *
 * @package VeaHealth
 */

get_header();

$term = get_queried_object();

veahealth_page_hero(
	__( 'Treatments', 'veahealth' ),
	$term ? $term->name : __( 'Treatments', 'veahealth' ),
	$term && $term->description ? $term->description : ''
);
?>
<section class="section">
	<div class="shell">
		<?php if ( have_posts() ) : ?>
			<div class="grid g-3" data-stagger="80">
				<?php while ( have_posts() ) : the_post(); veahealth_service_card( get_post(), false ); endwhile; ?>
			</div>
		<?php else : ?>
			<p class="lede"><?php esc_html_e( 'Nothing in this group yet.', 'veahealth' ); ?></p>
		<?php endif; ?>
	</div>
</section>
<?php
veahealth_cta_band(
	__( 'Not sure which treatment applies to you?', 'veahealth' ),
	__( 'Send photographs and any recent X-rays and a partner dentist will tell you what is indicated.', 'veahealth' )
);
get_footer();

<?php
/**
 * A single treatment page.
 *
 * The long-form content is stored in the post itself, so it can be edited in
 * the admin like any other page. The template supplies only the chrome the old
 * site was missing: the breadcrumb, and the closing call to action.
 *
 * @package VeaHealth
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<div class="shell" style="padding-top:14px">
		<?php echo veahealth_crumbs( veahealth_current_trail() ); ?>
	</div>

	<article <?php post_class(); ?>>
		<?php the_content(); ?>
	</article>
	<?php
endwhile;

veahealth_cta_band(
	__( 'Ready to see what this would cost in your case?', 'veahealth' ),
	__( 'Send photographs and any recent X-rays. A partner dentist reviews them and returns an itemised plan with a fixed price — no charge, no obligation.', 'veahealth' )
);

get_footer();

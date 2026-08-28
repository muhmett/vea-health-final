<?php
/**
 * Not found.
 *
 * @package VeaHealth
 */

get_header();
?>
<section class="page-hero">
	<div class="shell">
		<p class="eyebrow"><?php esc_html_e( 'Error 404', 'veahealth' ); ?></p>
		<h1><?php esc_html_e( 'That page is not here.', 'veahealth' ); ?></h1>
		<p class="lede"><?php esc_html_e( 'It may have moved when the site was rebuilt. The treatment guides, patient results and the enquiry form are all one click away.', 'veahealth' ); ?></p>
		<div class="hero-actions">
			<a class="btn btn--primary" href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<?php esc_html_e( 'Back to the homepage', 'veahealth' ); ?> <?php echo veahealth_icon( 'arrow' ); ?>
			</a>
			<a class="btn btn--ghost" href="<?php echo esc_url( get_post_type_archive_link( 'service' ) ); ?>"><?php esc_html_e( 'All treatments', 'veahealth' ); ?></a>
			<a class="btn btn--ghost" href="<?php echo esc_url( veahealth_contact_url() ); ?>"><?php esc_html_e( 'Contact', 'veahealth' ); ?></a>
		</div>
	</div>
</section>

<section class="section">
	<div class="shell">
		<h2><?php esc_html_e( 'Popular treatments', 'veahealth' ); ?></h2>
		<div class="grid g-3 mt-32" data-stagger="80">
			<?php
			foreach ( get_posts( array( 'post_type' => 'service', 'posts_per_page' => 3, 'orderby' => 'menu_order', 'order' => 'ASC' ) ) as $svc ) {
				veahealth_service_card( $svc );
			}
			?>
		</div>
	</div>
</section>
<?php
get_footer();

<?php
/**
 * Document head and site header.
 *
 * @package VeaHealth
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="theme-color" content="#0F2428">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip" href="#main"><?php esc_html_e( 'Skip to content', 'veahealth' ); ?></a>

<div class="scroll-progress" aria-hidden="true"></div>

<header class="site-header-group">
	<div class="site-topbar">
		<div class="shell">
			<span class="tb-item"><?php echo veahealth_icon( 'pin' ); ?> <?php echo esc_html( veahealth_option( 'city' ) ); ?>, <?php esc_html_e( 'Türkiye', 'veahealth' ); ?></span>
			<?php if ( veahealth_option( 'email' ) ) : ?>
				<a class="tb-item" href="mailto:<?php echo esc_attr( veahealth_option( 'email' ) ); ?>">
					<?php echo veahealth_icon( 'mail' ); ?> <?php echo esc_html( veahealth_option( 'email' ) ); ?>
				</a>
			<?php endif; ?>
			<?php if ( veahealth_option( 'phone' ) ) : ?>
				<a class="tb-item" href="tel:<?php echo esc_attr( preg_replace( '/[^\d+]/', '', veahealth_option( 'phone' ) ) ); ?>">
					<?php echo veahealth_icon( 'phone' ); ?> <?php echo esc_html( veahealth_option( 'phone' ) ); ?>
				</a>
			<?php endif; ?>
			<?php if ( veahealth_whatsapp_url() ) : ?>
				<a class="tb-item tb-spacer" href="<?php echo esc_url( veahealth_whatsapp_url() ); ?>" rel="noopener">
					<?php echo veahealth_icon( 'wa' ); ?> <?php esc_html_e( 'WhatsApp 7/24', 'veahealth' ); ?>
				</a>
			<?php endif; ?>
		</div>
	</div>

	<div class="site-header">
		<div class="shell">
			<?php echo veahealth_brand(); ?>
			<?php veahealth_primary_nav(); ?>
			<a class="btn btn--primary nav-cta magnet" href="<?php echo esc_url( veahealth_contact_url() ); ?>">
				<?php esc_html_e( 'Free assessment', 'veahealth' ); ?>
			</a>
			<button class="burger" type="button" aria-expanded="false" aria-controls="mobile-nav"
			        aria-label="<?php esc_attr_e( 'Open menu', 'veahealth' ); ?>"><span></span></button>
		</div>
	</div>
</header>

<nav class="mobile-nav" id="mobile-nav" aria-label="<?php esc_attr_e( 'Mobile', 'veahealth' ); ?>">
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'veahealth' ); ?></a>
	<a href="<?php echo esc_url( get_post_type_archive_link( 'service' ) ); ?>"><?php esc_html_e( 'All treatments', 'veahealth' ); ?></a>
	<?php
	echo veahealth_treatment_links( true );
	echo '<p class="m-group">' . esc_html__( 'Company', 'veahealth' ) . '</p><div class="m-sub">';
	foreach ( veahealth_default_pages() as $slug => $label ) {
		$page = get_page_by_path( $slug );
		if ( $page ) {
			printf( '<a href="%s">%s</a>', esc_url( get_permalink( $page ) ), esc_html( $label ) );
		}
	}
	$blog = get_option( 'page_for_posts' );
	if ( $blog ) {
		printf( '<a href="%s">%s</a>', esc_url( get_permalink( $blog ) ), esc_html( get_the_title( $blog ) ) );
	}
	printf( '<a href="%s">%s</a>', esc_url( veahealth_contact_url() ), esc_html__( 'Contact', 'veahealth' ) );
	echo '</div>';
	?>
	<a class="btn btn--primary btn--block mt-24" href="<?php echo esc_url( veahealth_contact_url() ); ?>">
		<?php esc_html_e( 'Free assessment', 'veahealth' ); ?>
	</a>
</nav>

<main id="main">

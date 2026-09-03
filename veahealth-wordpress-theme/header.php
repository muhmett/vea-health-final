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
					<?php echo veahealth_icon( 'mail' ); ?> <bdi dir="ltr"><?php echo esc_html( veahealth_option( 'email' ) ); ?></bdi>
				</a>
			<?php endif; ?>
			<?php if ( veahealth_option( 'phone' ) ) : ?>
				<a class="tb-item" href="tel:<?php echo esc_attr( preg_replace( '/[^\d+]/', '', veahealth_option( 'phone' ) ) ); ?>">
					<?php echo veahealth_icon( 'phone' ); ?> <bdi dir="ltr"><?php echo esc_html( veahealth_option( 'phone' ) ); ?></bdi>
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
			<?php echo veahealth_lang_switcher(); ?>
			<a class="btn btn--primary nav-cta magnet" href="<?php echo esc_url( veahealth_contact_url() ); ?>">
				<?php esc_html_e( 'Free assessment', 'veahealth' ); ?>
			</a>
			<button class="burger" type="button" aria-expanded="false" aria-controls="mobile-nav"
			        aria-label="<?php esc_attr_e( 'Open menu', 'veahealth' ); ?>"><span></span></button>

			<button class="menu-toggle" type="button" aria-expanded="false" aria-controls="vh-menu">
				<span class="label"><?php esc_html_e( 'Menu', 'veahealth' ); ?></span>
				<span class="bars" aria-hidden="true"><i></i><i></i><i></i></span>
			</button>
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
	<?php echo veahealth_lang_switcher(); ?>
</nav>

<?php
/**
 * The fullscreen menu. Rendered in the markup rather than built in JavaScript,
 * so its links are real links: crawlable, and usable if the motion layer never
 * loads (in which case it stays hidden and the plain menu takes over).
 */
$vh_menu_items = array();
$vh_menu_items[] = array( 'label' => __( 'Home', 'veahealth' ), 'url' => home_url( '/' ) );
$vh_menu_items[] = array( 'label' => __( 'All treatments', 'veahealth' ), 'url' => get_post_type_archive_link( 'service' ) );
foreach ( veahealth_default_pages() as $vh_slug => $vh_label ) {
	$vh_page = get_page_by_path( $vh_slug );
	if ( $vh_page ) {
		$vh_menu_items[] = array( 'label' => $vh_label, 'url' => get_permalink( $vh_page ) );
	}
}
$vh_blog = get_option( 'page_for_posts' );
if ( $vh_blog ) {
	$vh_menu_items[] = array( 'label' => get_the_title( $vh_blog ), 'url' => get_permalink( $vh_blog ) );
}
$vh_menu_items[] = array( 'label' => __( 'Free assessment', 'veahealth' ), 'url' => veahealth_contact_url() );

$vh_preview = array(
	'art/hero-istanbul-mosque-1100.webp',
	'clinic/vea-health-clinic-lounge-istanbul-900.webp',
	'art/dsd-consultation-room-900.webp',
	'results/hollywood-smile-zirconium-crowns-female-patient-900.webp',
);
?>
<nav class="vh-menu" id="vh-menu" aria-label="<?php esc_attr_e( 'Main', 'veahealth' ); ?>">
	<div class="vh-menu__inner">
		<p class="vh-menu__eyebrow"><?php esc_html_e( 'Navigate', 'veahealth' ); ?></p>
		<ul class="vh-menu__list">
			<?php foreach ( $vh_menu_items as $vh_item ) : ?>
				<li class="vh-menu__item">
					<a href="<?php echo esc_url( $vh_item['url'] ); ?>" data-cursor="link">
						<span><?php echo esc_html( $vh_item['label'] ); ?></span>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>

	<div class="vh-menu__meta">
		<div class="vh-menu__preview" aria-hidden="true">
			<?php foreach ( $vh_preview as $vh_img ) : ?>
				<img src="<?php echo esc_url( VEAHEALTH_URI . '/assets/img/' . $vh_img ); ?>" alt="" loading="lazy" decoding="async">
			<?php endforeach; ?>
		</div>
		<div>
			<h3><?php esc_html_e( 'Talk to a coordinator', 'veahealth' ); ?></h3>
			<?php if ( veahealth_option( 'email' ) ) : ?>
				<p><a href="mailto:<?php echo esc_attr( veahealth_option( 'email' ) ); ?>"><bdi dir="ltr"><?php echo esc_html( veahealth_option( 'email' ) ); ?></bdi></a></p>
			<?php endif; ?>
			<?php if ( veahealth_option( 'phone' ) ) : ?>
				<p><a href="tel:<?php echo esc_attr( preg_replace( '/[^\d+]/', '', veahealth_option( 'phone' ) ) ); ?>"><bdi dir="ltr"><?php echo esc_html( veahealth_option( 'phone' ) ); ?></bdi></a></p>
			<?php endif; ?>
		</div>
		<div>
			<h3><?php esc_html_e( 'Where we are', 'veahealth' ); ?></h3>
			<p><?php echo esc_html( veahealth_option( 'street' ) ); ?><br>
			<?php echo esc_html( veahealth_option( 'postcode' ) . ' ' . veahealth_option( 'district' ) ); ?><br>
			<?php echo esc_html( veahealth_option( 'city' ) ); ?>, <?php esc_html_e( 'Türkiye', 'veahealth' ); ?></p>
		</div>
	</div>
</nav>

<main id="main">

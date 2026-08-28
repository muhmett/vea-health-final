<?php
/**
 * Site footer, cookie notice and floating WhatsApp button.
 *
 * @package VeaHealth
 */
?>
</main>

<footer class="site-footer">
	<div class="shell">
		<div class="foot-grid">
			<div>
				<?php echo veahealth_brand(); ?>
				<p class="foot-disclaimer">
					<?php esc_html_e( 'VeaHealth is a medical tourism coordinator based in Istanbul. Treatment is carried out by licensed partner clinics and their clinical teams. Information on this site is general and is not a substitute for a consultation, diagnosis or treatment plan from a qualified clinician.', 'veahealth' ); ?>
				</p>
				<?php
				$social = array(
					'facebook'  => array( 'fb', __( 'Facebook', 'veahealth' ) ),
					'instagram' => array( 'ig', __( 'Instagram', 'veahealth' ) ),
					'youtube'   => array( 'yt', __( 'YouTube', 'veahealth' ) ),
				);
				$links = '';
				foreach ( $social as $key => $meta ) {
					$url = veahealth_option( $key );
					if ( $url ) {
						$links .= sprintf(
							'<a href="%s" rel="noopener" aria-label="%s">%s</a>',
							esc_url( $url ),
							esc_attr( sprintf( __( '%1$s on %2$s', 'veahealth' ), get_bloginfo( 'name' ), $meta[1] ) ),
							veahealth_icon( $meta[0] )
						);
					}
				}
				if ( $links ) {
					echo '<div class="social">' . $links . '</div>';
				}
				?>
			</div>

			<div class="foot-col">
				<h3><?php esc_html_e( 'Treatments', 'veahealth' ); ?></h3>
				<ul>
					<?php
					foreach ( get_terms( array( 'taxonomy' => 'service_category', 'hide_empty' => true ) ) as $term ) {
						$items = get_posts(
							array(
								'post_type'      => 'service',
								'posts_per_page' => 12,
								'orderby'        => 'menu_order',
								'order'          => 'ASC',
								'tax_query'      => array( array( 'taxonomy' => 'service_category', 'field' => 'term_id', 'terms' => $term->term_id ) ),
							)
						);
						foreach ( $items as $item ) {
							printf( '<li><a href="%s">%s</a></li>', esc_url( get_permalink( $item ) ), esc_html( get_the_title( $item ) ) );
						}
					}
					?>
				</ul>
			</div>

			<div class="foot-col">
				<h3><?php esc_html_e( 'Company', 'veahealth' ); ?></h3>
				<?php
				if ( has_nav_menu( 'footer' ) ) {
					wp_nav_menu( array( 'theme_location' => 'footer', 'container' => false, 'menu_class' => '', 'depth' => 1 ) );
				}
				?>
			</div>

			<div class="foot-col">
				<h3><?php esc_html_e( 'Contact', 'veahealth' ); ?></h3>
				<ul>
					<?php if ( veahealth_option( 'email' ) ) : ?>
						<li><a href="mailto:<?php echo esc_attr( veahealth_option( 'email' ) ); ?>"><?php echo esc_html( veahealth_option( 'email' ) ); ?></a></li>
					<?php endif; ?>
					<?php if ( veahealth_option( 'phone' ) ) : ?>
						<li><a href="tel:<?php echo esc_attr( preg_replace( '/[^\d+]/', '', veahealth_option( 'phone' ) ) ); ?>"><?php echo esc_html( veahealth_option( 'phone' ) ); ?></a></li>
					<?php endif; ?>
					<?php if ( veahealth_whatsapp_url() ) : ?>
						<li><a href="<?php echo esc_url( veahealth_whatsapp_url() ); ?>" rel="noopener"><?php esc_html_e( 'WhatsApp', 'veahealth' ); ?></a></li>
					<?php endif; ?>
					<li>
						<address style="font-style:normal">
							<?php echo esc_html( veahealth_option( 'street' ) ); ?><br>
							<?php echo esc_html( veahealth_option( 'postcode' ) . ' ' . veahealth_option( 'district' ) ); ?><br>
							<?php echo esc_html( veahealth_option( 'city' ) ); ?>, <?php esc_html_e( 'Türkiye', 'veahealth' ); ?>
						</address>
					</li>
				</ul>
				<h3 style="margin-top:26px"><?php esc_html_e( 'Opening hours', 'veahealth' ); ?></h3>
				<ul>
					<?php foreach ( preg_split( '/\r\n|\r|\n/', (string) veahealth_option( 'hours' ) ) as $line ) : ?>
						<?php if ( trim( $line ) ) : ?>
							<li><?php echo esc_html( trim( $line ) ); ?></li>
						<?php endif; ?>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>

		<div class="foot-bottom">
			<span>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'All rights reserved.', 'veahealth' ); ?></span>
			<?php
			if ( has_nav_menu( 'legal' ) ) {
				wp_nav_menu( array( 'theme_location' => 'legal', 'container' => false, 'menu_class' => '', 'depth' => 1, 'items_wrap' => '%3$s', 'walker' => new VeaHealth_Plain_Links() ) );
			}
			?>
			<span class="sep"></span>
		</div>
	</div>
</footer>

<aside class="cookie" role="dialog" aria-labelledby="cookie-h" aria-describedby="cookie-p">
	<h3 id="cookie-h"><?php esc_html_e( 'Cookies on this site', 'veahealth' ); ?></h3>
	<p id="cookie-p"><?php esc_html_e( 'We use essential cookies to make the site work. With your consent we also use analytics cookies to understand which pages help patients most. No analytics tag loads until you choose.', 'veahealth' ); ?></p>
	<div class="cookie-actions">
		<button class="btn btn--primary" type="button" data-consent="all"><?php esc_html_e( 'Accept analytics', 'veahealth' ); ?></button>
		<button class="btn btn--ghost" type="button" data-consent="necessary"><?php esc_html_e( 'Essential only', 'veahealth' ); ?></button>
		<?php
		$cookies = get_page_by_path( 'cookie-policy' );
		if ( $cookies ) :
			?>
			<a class="btn btn--ghost" href="<?php echo esc_url( get_permalink( $cookies ) ); ?>"><?php esc_html_e( 'Read policy', 'veahealth' ); ?></a>
		<?php endif; ?>
	</div>
</aside>

<?php if ( veahealth_whatsapp_url() ) : ?>
	<aside class="wa-float-wrap" aria-label="<?php esc_attr_e( 'Quick contact', 'veahealth' ); ?>">
		<a class="wa-float" href="<?php echo esc_url( veahealth_whatsapp_url() ); ?>" rel="noopener"
		   aria-label="<?php esc_attr_e( 'Chat with us on WhatsApp', 'veahealth' ); ?>">
			<?php echo veahealth_icon( 'wa' ); ?><span><?php esc_html_e( 'Chat on WhatsApp', 'veahealth' ); ?></span>
		</a>
	</aside>
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>

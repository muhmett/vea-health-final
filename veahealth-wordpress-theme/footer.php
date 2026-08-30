<?php
/**
 * Site footer, cookie notice and floating WhatsApp button.
 *
 * The previous version listed all twenty-one treatments in a column. Nobody
 * reads a link dump, and Google has the sitemap, so this links the three
 * groups instead and gives the space back to the things a visitor at the
 * bottom of a page actually wants: how to reach a person, and where the clinic
 * is.
 *
 * @package VeaHealth
 */
?>
</main>

<footer class="site-footer">
	<div class="shell foot-inner">

		<?php
		/*
		 * The swarm gets a reserved square of its own. It used to run across the
		 * whole footer and settled its shapes directly on top of the Company
		 * column, which is precisely the thing a background effect must never
		 * do. Giving it a box means the overlap is impossible by construction
		 * rather than by tuning opacity until it looks survivable.
		 */
		?>
		<div class="foot-stage" data-particles aria-hidden="true"></div>

		<div class="foot-main">

		<div class="foot-top">
			<div class="foot-say">
				<?php echo veahealth_brand(); ?>
				<p class="foot-line">
					<?php esc_html_e( 'Dental and hair restoration in Istanbul, coordinated end to end — a written plan and a fixed price before you travel.', 'veahealth' ); ?>
				</p>
			</div>
			<a class="btn btn--primary btn--lg" href="<?php echo esc_url( veahealth_contact_url() ); ?>">
				<?php esc_html_e( 'Get a free assessment', 'veahealth' ); ?> <?php echo veahealth_icon( 'arrow' ); ?>
			</a>
		</div>

		<div class="foot-cols">
			<nav class="foot-col" aria-label="<?php esc_attr_e( 'Treatments', 'veahealth' ); ?>">
				<h2><?php esc_html_e( 'Treatments', 'veahealth' ); ?></h2>
				<ul>
					<?php
					foreach ( get_terms( array( 'taxonomy' => 'service_category', 'hide_empty' => true ) ) as $term ) {
						printf(
							'<li><a href="%s">%s</a></li>',
							esc_url( get_term_link( $term ) ),
							esc_html( $term->name )
						);
					}
					?>
					<li><a href="<?php echo esc_url( get_post_type_archive_link( 'service' ) ); ?>"><?php esc_html_e( 'All treatments', 'veahealth' ); ?></a></li>
				</ul>
			</nav>

			<nav class="foot-col" aria-label="<?php esc_attr_e( 'Company', 'veahealth' ); ?>">
				<h2><?php esc_html_e( 'Company', 'veahealth' ); ?></h2>
				<?php
				if ( has_nav_menu( 'footer' ) ) {
					wp_nav_menu( array( 'theme_location' => 'footer', 'container' => false, 'menu_class' => '', 'depth' => 1 ) );
				}
				?>
			</nav>

			<div class="foot-col foot-col--contact">
				<h2><?php esc_html_e( 'Talk to a coordinator', 'veahealth' ); ?></h2>
				<ul>
					<?php if ( veahealth_option( 'email' ) ) : ?>
						<li><a href="mailto:<?php echo esc_attr( veahealth_option( 'email' ) ); ?>"><?php echo esc_html( veahealth_option( 'email' ) ); ?></a></li>
					<?php endif; ?>
					<?php if ( veahealth_option( 'phone' ) ) : ?>
						<li><a href="tel:<?php echo esc_attr( preg_replace( '/[^\d+]/', '', veahealth_option( 'phone' ) ) ); ?>"><?php echo esc_html( veahealth_option( 'phone' ) ); ?></a></li>
					<?php endif; ?>
					<?php if ( veahealth_whatsapp_url() ) : ?>
						<li><a href="<?php echo esc_url( veahealth_whatsapp_url() ); ?>" rel="noopener"><?php esc_html_e( 'WhatsApp, 7/24', 'veahealth' ); ?></a></li>
					<?php endif; ?>
				</ul>
				<address>
					<?php echo esc_html( veahealth_option( 'street' ) ); ?><br>
					<?php echo esc_html( trim( veahealth_option( 'postcode' ) . ' ' . veahealth_option( 'district' ) ) ); ?><br>
					<?php echo esc_html( veahealth_option( 'city' ) ); ?>, <?php esc_html_e( 'Türkiye', 'veahealth' ); ?>
				</address>
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
		</div>

		</div><!-- /.foot-main -->

		<div class="foot-bottom">
			<p class="foot-legal">
				&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>.
				<?php esc_html_e( 'A medical tourism coordinator. Treatment is carried out by licensed partner clinics; nothing here is a diagnosis.', 'veahealth' ); ?>
			</p>
			<?php
			if ( has_nav_menu( 'legal' ) ) {
				wp_nav_menu( array( 'theme_location' => 'legal', 'container' => false, 'menu_class' => 'foot-legal-links', 'depth' => 1, 'items_wrap' => '<div class="%2$s">%3$s</div>', 'walker' => new VeaHealth_Plain_Links() ) );
			}
			?>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>

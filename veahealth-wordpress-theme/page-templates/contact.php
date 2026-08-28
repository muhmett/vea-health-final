<?php
/**
 * Template Name: Free assessment (enquiry form)
 *
 * @package VeaHealth
 */

get_header();

while ( have_posts() ) :
	the_post();
	veahealth_page_hero(
		__( 'Free assessment', 'veahealth' ),
		__( 'Send your photographs. Get a written plan.', 'veahealth' ),
		has_excerpt() ? get_the_excerpt() : __( 'A partner dentist reviews what you send and returns an itemised treatment plan with a fixed price. No charge, and no obligation afterwards.', 'veahealth' )
	);
endwhile;
?>

<section class="section">
	<div class="shell">
		<div class="grid g-2" style="gap:clamp(30px,5vw,64px);align-items:start">

			<div class="form-card" data-anim="up">
				<?php veahealth_enquiry_form(); ?>
			</div>

			<div>
				<h2 data-anim="up"><?php esc_html_e( 'Prefer to talk first?', 'veahealth' ); ?></h2>
				<p class="lede mt-24" data-anim="up">
					<?php esc_html_e( 'WhatsApp is answered seven days a week, in English. Call or email during Istanbul office hours.', 'veahealth' ); ?>
				</p>

				<div class="mt-32" data-anim="up" style="display:flex;flex-direction:column;gap:12px">
					<?php if ( veahealth_whatsapp_url() ) : ?>
						<a class="btn btn--wa btn--lg" href="<?php echo esc_url( veahealth_whatsapp_url() ); ?>" rel="noopener">
							<?php echo veahealth_icon( 'wa' ); ?> <?php esc_html_e( 'WhatsApp', 'veahealth' ); ?> <?php echo esc_html( veahealth_option( 'phone' ) ); ?>
						</a>
					<?php endif; ?>
					<?php if ( veahealth_option( 'phone' ) ) : ?>
						<a class="btn btn--ghost btn--lg" href="tel:<?php echo esc_attr( preg_replace( '/[^\d+]/', '', veahealth_option( 'phone' ) ) ); ?>">
							<?php echo veahealth_icon( 'phone' ); ?> <?php echo esc_html( veahealth_option( 'phone' ) ); ?>
						</a>
					<?php endif; ?>
					<?php if ( veahealth_option( 'email' ) ) : ?>
						<a class="btn btn--ghost btn--lg" href="mailto:<?php echo esc_attr( veahealth_option( 'email' ) ); ?>">
							<?php echo veahealth_icon( 'mail' ); ?> <?php echo esc_html( veahealth_option( 'email' ) ); ?>
						</a>
					<?php endif; ?>
				</div>

				<div class="card mt-48" data-anim="up">
					<h3><?php esc_html_e( 'What to send', 'veahealth' ); ?></h3>
					<ul class="checklist mt-24">
						<li><?php echo veahealth_icon( 'check' ); ?> <?php esc_html_e( 'A photograph of your smile, relaxed and wide', 'veahealth' ); ?></li>
						<li><?php echo veahealth_icon( 'check' ); ?> <?php esc_html_e( 'A photograph from the side, if you can', 'veahealth' ); ?></li>
						<li><?php echo veahealth_icon( 'check' ); ?> <?php esc_html_e( 'Any panoramic X-ray taken in the last two years', 'veahealth' ); ?></li>
						<li><?php echo veahealth_icon( 'check' ); ?> <?php esc_html_e( 'A note of any medication or medical condition', 'veahealth' ); ?></li>
					</ul>
					<p class="mt-24" style="font-size:.86rem;color:var(--ink-2)">
						<?php esc_html_e( 'Photographs taken on a phone in daylight are fine. You do not need professional images for the assessment.', 'veahealth' ); ?>
					</p>
				</div>

				<div class="card mt-24" data-anim="up">
					<h3><?php esc_html_e( 'Opening hours', 'veahealth' ); ?></h3>
					<p>
						<?php
						foreach ( preg_split( '/\r\n|\r|\n/', (string) veahealth_option( 'hours' ) ) as $line ) {
							if ( trim( $line ) ) {
								echo esc_html( trim( $line ) ) . '<br>';
							}
						}
						?>
					</p>
				</div>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>

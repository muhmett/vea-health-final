<?php
/**
 * Template Name: About VeaHealth
 *
 * @package VeaHealth
 */

get_header();

while ( have_posts() ) :
	the_post();
	veahealth_page_hero(
		__( 'About', 'veahealth' ),
		__( 'A coordinator, not a clinic.', 'veahealth' ),
		has_excerpt() ? get_the_excerpt() : ''
	);
endwhile;
?>

<section class="section">
	<div class="shell">
		<div class="grid g-2" style="gap:clamp(32px,6vw,72px);align-items:start">
			<div>
				<h2 data-anim="up"><?php esc_html_e( 'What we do', 'veahealth' ); ?></h2>
				<p class="lede mt-24" data-anim="up">
					<?php esc_html_e( 'We sit between you and the clinic. That means reviewing your photographs with a partner dentist before you travel, getting the treatment plan and the price in writing, booking the transfers and the hotel around your appointments, translating in the chair, and staying reachable once you are home.', 'veahealth' ); ?>
				</p>
				<p class="mt-24" data-anim="up">
					<?php esc_html_e( 'It also means telling you when a treatment is not indicated. An assessment that comes back saying you do not need what you asked about is a good assessment, and you will get those from us.', 'veahealth' ); ?>
				</p>
			</div>
			<div>
				<h2 data-anim="up"><?php esc_html_e( 'What we do not do', 'veahealth' ); ?></h2>
				<ul class="checklist mt-24" data-anim="up">
					<li><?php echo veahealth_icon( 'check' ); ?> <?php esc_html_e( 'We do not perform treatment — partner clinics and their clinicians do', 'veahealth' ); ?></li>
					<li><?php echo veahealth_icon( 'check' ); ?> <?php esc_html_e( 'We do not quote a price that changes once you land', 'veahealth' ); ?></li>
					<li><?php echo veahealth_icon( 'check' ); ?> <?php esc_html_e( 'We do not publish stock photography as patient results', 'veahealth' ); ?></li>
					<li><?php echo veahealth_icon( 'check' ); ?> <?php esc_html_e( 'We do not guarantee an outcome; no honest clinic can', 'veahealth' ); ?></li>
					<li><?php echo veahealth_icon( 'check' ); ?> <?php esc_html_e( 'We do not take a deposit before you have a written plan', 'veahealth' ); ?></li>
				</ul>
			</div>
		</div>
	</div>
</section>

<section class="section section--tint">
	<div class="shell">
		<?php
		veahealth_section_head(
			__( 'How to judge us', 'veahealth' ),
			__( 'Questions worth asking any coordinator.', 'veahealth' ),
			__( 'Including this one. If a question below cannot be answered plainly and in writing, that tells you something.', 'veahealth' )
		);
		$cards = array(
			array( __( 'Who performs the treatment?', 'veahealth' ), __( 'Ask for the name and registration of the treating clinician, not the name of the agency. You are entitled to know who will be operating on you.', 'veahealth' ) ),
			array( __( 'Is the quote itemised and fixed?', 'veahealth' ), __( 'A quote should list every component — implants, abutments, crowns, grafting materials, laboratory work — and state what happens if the plan changes once you are in the chair.', 'veahealth' ) ),
			array( __( 'Are these results your own patients?', 'veahealth' ), __( 'Ask directly whether before-and-after images are the clinic’s own cases. Stock and generated images are common in this industry and are worth nothing to you.', 'veahealth' ) ),
			array( __( 'What happens if something goes wrong at home?', 'veahealth' ), __( 'Ask what the warranty covers, what it excludes, who reviews a problem, and whether return flights are included in a revision. Get the answer in writing.', 'veahealth' ) ),
		);
		?>
		<div class="grid g-2" data-stagger="80">
			<?php foreach ( $cards as $c ) : ?>
				<div class="card" data-anim="up">
					<h3><?php echo esc_html( $c[0] ); ?></h3>
					<p><?php echo esc_html( $c[1] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php if ( trim( get_the_content() ) ) : ?>
	<section class="section">
		<div class="shell shell-narrow">
			<div class="entry"><?php echo apply_filters( 'the_content', get_the_content() ); ?></div>
		</div>
	</section>
<?php endif; ?>

<?php
veahealth_cta_band(
	__( 'Ask us anything before you commit.', 'veahealth' ),
	__( 'No deposit, no booking and no pressure until you have a written plan you are happy with.', 'veahealth' )
);
get_footer();

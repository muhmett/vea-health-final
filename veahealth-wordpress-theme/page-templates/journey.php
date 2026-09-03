<?php
/**
 * Template Name: The journey
 *
 * @package VeaHealth
 */

get_header();

while ( have_posts() ) :
	the_post();
	veahealth_page_hero(
		__( 'The journey', 'veahealth' ),
		__( 'From your first message to the flight home.', 'veahealth' ),
		has_excerpt() ? get_the_excerpt() : __( 'Medical travel goes wrong in the gaps — the transfer nobody booked, the plan that changed price on arrival, the clinic that stopped replying once you landed back home. This is how each of those gaps is closed.', 'veahealth' )
	);
endwhile;

/*
 * Everything from the first stage to the aftercare is one scope: the timeline
 * measures its nodes out of it, so a stage added or removed renumbers the rail
 * without anything here needing to be told.
 */
$stages = veahealth_journey();
?>
<div class="tl-scope" data-timeline-scope>
	<div class="tl-rail" aria-hidden="true">
		<canvas data-timeline></canvas>
	</div>
	<div class="tl-track">
<?php
$i = 0;
foreach ( $stages as $j ) :
	$media = sprintf(
		'<div class="media-frame ratio-16-9" data-anim="scale"><img src="%s" alt="%s" width="900" height="506" loading="lazy" decoding="async"></div>',
		esc_url( VEAHEALTH_URI . '/assets/img/art/' . $j['img'] . '-900.webp' ),
		esc_attr( $j['alt'] )
	);
	ob_start();
	?>
	<div>
		<p class="step-meta" data-anim="fade"><?php echo esc_html( $j['meta'] ); ?></p>
		<h2 data-anim="up"><?php echo esc_html( $j['title'] ); ?></h2>
		<p class="lede mt-24" data-anim="up"><?php echo esc_html( $j['text'] ); ?></p>
		<ul class="checklist mt-24" data-anim="up">
			<?php foreach ( $j['list'] as $x ) : ?>
				<li><?php echo veahealth_icon( 'check' ); ?> <?php echo esc_html( $x ); ?></li>
			<?php endforeach; ?>
		</ul>
	</div>
	<?php
	$text = ob_get_clean();
	?>
	<section class="section<?php echo ( $i % 2 ) ? ' section--tint' : ''; ?>" data-timeline-step>
		<div class="shell">
			<div class="grid g-2" style="align-items:center;gap:clamp(28px,5vw,64px)">
				<?php echo ( 0 === $i % 2 ) ? $text . $media : $media . $text; ?>
			</div>
		</div>
	</section>
	<?php
	$i++;
endforeach;
?>

<section class="section" data-timeline-step>
	<div class="shell shell-narrow">
		<h2 data-anim="up"><?php esc_html_e( 'After you fly home', 'veahealth' ); ?></h2>
		<p class="lede mt-24" data-anim="up">
			<?php esc_html_e( 'Aftercare is where medical tourism most often fails patients. Your coordinator stays reachable on the same WhatsApp number you used before treatment. If something needs reviewing, you send photographs and the treating clinician looks at them — you are not handed to a general inbox.', 'veahealth' ); ?>
		</p>
		<ul class="checklist mt-24" data-anim="up">
			<li><?php echo veahealth_icon( 'check' ); ?> <?php esc_html_e( 'Same coordinator, same number, after you land', 'veahealth' ); ?></li>
			<li><?php echo veahealth_icon( 'check' ); ?> <?php esc_html_e( 'Written aftercare protocol before you leave Istanbul', 'veahealth' ); ?></li>
			<li><?php echo veahealth_icon( 'check' ); ?> <?php esc_html_e( 'Follow-up photograph reviews at agreed intervals', 'veahealth' ); ?></li>
			<li><?php echo veahealth_icon( 'check' ); ?> <?php esc_html_e( 'Warranty terms issued in writing with your treatment plan', 'veahealth' ); ?></li>
		</ul>
	</div>
</section>

	</div>
</div>

<?php
veahealth_cta_band(
	__( 'Start with the assessment, not the booking.', 'veahealth' ),
	__( 'Nothing is scheduled and no deposit is taken until you have read a written plan with a fixed price and decided you want to go ahead.', 'veahealth' )
);
get_footer();

<?php
/**
 * Template Name: Before &amp; after (patient results)
 *
 * @package VeaHealth
 */

get_header();

while ( have_posts() ) :
	the_post();
	veahealth_page_hero(
		__( 'Patient results', 'veahealth' ),
		__( 'Before and after, with the handle in your hand.', 'veahealth' ),
		has_excerpt() ? get_the_excerpt() : __( 'Drag across each image to compare. These are photographs of VeaHealth patients, taken at the partner clinic and published with permission — not stock photography and not generated images.', 'veahealth' )
	);
endwhile;
?>

<section class="section">
	<div class="shell">
		<div class="grid g-2" data-stagger="110">
			<?php foreach ( veahealth_results() as $r ) { veahealth_before_after( $r ); } ?>
		</div>
		<p class="mt-48" style="font-size:.88rem;color:var(--ink-2);max-width:70ch">
			<?php esc_html_e( 'Results vary between individuals. Bone quality, gum health, healing response and aftercare all affect the outcome, and no clinic can guarantee that your result will match another patient’s. What you see here is what was achieved for these patients, photographed under the clinic’s own lighting conditions.', 'veahealth' ); ?>
		</p>
	</div>
</section>

<section class="section section--tint">
	<div class="shell">
		<?php
		veahealth_section_head(
			__( 'In motion', 'veahealth' ),
			__( 'Patients, filmed at the clinic.', 'veahealth' ),
			__( 'Short clips recorded after treatment, with the patients’ permission.', 'veahealth' )
		);
		?>
		<div class="grid g-3" data-stagger="120" style="max-width:760px">
			<?php foreach ( array( 2, 4 ) as $n ) : ?>
				<figure class="media-frame" data-anim="up">
					<video controls preload="none" playsinline width="460" height="816"
					       poster="<?php echo esc_url( VEAHEALTH_URI . '/assets/img/film/patient-story-' . $n . '-poster.webp' ); ?>"
					       aria-label="<?php esc_attr_e( 'Patient filmed after treatment', 'veahealth' ); ?>">
						<source src="<?php echo esc_url( VEAHEALTH_URI . '/assets/video/patient-story-' . $n . '.mp4' ); ?>" type="video/mp4">
					</video>
				</figure>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php
veahealth_cta_band(
	__( 'See what is achievable in your case.', 'veahealth' ),
	__( 'Send photographs of your current smile and any recent X-rays. You will get a written plan showing what is realistic — not a sales pitch built on somebody else’s results.', 'veahealth' )
);
get_footer();

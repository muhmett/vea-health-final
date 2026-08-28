<?php
/**
 * A standard page: hero from the title and excerpt, then the editor content.
 *
 * @package VeaHealth
 */

get_header();

while ( have_posts() ) :
	the_post();
	veahealth_page_hero(
		__( 'VeaHealth', 'veahealth' ),
		get_the_title(),
		has_excerpt() ? get_the_excerpt() : ''
	);
	?>
	<section class="section">
		<div class="shell shell-narrow">
			<div class="entry"><?php the_content(); ?></div>
		</div>
	</section>
	<?php
endwhile;

veahealth_cta_band(
	__( 'Ask us anything before you commit.', 'veahealth' ),
	__( 'No deposit, no booking and no pressure until you have a written plan you are happy with.', 'veahealth' )
);

get_footer();

<?php
/**
 * The treatments hub, grouped by treatment category.
 *
 * @package VeaHealth
 */

get_header();

$count = (int) wp_count_posts( 'service' )->publish;

veahealth_page_hero(
	__( 'Treatments', 'veahealth' ),
	__( 'Every treatment, documented in full.', 'veahealth' ),
	sprintf(
		/* translators: %d: number of treatments */
		__( '%d treatments across dentistry and hair restoration. Each page carries the technique, the materials, the day-by-day procedure, the recovery timeline, the published evidence and the Istanbul price — so you can decide before you speak to anyone.', 'veahealth' ),
		$count
	)
);

$terms = get_terms( array( 'taxonomy' => 'service_category', 'hide_empty' => true ) );
$tint  = false;

if ( ! is_wp_error( $terms ) && $terms ) :
	foreach ( $terms as $term ) :
		$items = get_posts(
			array(
				'post_type'      => 'service',
				'posts_per_page' => 40,
				'orderby'        => 'menu_order',
				'order'          => 'ASC',
				'tax_query'      => array( array( 'taxonomy' => 'service_category', 'field' => 'term_id', 'terms' => $term->term_id ) ),
			)
		);
		if ( ! $items ) {
			continue;
		}
		?>
		<section class="section<?php echo $tint ? ' section--tint' : ''; ?>">
			<div class="shell">
				<div class="sec-head">
					<p class="eyebrow" data-anim="fade">
						<?php
						/* translators: %d: number of treatments in this group */
						printf( esc_html( _n( '%d treatment', '%d treatments', count( $items ), 'veahealth' ) ), count( $items ) );
						?>
					</p>
					<h2 data-anim="up"><?php echo esc_html( $term->name ); ?></h2>
					<?php if ( $term->description ) : ?>
						<p class="lede" data-anim="up"><?php echo esc_html( $term->description ); ?></p>
					<?php endif; ?>
				</div>
				<div class="grid g-3" data-stagger="80">
					<?php foreach ( $items as $item ) { veahealth_service_card( $item, false ); } ?>
				</div>
			</div>
		</section>
		<?php
		$tint = ! $tint;
	endforeach;
else :
	?>
	<section class="section">
		<div class="shell">
			<p class="lede"><?php esc_html_e( 'No treatments have been published yet.', 'veahealth' ); ?></p>
		</div>
	</section>
	<?php
endif;

veahealth_cta_band(
	__( 'Not sure which treatment applies to you?', 'veahealth' ),
	__( 'Send photographs and any recent X-rays. A partner dentist reviews them and tells you what is actually indicated — including when the answer is that you do not need what you asked about.', 'veahealth' )
);

get_footer();

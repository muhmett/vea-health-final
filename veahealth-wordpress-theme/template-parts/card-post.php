<?php
/**
 * One article card.
 *
 * @package VeaHealth
 */

$cover = get_the_post_thumbnail_url( get_the_ID(), 'veahealth-wide' );
if ( ! $cover ) {
	$cover = VEAHEALTH_URI . '/assets/img/art/blog-cover-dental-ceramic-sand-900.webp';
}
?>
<a class="card svc-card" href="<?php the_permalink(); ?>" data-anim="up">
	<div class="svc-media">
		<img src="<?php echo esc_url( $cover ); ?>"
		     alt="<?php echo esc_attr( get_the_title() ); ?>"
		     width="900" height="506" loading="lazy" decoding="async">
	</div>
	<div class="svc-body">
		<p class="svc-tag"><time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time></p>
		<h3><?php the_title(); ?></h3>
		<p><?php echo esc_html( get_the_excerpt() ); ?></p>
		<span class="card-arrow"><?php esc_html_e( 'Read', 'veahealth' ); ?> <?php echo veahealth_icon( 'arrow' ); ?></span>
	</div>
</a>

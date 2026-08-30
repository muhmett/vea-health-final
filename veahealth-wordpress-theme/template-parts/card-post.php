<?php
/**
 * One article card.
 *
 * @package VeaHealth
 */

$cover = veahealth_post_cover( get_the_ID() );
$cats  = get_the_category();
$read  = (int) get_post_meta( get_the_ID(), '_vh_read', true );
?>
<a class="card svc-card" href="<?php the_permalink(); ?>" data-anim="up">
	<div class="svc-media">
		<img src="<?php echo esc_url( $cover ); ?>"
		     alt="<?php echo esc_attr( get_the_title() ); ?>"
		     width="900" height="506" loading="lazy" decoding="async">
	</div>
	<div class="svc-body">
		<p class="svc-tag">
			<?php if ( $cats ) : ?>
				<?php echo esc_html( $cats[0]->name ); ?> <span aria-hidden="true">·</span>
			<?php endif; ?>
			<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date( 'j M Y' ) ); ?></time>
			<?php if ( $read ) : ?>
				<span aria-hidden="true">·</span>
				<?php
				/* translators: %d: minutes to read */
				printf( esc_html__( '%d min', 'veahealth' ), (int) $read );
				?>
			<?php endif; ?>
		</p>
		<h3><?php the_title(); ?></h3>
		<p><?php echo esc_html( get_the_excerpt() ); ?></p>
		<span class="card-arrow"><?php esc_html_e( 'Read', 'veahealth' ); ?> <?php echo veahealth_icon( 'arrow' ); ?></span>
	</div>
</a>

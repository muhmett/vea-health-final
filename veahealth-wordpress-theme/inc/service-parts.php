<?php
/**
 * The treatment page, section by section.
 *
 * Each function here renders one part of a treatment from the structured data
 * in service-data.php. Nothing renders when its data is absent, so a treatment
 * that has no published evidence simply has no evidence section rather than an
 * empty heading — which is also why the contents rail is built from what a
 * given page actually contains rather than from a fixed list.
 *
 * @package VeaHealth
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The sections a given treatment actually has, in reading order.
 *
 * @param array $p Structured treatment data.
 * @return array<string,string> section id => nav label
 */
function veahealth_service_sections( $p ) {
	$map = array(
		'why'       => __( 'Why this treatment', 'veahealth' ),
		'compare'   => __( 'How it compares', 'veahealth' ),
		'procedure' => __( 'The procedure', 'veahealth' ),
		'cost'      => __( 'What it costs', 'veahealth' ),
		'recovery'  => __( 'Recovery', 'veahealth' ),
		'evidence'  => __( 'The evidence', 'veahealth' ),
		'faq'       => __( 'Questions', 'veahealth' ),
	);
	$out = array();
	foreach ( $map as $key => $label ) {
		if ( ! empty( $p[ $key ] ) ) {
			$out[ $key ] = $label;
		}
	}
	return $out;
}

/** A section's eyebrow and heading, with a link you can copy. */
function veahealth_part_head( $part, $id, $fallback_title = '' ) {
	$label = isset( $part['label'] ) ? $part['label'] : '';
	$title = ! empty( $part['title'] ) ? $part['title'] : $fallback_title;
	$intro = isset( $part['intro'] ) ? $part['intro'] : '';
	?>
	<header class="tp-head">
		<?php if ( $label ) : ?>
			<p class="eyebrow"><?php echo esc_html( $label ); ?></p>
		<?php endif; ?>
		<h2 id="<?php echo esc_attr( $id ); ?>-title">
			<?php echo esc_html( $title ); ?>
			<a class="tp-anchor" href="#<?php echo esc_attr( $id ); ?>"
			   aria-label="<?php echo esc_attr( sprintf( __( 'Link to “%s”', 'veahealth' ), $title ) ); ?>">#</a>
		</h2>
		<?php if ( $intro ) : ?>
			<p class="lede"><?php echo esc_html( $intro ); ?></p>
		<?php endif; ?>
	</header>
	<?php
}

/** Benefits, as a grid of claims each with its reasoning. */
function veahealth_part_why( $part ) {
	if ( empty( $part['cards'] ) ) {
		return;
	}
	?>
	<section class="tp-section" id="why" aria-labelledby="why-title">
		<?php veahealth_part_head( $part, 'why', __( 'Why patients choose it', 'veahealth' ) ); ?>
		<div class="tp-why" data-stagger="70">
			<?php foreach ( $part['cards'] as $i => $c ) : ?>
				<article class="tp-why-card" data-anim="up">
					<p class="tp-why-n"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></p>
					<h3><?php echo esc_html( $c['title'] ); ?></h3>
					<p><?php echo esc_html( $c['text'] ); ?></p>
				</article>
			<?php endforeach; ?>
		</div>
	</section>
	<?php
}

/**
 * The comparison table.
 *
 * A wide table is unreadable on a phone, and putting it in a horizontal
 * scroller just hides the comparison. Each row is repeated as a card below the
 * table and one or the other is shown, so the same markup answers "how does
 * this compare" at both sizes.
 */
function veahealth_part_compare( $part ) {
	if ( empty( $part['rows'] ) || empty( $part['head'] ) ) {
		return;
	}
	$head = $part['head'];
	?>
	<section class="tp-section" id="compare" aria-labelledby="compare-title">
		<?php veahealth_part_head( $part, 'compare', __( 'How it compares', 'veahealth' ) ); ?>

		<div class="tp-table-wrap" data-anim="up">
			<table class="tp-table">
				<caption class="screen-reader-text">
					<?php echo esc_html( ! empty( $part['title'] ) ? $part['title'] : __( 'Comparison of options', 'veahealth' ) ); ?>
				</caption>
				<thead>
					<tr>
						<?php foreach ( $head as $n => $h ) : ?>
							<th scope="col"<?php echo 1 === $n ? ' class="is-ours"' : ''; ?>><?php echo esc_html( $h ); ?></th>
						<?php endforeach; ?>
					</tr>
				</thead>
				<tbody>
					<?php foreach ( $part['rows'] as $row ) : ?>
						<tr>
							<th scope="row"><?php echo esc_html( $row['label'] ); ?></th>
							<?php foreach ( $row['values'] as $n => $v ) : ?>
								<td class="<?php echo esc_attr( trim( ( 0 === $n ? 'is-ours ' : '' ) . ( $v['good'] ? 'is-good' : ( $v['bad'] ? 'is-bad' : '' ) ) ) ); ?>">
									<?php echo esc_html( $v['v'] ); ?>
								</td>
							<?php endforeach; ?>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>

		<ul class="tp-table-cards" data-anim="up">
			<?php foreach ( $part['rows'] as $row ) : ?>
				<li class="tp-table-card">
					<p class="tp-table-card__k"><?php echo esc_html( $row['label'] ); ?></p>
					<dl>
						<?php foreach ( $row['values'] as $n => $v ) : ?>
							<div class="<?php echo 0 === $n ? 'is-ours' : ''; ?>">
								<dt><?php echo esc_html( isset( $head[ $n + 1 ] ) ? $head[ $n + 1 ] : '' ); ?></dt>
								<dd><?php echo esc_html( $v['v'] ); ?></dd>
							</div>
						<?php endforeach; ?>
					</dl>
				</li>
			<?php endforeach; ?>
		</ul>
	</section>
	<?php
}

/** The procedure, as a spine that fills as you read down it. */
function veahealth_part_procedure( $part ) {
	if ( empty( $part['steps'] ) ) {
		return;
	}
	?>
	<section class="tp-section" id="procedure" aria-labelledby="procedure-title">
		<?php veahealth_part_head( $part, 'procedure', __( 'The procedure, step by step', 'veahealth' ) ); ?>
		<ol class="tp-steps">
			<span class="tp-steps__spine" aria-hidden="true"><i></i></span>
			<?php foreach ( $part['steps'] as $i => $s ) : ?>
				<li class="tp-step" data-anim="up">
					<div class="tp-step__n" aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></div>
					<div class="tp-step__body">
						<?php if ( ! empty( $s['tag'] ) ) : ?>
							<p class="tp-step__tag"><?php echo esc_html( $s['tag'] ); ?></p>
						<?php endif; ?>
						<h3><?php echo esc_html( $s['title'] ); ?></h3>
						<?php if ( ! empty( $s['text'] ) ) : ?>
							<p><?php echo esc_html( $s['text'] ); ?></p>
						<?php endif; ?>
						<?php if ( ! empty( $s['points'] ) ) : ?>
							<ul class="checklist">
								<?php foreach ( $s['points'] as $pt ) : ?>
									<li><?php echo veahealth_icon( 'check' ); ?> <?php echo esc_html( $pt ); ?></li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>
					</div>
				</li>
			<?php endforeach; ?>
		</ol>
	</section>
	<?php
}

/**
 * Read a price out of the copy so the bars can be drawn to scale.
 *
 * Returns 0 when there is no number to read — a treatment quoted "on request"
 * gets a row without a bar rather than a bar of length zero pretending to be
 * a price.
 */
function veahealth_price_value( $s ) {
	if ( ! preg_match( '/([\d][\d,\.]*)/', (string) $s, $m ) ) {
		return 0;
	}
	return (float) str_replace( ',', '', $m[1] );
}

/** What it costs, drawn to scale, with the saving worked out. */
function veahealth_part_cost( $part ) {
	if ( empty( $part['tiers'] ) ) {
		return;
	}
	$tiers = $part['tiers'];
	$vals  = array_map( 'veahealth_price_value', wp_list_pluck( $tiers, 'price' ) );
	$max   = max( $vals ) ?: 0;

	// The cheapest quoted figure is ours; the dearest is what it is compared to.
	$ours = null;
	foreach ( $tiers as $i => $t ) {
		if ( $vals[ $i ] > 0 && ( null === $ours || $vals[ $i ] < $vals[ $ours ] ) ) {
			$ours = $i;
		}
	}
	$saving = 0;
	if ( null !== $ours && $max > 0 && $vals[ $ours ] > 0 ) {
		$saving = (int) round( ( 1 - ( $vals[ $ours ] / $max ) ) * 100 );
	}
	?>
	<section class="tp-section" id="cost" aria-labelledby="cost-title">
		<?php veahealth_part_head( $part, 'cost', __( 'What it costs', 'veahealth' ) ); ?>

		<div class="tp-cost" data-anim="up">
			<?php foreach ( $tiers as $i => $t ) :
				$pct = $max > 0 && $vals[ $i ] > 0 ? max( 4, round( ( $vals[ $i ] / $max ) * 100 ) ) : 0;
				?>
				<div class="tp-cost-row<?php echo $i === $ours ? ' is-ours' : ''; ?>">
					<p class="tp-cost-where">
						<?php echo esc_html( $t['where'] ); ?>
						<?php if ( $i === $ours ) : ?>
							<span class="tp-badge"><?php esc_html_e( 'Your price', 'veahealth' ); ?></span>
						<?php endif; ?>
					</p>
					<div class="tp-cost-bar" aria-hidden="true">
						<span style="--w:<?php echo (int) $pct; ?>%"></span>
					</div>
					<p class="tp-cost-price"><?php echo esc_html( $t['price'] ); ?></p>
				</div>
				<?php if ( ! empty( $t['note'] ) ) : ?>
					<p class="tp-cost-note"><?php echo esc_html( $t['note'] ); ?></p>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>

		<?php if ( $saving >= 10 ) : ?>
			<p class="tp-saving" data-anim="up">
				<?php
				printf(
					/* translators: %s: percentage saved */
					esc_html__( 'Around %s less than the highest figure above, for the same implant systems and the same materials.', 'veahealth' ),
					'<strong><span data-count="' . esc_attr( $saving ) . '" data-suffix="%">0</span></strong>'
				);
				?>
			</p>
		<?php endif; ?>

		<p class="tp-cost-caveat">
			<?php esc_html_e( 'Figures are indicative and are what comparable clinics were quoting when this page was written. Your own price is fixed in writing after a dentist has reviewed your photographs and X-rays — it is not estimated from this page.', 'veahealth' ); ?>
		</p>
	</section>
	<?php
}

/** Recovery, phase by phase. */
function veahealth_part_recovery( $part ) {
	if ( empty( $part['phases'] ) ) {
		return;
	}
	?>
	<section class="tp-section" id="recovery" aria-labelledby="recovery-title">
		<?php veahealth_part_head( $part, 'recovery', __( 'Recovery', 'veahealth' ) ); ?>
		<div class="tp-phases" data-stagger="80">
			<?php foreach ( $part['phases'] as $ph ) : ?>
				<article class="tp-phase" data-anim="up">
					<?php if ( ! empty( $ph['n'] ) ) : ?>
						<p class="tp-phase__n"><?php echo esc_html( $ph['n'] ); ?></p>
					<?php endif; ?>
					<h3><?php echo esc_html( $ph['title'] ); ?></h3>
					<?php if ( ! empty( $ph['text'] ) ) : ?>
						<p><?php echo esc_html( $ph['text'] ); ?></p>
					<?php endif; ?>
					<?php if ( ! empty( $ph['points'] ) ) : ?>
						<ul class="checklist">
							<?php foreach ( $ph['points'] as $pt ) : ?>
								<li><?php echo veahealth_icon( 'check' ); ?> <?php echo esc_html( $pt ); ?></li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</article>
			<?php endforeach; ?>
		</div>
	</section>
	<?php
}

/** Published figures, each with the study it came from. */
function veahealth_part_evidence( $part ) {
	if ( empty( $part['items'] ) ) {
		return;
	}
	?>
	<section class="tp-section tp-section--tint" id="evidence" aria-labelledby="evidence-title">
		<?php veahealth_part_head( $part, 'evidence', __( 'What the studies show', 'veahealth' ) ); ?>
		<div class="tp-evidence" data-stagger="90">
			<?php foreach ( $part['items'] as $e ) : ?>
				<figure class="tp-ev" data-anim="up">
					<p class="tp-ev__fig"><?php echo esc_html( $e['figure'] ); ?></p>
					<blockquote><p><?php echo esc_html( $e['text'] ); ?></p></blockquote>
					<?php if ( ! empty( $e['source'] ) ) : ?>
						<figcaption><?php echo esc_html( $e['source'] ); ?></figcaption>
					<?php endif; ?>
				</figure>
			<?php endforeach; ?>
		</div>
	</section>
	<?php
}

/**
 * The questions.
 *
 * Built on <details>, so every answer opens without JavaScript and every answer
 * is in the page for search engines to read rather than injected on click.
 */
function veahealth_part_faq( $part ) {
	if ( empty( $part['items'] ) ) {
		return;
	}
	?>
	<section class="tp-section" id="faq" aria-labelledby="faq-title">
		<?php veahealth_part_head( $part, 'faq', __( 'Questions patients ask', 'veahealth' ) ); ?>
		<div class="tp-faq" data-anim="up">
			<?php foreach ( $part['items'] as $i => $f ) : ?>
				<details class="tp-faq-item"<?php echo 0 === $i ? ' open' : ''; ?>>
					<summary>
						<span><?php echo esc_html( $f['q'] ); ?></span>
						<?php echo veahealth_icon( 'plus' ); ?>
					</summary>
					<div class="tp-faq-a"><p><?php echo esc_html( $f['a'] ); ?></p></div>
				</details>
			<?php endforeach; ?>
		</div>
	</section>
	<?php
}

/**
 * The key-facts strip under the hero.
 *
 * Only what is actually recorded for the treatment goes in it. There is no
 * placeholder row: a fact nobody has entered is a fact the page does not claim.
 */
function veahealth_treatment_facts( $post_id, $p ) {
	$facts = array();

	if ( ! empty( $p['price'] ) ) {
		$facts[] = array( 'icon' => 'tag', 'k' => __( 'Istanbul, from', 'veahealth' ), 'v' => $p['price'] );
	}
	$type = get_post_meta( $post_id, '_vh_procedure_type', true );
	if ( $type ) {
		$facts[] = array( 'icon' => 'shield', 'k' => __( 'Procedure type', 'veahealth' ), 'v' => $type );
	}
	foreach ( array_slice( isset( $p['stats'] ) ? $p['stats'] : array(), 0, 2 ) as $s ) {
		if ( ! empty( $s['v'] ) && ! empty( $s['k'] ) ) {
			$facts[] = array( 'icon' => 'clock', 'k' => $s['k'], 'v' => $s['v'] );
		}
	}

	$prep   = get_post_meta( $post_id, '_vh_preparation', true );
	$follow = get_post_meta( $post_id, '_vh_followup', true );

	if ( ! $facts && ! $prep && ! $follow ) {
		return;
	}
	?>
	<div class="tp-facts">
		<div class="shell">
			<?php if ( $facts ) : ?>
				<dl class="tp-facts__row">
					<?php foreach ( $facts as $f ) : ?>
						<?php
						/*
						 * The icon lives inside the <dt>, not beside it. A <dl>
						 * may only group its terms with a bare <div>, so a
						 * wrapper around the dt/dd pair to hang an icon off
						 * breaks the term-to-value association for a screen
						 * reader — which is what it did here until axe said so.
						 */
						?>
						<div class="tp-fact">
							<dt>
								<span class="tp-fact__i" aria-hidden="true"><?php echo veahealth_icon( $f['icon'] ); ?></span>
								<?php echo esc_html( $f['k'] ); ?>
							</dt>
							<dd><?php echo esc_html( $f['v'] ); ?></dd>
						</div>
					<?php endforeach; ?>
				</dl>
			<?php endif; ?>

			<?php if ( $prep || $follow ) : ?>
				<div class="tp-facts__long">
					<?php if ( $prep ) : ?>
						<div>
							<h2><?php esc_html_e( 'Before your appointment', 'veahealth' ); ?></h2>
							<p><?php echo esc_html( $prep ); ?></p>
						</div>
					<?php endif; ?>
					<?php if ( $follow ) : ?>
						<div>
							<h2><?php esc_html_e( 'Afterwards', 'veahealth' ); ?></h2>
							<p><?php echo esc_html( $follow ); ?></p>
						</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<p class="tp-facts__meta">
				<?php
				printf(
					/* translators: %s: date the page was last edited */
					esc_html__( 'Page last updated %s. Prices and protocols are reviewed by the partner clinic; your own plan is written for your case.', 'veahealth' ),
					esc_html( get_the_modified_date( get_option( 'date_format' ), $post_id ) )
				);
				?>
			</p>
		</div>
	</div>
	<?php
}

/**
 * Other treatments from the same group.
 *
 * Somebody reading about a single implant is usually deciding between three
 * things, not one, so the page ends by naming the other two rather than
 * leaving the back button as the only way on.
 */
function veahealth_related_treatments( $post_id, $limit = 3 ) {
	$terms = wp_get_post_terms( $post_id, 'service_category', array( 'fields' => 'ids' ) );
	$args  = array(
		'post_type'      => 'service',
		'posts_per_page' => $limit,
		'post__not_in'   => array( $post_id ),
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
	);
	if ( $terms ) {
		$args['tax_query'] = array( array( 'taxonomy' => 'service_category', 'field' => 'term_id', 'terms' => $terms ) );
	}
	$related = get_posts( $args );

	// A group with nothing else in it should still not dead-end the reader.
	if ( count( $related ) < $limit ) {
		$fill = get_posts( array(
			'post_type'      => 'service',
			'posts_per_page' => $limit - count( $related ),
			'post__not_in'   => array_merge( array( $post_id ), wp_list_pluck( $related, 'ID' ) ),
			'orderby'        => 'rand',
		) );
		$related = array_merge( $related, $fill );
	}
	if ( ! $related ) {
		return;
	}
	?>
	<section class="section section--tint tp-related">
		<div class="shell">
			<?php
			veahealth_section_head(
				__( 'Keep reading', 'veahealth' ),
				__( 'Treatments people compare with this one.', 'veahealth' )
			);
			?>
			<div class="grid g-3" data-stagger="90">
				<?php foreach ( $related as $r ) { veahealth_service_card( $r ); } ?>
			</div>
		</div>
	</section>
	<?php
}

/**
 * A callout.
 *
 * Two things go in one: a page saying plainly what a treatment does not do, and
 * the line telling the reader that a clinician still has to look at their case.
 * Both are the sort of thing a marketing page leaves out, which is exactly why
 * they are components rather than something an editor has to remember.
 *
 * @param string $text  The note.
 * @param string $kind  'plain' or 'warn'.
 */
function veahealth_part_note( $text, $kind = 'plain' ) {
	if ( ! $text ) {
		return;
	}
	?>
	<aside class="tp-note tp-note--<?php echo esc_attr( $kind ); ?>">
		<p><?php echo esc_html( $text ); ?></p>
	</aside>
	<?php
}

/**
 * The whole body of a treatment, as HTML.
 *
 * The installer stores this as the post content, so what the theme renders and
 * what the admin edits are the same thing. That is the point: the structured
 * data below is a source, not a runtime dependency — an owner who rewrites a
 * paragraph in the editor sees their words on the page, and nothing here reads
 * the data back to overrule them.
 *
 * @param string $slug Treatment slug.
 * @return string
 */
function veahealth_service_body_html( $slug ) {
	$p = veahealth_service_parts( $slug );
	if ( ! $p ) {
		return '';
	}
	ob_start();
	veahealth_part_note( isset( $p['caveat'] ) ? $p['caveat'] : '', 'warn' );
	veahealth_part_why( isset( $p['why'] ) ? $p['why'] : array() );
	veahealth_part_compare( isset( $p['compare'] ) ? $p['compare'] : array() );
	veahealth_part_procedure( isset( $p['procedure'] ) ? $p['procedure'] : array() );
	veahealth_part_cost( isset( $p['cost'] ) ? $p['cost'] : array() );
	veahealth_part_recovery( isset( $p['recovery'] ) ? $p['recovery'] : array() );
	veahealth_part_evidence( isset( $p['evidence'] ) ? $p['evidence'] : array() );
	veahealth_part_faq( isset( $p['faq'] ) ? $p['faq'] : array() );
	veahealth_part_note( isset( $p['review_note'] ) ? $p['review_note'] : '', 'plain' );
	return trim( ob_get_clean() );
}

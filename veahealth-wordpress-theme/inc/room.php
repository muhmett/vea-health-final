<?php
/**
 * The treatment room.
 *
 * An immersive layer that opens over a treatment page: a lit space you can move
 * around, with the treatment's own object at the centre and notes pinned in the
 * air beside it. Click a note and it opens with something real about the
 * material, the technique, the evidence or the price.
 *
 * Three decisions worth recording, because they are the ones that make this
 * appropriate for a medical site rather than a fashion campaign:
 *
 * 1. It is a LAYER, not a route. The treatment page underneath keeps its URL,
 *    its 1,500 words and its structured data. Search engines see the page;
 *    the room is something a visitor opens on purpose. An immersive experience
 *    that replaces the page would cost the rankings the page exists to win.
 *
 * 2. It is CLEARLY A DIAGRAM, not a photograph. The space is drawn — lit
 *    volume, depth, the treatment's own render floating in it. It never
 *    pretends to be a photograph of the partner clinic, because a visitor who
 *    flies to Istanbul on the strength of a room that does not exist has been
 *    misled, and that is not a risk worth a nice transition.
 *
 * 3. There is NO GAME. No counter, no "three left to find", no reward. The
 *    reference this is modelled on is selling handbags and can afford to make
 *    the visitor play; somebody deciding whether to have their jaw operated on
 *    abroad cannot. Every note is information, and you can leave at any point.
 *
 * The notes are not written separately — they are drawn from the structured
 * treatment data, so a room can never drift out of step with its page.
 *
 * @package VeaHealth
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The notes for a treatment's room.
 *
 * Each note is pinned at a normalised coordinate — x and y from 0 to 1 across
 * the scene, plus a depth so it parallaxes with the layer it belongs to. The
 * layout is deliberately fixed rather than random: a visitor who opens two
 * treatments in a row should find the material note in the same place both
 * times.
 *
 * @param string $slug Treatment slug.
 * @return array
 */
function veahealth_room_notes( $slug ) {
	$p = function_exists( 'veahealth_service_parts' ) ? veahealth_service_parts( $slug ) : array();
	if ( ! $p ) {
		return array();
	}
	$notes = array();

	// ---- the material, taken from the winning column of the comparison ----
	if ( ! empty( $p['compare']['rows'] ) && ! empty( $p['compare']['head'][1] ) ) {
		$facts = array();
		foreach ( $p['compare']['rows'] as $row ) {
			if ( empty( $row['values'][0]['v'] ) || empty( $row['label'] ) ) {
				continue;
			}
			$facts[] = array( 'k' => $row['label'], 'v' => $row['values'][0]['v'] );
			if ( count( $facts ) >= 5 ) {
				break;
			}
		}
		if ( $facts ) {
			$notes[] = array(
				'id'    => 'material',
				'icon'  => 'shield',
				'kicker'=> __( 'The material', 'veahealth' ),
				'title' => $p['compare']['head'][1],
				'facts' => $facts,
				'x'     => 0.735, 'y' => 0.325, 'depth' => 0.55,
			);
		}
	}

	// ---- the technique: the step that is the actual intervention ----
	if ( ! empty( $p['procedure']['steps'] ) ) {
		$steps = $p['procedure']['steps'];
		// Skip the consultation and the handover; the middle of the list is
		// where the treatment itself happens.
		$i    = min( count( $steps ) - 1, max( 1, (int) floor( count( $steps ) / 2 ) ) );
		$step = $steps[ $i ];
		$notes[] = array(
			'id'     => 'technique',
			'icon'   => 'compare',
			'kicker' => __( 'The technique', 'veahealth' ),
			'title'  => $step['title'],
			'text'   => $step['text'],
			'points' => array_slice( isset( $step['points'] ) ? $step['points'] : array(), 0, 4 ),
			'x'      => 0.255, 'y' => 0.44, 'depth' => 0.8,
		);
	}

	// ---- what it costs ----
	if ( ! empty( $p['cost']['tiers'] ) ) {
		$tiers = $p['cost']['tiers'];
		$vals  = array_map( 'veahealth_price_value', wp_list_pluck( $tiers, 'price' ) );
		$ours  = null;
		foreach ( $tiers as $n => $t ) {
			if ( $vals[ $n ] > 0 && ( null === $ours || $vals[ $n ] < $vals[ $ours ] ) ) {
				$ours = $n;
			}
		}
		if ( null !== $ours ) {
			$max = max( $vals );
			$notes[] = array(
				'id'     => 'cost',
				'icon'   => 'tag',
				'kicker' => __( 'What it costs', 'veahealth' ),
				'title'  => $tiers[ $ours ]['price'] . ' · ' . $tiers[ $ours ]['where'],
				'text'   => $max > 0 && $vals[ $ours ] > 0
					? sprintf(
						/* translators: 1: percentage, 2: the highest quoted figure */
						__( 'Around %1$d%% less than the highest figure quoted for the same work, which was %2$s. Your own price is fixed in writing after a dentist has seen your photographs.', 'veahealth' ),
						(int) round( ( 1 - ( $vals[ $ours ] / $max ) ) * 100 ),
						$tiers[ array_search( $max, $vals, true ) ]['price']
					)
					: __( 'Your price is fixed in writing after assessment.', 'veahealth' ),
				'x'      => 0.185, 'y' => 0.7, 'depth' => 0.35,
			);
		}
	}

	// ---- the evidence, only where there is a real citation ----
	if ( ! empty( $p['evidence']['items'][0]['source'] ) ) {
		$e = $p['evidence']['items'][0];
		$notes[] = array(
			'id'     => 'evidence',
			'icon'   => 'check',
			'kicker' => __( 'The evidence', 'veahealth' ),
			'title'  => $e['figure'],
			'text'   => $e['text'],
			'source' => $e['source'],
			'x'      => 0.815, 'y' => 0.665, 'depth' => 0.42,
		);
	}

	// ---- what the first days are like ----
	if ( ! empty( $p['recovery']['phases'][0] ) ) {
		$ph = $p['recovery']['phases'][0];
		$notes[] = array(
			'id'     => 'recovery',
			'icon'   => 'clock',
			'kicker' => __( 'Afterwards', 'veahealth' ),
			'title'  => $ph['title'],
			'text'   => $ph['text'],
			'points' => array_slice( isset( $ph['points'] ) ? $ph['points'] : array(), 0, 4 ),
			'x'      => 0.5, 'y' => 0.815, 'depth' => 0.22,
		);
	}

	/*
	 * The two below exist for the treatments that have no comparison table and
	 * no published price list — the hair pages. Without them those rooms had
	 * two notes in them, which is a corridor rather than a room.
	 */
	if ( ! empty( $p['why']['cards'][0] ) ) {
		$w = $p['why']['cards'][0];
		$notes[] = array(
			'id'     => 'why',
			'icon'   => 'compare',
			'kicker' => __( 'Why this one', 'veahealth' ),
			'title'  => $w['title'],
			'text'   => $w['text'],
			'x'      => 0.30, 'y' => 0.195, 'depth' => 0.62,
		);
	}

	if ( ! empty( $p['faq']['items'][0]['q'] ) ) {
		$q = $p['faq']['items'][0];
		$notes[] = array(
			'id'     => 'question',
			'icon'   => 'check',
			'kicker' => __( 'People ask', 'veahealth' ),
			'title'  => $q['q'],
			'text'   => $q['a'],
			'x'      => 0.705, 'y' => 0.875, 'depth' => 0.30,
		);
	}

	/*
	 * Five is the ceiling. Every note is worth reading, but a room with seven
	 * pins in it stops being a space you look around and becomes a menu with a
	 * background — and the ones at the edges start colliding with the exit.
	 * The order above is the priority order: the material and the technique win
	 * a place before the FAQ does.
	 */
	return array_slice( $notes, 0, 5 );
}

/** Does this treatment have enough behind it to be worth a room? */
function veahealth_has_room( $post_id ) {
	$slug = get_post_field( 'post_name', $post_id );
	return count( veahealth_room_notes( $slug ) ) >= 3;
}

/**
 * The room itself.
 *
 * Server-rendered in full: every note's text is in the HTML before any script
 * runs, and the notes are <button>s in document order rather than positioned
 * divs with no semantics.
 *
 * That buys two things, and it is worth being precise about which. If WebGL
 * never starts, the room still opens and still reads — it is simply a dark
 * panel rather than a lit one. And under reduced motion the stylesheet lays
 * the same markup out as a plain scrollable list of notes, with nothing
 * animating and nothing to look around.
 *
 * It does not make the room work without JavaScript: it cannot be opened at
 * all then, which is why the button that opens it is hidden in that case. The
 * treatment page underneath is the no-script experience, and it is complete.
 */
function veahealth_room( $post_id ) {
	$slug  = get_post_field( 'post_name', $post_id );
	$notes = veahealth_room_notes( $slug );
	if ( count( $notes ) < 3 ) {
		return;
	}
	$art   = veahealth_service_image( $post_id, 'full' );
	$title = get_the_title( $post_id );
	// The object is what the room is about, so it describes itself rather than
	// being marked decorative. The theme already stores this alongside the art.
	$alt   = get_post_meta( $post_id, '_vh_alt', true );
	if ( ! $alt ) {
		$alt = sprintf( __( '%s, illustrated', 'veahealth' ), $title );
	}
	$group = wp_get_post_terms( $post_id, 'service_category', array( 'fields' => 'names' ) );
	?>
	<div class="room" id="room" data-room hidden
	     aria-label="<?php echo esc_attr( sprintf( __( '%s — explore the treatment', 'veahealth' ), $title ) ); ?>">

		<div class="room__stage" data-room-stage>
			<?php
			/*
			 * The object the room is built around. The canvas draws over it once
			 * WebGL is up; until then, and forever if it never comes up, this is
			 * what is on screen.
			 */
			?>
			<img class="room__object" src="<?php echo esc_url( $art ); ?>"
			     alt="<?php echo esc_attr( $alt ); ?>" data-room-art
			     width="1400" height="910" decoding="async">
		</div>

		<header class="room__head">
			<p class="room__kicker"><?php echo esc_html( $group ? $group[0] : __( 'Treatment', 'veahealth' ) ); ?></p>
			<h2 class="room__title"><?php echo esc_html( $title ); ?></h2>
			<p class="room__hint" data-room-hint><?php esc_html_e( 'Move to look around · open a note to read it', 'veahealth' ); ?></p>
		</header>

		<ul class="room__notes" data-room-notes>
			<?php foreach ( $notes as $i => $n ) : ?>
				<li class="room-note"
				    style="--x:<?php echo esc_attr( $n['x'] ); ?>;--y:<?php echo esc_attr( $n['y'] ); ?>;--depth:<?php echo esc_attr( $n['depth'] ); ?>"
				    data-note="<?php echo esc_attr( $n['id'] ); ?>">
					<button class="room-note__pin" type="button"
					        aria-expanded="false" aria-controls="note-<?php echo esc_attr( $n['id'] ); ?>">
						<span class="room-note__blob" aria-hidden="true"></span>
						<span class="room-note__icon" aria-hidden="true"><?php echo veahealth_icon( $n['icon'] ); ?></span>
						<span class="screen-reader-text">
							<?php echo esc_html( sprintf( __( 'Open note: %s', 'veahealth' ), $n['kicker'] ) ); ?>
						</span>
						<span class="room-note__label" aria-hidden="true"><?php echo esc_html( $n['kicker'] ); ?></span>
					</button>

					<div class="room-note__card" id="note-<?php echo esc_attr( $n['id'] ); ?>">
						<p class="room-note__kicker"><?php echo esc_html( $n['kicker'] ); ?></p>
						<h3><?php echo esc_html( $n['title'] ); ?></h3>

						<?php if ( ! empty( $n['facts'] ) ) : ?>
							<dl class="room-note__facts">
								<?php foreach ( $n['facts'] as $f ) : ?>
									<div>
										<dt><?php echo esc_html( $f['k'] ); ?></dt>
										<dd><?php echo esc_html( $f['v'] ); ?></dd>
									</div>
								<?php endforeach; ?>
							</dl>
						<?php endif; ?>

						<?php if ( ! empty( $n['text'] ) ) : ?>
							<p><?php echo esc_html( $n['text'] ); ?></p>
						<?php endif; ?>

						<?php if ( ! empty( $n['points'] ) ) : ?>
							<ul class="checklist">
								<?php foreach ( $n['points'] as $pt ) : ?>
									<li><?php echo veahealth_icon( 'check' ); ?> <?php echo esc_html( $pt ); ?></li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>

						<?php if ( ! empty( $n['source'] ) ) : ?>
							<p class="room-note__source"><?php echo esc_html( $n['source'] ); ?></p>
						<?php endif; ?>

						<button class="room-note__close" type="button" data-room-note-close>
							<?php esc_html_e( 'Close', 'veahealth' ); ?>
						</button>
					</div>
				</li>
			<?php endforeach; ?>
		</ul>

		<div class="room__bar">
			<button class="room__exit" type="button" data-room-exit>
				<span aria-hidden="true">&larr;</span> <?php esc_html_e( 'Back to the page', 'veahealth' ); ?>
			</button>
			<a class="btn btn--primary" href="<?php echo esc_url( veahealth_contact_url() ); ?>">
				<?php esc_html_e( 'Get a written quote', 'veahealth' ); ?>
			</a>
		</div>

		<p class="room__disclaimer">
			<?php esc_html_e( 'An illustration of the treatment, not a photograph of the clinic. Book a live video tour with your coordinator to see the real rooms.', 'veahealth' ); ?>
		</p>
	</div>
	<?php
}

/** The button on the treatment page that opens the room. */
function veahealth_room_button( $post_id ) {
	if ( ! veahealth_has_room( $post_id ) ) {
		return;
	}
	?>
	<button class="room-open" type="button" data-room-open aria-controls="room" aria-expanded="false">
		<span class="room-open__ring" aria-hidden="true"></span>
		<span class="room-open__text">
			<span class="room-open__k"><?php esc_html_e( 'Explore', 'veahealth' ); ?></span>
			<span class="room-open__v"><?php esc_html_e( 'Enter the treatment', 'veahealth' ); ?></span>
		</span>
	</button>
	<?php
}

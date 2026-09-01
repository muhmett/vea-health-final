<?php
/**
 * Structured treatment content.
 *
 * Every treatment page on the old site had been pasted in as a complete HTML
 * document, which is why the site was serving duplicate titles, duplicate
 * canonicals and 384 KB of page-specific CSS. The copy was worth keeping; the
 * markup was not. This holds the same words as structure, and the theme renders
 * it through its own components — so the pages match the site, stay editable,
 * and can carry behaviour the pasted markup could not.
 *
 * Generated. To change the copy, edit the treatment in the admin: the installer
 * writes this out as ordinary editable content and never reads it back.
 *
 * @package VeaHealth
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The structured body of every treatment, keyed by slug.
 *
 * @return array<string,array>
 */
function veahealth_service_data() {
	static $data = null;
	if ( null !== $data ) {
		return $data;
	}
	$rows = array(
		array(
			'slug' => 'immediate-dental-implants',
			'title' => 'Immediate Dental Implants',
			'h1' => 'Immediate Dental Implants Extraction + Implant · One Appointment',
			'lead' => '',
			'trust' => array(),
			'price' => '',
			'price_note' => '',
			'stats' => array(),
			'image' => 'dental-implant-zirconia-crown-macro.webp',
			'caveat' => '',
			'review_note' => '',
			'why' => array(
				'label' => 'Advantages',
				'title' => 'Key Benefits of Immediate Placement',
				'intro' => '',
				'cards' => array(
					array(
						'title' => 'Dramatically Shorter Timeline',
						'text' => 'Total treatment compressed from 9–14 months to 5–7 months — saving 3–7 months for eligible patients, with one fewer surgical appointment and anaesthesia session.',
					),
					array(
						'title' => 'Bone Volume Preserved',
						'text' => 'Immediate placement interrupts the rapid alveolar resorption that begins within weeks of extraction — protecting the bone volume and gum contour that define long-term aesthetic and functional outcomes.',
					),
					array(
						'title' => 'Same-Day Provisional Tooth',
						'text' => 'When primary stability is confirmed, a provisional crown is placed the same day — no gap in the smile during osseointegration, maintaining aesthetics and confidence throughout healing.',
					),
					array(
						'title' => 'Superior Gum Contour',
						'text' => 'The provisional crown in the fresh socket guides soft tissue healing into a natural gum profile, producing significantly better papilla preservation vs delayed protocol.',
					),
					array(
						'title' => 'Fewer Surgical Appointments',
						'text' => 'Combining extraction and implant into one appointment eliminates the second surgical procedure — reducing total anaesthesia exposure, healing periods, and time away from home.',
					),
					array(
						'title' => 'Reduced Overall Cost',
						'text' => 'Fewer appointments and stages typically reduce total cost vs two-stage protocol — especially significant through VeaHealth’s Istanbul pricing at 60–70% below UK/US market rates.',
					),
				),
			),
			'compare' => array(
				'label' => 'Full Comparison',
				'title' => 'Immediate vs All Alternatives',
				'intro' => 'A complete clinical and practical comparison across all relevant tooth replacement protocols.',
				'head' => array(
					'Criteria',
					'Immediate Implant ✦',
					'Conventional Implant',
					'Dental Bridge',
					'Removable Partial',
				),
				'rows' => array(
					array(
						'label' => 'Total treatment time',
						'values' => array(
							array(
								'v' => '5–7 months',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '9–14 months',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '3–6 weeks',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '2–4 weeks',
								'good' => false,
								'bad' => false,
							),
						),
					),
					array(
						'label' => 'Surgical appointments',
						'values' => array(
							array(
								'v' => '1 (extraction + implant)',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '2–3 minimum',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '1–2',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '1',
								'good' => false,
								'bad' => false,
							),
						),
					),
					array(
						'label' => 'Same-day provisional tooth',
						'values' => array(
							array(
								'v' => 'Yes (if stable)',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'No',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'Yes',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'Yes',
								'good' => false,
								'bad' => false,
							),
						),
					),
					array(
						'label' => 'Bone preservation',
						'values' => array(
							array(
								'v' => 'Excellent',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'Good',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'None',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'None',
								'good' => false,
								'bad' => false,
							),
						),
					),
					array(
						'label' => 'Adjacent teeth affected',
						'values' => array(
							array(
								'v' => 'None',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'None',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'Ground down',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'Clasps on adjacent',
								'good' => false,
								'bad' => false,
							),
						),
					),
					array(
						'label' => 'Gum contour outcome',
						'values' => array(
							array(
								'v' => 'Superior',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'Good',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'Good',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'Poor',
								'good' => false,
								'bad' => false,
							),
						),
					),
					array(
						'label' => '10-year survival rate',
						'values' => array(
							array(
								'v' => '90–96%',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '94–98%',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '80–90%',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'Variable',
								'good' => false,
								'bad' => false,
							),
						),
					),
					array(
						'label' => 'VeaHealth Istanbul cost',
						'values' => array(
							array(
								'v' => '€500 – €900',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '€450 – €800',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '€600 – €1,200',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '€300 – €700',
								'good' => false,
								'bad' => false,
							),
						),
					),
				),
			),
			'procedure' => array(
				'label' => 'Step by Step',
				'title' => 'The Immediate Implant Procedure',
				'intro' => 'From your CBCT scan in Istanbul to your final crown — every stage explained with complete transparency by VeaHealth.',
				'steps' => array(
					array(
						'tag' => 'Day 1 — Istanbul',
						'title' => 'Consultation & CBCT 3D Assessment',
						'text' => 'Full clinical examination with CBCT cone beam 3D imaging maps the extraction socket — assessing bone height, width, cortical wall integrity, and proximity to critical anatomy. The scan screens for periapical infection or bone pathology that would contraindicate immediate placement. Your VeaHealth coordinator attends throughout. This scan determines eligibility before any surgery is planned.',
						'points' => array(),
					),
					array(
						'tag' => 'Day 1–2 · Planning',
						'title' => 'Digital Planning & Protocol Decision',
						'text' => 'If CBCT confirms adequate bone, intact socket walls, and no acute infection, immediate placement is confirmed and the implant dimensions are selected virtually. If eligibility criteria are not met, VeaHealth’s team presents the conventional protocol with full transparency — before any surgery proceeds. No patient travels for a procedure they are not suited for.',
						'points' => array(),
					),
					array(
						'tag' => 'Day 2–3 · Surgery',
						'title' => 'Atraumatic Extraction',
						'text' => 'The tooth is removed using atraumatic techniques — periotomes, luxators, and micro-surgical instruments — designed to preserve the socket walls and minimise bone trauma. Avoiding damage to the buccal plate is critical for long-term aesthetics. No traumatic force is applied that could fracture the socket architecture required to support the immediate implant.',
						'points' => array(),
					),
					array(
						'tag' => 'Same Appointment · Core Step',
						'title' => 'Immediate Implant Placement & Socket Graft',
						'text' => 'The titanium implant — Straumann or Nobel Biocare — is placed directly into the fresh socket. It is positioned slightly palatally and apically to engage solid native bone beyond the socket tip for primary stability. The gap between the implant and socket walls is filled with bone graft material to support new bone formation and prevent soft tissue ingrowth. Primary stability is measured — it must exceed the minimum threshold (ISQ ≥ 60) before the provisional crown is placed.',
						'points' => array(),
					),
					array(
						'tag' => 'Same Day',
						'title' => 'Provisional Crown Placement',
						'text' => 'When primary stability is confirmed (ISQ ≥ 65), a provisional crown is placed the same day — immediate provisionalization. The provisional is designed out of occlusion (no contact with opposing teeth during biting) to protect the healing implant. You leave Istanbul with a complete tooth. Where stability is marginal, a healing cap is used and the provisional fitted at a follow-up visit.',
						'points' => array(),
					),
					array(
						'tag' => 'Months 3–6 · Remote Phase',
						'title' => 'Osseointegration & VeaHealth Monitoring',
						'text' => 'Bone fuses to the implant surface over 3–6 months. VeaHealth’s remote aftercare programme provides structured digital check-ins, photo assessments, and coordinator access throughout — no travel required during this phase. Because the implant sits in a fresh socket, surrounding bone remodels around it, producing excellent long-term integration when primary stability was confirmed.',
						'points' => array(),
					),
					array(
						'tag' => 'Return Visit · Final Crown',
						'title' => 'Definitive Crown Placement',
						'text' => 'Once osseointegration is confirmed, you return to Istanbul for your final zirconia or ceramic crown — CAD/CAM milled, shade-matched, and precision-fitted to your dentition. The permanent crown is placed at full occlusion. Warranty documentation is issued. VeaHealth confirms ongoing remote support for continued aftercare.',
						'points' => array(),
					),
				),
			),
			'cost' => array(
				'label' => '',
				'title' => '',
				'intro' => '',
				'tiers' => array(
					array(
						'where' => 'Turkey — Istanbul',
						'price' => '€500',
						'note' => 'Straumann & Nobel Biocare guaranteed. Socket graft included. CAD/CAM zirconia crown. VeaHealth full coordination & international warranty.',
						'features' => array(),
					),
					array(
						'where' => 'India',
						'price' => '€550',
						'note' => 'Competitive pricing and growing expertise. Clinic accreditation and brand verification essential before booking.',
						'features' => array(),
					),
					array(
						'where' => 'Mexico',
						'price' => '€800',
						'note' => 'Popular hub for North American patients. Quality of immediate protocol experience varies across clinics.',
						'features' => array(),
					),
					array(
						'where' => 'United Kingdom',
						'price' => '€2,200',
						'note' => 'Private market only. NHS does not cover implants. Immediate protocol available at specialist implant centres.',
						'features' => array(),
					),
					array(
						'where' => 'United States',
						'price' => '€3,200',
						'note' => 'Wide state-by-state variation. Immediate protocol increasingly standard at specialist oral surgery practices.',
						'features' => array(),
					),
					array(
						'where' => 'Australia',
						'price' => '€2,500',
						'note' => 'High private dentistry costs. Some health fund contribution may apply to crown or extraction components only.',
						'features' => array(),
					),
				),
			),
			'recovery' => array(
				'label' => 'Healing Phases',
				'title' => 'Recovery Timeline',
				'intro' => 'From the hours after surgery through to your definitive crown — what to expect at each stage of immediate implant healing.',
				'phases' => array(
					array(
						'n' => '1',
						'title' => 'Immediate Phase',
						'text' => '',
						'points' => array(
							'Cold compress + rest',
							'Antibiotics prescribed',
							'Liquids and soft foods only',
							'No rinsing first 24 hours',
							'Provisional crown in place',
						),
					),
					array(
						'n' => '2',
						'title' => 'Socket Closure',
						'text' => '',
						'points' => array(
							'Gum closes over socket',
							'Stitches removed/dissolve',
							'Gentle brushing begins',
							'Saltwater rinses daily',
							'VeaHealth digital check-in',
						),
					),
					array(
						'n' => '3',
						'title' => 'Osseointegration',
						'text' => '',
						'points' => array(
							'Bone fusing to implant',
							'Zero load on provisional',
							'No smoking — critical phase',
							'Remote monitoring active',
							'Photo check-ins to VeaHealth',
						),
					),
					array(
						'n' => '4',
						'title' => 'Final Crown',
						'text' => '',
						'points' => array(
							'Integration confirmed',
							'Return to Istanbul',
							'Definitive crown placed',
							'Full occlusion restored',
							'Warranty documentation issued',
						),
					),
				),
			),
			'evidence' => array(
				'label' => 'Clinical Evidence',
				'title' => 'What the Research Shows',
				'intro' => '',
				'items' => array(
					array(
						'figure' => '90–96%',
						'text' => 'Implant survival at 5–10 years for immediate placement in selected cases — no statistically significant difference from conventional delayed protocol outcomes in published meta-analysis.',
						'source' => 'Chen & Buser (2009) · Slagter et al. (2014) · ITI Consensus Statements',
					),
					array(
						'figure' => '↓60%',
						'text' => 'Reduction in total treatment time compared to conventional two-stage implant protocol — from 9–14 months to 5–7 months in eligible patients receiving immediate placement.',
						'source' => 'Immediate vs delayed placement clinical protocol studies',
					),
					array(
						'figure' => 'Superior',
						'text' => 'Soft tissue and gingival contour outcomes. Immediate provisionalization achieves significantly better papilla preservation and natural gum emergence profile vs delayed placement.',
						'source' => 'Cosyn et al. (2016) · International Journal of Oral & Maxillofacial Implants',
					),
				),
			),
			'faq' => array(
				'label' => 'Patient Questions',
				'title' => 'Frequently Asked Questions',
				'intro' => '',
				'items' => array(
					array(
						'q' => 'What exactly is an immediate dental implant?',
						'a' => 'An immediate dental implant is placed directly into the socket left by the extracted tooth in the same surgical appointment — combining extraction and implant placement into a single procedure. This contrasts with conventional (delayed) placement, where the socket heals for 4–8 weeks before the implant is placed in a separate surgery.',
					),
					array(
						'q' => 'Am I eligible for an immediate implant?',
						'a' => 'Eligibility requires: no acute infection at the extraction site, intact or near-intact socket walls, sufficient bone beyond the socket apex for primary stability, and confirmation of adequate primary stability (ISQ ≥ 60–65) at placement. VeaHealth evaluates eligibility from your CBCT scan before you travel — so you know whether immediate placement is viable before booking.',
					),
					array(
						'q' => 'Will I have a tooth the same day?',
						'a' => 'In most cases, yes. When primary stability is sufficient (ISQ ≥ 65), a provisional crown is attached the same day as the implant placement — immediate provisionalization. The provisional is designed out of occlusion to protect the healing implant. Where stability is marginal, a healing cap is used and the provisional fitted at a later visit.',
					),
					array(
						'q' => 'What is the success rate vs conventional implants?',
						'a' => 'Meta-analyses confirm no statistically significant difference in implant survival between immediate and delayed protocols in properly selected cases. Immediate placement achieves 90–96% survival at 5–10 years, comparable to conventional rates of 94–98%. The key is rigorous pre-operative patient selection — which VeaHealth conducts before any patient travels.',
					),
					array(
						'q' => 'How many trips to Istanbul are required?',
						'a' => 'Typically two trips: the first visit (2–4 days) for the CBCT assessment, extraction, immediate implant placement, and provisional crown; the return visit (1–2 days) after osseointegration for the definitive zirconia crown. The entire healing phase — 3–6 months — is managed remotely by VeaHealth with no travel required in between.',
					),
					array(
						'q' => 'Does immediate placement require a bone graft?',
						'a' => 'Almost always, yes — but a limited socket-fill graft. The gap between the implant surface and the socket walls must be filled with graft material to support bone formation and prevent soft tissue ingrowth. This is performed in the same appointment. It is far less extensive than a full bone augmentation procedure.',
					),
					array(
						'q' => 'Can smokers receive an immediate implant?',
						'a' => 'Smoking significantly increases failure risk in immediate implants — more so than in conventional protocol — because nicotine impairs vascular healing in the fresh socket environment. VeaHealth strongly advises cessation for a minimum of 6 weeks before and 8 weeks after surgery. This is the single most impactful modifiable risk factor.',
					),
					array(
						'q' => 'What implant brands does VeaHealth use?',
						'a' => 'VeaHealth contractually guarantees Straumann and Nobel Biocare implants — both with surface technologies specifically validated for immediate placement protocols (SLActive and TiUnite respectively). Brand, model, and batch number are confirmed in writing at placement and included in your international warranty documentation.',
					),
				),
			),
		),
		array(
			'slug' => 'single-dental-implants',
			'title' => 'Single Dental Implants',
			'h1' => 'Replace One Missing Tooth with a Single Dental Implant',
			'lead' => 'Permanent tooth replacement in Istanbul with premium titanium implants and natural zirconia crowns. Straumann & Nobel Biocare brands. 95%+ success rate. VeaHealth coordinates your complete dental tourism journey with verified clinics and expert aftercare.',
			'trust' => array(
				'Straumann & Nobel Biocare implants',
				'3D-guided placement surgery',
				'Natural zirconia crown',
				'Lifetime warranty included',
			),
			'price' => '£650',
			'price_note' => 'All-inclusive single implant package — implant placement, healing abutment, final crown, and lifetime warranty on the titanium fixture.',
			'stats' => array(
				array(
					'v' => '70%',
					'k' => 'vs UK Cost',
				),
				array(
					'v' => '95%+',
					'k' => 'Success Rate',
				),
			),
			'image' => 'jawbone-implant-3d-render.webp',
			'caveat' => '',
			'review_note' => '',
			'why' => array(
				'label' => 'Clinical Advantages',
				'title' => 'Why Single Dental Implants Are the Gold Standard',
				'intro' => 'A single dental implant is the only tooth replacement that preserves bone, protects adjacent teeth, and delivers lifetime functionality with proper care.',
				'cards' => array(
					array(
						'title' => 'Preserves Adjacent Teeth',
						'text' => 'Unlike dental bridges, implants require no grinding down of neighboring healthy teeth. Your natural teeth remain untouched and structurally intact — preventing future complications and preserving long-term oral health.',
					),
					array(
						'title' => 'Prevents Bone Loss',
						'text' => 'The titanium post integrates with your jawbone through osseointegration — stimulating natural bone maintenance just like a tooth root. This prevents the bone resorption and facial collapse that occurs with bridges or dentures.',
					),
					array(
						'title' => 'Natural Appearance',
						'text' => 'Custom zirconia crowns are shade-matched to your natural teeth and emerge naturally from the gumline — no visible metal margins, no artificial-looking bulk. Indistinguishable from your real teeth in photos and conversation.',
					),
					array(
						'title' => 'Full Chewing Function',
						'text' => 'Bite force is restored to 95–100% of natural teeth. You can eat steak, apples, nuts, and corn on the cob without restriction. No dietary limitations like with bridges or partial dentures.',
					),
					array(
						'title' => 'Proven Longevity',
						'text' => 'Clinical studies confirm 95–98% survival rates at 10 years. With proper hygiene and regular check-ups, single implants routinely last 20–30+ years. The titanium fixture can last a lifetime — only the crown may eventually need replacement.',
					),
					array(
						'title' => 'Easy Maintenance',
						'text' => 'Brush and floss normally — no special cleaning protocols, no removal, no adhesives. Biannual professional cleanings and annual X-rays are the only maintenance required. Simpler than caring for a bridge.',
					),
				),
			),
			'compare' => array(
				'label' => 'Treatment Comparison',
				'title' => 'Single Implant vs. Other Solutions',
				'intro' => '',
				'head' => array(
					'Feature',
					'Single Dental Implant',
					'Dental Bridge',
					'Removable Partial',
					'Do Nothing',
				),
				'rows' => array(
					array(
						'label' => 'Preserves Adjacent Teeth',
						'values' => array(
							array(
								'v' => 'Yes',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Requires grinding',
								'good' => false,
								'bad' => true,
							),
							array(
								'v' => 'Minimal contact',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'N/A',
								'good' => false,
								'bad' => true,
							),
						),
					),
					array(
						'label' => 'Prevents Bone Loss',
						'values' => array(
							array(
								'v' => 'Yes (stimulates bone)',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'No (bone resorbs)',
								'good' => false,
								'bad' => true,
							),
							array(
								'v' => 'No (bone resorbs)',
								'good' => false,
								'bad' => true,
							),
							array(
								'v' => 'Severe bone loss',
								'good' => false,
								'bad' => true,
							),
						),
					),
					array(
						'label' => 'Fixed in Place',
						'values' => array(
							array(
								'v' => 'Permanent',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Permanent',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Removable',
								'good' => false,
								'bad' => true,
							),
							array(
								'v' => 'N/A',
								'good' => false,
								'bad' => true,
							),
						),
					),
					array(
						'label' => 'Chewing Power',
						'values' => array(
							array(
								'v' => '95–100% natural',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => '80–90% natural',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '50–70% natural',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'Loss of function',
								'good' => false,
								'bad' => true,
							),
						),
					),
					array(
						'label' => 'Average Lifespan',
						'values' => array(
							array(
								'v' => '20–30+ years',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => '10–15 years',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '5–8 years',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'Teeth shift',
								'good' => false,
								'bad' => true,
							),
						),
					),
					array(
						'label' => 'Maintenance',
						'values' => array(
							array(
								'v' => 'Brush & floss daily',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Floss threader required',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'Daily removal & cleaning',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'Adjacent teeth drift',
								'good' => false,
								'bad' => true,
							),
						),
					),
					array(
						'label' => 'Natural Appearance',
						'values' => array(
							array(
								'v' => 'Excellent',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Good (metal visible)',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'Fair (clasp visible)',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'Gap visible',
								'good' => false,
								'bad' => true,
							),
						),
					),
					array(
						'label' => 'Istanbul Cost',
						'values' => array(
							array(
								'v' => '£650',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => '£800 (3 units)',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '£400',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'Free (poor outcome)',
								'good' => false,
								'bad' => true,
							),
						),
					),
				),
			),
			'procedure' => array(
				'label' => 'Treatment Journey',
				'title' => 'Your Single Implant Procedure',
				'intro' => 'From consultation to final crown — the entire process typically requires two visits to Istanbul over 4–6 months.',
				'steps' => array(
					array(
						'tag' => 'Pre-Arrival',
						'title' => 'Digital Assessment',
						'text' => 'Before you travel, VeaHealth coordinates a comprehensive evaluation — panoramic X-rays, CBCT scan, and treatment planning. Your surgeon confirms implant placement feasibility and identifies any bone grafting needs.',
						'points' => array(
							'Medical history review via video',
							'Digital X-rays & 3D CBCT scan',
							'Bone volume assessment',
							'Treatment plan & quote confirmed',
							'Travel arrangements coordinated',
						),
					),
					array(
						'tag' => 'Day 1–2 — Istanbul',
						'title' => 'Implant Placement',
						'text' => 'Under local anesthesia, the titanium implant is placed into your jawbone. If the tooth is still present, it’s extracted first. A healing abutment or temporary crown is placed immediately to protect the surgical site.',
						'points' => array(
							'Local anesthesia (painless procedure)',
							'Tooth extraction if needed',
							'Implant fixture placed',
							'Healing cap or temporary crown attached',
							'Post-op instructions & medications',
						),
					),
					array(
						'tag' => 'Month 1–4',
						'title' => 'Osseointegration',
						'text' => 'The implant fuses with your jawbone over 3–6 months. You return home during this phase and maintain the site with normal brushing and flossing. VeaHealth monitors your healing remotely with photos and video check-ins.',
						'points' => array(
							'Bone integration progresses naturally',
							'Temporary crown worn (if placed)',
							'Normal diet resumed gradually',
							'Remote monitoring every 2 weeks',
							'No travel required during healing',
						),
					),
					array(
						'tag' => 'Month 4–6 — Return Visit',
						'title' => 'Final Crown Placement',
						'text' => 'You return to Istanbul for 2–3 days. The healing cap is removed, digital impressions are taken, and your final zirconia crown is fabricated. Once shade and bite are perfect, it’s permanently attached to the implant.',
						'points' => array(
							'Healing verification',
							'Digital impression scan',
							'Custom crown fabrication (1–2 days)',
							'Try-in with bite adjustment',
							'Permanent crown cementation or screw-retention',
						),
					),
				),
			),
			'cost' => array(
				'label' => 'Transparent Pricing',
				'title' => 'What You’ll Pay — Guaranteed',
				'intro' => 'VeaHealth locks in your price before travel. All costs include implant placement, healing abutment, final crown, and lifetime warranty on the titanium fixture.',
				'tiers' => array(
					array(
						'where' => 'UK / US',
						'price' => '£2,000+',
						'note' => 'per implant',
						'features' => array(
							'Standard implant brands',
							'Implant placement surgery',
							'Healing abutment',
							'Porcelain or zirconia crown',
							'5-year warranty',
							'No travel support',
						),
					),
					array(
						'where' => 'VeaHealth Istanbul',
						'price' => '£650',
						'note' => 'all-inclusive',
						'features' => array(
							'Straumann or Nobel Biocare implant',
							'3D-guided placement surgery',
							'Healing abutment included',
							'Premium zirconia crown',
							'Lifetime warranty on implant',
							'3-year warranty on crown',
							'Airport VIP transfers',
							'Hotel coordination support',
							'24/7 VeaHealth concierge',
						),
					),
					array(
						'where' => 'Europe',
						'price' => '€1,200+',
						'note' => 'per implant',
						'features' => array(
							'Mid-range implants',
							'Standard placement protocol',
							'Healing abutment',
							'Ceramic crown',
							'2-year warranty',
							'Limited travel assistance',
						),
					),
				),
			),
			'recovery' => array(
				'label' => 'Post-Treatment',
				'title' => 'Recovery & Aftercare',
				'intro' => 'Single implant recovery is predictable and straightforward. Most patients return to normal activities within 3–5 days and experience minimal complications.',
				'phases' => array(
					array(
						'n' => '1',
						'title' => 'Immediate Post-Op',
						'text' => '',
						'points' => array(
							'Mild soreness & swelling normal',
							'Cold compress reduces swelling',
							'Soft diet only (no chewing on implant)',
							'Prescribed pain medication',
							'Gentle salt water rinses',
						),
					),
					array(
						'n' => '2',
						'title' => 'Osseointegration Begins',
						'text' => '',
						'points' => array(
							'Implant fusing with bone',
							'Temporary crown placed (if not immediate)',
							'No smoking or alcohol',
							'No hard bite on implant',
							'VeaHealth digital check-ins',
						),
					),
					array(
						'n' => '3',
						'title' => 'Full Integration',
						'text' => '',
						'points' => array(
							'Osseointegration complete',
							'Final abutment & crown placed',
							'Normal chewing restored',
							'Speech fully natural',
							'95%+ success at 10 years',
						),
					),
					array(
						'n' => '4',
						'title' => 'Ongoing Maintenance',
						'text' => '',
						'points' => array(
							'Brush 2× daily with soft brush',
							'Floss daily around crown margins',
							'Biannual professional cleanings',
							'Annual X-rays to monitor bone',
							'Lifetime implant durability',
						),
					),
				),
			),
			'evidence' => array(
				'label' => 'Clinical Evidence',
				'title' => 'What the Studies Show',
				'intro' => '',
				'items' => array(
					array(
						'figure' => '95–98%',
						'text' => 'Implant survival rate over 10 years in healthy non-smoking patients — confirming single implants as the most predictable tooth replacement in modern dentistry.',
						'source' => 'Pjetursson et al. (2014) · Clinical Oral Implants Research',
					),
					array(
						'figure' => '~5%',
						'text' => 'First-year failure rate, primarily in patients with uncontrolled systemic conditions or heavy smoking — confirming that risk factor management is essential.',
						'source' => 'Systematic review · Implant failure studies',
					),
					array(
						'figure' => '19.5%',
						'text' => 'Lifetime prevalence of peri-implantitis — the most common complication — underscoring why daily oral hygiene and regular professional maintenance are non-negotiable.',
						'source' => 'Journal of Periodontology · Systematic review 2024',
					),
				),
			),
			'faq' => array(
				'label' => 'Patient Questions',
				'title' => 'Frequently Asked Questions',
				'intro' => '',
				'items' => array(
					array(
						'q' => 'Is a single dental implant painful?',
						'a' => 'The procedure is performed under local anesthesia — no pain during surgery, only mild pressure. Post-op discomfort (soreness, swelling) peaks at 48 hours and typically resolves within a week with prescribed medication and cold compresses.',
					),
					array(
						'q' => 'How long does a single implant last?',
						'a' => 'The titanium post can last a lifetime with proper care. Studies confirm >95% survival at 10 years. The zirconia crown may need replacement after 15–20 years depending on wear. Regular 6-month check-ups are the primary maintenance requirement.',
					),
					array(
						'q' => 'Can the implant be placed the same day as extraction?',
						'a' => 'Yes — immediate implant placement is possible when the extraction socket has sufficient bone volume and no active infection. This reduces overall treatment time and preserves the natural socket architecture. VeaHealth’s surgeons assess eligibility during the 3D scan consultation.',
					),
					array(
						'q' => 'What if I need a bone graft first?',
						'a' => 'If bone volume is insufficient, a graft is performed first — either with your own bone, donor bone, or synthetic material. The graft heals for 3–6 months before the implant is placed, extending the total timeline to 8–12 months. VeaHealth identifies the need before you travel and factors it into your treatment plan and quote.',
					),
					array(
						'q' => 'How many trips to Istanbul are required?',
						'a' => 'Typically two visits: the first (2–4 days) for the implant placement, and a return visit (1–2 days) after osseointegration for the final crown. The healing phase in between is fully managed remotely by VeaHealth with no travel required.',
					),
					array(
						'q' => 'Is the warranty valid when I return home?',
						'a' => 'Yes. VeaHealth’s implant warranty covers both the fixture and the prosthetic components and is valid internationally. Full documentation is provided at treatment completion. If any warranty-covered issue arises after your return home, VeaHealth coordinates the resolution remotely or via a local affiliated clinic.',
					),
					array(
						'q' => 'What brand of implant will be used?',
						'a' => 'VeaHealth uses exclusively Straumann and Nobel Biocare implants — the two most clinically validated brands globally. The brand, model, and batch number are confirmed in your treatment plan and documented at placement. This is a contractual guarantee, not a marketing promise.',
					),
					array(
						'q' => 'Can smokers receive a single dental implant?',
						'a' => 'Smokers can receive implants, but tobacco significantly reduces success rates by impairing blood flow and healing. VeaHealth strongly recommends stopping smoking at least 4–6 weeks before and after surgery. Partial or full cessation during the healing period measurably improves osseointegration outcomes.',
					),
				),
			),
		),
		array(
			'slug' => 'full-mouth-dental-implants',
			'title' => 'Full Mouth Dental Implants',
			'h1' => 'Full Mouth Dental Implants in Istanbul',
			'lead' => 'Complete smile restoration with All-on-4 or All-on-6 implant techniques. Replace an entire arch with just 4–6 strategically placed implants. Straumann & Nobel Biocare brands. Fixed, functional teeth in one visit. VeaHealth coordinates your complete transformation.',
			'trust' => array(
				'All-on-4 & All-on-6 techniques',
				'Straumann & Nobel Biocare implants',
				'Same-day temporary teeth',
				'Lifetime warranty on implants',
			),
			'price' => '£4,500',
			'price_note' => 'All-inclusive full arch restoration package — consultation, surgery, temporary teeth, final prosthesis, and lifetime implant warranty.',
			'stats' => array(
				array(
					'v' => '70%',
					'k' => 'vs UK Cost',
				),
				array(
					'v' => '7',
					'k' => 'Days in Istanbul',
				),
			),
			'image' => 'full-arch-prosthesis-macro.webp',
			'caveat' => '',
			'review_note' => '',
			'why' => array(
				'label' => 'Complete Restoration',
				'title' => 'Why Full Mouth Implants Transform Lives',
				'intro' => 'Full arch implants replace all missing or failing teeth with a permanent, fixed solution. No more dentures, no adhesives, no slipping — just confident eating, speaking, and smiling.',
				'cards' => array(
					array(
						'title' => 'Permanent Fixed Solution',
						'text' => 'Unlike dentures, full arch implants are screwed directly into your jawbone. They never come out, never slip, and require no special cleaning routines. Brush and floss just like natural teeth.',
					),
					array(
						'title' => 'Immediate Functionality',
						'text' => 'Walk out with temporary teeth the same day as surgery. You can eat soft foods immediately and resume normal chewing within 2–3 weeks. Final zirconia bridge placed after 3–6 months of healing.',
					),
					array(
						'title' => 'Cost-Effective at Scale',
						'text' => 'Replacing 10–14 teeth individually would cost £15,000–25,000 in the UK. Full arch restoration with 4–6 implants costs £4,500–6,500 in Istanbul — a 70% saving with identical clinical outcomes.',
					),
					array(
						'title' => 'Preserves Jawbone',
						'text' => 'Dental implants stimulate bone just like natural tooth roots, preventing the bone loss and facial collapse that occurs with dentures. Your facial structure remains youthful and stable long-term.',
					),
					array(
						'title' => 'Natural Aesthetics',
						'text' => 'Final prostheses are crafted from layered zirconia — mimicking natural tooth translucency, color, and texture. Gum-colored acrylic recreates natural tissue. Results are indistinguishable from real teeth.',
					),
					array(
						'title' => 'Proven Longevity',
						'text' => 'All-on-4/6 implants have 95%+ survival rates at 10 years. With proper hygiene and regular check-ups, your implants can last a lifetime. The prosthetic bridge may need replacement after 15–20 years due to wear.',
					),
				),
			),
			'compare' => array(
				'label' => 'Treatment Comparison',
				'title' => 'Full Mouth Implants vs. Other Solutions',
				'intro' => '',
				'head' => array(
					'Feature',
					'Full Arch Implants',
					'Traditional Dentures',
					'Individual Implants',
					'Implant-Supported Dentures',
				),
				'rows' => array(
					array(
						'label' => 'Fixed in Place',
						'values' => array(
							array(
								'v' => 'Permanent',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Removable',
								'good' => false,
								'bad' => true,
							),
							array(
								'v' => 'Permanent',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Removable (clips on)',
								'good' => false,
								'bad' => true,
							),
						),
					),
					array(
						'label' => 'Bone Preservation',
						'values' => array(
							array(
								'v' => 'Excellent',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Bone loss continues',
								'good' => false,
								'bad' => true,
							),
							array(
								'v' => 'Excellent',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Good',
								'good' => true,
								'bad' => false,
							),
						),
					),
					array(
						'label' => 'Chewing Power',
						'values' => array(
							array(
								'v' => '90–95% natural',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => '25–50% natural',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '95–100% natural',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => '70–80% natural',
								'good' => false,
								'bad' => false,
							),
						),
					),
					array(
						'label' => 'Speech Quality',
						'values' => array(
							array(
								'v' => 'Natural',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Impaired (slipping)',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'Natural',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Good (minimal bulk)',
								'good' => false,
								'bad' => false,
							),
						),
					),
					array(
						'label' => 'Maintenance',
						'values' => array(
							array(
								'v' => 'Brush & floss daily',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Daily removal & soaking',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'Brush & floss daily',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Daily removal & cleaning',
								'good' => false,
								'bad' => false,
							),
						),
					),
					array(
						'label' => 'Implants Required',
						'values' => array(
							array(
								'v' => '4–6 per arch',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'None (bone loss)',
								'good' => false,
								'bad' => true,
							),
							array(
								'v' => '10–14 per arch',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '2–4 per arch',
								'good' => false,
								'bad' => false,
							),
						),
					),
					array(
						'label' => 'Treatment Time',
						'values' => array(
							array(
								'v' => '1 day (temp teeth)',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => '2–4 weeks (impressions)',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '6–12 months (staged)',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '3–6 months',
								'good' => false,
								'bad' => false,
							),
						),
					),
					array(
						'label' => 'Istanbul Cost (per arch)',
						'values' => array(
							array(
								'v' => '£4,500–6,500',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => '£800–1,500',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '£12,000–18,000',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '£3,000–4,500',
								'good' => false,
								'bad' => false,
							),
						),
					),
				),
			),
			'procedure' => array(
				'label' => 'Treatment Journey',
				'title' => 'Your Full Mouth Implant Procedure',
				'intro' => 'From consultation to final prosthesis — the entire journey typically requires two visits to Istanbul over 5–6 months.',
				'steps' => array(
					array(
						'tag' => 'Pre-Arrival',
						'title' => 'Digital Planning',
						'text' => 'Before you travel, VeaHealth coordinates a full diagnostic workup — panoramic X-rays, 3D CBCT scan, and digital treatment planning. Your surgeon designs implant placement virtually to ensure optimal positioning.',
						'points' => array(
							'Medical history & consultation via video',
							'Digital X-rays & CBCT scan uploaded',
							'3D surgical guide designed',
							'Final treatment plan & quote confirmed',
							'Travel & accommodation arranged',
						),
					),
					array(
						'tag' => 'Day 1–2 — Istanbul',
						'title' => 'Surgery & Temporary Teeth',
						'text' => 'Under IV sedation or general anesthesia, 4–6 implants are placed per arch. Any failing teeth are extracted. Temporary acrylic teeth are attached the same day — you walk out with a full smile.',
						'points' => array(
							'IV sedation or general anesthesia',
							'Tooth extractions (if needed)',
							'4–6 implants placed per arch',
							'Immediate temporary prosthesis attached',
							'Post-op instructions & medications',
						),
					),
					array(
						'tag' => 'Day 3–7 — Istanbul',
						'title' => 'Healing & Adjustments',
						'text' => 'You remain in Istanbul for 5–7 days for daily check-ups. Swelling peaks at 48 hours. Your surgeon adjusts the temporary teeth for comfort and verifies healing is on track before you return home.',
						'points' => array(
							'Daily wound inspection',
							'Suture removal (day 7–10)',
							'Temporary teeth bite adjustment',
							'Pain management monitored',
							'Soft diet guidance provided',
						),
					),
					array(
						'tag' => 'Month 1–4',
						'title' => 'Osseointegration',
						'text' => 'Implants fuse with your jawbone over 3–6 months. You wear temporary teeth during this period and follow a gradual diet progression. VeaHealth monitors your healing remotely via photos and video calls.',
						'points' => array(
							'Bone integration occurs naturally',
							'Temporary teeth remain in place',
							'Gradual return to normal diet',
							'Remote check-ins every 2 weeks',
							'No travel required during healing',
						),
					),
					array(
						'tag' => 'Month 4–6 — Return Visit',
						'title' => 'Final Prosthesis Placement',
						'text' => 'You return to Istanbul for 3–5 days. The temporary bridge is removed and digital impressions are taken. Your final zirconia prosthesis is fabricated, tested, and permanently attached.',
						'points' => array(
							'Temporary prosthesis removed',
							'Digital impressions & bite registration',
							'Final zirconia bridge crafted (2–3 days)',
							'Try-in with shade and bite verification',
							'Permanent attachment & warranty docs',
						),
					),
				),
			),
			'cost' => array(
				'label' => 'Transparent Pricing',
				'title' => 'What You’ll Pay — Guaranteed',
				'intro' => 'VeaHealth locks in your price before travel. All costs include surgery, implants, temporary teeth, final prosthesis, and lifetime warranty on fixtures.',
				'tiers' => array(
					array(
						'where' => 'UK / US',
						'price' => '£15,000+',
						'note' => 'per arch',
						'features' => array(
							'All-on-4 procedure',
							'Standard implant brands',
							'Temporary acrylic teeth',
							'Final zirconia bridge',
							'5-year warranty',
							'No travel support',
						),
					),
					array(
						'where' => 'VeaHealth Istanbul',
						'price' => '£4,500',
						'note' => 'all-inclusive per arch',
						'features' => array(
							'All-on-4 or All-on-6 technique',
							'Straumann or Nobel Biocare implants',
							'3D-guided surgery',
							'Same-day temporary prosthesis',
							'Premium zirconia final bridge',
							'Lifetime warranty on implants',
							'3-year warranty on prosthesis',
							'Airport VIP transfers',
							'7 nights hotel coordination',
							'24/7 VeaHealth concierge',
						),
					),
					array(
						'where' => 'Europe',
						'price' => '€9,000+',
						'note' => 'per arch',
						'features' => array(
							'All-on-4 standard protocol',
							'Mid-range implants',
							'Temporary teeth',
							'Acrylic or hybrid bridge',
							'2-year warranty',
							'Limited travel assistance',
						),
					),
				),
			),
			'recovery' => array(
				'label' => 'Post-Treatment',
				'title' => 'Recovery & Aftercare',
				'intro' => 'Full mouth implant recovery is gradual but predictable. Most patients resume normal activities within 7–10 days and full chewing function within 3–6 months.',
				'phases' => array(
					array(
						'n' => '1',
						'title' => 'Immediate Post-Op',
						'text' => '',
						'points' => array(
							'Swelling peaks at 48 hours',
							'Bruising may appear (normal)',
							'Soft/liquid diet only',
							'Pain managed with medication',
							'Daily clinic check-ups',
						),
					),
					array(
						'n' => '2',
						'title' => 'Early Healing',
						'text' => '',
						'points' => array(
							'Swelling subsides completely',
							'Sutures dissolve or removed',
							'Gradual return to soft solids',
							'No hard/chewy foods yet',
							'Remote VeaHealth check-ins',
						),
					),
					array(
						'n' => '3',
						'title' => 'Osseointegration',
						'text' => '',
						'points' => array(
							'Bone fusion progressing',
							'Normal diet resuming gradually',
							'Temporary teeth feel stable',
							'Oral hygiene routine established',
							'Monthly photo updates to clinic',
						),
					),
					array(
						'n' => '4',
						'title' => 'Final Restoration',
						'text' => '',
						'points' => array(
							'Full osseointegration complete',
							'Return to Istanbul for final bridge',
							'Permanent prosthesis placed',
							'Full chewing function restored',
							'Biannual check-ups begin',
						),
					),
				),
			),
			'evidence' => array(
				'label' => 'Clinical Evidence',
				'title' => 'What the Studies Show',
				'intro' => '',
				'items' => array(
					array(
						'figure' => '95–98%',
						'text' => 'Implant survival rate for All-on-4/6 at 10 years across multiple systematic reviews — matching or exceeding individual implant protocols with significantly faster treatment times.',
						'source' => 'Maló et al. (2016) · Clinical Implant Dentistry',
					),
					array(
						'figure' => '3.2%',
						'text' => 'Prosthetic complication rate (crown fracture, screw loosening) over 10 years — manageable issues that are easily repaired without compromising the underlying implants.',
						'source' => 'Pjetursson et al. (2018) · Systematic review',
					),
					array(
						'figure' => '20+ yrs',
						'text' => 'Documented implant lifespan in well-maintained All-on-4 cases — confirming that with proper hygiene and regular professional care, full arch implants are truly a lifetime investment.',
						'source' => 'Journal of Oral Implantology · Long-term follow-up studies',
					),
				),
			),
			'faq' => array(
				'label' => 'Patient Questions',
				'title' => 'Frequently Asked Questions',
				'intro' => '',
				'items' => array(
					array(
						'q' => 'Is full mouth implant surgery painful?',
						'a' => 'The procedure is performed under IV sedation or general anesthesia — you feel nothing during surgery. Post-op discomfort (swelling, soreness) peaks at 48 hours and is managed with prescribed pain medication and cold compresses. Most patients describe it as less painful than a single tooth extraction.',
					),
					array(
						'q' => 'How long do full mouth dental implants last?',
						'a' => 'The titanium implants can last a lifetime with proper care — studies confirm 95%+ survival at 10 years and 20+ year longevity is common. The zirconia prosthesis may need replacement after 15–20 years due to wear. Biannual professional cleanings are essential for long-term success.',
					),
					array(
						'q' => 'Can I eat normally with full arch implants?',
						'a' => 'Yes. After the initial healing period (3–6 months), you can eat all foods without restriction — including steak, nuts, apples, and corn on the cob. Chewing power is restored to 90–95% of natural teeth. No more dietary limitations like with dentures.',
					),
					array(
						'q' => 'What if I don’t have enough bone?',
						'a' => 'The All-on-4/6 technique is specifically designed for patients with bone loss. Angled posterior implants avoid areas of deficiency and maximize contact with available bone. In 90% of cases, no bone grafting is needed. If grafting is required, VeaHealth identifies this during pre-treatment planning.',
					),
					array(
						'q' => 'How many trips to Istanbul are required?',
						'a' => 'Two visits: the first for surgery and temporary teeth (7 days), and a second visit 4–6 months later for the final prosthesis (3–5 days). The healing phase in between is managed remotely by VeaHealth with no travel required.',
					),
					array(
						'q' => 'Is the warranty valid internationally?',
						'a' => 'Yes. VeaHealth’s lifetime warranty on implants and 3-year warranty on prosthetics are valid worldwide. If a warranty issue arises after you return home, VeaHealth coordinates resolution remotely or via a local affiliated clinic in your country.',
					),
					array(
						'q' => 'What implant brand will be used?',
						'a' => 'VeaHealth exclusively uses Straumann and Nobel Biocare implants — the two most researched and validated brands globally. The specific brand, model, and serial numbers are documented in your treatment file and provided at completion. This is a contractual guarantee.',
					),
					array(
						'q' => 'Can smokers receive full mouth implants?',
						'a' => 'Smokers can receive implants, but tobacco significantly reduces success rates by impairing healing and osseointegration. VeaHealth strongly recommends stopping smoking at least 4–6 weeks before and 3–6 months after surgery. Compliance with smoking cessation measurably improves outcomes.',
					),
				),
			),
		),
		array(
			'slug' => 'all-on-4-dental-implants',
			'title' => 'All-on-4 Dental Implants',
			'h1' => 'All-on-4 Dental Implants Full Arch · Fixed · Same Day',
			'lead' => '',
			'trust' => array(),
			'price' => '',
			'price_note' => '',
			'stats' => array(),
			'image' => 'all-on-4-bridge-3d-render.webp',
			'caveat' => '',
			'review_note' => '',
			'why' => array(
				'label' => 'Why All-on-4',
				'title' => 'Key Benefits',
				'intro' => '',
				'cards' => array(
					array(
						'title' => 'Stability & Chewing Function',
						'text' => 'No movement, no adhesives. Chewing efficiency approaches that of natural teeth — allowing a full diet. Implant-supported full-arch prostheses outperform removable dentures significantly in clinical chewing assessments (Pjetursson et al., 2005).',
					),
					array(
						'title' => 'Natural Aesthetics',
						'text' => 'Custom zirconia bridges restore natural smile line, lip support, and facial volume — preventing the “sunken face” appearance that accompanies long-term denture use. Every prosthesis is shade-matched and individually designed.',
					),
					array(
						'title' => 'Bone Preservation',
						'text' => 'Osseointegrated implants stimulate the jawbone through mechanical load transfer, halting the bone resorption that naturally follows tooth loss. This maintains facial structure and long-term prosthetic fit over decades.',
					),
					array(
						'title' => 'Cost Efficiency',
						'text' => 'Four implants deliver a full restoration at a fraction of the cost of individual implants for each missing tooth. VeaHealth’s Istanbul pricing is 60–70% below UK and US rates — with no compromise on brand quality or clinical standards.',
					),
				),
			),
			'compare' => array(
				'label' => 'Comparative Analysis',
				'title' => 'All-on-4 vs Other Solutions',
				'intro' => 'Understanding the clinical and practical differences helps you choose the approach best suited to your situation.',
				'head' => array(
					'Criteria',
					'All-on-4 ✦',
					'Removable Dentures',
					'Single Implants',
				),
				'rows' => array(
					array(
						'label' => 'Implants required',
						'values' => array(
							array(
								'v' => '4 per arch',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'None',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '1 per missing tooth',
								'good' => false,
								'bad' => false,
							),
						),
					),
					array(
						'label' => 'Fixation type',
						'values' => array(
							array(
								'v' => 'Fixed (permanent)',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'Removable',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'Fixed',
								'good' => false,
								'bad' => false,
							),
						),
					),
					array(
						'label' => 'Bone graft required',
						'values' => array(
							array(
								'v' => 'Rarely needed',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'Never',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'Sometimes',
								'good' => false,
								'bad' => false,
							),
						),
					),
					array(
						'label' => 'Best indication',
						'values' => array(
							array(
								'v' => 'Full arch loss',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'Full arch loss',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '1–few missing teeth',
								'good' => false,
								'bad' => false,
							),
						),
					),
					array(
						'label' => 'Same-day teeth',
						'values' => array(
							array(
								'v' => 'Yes',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'Yes',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'Variable',
								'good' => false,
								'bad' => false,
							),
						),
					),
					array(
						'label' => 'Bone preservation',
						'values' => array(
							array(
								'v' => 'Excellent',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'None',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'Yes',
								'good' => false,
								'bad' => false,
							),
						),
					),
					array(
						'label' => 'VeaHealth cost (Istanbul)',
						'values' => array(
							array(
								'v' => '€3,250 – €8,000',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '€800 – €2,500',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '€600 – €1,200/unit',
								'good' => false,
								'bad' => false,
							),
						),
					),
					array(
						'label' => '10-year survival rate',
						'values' => array(
							array(
								'v' => '>93% (implants)',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'Variable',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '>95%',
								'good' => false,
								'bad' => false,
							),
						),
					),
				),
			),
			'procedure' => array(
				'label' => 'Step by Step',
				'title' => 'The All-on-4 Procedure',
				'intro' => 'From your first consultation in Istanbul to your final smile — every step mapped out with precision and transparency.',
				'steps' => array(
					array(
						'tag' => 'Day 1 — Istanbul',
						'title' => 'Examination & 3D Diagnosis',
						'text' => 'Full clinical consultation, panoramic X-rays, and CBCT 3D scan to assess bone density and volume. Anatomical landmarks (sinuses, nerves) are mapped, and systemic health conditions are reviewed. Your VeaHealth coordinator accompanies you throughout.',
						'points' => array(),
					),
					array(
						'tag' => 'Day 1–2 · Planning',
						'title' => 'Digital Treatment Planning',
						'text' => 'CAD/CAM software is used to virtually position all 4 implants, simulating the ideal angulation and depth. The titanium bar and prosthetic arch are designed digitally. Bite function, aesthetics, and bone engagement are all optimized before a single drill touches the jaw.',
						'points' => array(),
					),
					array(
						'tag' => 'Day 2–3 · Surgery',
						'title' => 'Implant Placement Surgery',
						'text' => 'Four titanium implants are surgically placed under local anesthesia or IV sedation. The 2 anterior fixtures are vertical; the 2 posterior ones are tilted at 45° to maximize engagement with available bone volume — avoiding sinus anatomy entirely. Surgery takes 2–4 hours per arch.',
						'points' => array(),
					),
					array(
						'tag' => 'Same Day · Immediate Load',
						'title' => 'Same-Day Provisional Prosthesis',
						'text' => 'A fixed temporary bridge is attached on the same day — or within 24 hours — of implant placement. You leave the clinic with functional, aesthetic teeth. This immediate loading protocol restores confidence instantly while osseointegration begins beneath the surface.',
						'points' => array(),
					),
					array(
						'tag' => 'Months 3–6 · Healing',
						'title' => 'Osseointegration & Remote Follow-Up',
						'text' => 'The titanium implants gradually fuse with the jawbone. VeaHealth provides a structured remote aftercare protocol: digital check-ins, photo assessments, and direct access to your treatment coordinator from your home country. Any concerns are addressed promptly without requiring immediate travel.',
						'points' => array(),
					),
					array(
						'tag' => 'Month 4–6 · Return Visit',
						'title' => 'Final Zirconia Prosthesis Placement',
						'text' => 'Once full osseointegration is confirmed, you return to Istanbul for your definitive restoration. A custom-milled zirconia or high-grade acrylic bridge — fabricated to match your natural tooth shade, bite alignment, and facial aesthetics — is permanently secured. This is your final smile.',
						'points' => array(),
					),
				),
			),
			'cost' => array(
				'label' => '',
				'title' => '',
				'intro' => '',
				'tiers' => array(
					array(
						'where' => 'Turkey — Istanbul',
						'price' => '€3,250',
						'note' => 'Transparent pricing. Straumann & Nobel Biocare brands. CAD/CAM technology. English-speaking team. International warranty included.',
						'features' => array(),
					),
					array(
						'where' => 'United Kingdom',
						'price' => '€14,000',
						'note' => 'High clinical and lab fees. Limited NHS coverage for implants. Long waiting lists at major centres.',
						'features' => array(),
					),
					array(
						'where' => 'United States',
						'price' => '€11,000',
						'note' => 'Wide cost range depending on materials, state, and practice location. Insurance rarely covers implants.',
						'features' => array(),
					),
					array(
						'where' => 'India',
						'price' => '€3,000',
						'note' => 'Low treatment costs and experienced surgeons. Clinic quality varies — accreditation research essential.',
						'features' => array(),
					),
					array(
						'where' => 'Mexico',
						'price' => '€4,000',
						'note' => 'Popular dental tourism hub for North American patients. Border-city clinics dominate the market.',
						'features' => array(),
					),
					array(
						'where' => 'Europe (General)',
						'price' => '€10,000',
						'note' => 'Western Europe higher; Eastern Europe (Poland, Hungary) more competitive but still 2–3× Turkey pricing.',
						'features' => array(),
					),
				),
			),
			'recovery' => array(
				'label' => 'Afterwards',
				'title' => 'Recovery, week by week',
				'intro' => '',
				'phases' => array(
					array(
						'n' => 'Days 1–3',
						'title' => 'Immediately after surgery',
						'text' => 'Swelling peaks around the second day. You leave with a fixed provisional bridge, so you are never without teeth.',
						'points' => array(
							'Cold compresses for the first 48 hours',
							'Liquids and very soft food only',
							'Sleep with your head raised',
							'Take the prescribed medication on schedule',
						),
					),
					array(
						'n' => 'Weeks 1–2',
						'title' => 'Soft diet',
						'text' => 'Sutures dissolve or are removed. Comfort improves quickly, but the implants underneath are not yet integrated and the diet protects them.',
						'points' => array(
							'Soft food only — nothing that needs real force',
							'Prescribed rinse, no vigorous swilling',
							'No smoking: it is the single biggest risk to integration',
						),
					),
					array(
						'n' => 'Months 2–4',
						'title' => 'Integration',
						'text' => 'The implants fuse to the bone. This is the part that cannot be hurried and the reason the final bridge is not fitted yet.',
						'points' => array(
							'Keep the provisional scrupulously clean',
							'Remote review with your coordinator',
							'Report any looseness immediately',
						),
					),
					array(
						'n' => 'Final visit',
						'title' => 'The definitive bridge',
						'text' => 'You return to Istanbul for the permanent prosthesis, fitted after the tissue has settled to its final shape.',
						'points' => array(
							'Second trip, usually 5–7 days',
							'Bite refined over more than one appointment',
							'Hygiene routine taught for the finished bridge',
						),
					),
				),
			),
			'evidence' => array(
				'label' => 'Clinical Evidence',
				'title' => 'What the Studies Show',
				'intro' => '',
				'items' => array(
					array(
						'figure' => '93%+',
						'text' => 'Implant survival rate over 10 to 18 years of continuous clinical follow-up — confirming All-on-4 as a long-term solution.',
						'source' => 'Maló et al., 2019 · Longitudinal study 10–18 years',
					),
					array(
						'figure' => '~99%',
						'text' => 'Prosthesis survival rate over the same period — the full-arch bridge remained stable and functional in nearly all cases studied.',
						'source' => 'Maló et al., 2019 · Longitudinal study 10–18 years',
					),
					array(
						'figure' => '95%+',
						'text' => 'Single implant survival over 10 years — both approaches deliver comparable long-term results within their respective clinical indications.',
						'source' => 'Systematic review · Conventional implant protocols',
					),
				),
			),
			'faq' => array(
				'label' => 'Patient Questions',
				'title' => 'Frequently Asked Questions',
				'intro' => '',
				'items' => array(
					array(
						'q' => 'Is All-on-4 painful?',
						'a' => 'The procedure is performed under local anesthesia or sedation — no pain during surgery. Post-op discomfort (mild swelling, pressure) is managed with prescribed medication and typically resolves within a week. Most patients report less discomfort than anticipated.',
					),
					array(
						'q' => 'How long do All-on-4 implants last?',
						'a' => 'The titanium implants themselves typically last 15–20+ years with proper care. The zirconia prosthesis is highly durable and may last the same timeframe, while acrylic bridges may require replacement after 10–12 years. Clinical studies confirm >93% implant survival at 18 years.',
					),
					array(
						'q' => 'Can smokers receive All-on-4 implants?',
						'a' => 'Smokers are not excluded but tobacco significantly increases failure risk — nicotine reduces gingival blood flow and slows osseointegration. VeaHealth strongly advises reducing or stopping smoking at least 4–6 weeks before and after surgery to protect outcomes.',
					),
					array(
						'q' => 'What if one implant fails?',
						'a' => 'A single failure rarely destabilizes the full arch — the remaining 3 implants maintain function. The failed fixture is removed, and options include bone grafting with replacement or switching to an All-on-6 configuration for added redundancy. Early detection through regular follow-ups is key.',
					),
					array(
						'q' => 'Are Turkish implant warranties valid internationally?',
						'a' => 'Yes. VeaHealth’s warranties cover implant fixtures and prosthetic components and are honored internationally. Documentation is provided at treatment completion, and the warranty remains valid even after you return to your home country — with remote coordination available.',
					),
					array(
						'q' => 'Can people with bruxism get All-on-4?',
						'a' => 'Yes, with precautions. Night guards and reinforced prosthetic materials are used to protect against excessive wear from grinding. VeaHealth evaluates bite forces during planning and designs the restoration to manage bruxism loads effectively.',
					),
					array(
						'q' => 'How soon can I eat after the procedure?',
						'a' => 'You receive a fixed provisional bridge the same day, so you are never without teeth. A soft diet is maintained for 6–8 weeks. Once osseointegration is confirmed and the final bridge placed, you resume a full, unrestricted diet.',
					),
					array(
						'q' => 'Is there a metal-free option for titanium allergies?',
						'a' => 'Yes. Zirconia implants are available as a metal-free alternative for patients with confirmed titanium hypersensitivity. Zirconia offers excellent biocompatibility and strength while eliminating metal contact entirely. VeaHealth assesses allergy status during initial consultation.',
					),
				),
			),
		),
		array(
			'slug' => 'all-on-6-dental-implants',
			'title' => 'All-on-6 Dental Implants',
			'h1' => 'All-on-6 Dental Implants in Istanbul',
			'lead' => 'Enhanced full arch restoration with 6 strategically placed implants per jaw. Superior stability and load distribution compared to All-on-4. Straumann & Nobel Biocare brands. Same-day temporary teeth. VeaHealth coordinates your complete transformation journey.',
			'trust' => array(
				'Enhanced stability with 6 implants',
				'Straumann & Nobel Biocare guaranteed',
				'Same-day temporary teeth',
				'Lifetime warranty on implants',
			),
			'price' => '£5,200',
			'price_note' => 'All-inclusive All-on-6 package per arch — 6 implants, surgery, temporary teeth, final zirconia prosthesis, and lifetime warranty.',
			'stats' => array(
				array(
					'v' => '70%',
					'k' => 'vs UK Cost',
				),
				array(
					'v' => '97%+',
					'k' => 'Success Rate',
				),
			),
			'image' => 'full-arch-prosthesis-macro.webp',
			'caveat' => '',
			'review_note' => '',
			'why' => array(
				'label' => 'Enhanced Restoration',
				'title' => 'Why All-on-6 Offers Superior Stability',
				'intro' => 'All-on-6 uses two additional implants compared to All-on-4, providing enhanced load distribution, better long-term stability, and improved outcomes for patients with moderate bone loss.',
				'cards' => array(
					array(
						'title' => 'Superior Load Distribution',
						'text' => 'Six implants distribute chewing forces more evenly across the arch, reducing stress on individual fixtures. This enhanced biomechanics translates to better long-term survival rates and reduced risk of prosthetic complications.',
					),
					array(
						'title' => 'Greater Stability',
						'text' => 'Two extra implants provide significantly more retention and stability than All-on-4. Patients report greater confidence when chewing tough foods, reduced prosthetic movement, and a more natural feeling restoration.',
					),
					array(
						'title' => 'Versatile Placement',
						'text' => 'Six implants allow for more flexible positioning to work around anatomical limitations like sinuses or nerves. Surgeons can optimize placement based on your unique bone architecture, improving long-term success rates.',
					),
					array(
						'title' => 'Better for Bone Loss',
						'text' => 'Patients with moderate to severe bone loss often benefit from All-on-6 over All-on-4. The additional implants compensate for reduced bone density and provide redundancy if one fixture encounters complications during healing.',
					),
					array(
						'title' => 'Reduced Cantilever',
						'text' => 'The additional posterior implants minimize cantilever extension (unsupported bridge length), which is the primary cause of prosthetic fracture in full arch restorations. This means fewer repairs and longer prosthesis lifespan.',
					),
					array(
						'title' => 'Proven Excellence',
						'text' => 'Clinical studies show 97%+ implant survival at 10 years for All-on-6 — slightly higher than All-on-4. The additional implants provide a safety margin that translates to measurably better long-term outcomes for patients.',
					),
				),
			),
			'compare' => array(
				'label' => 'Treatment Comparison',
				'title' => 'All-on-6 vs. Other Full Arch Solutions',
				'intro' => '',
				'head' => array(
					'Feature',
					'All-on-6',
					'All-on-4',
					'Individual Implants',
					'Dentures',
				),
				'rows' => array(
					array(
						'label' => 'Implants Per Arch',
						'values' => array(
							array(
								'v' => '6 implants',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => '4 implants',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '8–10 implants',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'None',
								'good' => false,
								'bad' => true,
							),
						),
					),
					array(
						'label' => 'Stability & Retention',
						'values' => array(
							array(
								'v' => 'Excellent (best)',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Very Good',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'Excellent',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Poor (slips)',
								'good' => false,
								'bad' => true,
							),
						),
					),
					array(
						'label' => 'Chewing Power',
						'values' => array(
							array(
								'v' => '95–98% natural',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => '90–95% natural',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '95–100% natural',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => '25–50% natural',
								'good' => false,
								'bad' => false,
							),
						),
					),
					array(
						'label' => 'Bone Preservation',
						'values' => array(
							array(
								'v' => 'Excellent',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Excellent',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Excellent',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Bone loss continues',
								'good' => false,
								'bad' => true,
							),
						),
					),
					array(
						'label' => 'Treatment Time',
						'values' => array(
							array(
								'v' => '1 day (temp teeth)',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => '1 day (temp teeth)',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => '6–12 months (staged)',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '2–4 weeks',
								'good' => false,
								'bad' => false,
							),
						),
					),
					array(
						'label' => 'Cantilever Length',
						'values' => array(
							array(
								'v' => 'Minimal',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Moderate',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'None',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'N/A',
								'good' => false,
								'bad' => true,
							),
						),
					),
					array(
						'label' => 'Ideal For',
						'values' => array(
							array(
								'v' => 'Moderate bone loss',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Good bone density',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'Excellent bone',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'Budget option',
								'good' => false,
								'bad' => true,
							),
						),
					),
					array(
						'label' => 'Istanbul Cost (per arch)',
						'values' => array(
							array(
								'v' => '£5,200',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => '£4,500',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '£12,000–18,000',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '£800–1,500',
								'good' => false,
								'bad' => false,
							),
						),
					),
				),
			),
			'procedure' => array(
				'label' => 'Treatment Journey',
				'title' => 'Your All-on-6 Procedure',
				'intro' => 'From consultation to final prosthesis — the entire journey typically requires two visits to Istanbul over 5–6 months.',
				'steps' => array(
					array(
						'tag' => 'Pre-Arrival',
						'title' => 'Digital Planning',
						'text' => 'Before you travel, VeaHealth coordinates comprehensive diagnostics — 3D CBCT scan, panoramic X-rays, and digital treatment planning. Your surgeon designs the six-implant configuration virtually to optimize placement.',
						'points' => array(
							'Medical history & video consultation',
							'3D CBCT scan & X-rays analyzed',
							'6-implant surgical guide designed',
							'Final treatment plan confirmed',
							'Travel & hotel coordination',
						),
					),
					array(
						'tag' => 'Day 1–2 — Istanbul',
						'title' => 'Surgery & Immediate Teeth',
						'text' => 'Under IV sedation or general anesthesia, six implants are placed per arch using 3D-guided surgery. Any failing teeth are extracted. Temporary acrylic teeth are attached the same day — you leave with a full smile.',
						'points' => array(
							'IV sedation or general anesthesia',
							'Tooth extractions if needed',
							'6 implants placed per arch',
							'Immediate temporary prosthesis attached',
							'Post-op medications & instructions',
						),
					),
					array(
						'tag' => 'Day 3–7 — Istanbul',
						'title' => 'Recovery & Monitoring',
						'text' => 'You remain in Istanbul for 5–7 days for daily check-ups. Swelling peaks at 48–72 hours. Your surgeon adjusts temporary teeth for comfort and verifies healing progress before you return home.',
						'points' => array(
							'Daily wound inspection',
							'Suture removal (day 7–10)',
							'Bite adjustment on temporary teeth',
							'Pain management monitored',
							'Soft diet guidance provided',
						),
					),
					array(
						'tag' => 'Month 1–4',
						'title' => 'Osseointegration',
						'text' => 'Implants fuse with your jawbone over 4–6 months. You wear temporary teeth during this period and gradually return to normal eating. VeaHealth monitors your healing remotely via photos and video calls.',
						'points' => array(
							'Bone integration progresses naturally',
							'Temporary teeth remain functional',
							'Gradual diet progression',
							'Remote check-ins every 2 weeks',
							'No travel required during healing',
						),
					),
					array(
						'tag' => 'Month 5–6 — Return Visit',
						'title' => 'Final Prosthesis Placement',
						'text' => 'You return to Istanbul for 3–5 days. The temporary bridge is removed and digital impressions are taken. Your final premium zirconia prosthesis is fabricated, tested, and permanently attached to all six implants.',
						'points' => array(
							'Temporary prosthesis removed',
							'Digital impressions & bite registration',
							'Final zirconia bridge crafted (2–3 days)',
							'Try-in with shade and occlusion check',
							'Permanent screw-retention & warranty docs',
						),
					),
				),
			),
			'cost' => array(
				'label' => 'Transparent Pricing',
				'title' => 'What You’ll Pay — Guaranteed',
				'intro' => 'VeaHealth locks in your price before travel. All costs include 6 implants, surgery, temporary teeth, final prosthesis, and lifetime warranty on fixtures.',
				'tiers' => array(
					array(
						'where' => 'UK / US',
						'price' => '£18,000+',
						'note' => 'per arch',
						'features' => array(
							'All-on-6 procedure',
							'Standard implant brands',
							'Temporary acrylic teeth',
							'Final hybrid or zirconia bridge',
							'5-year warranty',
							'No travel support',
						),
					),
					array(
						'where' => 'VeaHealth Istanbul',
						'price' => '£5,200',
						'note' => 'all-inclusive per arch',
						'features' => array(
							'All-on-6 technique',
							'Straumann or Nobel Biocare implants',
							'3D-guided implant surgery',
							'Same-day temporary prosthesis',
							'Premium monolithic zirconia bridge',
							'Lifetime warranty on implants',
							'3-year warranty on prosthesis',
							'Airport VIP transfers',
							'7 nights hotel coordination',
							'24/7 VeaHealth concierge support',
						),
					),
					array(
						'where' => 'Europe',
						'price' => '€11,000+',
						'note' => 'per arch',
						'features' => array(
							'All-on-6 standard protocol',
							'Mid-range implants',
							'Temporary teeth',
							'Acrylic or hybrid bridge',
							'2-year warranty',
							'Limited travel assistance',
						),
					),
				),
			),
			'recovery' => array(
				'label' => 'Post-Treatment',
				'title' => 'Recovery & Aftercare',
				'intro' => 'All-on-6 recovery is gradual but predictable. Most patients resume normal activities within 7–10 days and achieve full chewing function within 4–6 months.',
				'phases' => array(
					array(
						'n' => '1',
						'title' => 'Immediate Post-Op',
						'text' => '',
						'points' => array(
							'Swelling peaks at 48–72 hours',
							'Bruising may appear (normal)',
							'Soft/liquid diet only',
							'Pain managed with medication',
							'Daily clinic check-ups in Istanbul',
						),
					),
					array(
						'n' => '2',
						'title' => 'Early Healing',
						'text' => '',
						'points' => array(
							'Swelling resolves completely',
							'Sutures dissolve or removed',
							'Gradual return to soft solids',
							'No hard/chewy foods yet',
							'Remote VeaHealth monitoring',
						),
					),
					array(
						'n' => '3',
						'title' => 'Osseointegration',
						'text' => '',
						'points' => array(
							'Bone fusion progressing',
							'Normal diet resuming gradually',
							'Temporary teeth feel stable',
							'Oral hygiene routine established',
							'Monthly photo updates to clinic',
						),
					),
					array(
						'n' => '4',
						'title' => 'Final Restoration',
						'text' => '',
						'points' => array(
							'Full osseointegration complete',
							'Return to Istanbul for final bridge',
							'Permanent zirconia prosthesis placed',
							'Full chewing function restored',
							'Biannual check-ups begin',
						),
					),
				),
			),
			'evidence' => array(
				'label' => 'Clinical Evidence',
				'title' => 'What the Studies Show',
				'intro' => '',
				'items' => array(
					array(
						'figure' => '97–99%',
						'text' => 'Implant survival rate for All-on-6 at 10 years — slightly higher than All-on-4 due to enhanced load distribution and reduced stress on individual fixtures.',
						'source' => 'Clinical studies · Full arch implant outcomes',
					),
					array(
						'figure' => '2.1%',
						'text' => 'Prosthetic complication rate over 10 years — 40% lower than All-on-4 due to reduced cantilever length and better biomechanical support from additional implants.',
						'source' => 'Systematic review · Full arch prosthetic complications',
					),
					array(
						'figure' => '25+ yrs',
						'text' => 'Documented implant lifespan in well-maintained All-on-6 cases — confirming that with proper hygiene, biannual cleanings, and regular monitoring, the implants can truly last a lifetime.',
						'source' => 'Journal of Oral Implantology · Long-term follow-up',
					),
				),
			),
			'faq' => array(
				'label' => 'Patient Questions',
				'title' => 'Frequently Asked Questions',
				'intro' => '',
				'items' => array(
					array(
						'q' => 'Is All-on-6 better than All-on-4?',
						'a' => 'All-on-6 offers enhanced stability, better load distribution, and reduced cantilever length compared to All-on-4. It’s particularly beneficial for patients with moderate bone loss or those seeking maximum long-term stability. Studies show slightly higher success rates and fewer prosthetic complications. However, All-on-4 remains an excellent option for patients with good bone density.',
					),
					array(
						'q' => 'Is All-on-6 surgery painful?',
						'a' => 'The procedure is performed under IV sedation or general anesthesia — you feel nothing during surgery. Post-op discomfort (swelling, soreness) peaks at 48–72 hours and is managed with prescribed pain medication. Most patients describe it as less painful than expected, comparable to multiple tooth extractions.',
					),
					array(
						'q' => 'How long do All-on-6 implants last?',
						'a' => 'The titanium implants can last a lifetime with proper care — studies confirm 97%+ survival at 10 years. The zirconia prosthesis may need replacement after 15–20 years due to wear. Biannual professional cleanings and good oral hygiene are essential for long-term success.',
					),
					array(
						'q' => 'Can I eat normally with All-on-6?',
						'a' => 'Yes. After full healing (4–6 months), you can eat all foods without restriction — including steak, nuts, apples, and corn on the cob. Chewing power is restored to 95–98% of natural teeth. The two extra implants provide even greater stability than All-on-4 for tough foods.',
					),
					array(
						'q' => 'What if I don’t have enough bone?',
						'a' => 'All-on-6 is specifically designed for patients with moderate bone loss. The strategic angulation of posterior implants and the addition of two mid-arch implants often eliminates the need for bone grafting. VeaHealth identifies any grafting needs during pre-treatment planning and factors it into your timeline and quote.',
					),
					array(
						'q' => 'How many trips to Istanbul are required?',
						'a' => 'Two visits: the first for surgery and temporary teeth (7 days), and a second visit 5–6 months later for the final prosthesis (3–5 days). The healing phase in between is managed remotely by VeaHealth with no travel required.',
					),
					array(
						'q' => 'Is the warranty valid internationally?',
						'a' => 'Yes. VeaHealth’s lifetime warranty on implants and 3-year warranty on prosthetics are valid worldwide. If a warranty issue arises after you return home, VeaHealth coordinates resolution remotely or via a local affiliated clinic in your country.',
					),
					array(
						'q' => 'What implant brand will be used?',
						'a' => 'VeaHealth exclusively uses Straumann and Nobel Biocare implants — the two most researched and validated brands globally. The specific brand, model, and serial numbers are documented in your treatment file and provided at completion. This is a contractual guarantee.',
					),
				),
			),
		),
		array(
			'slug' => 'zygomatic-implants',
			'title' => 'Zygomatic Implants',
			'h1' => 'Zygomatic Implants in Istanbul',
			'lead' => 'Advanced solution for severe upper jaw bone loss. Specialized long implants anchored in the cheekbone (zygoma) eliminate the need for bone grafting. Same-day temporary teeth. Straumann & Nobel Biocare brands. VeaHealth coordinates your complete advanced implant journey.',
			'trust' => array(
				'No bone grafting required',
				'Anchored in cheekbone (zygoma)',
				'Same-day temporary teeth',
				'Lifetime warranty on implants',
			),
			'price' => '£7,500',
			'price_note' => 'All-inclusive zygomatic package — 2-4 zygomatic implants, surgery, temporary teeth, final prosthesis, and lifetime warranty.',
			'stats' => array(
				array(
					'v' => '70%',
					'k' => 'vs UK Cost',
				),
				array(
					'v' => '95%+',
					'k' => 'Success Rate',
				),
			),
			'image' => 'sinus-lift-3d-render.webp',
			'caveat' => '',
			'review_note' => '',
			'why' => array(
				'label' => 'Advanced Solution',
				'title' => 'Why Zygomatic Implants Transform Impossible Cases',
				'intro' => 'Zygomatic implants are specialized titanium fixtures anchored in the dense cheekbone (zygoma) rather than the jaw. They’re the gold standard for patients with severe upper jaw bone loss who would otherwise need extensive bone grafting.',
				'cards' => array(
					array(
						'title' => 'No Bone Grafting',
						'text' => 'Zygomatic implants bypass the atrophied upper jaw entirely by anchoring into the cheekbone — which never resorbs. This eliminates 6–12 months of bone graft healing and multiple surgeries, saving time and avoiding graft complications.',
					),
					array(
						'title' => 'Immediate Function',
						'text' => 'Temporary teeth are attached the same day as surgery — you walk out with a full smile. The dense zygomatic bone provides immediate primary stability, allowing for functional loading within 24–48 hours unlike traditional grafting protocols.',
					),
					array(
						'title' => 'Superior Anchorage',
						'text' => 'The zygomatic bone is 3–4 times denser than maxillary bone. This exceptional density provides rock-solid implant stability and reduces risk of early failure. Zygomatic implants routinely achieve higher insertion torque values than conventional implants.',
					),
					array(
						'title' => 'Suitable for Extreme Cases',
						'text' => 'Zygomatic implants are designed for patients with <5mm of residual bone — cases where conventional implants and even sinus lifts are impossible. They\'re the last-resort solution that works when nothing else can.',
					),
					array(
						'title' => 'Cost-Effective at Scale',
						'text' => 'While zygomatic implants cost more than conventional ones, they’re far cheaper than the alternative: multiple sinus lifts + bone grafts + conventional implants. Total treatment time is also 6–9 months shorter, reducing overall expenses.',
					),
					array(
						'title' => 'Proven Long-Term Success',
						'text' => 'Clinical studies confirm 95–97% survival rates at 10+ years. The technique was pioneered in the 1990s and has decades of documented outcomes. Zygomatic implants are no longer experimental — they’re mainstream for severe bone loss cases.',
					),
				),
			),
			'compare' => array(
				'label' => 'Treatment Comparison',
				'title' => 'Zygomatic vs. Other Solutions',
				'intro' => '',
				'head' => array(
					'Feature',
					'Zygomatic Implants',
					'Sinus Lift + Implants',
					'Conventional All-on-4',
					'Removable Dentures',
				),
				'rows' => array(
					array(
						'label' => 'Bone Grafting Required',
						'values' => array(
							array(
								'v' => 'No',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Yes (6–9 months)',
								'good' => false,
								'bad' => true,
							),
							array(
								'v' => 'Maybe (moderate loss)',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'No',
								'good' => true,
								'bad' => false,
							),
						),
					),
					array(
						'label' => 'Anchorage Location',
						'values' => array(
							array(
								'v' => 'Cheekbone (zygoma)',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Upper jaw (maxilla)',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'Upper jaw (maxilla)',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'Gum tissue only',
								'good' => false,
								'bad' => true,
							),
						),
					),
					array(
						'label' => 'Ideal For',
						'values' => array(
							array(
								'v' => 'Severe bone loss',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Moderate bone loss',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'Good-moderate bone',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'Budget/no surgery',
								'good' => false,
								'bad' => true,
							),
						),
					),
					array(
						'label' => 'Immediate Teeth',
						'values' => array(
							array(
								'v' => 'Same day',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'After graft heals',
								'good' => false,
								'bad' => true,
							),
							array(
								'v' => 'Same day',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Immediate',
								'good' => true,
								'bad' => false,
							),
						),
					),
					array(
						'label' => 'Total Treatment Time',
						'values' => array(
							array(
								'v' => '4–6 months',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => '12–18 months',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '4–6 months',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '2–4 weeks',
								'good' => false,
								'bad' => false,
							),
						),
					),
					array(
						'label' => 'Implant Length',
						'values' => array(
							array(
								'v' => '30–55mm (extra long)',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => '10–15mm (standard)',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '10–18mm (standard)',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'N/A',
								'good' => false,
								'bad' => true,
							),
						),
					),
					array(
						'label' => 'Success Rate (10 years)',
						'values' => array(
							array(
								'v' => '95–97%',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => '90–95%',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '95–98%',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'N/A (replaceable)',
								'good' => false,
								'bad' => true,
							),
						),
					),
					array(
						'label' => 'Istanbul Cost',
						'values' => array(
							array(
								'v' => '£7,500',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => '£8,500–12,000',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '£4,500',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '£800–1,500',
								'good' => false,
								'bad' => false,
							),
						),
					),
				),
			),
			'procedure' => array(
				'label' => 'Treatment Journey',
				'title' => 'Your Zygomatic Implant Procedure',
				'intro' => 'From consultation to final prosthesis — the entire journey typically requires two visits to Istanbul over 5–6 months.',
				'steps' => array(
					array(
						'tag' => 'Pre-Arrival',
						'title' => 'Specialized Planning',
						'text' => 'Before you travel, VeaHealth coordinates advanced diagnostics — high-resolution CBCT scan showing zygomatic anatomy, sinus positioning, and nerve pathways. A specialized zygomatic surgeon designs your implant trajectory virtually.',
						'points' => array(
							'Medical history & video consultation',
							'High-res 3D CBCT scan analyzed',
							'Zygomatic trajectory planning software',
							'Combined zygoma + conventional plan',
							'Travel & hotel coordination',
						),
					),
					array(
						'tag' => 'Day 1–2 — Istanbul',
						'title' => 'Zygomatic Surgery',
						'text' => 'Under general anesthesia, 2–4 zygomatic implants are placed per arch using 3D-guided navigation. The extra-long implants traverse the sinus and anchor in the cheekbone. Temporary teeth are attached immediately.',
						'points' => array(
							'General anesthesia or IV sedation',
							'Tooth extractions if needed',
							'2–4 zygomatic implants placed (40–55mm)',
							'2–4 conventional anterior implants',
							'Same-day temporary prosthesis attached',
						),
					),
					array(
						'tag' => 'Day 3–10 — Istanbul',
						'title' => 'Recovery & Monitoring',
						'text' => 'You remain in Istanbul for 7–10 days for close monitoring. Swelling peaks at 72 hours. Your surgeon verifies implant stability and adjusts temporary teeth. Post-op care is more intensive than conventional implants due to sinus proximity.',
						'points' => array(
							'Daily clinic check-ups',
							'Suture removal (day 10–14)',
							'Nasal decongestants prescribed',
							'Bite adjustment on temporary teeth',
							'Pain management closely monitored',
						),
					),
					array(
						'tag' => 'Month 1–4',
						'title' => 'Osseointegration',
						'text' => 'Implants fuse with zygomatic bone over 4–6 months. You wear temporary teeth during this period and gradually resume normal eating. VeaHealth monitors your healing remotely via photos, video calls, and symptom tracking.',
						'points' => array(
							'Bone integration in zygoma',
							'Temporary teeth remain functional',
							'Gradual diet progression',
							'Remote monitoring every 2 weeks',
							'No travel required during healing',
						),
					),
					array(
						'tag' => 'Month 5–6 — Return Visit',
						'title' => 'Final Prosthesis',
						'text' => 'You return to Istanbul for 3–5 days. The temporary bridge is removed and digital impressions are taken. Your final premium zirconia prosthesis is fabricated, tested for fit and occlusion, and permanently attached.',
						'points' => array(
							'Temporary prosthesis removed',
							'Digital impressions & bite registration',
							'Final zirconia bridge crafted (2–3 days)',
							'Try-in with shade and occlusion check',
							'Permanent screw-retention & warranty docs',
						),
					),
				),
			),
			'cost' => array(
				'label' => 'Transparent Pricing',
				'title' => 'What You’ll Pay — Guaranteed',
				'intro' => 'VeaHealth locks in your price before travel. All costs include zygomatic implants, surgery, temporary teeth, final prosthesis, and lifetime warranty on fixtures.',
				'tiers' => array(
					array(
						'where' => 'UK / US',
						'price' => '£25,000+',
						'note' => 'per arch',
						'features' => array(
							'Zygomatic implant procedure',
							'Standard implant brands',
							'Temporary acrylic teeth',
							'Final hybrid or zirconia bridge',
							'5-year warranty',
							'No travel support',
						),
					),
					array(
						'where' => 'VeaHealth Istanbul',
						'price' => '£7,500',
						'note' => 'all-inclusive per arch',
						'features' => array(
							'2–4 zygomatic implants (Straumann/Nobel)',
							'2–4 conventional anterior implants',
							'3D-guided navigation surgery',
							'General anesthesia included',
							'Same-day temporary prosthesis',
							'Premium monolithic zirconia bridge',
							'Lifetime warranty on implants',
							'Airport VIP transfers',
							'10 nights hotel coordination',
							'24/7 VeaHealth specialist support',
						),
					),
					array(
						'where' => 'Europe',
						'price' => '€15,000+',
						'note' => 'per arch',
						'features' => array(
							'Zygomatic procedure',
							'Mid-range implants',
							'Temporary teeth',
							'Acrylic or hybrid bridge',
							'2-year warranty',
							'Limited travel assistance',
						),
					),
				),
			),
			'recovery' => array(
				'label' => 'Post-Treatment',
				'title' => 'Recovery & Aftercare',
				'intro' => 'Zygomatic implant recovery requires closer monitoring than conventional implants due to sinus proximity. Most patients resume normal activities within 10–14 days and achieve full function within 5–6 months.',
				'phases' => array(
					array(
						'n' => '1',
						'title' => 'Intensive Post-Op',
						'text' => '',
						'points' => array(
							'Swelling peaks at 72 hours',
							'Nasal congestion common (normal)',
							'Soft/liquid diet only',
							'Pain managed with prescription meds',
							'Daily clinic visits in Istanbul',
						),
					),
					array(
						'n' => '2',
						'title' => 'Early Healing',
						'text' => '',
						'points' => array(
							'Swelling resolves significantly',
							'Sutures removed or dissolved',
							'Gradual return to soft solids',
							'Nasal decongestants continued',
							'Remote VeaHealth monitoring',
						),
					),
					array(
						'n' => '3',
						'title' => 'Osseointegration',
						'text' => '',
						'points' => array(
							'Implants fusing with zygoma',
							'Normal diet resuming gradually',
							'Temporary teeth feel stable',
							'Oral hygiene routine established',
							'Monthly photo updates to clinic',
						),
					),
					array(
						'n' => '4',
						'title' => 'Final Restoration',
						'text' => '',
						'points' => array(
							'Full osseointegration complete',
							'Return to Istanbul for final bridge',
							'Permanent zirconia prosthesis placed',
							'Full chewing function restored',
							'Biannual check-ups begin',
						),
					),
				),
			),
			'evidence' => array(
				'label' => 'Clinical Evidence',
				'title' => 'What the Studies Show',
				'intro' => '',
				'items' => array(
					array(
						'figure' => '95–97%',
						'text' => 'Implant survival rate for zygomatic implants at 10+ years across multiple systematic reviews — confirming they’re a predictable, mainstream solution for severe maxillary atrophy.',
						'source' => 'Chrcanovic et al. (2016) · Systematic review',
					),
					array(
						'figure' => '10.5%',
						'text' => 'Incidence of sinusitis following zygomatic placement — typically mild and self-limiting, managed with antibiotics and decongestants. Serious sinus complications are rare (<2%).',
						'source' => 'Clinical studies · Zygomatic complications',
					),
					array(
						'figure' => '20+ yrs',
						'text' => 'Documented lifespan in well-maintained zygomatic cases since the technique’s introduction in 1998. The zygomatic bone’s exceptional density provides stable long-term anchorage.',
						'source' => 'Brånemark et al. · Long-term follow-up',
					),
				),
			),
			'faq' => array(
				'label' => 'Patient Questions',
				'title' => 'Frequently Asked Questions',
				'intro' => '',
				'items' => array(
					array(
						'q' => 'Are zygomatic implants safe?',
						'a' => 'Yes. Zygomatic implants have been used since 1998 with well-documented safety profiles. The procedure is more complex than conventional implants and requires a specialized surgeon, but serious complications are rare (<2%). Mild, self-limiting sinusitis is the most common issue (10.5% of cases).',
					),
					array(
						'q' => 'Is zygomatic implant surgery painful?',
						'a' => 'The procedure is performed under general anesthesia — you feel nothing during surgery. Post-op discomfort (swelling, nasal congestion, soreness) is more significant than conventional implants and peaks at 72 hours. Pain is managed with prescription medications and typically resolves within 10–14 days.',
					),
					array(
						'q' => 'How long do zygomatic implants last?',
						'a' => 'The titanium fixtures can last a lifetime with proper care — studies confirm 95%+ survival at 10 years and documented cases exceeding 20 years. The zirconia prosthesis may need replacement after 15–20 years due to wear. Biannual check-ups are essential for long-term success.',
					),
					array(
						'q' => 'Am I a candidate for zygomatic implants?',
						'a' => 'Zygomatic implants are designed for patients with severe upper jaw bone loss — typically <5mm of residual bone where conventional implants and sinus lifts are impossible. VeaHealth\'s surgeons assess eligibility during the 3D CBCT scan consultation. Not all severe bone loss cases require zygomatic implants.',
					),
					array(
						'q' => 'How many trips to Istanbul are required?',
						'a' => 'Two visits: the first for surgery and temporary teeth (7–10 days due to more intensive monitoring), and a second visit 5–6 months later for the final prosthesis (3–5 days). The healing phase in between is managed remotely by VeaHealth.',
					),
					array(
						'q' => 'Will I have sinus problems after zygomatic implants?',
						'a' => 'Mild, temporary sinusitis occurs in ~10% of patients and resolves with antibiotics and decongestants within 2–4 weeks. The implants traverse the sinus but don’t cause chronic sinus issues. Serious complications like sinus perforation or chronic infection are rare (<2%) with experienced surgeons.',
					),
					array(
						'q' => 'What implant brand will be used?',
						'a' => 'VeaHealth exclusively uses Straumann and Nobel Biocare zygomatic implants — the two brands with the most clinical validation for this advanced technique. The specific brand, model, and serial numbers are documented in your treatment file and provided at completion.',
					),
					array(
						'q' => 'Is the warranty valid internationally?',
						'a' => 'Yes. VeaHealth’s lifetime warranty on zygomatic implants and 3-year warranty on prosthetics are valid worldwide. If a warranty issue arises after you return home, VeaHealth coordinates resolution remotely or via a local affiliated specialist clinic in your country.',
					),
				),
			),
		),
		array(
			'slug' => 'bone-graft',
			'title' => 'Bone Graft',
			'h1' => 'Professional Bone Graft Surgery in Istanbul',
			'lead' => 'Rebuild jawbone volume with advanced bone grafting techniques. 1cc premium graft material — autogenous, xenograft, or alloplastic options. Essential preparation for successful dental implant placement. VeaHealth coordinates your complete bone regeneration journey.',
			'trust' => array(
				'Premium graft materials (Bio-Oss, Cerabone)',
				'3D CBCT scan & planning',
				'PRF (platelet-rich fibrin) included',
				'3–6 month healing protocol',
			),
			'price' => '£280',
			'price_note' => 'All-inclusive 1cc bone graft package — consultation, 3D scan, surgery, premium graft material, PRF membrane, and follow-up monitoring.',
			'stats' => array(
				array(
					'v' => '70%',
					'k' => 'vs UK Cost',
				),
				array(
					'v' => '4–6',
					'k' => 'Months Healing',
				),
			),
			'image' => 'bone-graft-3d-render.webp',
			'caveat' => '',
			'review_note' => '',
			'why' => array(
				'label' => 'Essential Foundation',
				'title' => 'Why Bone Grafting Is Critical for Implant Success',
				'intro' => 'Bone grafting rebuilds lost jawbone volume, creating the stable foundation needed for long-term implant success. Without adequate bone, implants cannot integrate properly.',
				'cards' => array(
					array(
						'title' => 'Restores Bone Volume',
						'text' => 'After tooth loss, jawbone resorbs at 25% per year. Bone grafts halt this process and rebuild lost volume, creating the height and width needed for stable implant placement and long-term osseointegration.',
					),
					array(
						'title' => 'Prevents Implant Failure',
						'text' => 'Insufficient bone is the leading cause of implant failure. Grafting ensures adequate bone density and volume around the implant fixture, dramatically improving success rates from 60% to 95%+ in compromised sites.',
					),
					array(
						'title' => 'Maintains Facial Structure',
						'text' => 'Bone loss causes facial collapse and premature aging. Grafting preserves jawbone architecture, maintaining proper facial proportions and preventing the sunken appearance associated with long-term tooth loss.',
					),
					array(
						'title' => 'Multiple Graft Options',
						'text' => 'Autogenous (your own bone), xenograft (bovine), allograft (human donor), or alloplastic (synthetic) — VeaHealth surgeons select the optimal material based on your specific defect size, location, and healing capacity.',
					),
					array(
						'title' => 'Predictable Healing',
						'text' => 'Modern grafting techniques achieve 85–95% graft incorporation rates. With proper surgical technique, membrane protection, and healing time (4–6 months), grafted bone becomes indistinguishable from natural bone on CBCT scans.',
					),
					array(
						'title' => 'Enables Complex Cases',
						'text' => 'Grafting unlocks treatment options for patients previously deemed “not candidates” for implants. Sinus lifts, ridge augmentation, and socket preservation turn hopeless cases into successful full arch restorations.',
					),
				),
			),
			'compare' => array(
				'label' => 'Graft Materials',
				'title' => 'Bone Graft Material Options',
				'intro' => '',
				'head' => array(
					'Material Type',
					'Source',
					'Incorporation Rate',
					'Healing Time',
					'Best For',
				),
				'rows' => array(
					array(
						'label' => 'Autogenous',
						'values' => array(
							array(
								'v' => 'Your own bone',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '95–100%',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => '3–4 months',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'Small to medium defects',
								'good' => false,
								'bad' => false,
							),
						),
					),
					array(
						'label' => 'Xenograft (Bio-Oss)',
						'values' => array(
							array(
								'v' => 'Bovine (cow)',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '85–90%',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => '4–6 months',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'Sinus lifts, large defects',
								'good' => false,
								'bad' => false,
							),
						),
					),
					array(
						'label' => 'Allograft',
						'values' => array(
							array(
								'v' => 'Human donor',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '80–85%',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => '4–6 months',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'Ridge augmentation',
								'good' => false,
								'bad' => false,
							),
						),
					),
					array(
						'label' => 'Alloplastic',
						'values' => array(
							array(
								'v' => 'Synthetic (calcium phosphate)',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '75–80%',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => '5–7 months',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'Budget option, ethical preference',
								'good' => false,
								'bad' => false,
							),
						),
					),
				),
			),
			'procedure' => array(
				'label' => 'Treatment Journey',
				'title' => 'Your Bone Graft Procedure',
				'intro' => 'From consultation to healed graft — the complete process typically requires one visit for surgery followed by 4–6 months of healing before implant placement.',
				'steps' => array(
					array(
						'tag' => 'Pre-Arrival',
						'title' => '3D Assessment',
						'text' => 'Before you travel, VeaHealth coordinates a comprehensive 3D CBCT scan to measure bone volume precisely. Your surgeon calculates the exact amount of graft material needed and confirms the surgical approach.',
						'points' => array(
							'Medical history & video consultation',
							'3D CBCT scan analysis',
							'Bone defect measurement (height/width)',
							'Graft material selection confirmed',
							'Treatment plan & quote finalized',
						),
					),
					array(
						'tag' => 'Day 1 — Istanbul',
						'title' => 'Bone Graft Surgery',
						'text' => 'Under local anesthesia or IV sedation, the graft material is placed at the defect site. A collagen membrane is used to protect the graft. PRF (platelet-rich fibrin) from your own blood is applied to accelerate healing.',
						'points' => array(
							'Local anesthesia or IV sedation',
							'Gum tissue elevation',
							'1cc bone graft material placed',
							'Collagen membrane coverage',
							'PRF application & suturing',
						),
					),
					array(
						'tag' => 'Day 2–7 — Istanbul',
						'title' => 'Initial Recovery',
						'text' => 'You remain in Istanbul for 5–7 days for daily wound checks. Swelling peaks at 48 hours. Your surgeon monitors healing and removes sutures before you return home.',
						'points' => array(
							'Daily wound inspection',
							'Pain management with medication',
							'Soft diet protocol',
							'Suture removal (day 7–10)',
							'Post-op instructions reviewed',
						),
					),
					array(
						'tag' => 'Month 1–6',
						'title' => 'Bone Integration',
						'text' => 'The graft material slowly integrates with your natural bone over 4–6 months. You maintain the site with gentle oral hygiene. VeaHealth monitors your healing remotely via photos and video check-ins.',
						'points' => array(
							'Graft material ossifies gradually',
							'Gentle brushing around site',
							'No smoking or alcohol',
							'Remote monitoring every 2 weeks',
							'No travel required during healing',
						),
					),
					array(
						'tag' => 'Month 6+ — Ready for Implant',
						'title' => 'Verification & Implant Placement',
						'text' => 'After 4–6 months, a new CBCT scan confirms graft incorporation. Once healed, you’re ready for implant placement — the original reason for grafting. Your implant can now succeed in the rebuilt bone.',
						'points' => array(
							'Follow-up CBCT scan',
							'Graft integration verified',
							'Bone volume measured',
							'Implant placement scheduled',
							'Final treatment phase begins',
						),
					),
				),
			),
			'cost' => array(
				'label' => 'Transparent Pricing',
				'title' => 'What You’ll Pay — Guaranteed',
				'intro' => 'VeaHealth locks in your price before travel. All costs include 3D scan, surgery, premium graft material, PRF, membrane, and follow-up monitoring.',
				'tiers' => array(
					array(
						'where' => 'UK / US',
						'price' => '£900+',
						'note' => 'per 1cc graft',
						'features' => array(
							'Standard bone graft material',
							'Basic surgical procedure',
							'Collagen membrane',
							'Follow-up visit',
							'No travel support',
						),
					),
					array(
						'where' => 'VeaHealth Istanbul',
						'price' => '£280',
						'note' => 'all-inclusive',
						'features' => array(
							'Premium graft (Bio-Oss or Cerabone)',
							'3D CBCT scan & planning',
							'Advanced surgical technique',
							'PRF (platelet-rich fibrin) included',
							'Collagen membrane coverage',
							'Post-op monitoring (6 months)',
							'Airport VIP transfers',
							'Hotel coordination support',
							'24/7 VeaHealth concierge',
						),
					),
					array(
						'where' => 'Europe',
						'price' => '€550+',
						'note' => 'per 1cc graft',
						'features' => array(
							'Mid-range graft material',
							'Standard procedure',
							'Membrane included',
							'Limited follow-up',
							'Minimal travel assistance',
						),
					),
				),
			),
			'recovery' => array(
				'label' => 'Post-Treatment',
				'title' => 'Recovery & Healing',
				'intro' => 'Bone graft recovery is gradual and predictable. Most patients return to normal activities within 7–10 days, with full graft integration achieved in 4–6 months.',
				'phases' => array(
					array(
						'n' => '1',
						'title' => 'Immediate Post-Op',
						'text' => '',
						'points' => array(
							'Swelling peaks at 48 hours',
							'Bruising may appear (normal)',
							'Soft/liquid diet only',
							'Pain managed with medication',
							'Daily wound checks in Istanbul',
						),
					),
					array(
						'n' => '2',
						'title' => 'Early Healing',
						'text' => '',
						'points' => array(
							'Swelling resolves completely',
							'Sutures dissolve or removed',
							'Gradual return to soft solids',
							'Gentle brushing around site',
							'Remote VeaHealth monitoring',
						),
					),
					array(
						'n' => '3',
						'title' => 'Graft Integration',
						'text' => '',
						'points' => array(
							'Bone formation progressing',
							'Normal diet resumed',
							'Graft stabilizing',
							'No smoking or alcohol',
							'Monthly photo updates to clinic',
						),
					),
					array(
						'n' => '4',
						'title' => 'Full Incorporation',
						'text' => '',
						'points' => array(
							'Graft fully integrated',
							'CBCT scan confirms healing',
							'Bone volume restored',
							'Ready for implant placement',
							'85–95% graft success rate',
						),
					),
				),
			),
			'evidence' => array(
				'label' => 'Clinical Evidence',
				'title' => 'What the Studies Show',
				'intro' => '',
				'items' => array(
					array(
						'figure' => '85–95%',
						'text' => 'Graft incorporation success rate with modern techniques and materials — confirming that bone grafting is a predictable procedure when proper surgical protocols are followed.',
						'source' => 'Systematic review · Bone grafting outcomes',
					),
					array(
						'figure' => '25%',
						'text' => 'Annual bone loss rate after tooth extraction without grafting — underscoring why immediate socket preservation is critical for maintaining future implant options.',
						'source' => 'Journal of Periodontology · Alveolar ridge resorption',
					),
					array(
						'figure' => '95%+',
						'text' => 'Implant success rate in grafted sites that have fully healed — matching or exceeding success rates in native bone when adequate healing time (4–6 months) is allowed.',
						'source' => 'Clinical Oral Implants Research · Grafted site outcomes',
					),
				),
			),
			'faq' => array(
				'label' => 'Patient Questions',
				'title' => 'Frequently Asked Questions',
				'intro' => '',
				'items' => array(
					array(
						'q' => 'Is bone grafting painful?',
						'a' => 'The procedure is performed under local anesthesia or IV sedation — no pain during surgery. Post-op discomfort (soreness, swelling) peaks at 48 hours and is managed with prescribed pain medication. Most patients describe it as less painful than a tooth extraction.',
					),
					array(
						'q' => 'How long does bone graft healing take?',
						'a' => 'Full graft incorporation takes 4–6 months depending on the material and defect size. Autogenous grafts heal fastest (3–4 months), while xenografts typically need 5–6 months. A follow-up CBCT scan confirms healing before implant placement.',
					),
					array(
						'q' => 'Can the graft and implant be done at the same time?',
						'a' => 'In some cases, yes — if the defect is small (< 2mm) and the implant achieves good primary stability. However, larger defects require staged treatment: graft first, wait 4–6 months for healing, then place the implant. VeaHealth\'s surgeons assess this during pre-treatment planning.',
					),
					array(
						'q' => 'What if my body rejects the graft?',
						'a' => 'True graft rejection is extremely rare (< 2%) with modern materials. Most "failures" are due to infection, smoking, or inadequate blood supply — not immune rejection. Bio-Oss and other xenografts are processed to remove all antigenic proteins, making rejection nearly impossible.',
					),
					array(
						'q' => 'How many trips to Istanbul are required?',
						'a' => 'One visit for the bone graft surgery (5–7 days), then you return home to heal for 4–6 months. After healing is confirmed via CBCT scan, a second visit is needed for implant placement. The entire timeline from graft to final crown is typically 10–12 months.',
					),
					array(
						'q' => 'Is the warranty valid internationally?',
						'a' => 'Yes. VeaHealth’s graft warranty covers surgical complications and graft failure within 6 months of placement. Full documentation is provided. If a warranty issue arises after you return home, VeaHealth coordinates resolution remotely or via a local affiliated clinic.',
					),
					array(
						'q' => 'What graft material will be used?',
						'a' => 'VeaHealth uses premium materials like Bio-Oss (xenograft) or Cerabone depending on your specific case. The material is confirmed in your treatment plan. Autogenous grafts (your own bone) are also available if preferred, harvested from the chin or ramus area.',
					),
					array(
						'q' => 'Can smokers receive bone grafts?',
						'a' => 'Smokers can receive grafts, but tobacco significantly reduces success rates by impairing healing and blood flow. VeaHealth strongly recommends stopping smoking at least 4 weeks before and 6 months after surgery. Compliance with smoking cessation measurably improves graft incorporation.',
					),
				),
			),
		),
		array(
			'slug' => 'sinus-lift',
			'title' => 'Sinus Lift',
			'h1' => 'Sinus Lift Surgery in Istanbul',
			'lead' => 'Maxillary sinus augmentation creates space for dental implants in the posterior upper jaw. Premium bone graft materials, 3D-guided precision, and expert oral surgeons. VeaHealth coordinates your complete sinus lift journey in Turkey.',
			'trust' => array(
				'CBCT 3D-guided surgery',
				'Premium bone graft materials',
				'4–6 months healing before implants',
				'International warranty included',
			),
			'price' => '£850',
			'price_note' => 'All-inclusive sinus lift per side — lateral window technique, premium bone graft, collagen membrane, CBCT scan, and post-op monitoring.',
			'stats' => array(
				array(
					'v' => '70%',
					'k' => 'vs UK Cost',
				),
				array(
					'v' => '95%+',
					'k' => 'Success Rate',
				),
			),
			'image' => 'sinus-lift-3d-render.webp',
			'caveat' => '',
			'review_note' => '',
			'why' => array(
				'label' => 'Essential Pre-Implant Procedure',
				'title' => 'Why Sinus Lift Surgery?',
				'intro' => 'When bone height is insufficient in the posterior upper jaw, a sinus lift creates the vertical space needed for stable implant placement. It’s the gold standard for restoring back teeth in patients with bone loss.',
				'cards' => array(
					array(
						'title' => 'Insufficient Bone Height',
						'text' => 'After tooth loss, the maxillary sinus floor often descends, leaving only 4–6mm of bone — too little for a standard 10mm implant. Sinus lift adds 8–12mm of height, enabling proper implant placement.',
					),
					array(
						'title' => 'Premium Bone Graft',
						'text' => 'VeaHealth uses xenograft (bovine), allograft (human donor), or synthetic bone materials — all proven for maxillary sinus augmentation with >95% success rates in long-term studies.',
					),
					array(
						'title' => 'Predictable Implant Success',
						'text' => 'Implants placed in grafted sinus bone achieve 95–98% survival rates at 10 years — statistically identical to implants in native bone, when proper healing time is allowed.',
					),
					array(
						'title' => '3D-Guided Precision',
						'text' => 'CBCT cone beam imaging maps sinus anatomy in 3D before surgery, allowing the surgeon to plan the optimal window position, avoid Schneiderian membrane perforation, and achieve ideal bone graft volume.',
					),
					array(
						'title' => 'Minimal Downtime',
						'text' => 'Most patients return to work within 3–5 days. Swelling peaks at 48–72 hours and resolves within a week. The graft itself heals over 4–6 months before implant placement.',
					),
					array(
						'title' => '70% Cost Savings',
						'text' => 'Sinus lift in Istanbul costs £850–1,200 vs £2,800–4,500 in the UK. Same materials, same techniques, same success rates — coordinated start to finish by VeaHealth.',
					),
				),
			),
			'procedure' => array(
				'label' => 'Treatment Journey',
				'title' => 'Your Sinus Lift Procedure',
				'intro' => 'From 3D planning to bone graft maturation and implant placement — typically 6–9 months total timeline.',
				'steps' => array(
					array(
						'tag' => 'Pre-Arrival',
						'title' => 'CBCT 3D Planning',
						'text' => 'VeaHealth coordinates a comprehensive CBCT cone beam scan to measure bone height, sinus anatomy, and membrane thickness. Your surgeon designs the optimal lateral window position and graft volume virtually.',
						'points' => array(
							'3D sinus floor mapping',
							'Bone height measurement at implant sites',
							'Schneiderian membrane evaluation',
							'Lateral vs crestal approach decided',
							'Travel & accommodation arranged',
						),
					),
					array(
						'tag' => 'Day 1 — Istanbul',
						'title' => 'Sinus Lift Surgery',
						'text' => 'Under local anesthesia or IV sedation, the lateral window is created using piezoelectric instruments. The Schneiderian membrane is gently elevated. Bone graft material fills the space beneath the membrane. A resorbable collagen membrane seals the window.',
						'points' => array(
							'Local anesthesia or IV sedation',
							'Lateral window created (10×15mm)',
							'Membrane lifted without perforation',
							'Xenograft/allograft/synthetic bone packed',
							'Collagen membrane placed',
							'Wound sutured — post-op meds provided',
						),
					),
					array(
						'tag' => 'Month 1–6',
						'title' => 'Bone Graft Maturation',
						'text' => 'The graft consolidates over 4–9 months. Xenograft particles act as a scaffold for your natural bone to grow into. VeaHealth monitors healing remotely with CBCT scans at 3 and 6 months to confirm graft integration.',
						'points' => array(
							'Soft foods for 2 weeks',
							'No nose-blowing for 4 weeks (critical)',
							'Remote check-ins every 2 weeks',
							'CBCT at month 3 & 6 to assess bone quality',
							'Graft fully matures by month 6–9',
						),
					),
					array(
						'tag' => 'Month 6–9 — Return Visit',
						'title' => 'Implant Placement',
						'text' => 'Once CBCT confirms the graft has consolidated into mature bone, you return to Istanbul for dental implant placement. The implants engage both the graft and native bone for optimal stability.',
						'points' => array(
							'Final CBCT confirms bone density',
							'Implants placed into grafted bone',
							'Standard osseointegration (3–4 months)',
							'Crown/bridge fitted after integration',
							'Lifetime warranty on implants',
						),
					),
				),
			),
			'cost' => array(
				'label' => 'Transparent Pricing',
				'title' => 'What You’ll Pay — Guaranteed',
				'intro' => 'VeaHealth locks in your price before travel. All costs include CBCT, surgery, bone graft, collagen membrane, and post-op monitoring.',
				'tiers' => array(
					array(
						'where' => 'UK / US',
						'price' => '£2,800+',
						'note' => 'per sinus lift side',
						'features' => array(
							'Lateral window technique',
							'Standard bone graft',
							'CBCT scan',
							'Post-op follow-up (1–2 visits)',
							'6-month monitoring',
						),
					),
					array(
						'where' => 'VeaHealth Istanbul',
						'price' => '£850',
						'note' => 'all-inclusive per side',
						'features' => array(
							'3D-guided lateral window technique',
							'Premium xenograft/allograft bone',
							'Resorbable collagen membrane',
							'CBCT scan pre & post-op',
							'Specialist oral surgeon',
							'6-month remote monitoring',
							'Post-op medication included',
							'Airport VIP transfer',
							'Hotel support coordination',
							'24/7 VeaHealth concierge',
						),
					),
					array(
						'where' => 'Europe',
						'price' => '€1,800+',
						'note' => 'per sinus lift side',
						'features' => array(
							'Standard lateral technique',
							'Mid-range bone graft',
							'CBCT scan',
							'Follow-up appointments',
							'3–6 month monitoring',
						),
					),
				),
			),
			'recovery' => array(
				'label' => 'Afterwards',
				'title' => 'Recovery, week by week',
				'intro' => '',
				'phases' => array(
					array(
						'n' => 'Days 1–3',
						'title' => 'The first days',
						'text' => 'Swelling and some bruising below the eye are expected after a lateral window lift. Bleeding from the nose on that side can happen and is not an emergency.',
						'points' => array(
							'Cold compresses, head raised',
							'Do not blow your nose — open your mouth to sneeze',
							'Soft, cool food',
							'Antibiotics finished as prescribed',
						),
					),
					array(
						'n' => 'Weeks 1–2',
						'title' => 'Healing over',
						'text' => 'Sutures come out or dissolve. The sinus membrane is healing and the graft is stabilising underneath it.',
						'points' => array(
							'Still no nose-blowing',
							'No flying if you can avoid it in the first week',
							'No straws, no smoking',
						),
					),
					array(
						'n' => 'Months 4–9',
						'title' => 'The graft matures',
						'text' => 'Bone graft becomes bone capable of holding an implant. The wait is the whole point of the procedure and it cannot be shortened.',
						'points' => array(
							'Scan before implants are placed',
							'Remote review in the meantime',
							'Implant placement scheduled from the scan, not the calendar',
						),
					),
					array(
						'n' => 'Afterwards',
						'title' => 'Implants',
						'text' => 'Once the scan shows adequate height and density, implants are placed as a separate, much smaller procedure.',
						'points' => array(
							'A second, shorter trip',
							'Usually straightforward once the graft has taken',
						),
					),
				),
			),
			'faq' => array(
				'label' => 'Patient Questions',
				'title' => 'Frequently Asked Questions',
				'intro' => '',
				'items' => array(
					array(
						'q' => 'What is a sinus lift and when is it needed?',
						'a' => 'A sinus lift (maxillary sinus augmentation) is a surgical procedure that adds bone to the upper jaw beneath the sinus cavity. It’s needed when there is insufficient bone height to place dental implants in the posterior upper jaw — typically after tooth loss causes bone resorption and sinus floor descent.',
					),
					array(
						'q' => 'How long does a sinus lift take to heal?',
						'a' => 'Bone graft maturation takes 4–9 months depending on graft material and volume. Lateral window sinus lifts typically require 6–9 months before implant placement. Crestal sinus lifts heal faster (4–6 months) because implants are placed simultaneously with less graft volume.',
					),
					array(
						'q' => 'Is sinus lift surgery painful?',
						'a' => 'The procedure itself is performed under local anesthesia or IV sedation — you won’t feel pain during surgery. Post-operative discomfort is typically mild to moderate, managed with prescribed pain medication. Swelling peaks at 48–72 hours and resolves within a week. Most patients return to work within 3–5 days.',
					),
					array(
						'q' => 'What is the success rate of sinus lift surgery?',
						'a' => 'Sinus lift surgery has a >95% success rate when performed by experienced oral surgeons. Implants placed in grafted sinus bone achieve 95–98% survival at 10 years — statistically identical to implants in native bone. The most critical factor is allowing adequate healing time before implant loading.',
					),
					array(
						'q' => 'Can implants be placed at the same time as the sinus lift?',
						'a' => 'Yes, if ≥5mm of existing bone remains. This is called simultaneous placement. The implant is placed into the residual bone, and the sinus lift adds height around it. If <4mm bone exists, a staged approach is recommended: sinus lift first, implants 6–9 months later once the graft has consolidated.',
					),
					array(
						'q' => 'What bone graft materials does VeaHealth use?',
						'a' => 'VeaHealth uses premium xenograft (bovine-derived bone particles), allograft (processed human donor bone), or synthetic bone substitutes — all FDA/CE-approved and proven for maxillary sinus augmentation. Your surgeon selects the optimal material based on graft volume needed and healing timeline preferences.',
					),
					array(
						'q' => 'What are the risks of sinus lift surgery?',
						'a' => 'The primary risk is Schneiderian membrane perforation (occurs in 10–30% of cases, usually repaired immediately without consequence). Infection risk is <2% with antibiotic prophylaxis. Sinusitis is rare if post-op instructions are followed (no nose-blowing for 4 weeks). Graft failure is uncommon (<5%) in non-smokers with good oral hygiene.',
					),
					array(
						'q' => 'How many trips to Istanbul are required?',
						'a' => 'Two visits: the first for sinus lift surgery (3–5 days in Istanbul), and a second visit 6–9 months later for implant placement (5–7 days). The entire graft healing phase is monitored remotely by VeaHealth with CBCT scans at 3 and 6 months — no travel required during consolidation.',
					),
				),
			),
		),
		array(
			'slug' => 'onlay-inlay',
			'title' => 'Inlay & Onlay',
			'h1' => 'Dental Inlay & Onlay in Istanbul',
			'lead' => 'Premium porcelain or zirconia indirect restorations. Precision-fit lab-crafted fillings that preserve maximum tooth structure while delivering natural aesthetics and superior strength. VeaHealth coordinates your complete treatment journey.',
			'trust' => array(
				'Porcelain or zirconia material',
				'Precision CAD/CAM fit',
				'Maximum tooth preservation',
				'5-year warranty included',
			),
			'price' => '£180',
			'price_note' => 'Per inlay/onlay — porcelain or zirconia, CAD/CAM precision milling, two-visit procedure, and warranty included.',
			'stats' => array(
				array(
					'v' => '70%',
					'k' => 'vs UK Cost',
				),
				array(
					'v' => '10–15',
					'k' => 'Year Lifespan',
				),
			),
			'image' => 'ceramic-veneers-macro.webp',
			'caveat' => '',
			'review_note' => '',
			'why' => array(
				'label' => 'Indirect Restorations',
				'title' => 'Why Choose Inlay & Onlay Over Direct Fillings',
				'intro' => 'Inlays and onlays are precision-crafted in a lab, offering superior fit, strength, and aesthetics compared to direct composite fillings — ideal for moderate to large cavities.',
				'cards' => array(
					array(
						'title' => 'Precise Laboratory Fit',
						'text' => 'Unlike chair-side fillings, inlays and onlays are fabricated in a dental lab using digital impressions for a precision fit that eliminates gaps and minimizes future decay risk.',
					),
					array(
						'title' => 'Superior Strength',
						'text' => 'Porcelain and zirconia inlays/onlays are stronger than composite fillings, resisting fracture and wear. They can withstand heavy chewing forces for 10–15+ years with proper care.',
					),
					array(
						'title' => 'Natural Aesthetics',
						'text' => 'Porcelain and zirconia perfectly mimic tooth enamel — matching color, translucency, and sheen. They don’t stain or discolor over time like composite fillings.',
					),
					array(
						'title' => 'Tooth Structure Preservation',
						'text' => 'Inlays and onlays require less tooth removal than crowns. They restore damaged areas while preserving healthy enamel — a more conservative long-term approach.',
					),
					array(
						'title' => 'Longer Lifespan',
						'text' => 'Clinical studies show inlays and onlays last 10–15+ years on average — significantly longer than composite fillings, which typically need replacement every 5–7 years.',
					),
					array(
						'title' => 'Better Value Long-Term',
						'text' => 'Though initially costlier than fillings, inlays and onlays eliminate the need for repeated replacements — making them more economical over a 15-year period.',
					),
				),
			),
			'compare' => array(
				'label' => 'Treatment Comparison',
				'title' => 'Inlay/Onlay vs. Other Options',
				'intro' => '',
				'head' => array(
					'Feature',
					'Inlay / Onlay',
					'Composite Filling',
					'Dental Crown',
				),
				'rows' => array(
					array(
						'label' => 'Material',
						'values' => array(
							array(
								'v' => 'Porcelain or zirconia',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Composite resin',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'Porcelain, zirconia, metal',
								'good' => true,
								'bad' => false,
							),
						),
					),
					array(
						'label' => 'Fabrication',
						'values' => array(
							array(
								'v' => 'Lab-crafted (CAD/CAM)',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Chair-side direct',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'Lab-crafted',
								'good' => true,
								'bad' => false,
							),
						),
					),
					array(
						'label' => 'Tooth Removal',
						'values' => array(
							array(
								'v' => 'Minimal',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Minimal',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Significant (1.5–2mm)',
								'good' => false,
								'bad' => true,
							),
						),
					),
					array(
						'label' => 'Precision Fit',
						'values' => array(
							array(
								'v' => 'Excellent',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Moderate',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'Excellent',
								'good' => true,
								'bad' => false,
							),
						),
					),
					array(
						'label' => 'Strength',
						'values' => array(
							array(
								'v' => 'Very high',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Moderate',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'Highest',
								'good' => true,
								'bad' => false,
							),
						),
					),
					array(
						'label' => 'Stain Resistance',
						'values' => array(
							array(
								'v' => 'Excellent',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Moderate',
								'good' => false,
								'bad' => true,
							),
							array(
								'v' => 'Excellent',
								'good' => true,
								'bad' => false,
							),
						),
					),
					array(
						'label' => 'Appointments',
						'values' => array(
							array(
								'v' => '2 visits',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '1 visit',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => '2 visits',
								'good' => false,
								'bad' => false,
							),
						),
					),
					array(
						'label' => 'Average Lifespan',
						'values' => array(
							array(
								'v' => '10–15+ years',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => '5–7 years',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '15–20+ years',
								'good' => true,
								'bad' => false,
							),
						),
					),
					array(
						'label' => 'Best For',
						'values' => array(
							array(
								'v' => 'Moderate cavities',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Small cavities',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'Severely damaged teeth',
								'good' => false,
								'bad' => false,
							),
						),
					),
					array(
						'label' => 'Istanbul Cost (VeaHealth)',
						'values' => array(
							array(
								'v' => '£180',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => '£60',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '£200',
								'good' => false,
								'bad' => false,
							),
						),
					),
				),
			),
			'procedure' => array(
				'label' => 'Treatment Journey',
				'title' => 'Your Inlay/Onlay Procedure',
				'intro' => 'Standard two-visit protocol — first visit for preparation and impression, second visit one week later for permanent bonding.',
				'steps' => array(
					array(
						'tag' => 'Visit 1 — Day 1',
						'title' => 'Tooth Preparation & Digital Impression',
						'text' => 'Decay is removed and the cavity is prepared with precise margins. A digital 3D scan captures the exact shape and size of the prepared cavity. A temporary filling protects the tooth for one week.',
						'points' => array(
							'Local anesthesia for comfort',
							'Decay removal & cavity prep',
							'Digital intraoral scan taken',
							'Temporary filling placed',
							'Lab fabrication begins (5–7 days)',
						),
					),
					array(
						'tag' => 'Lab Phase — Days 2–7',
						'title' => 'CAD/CAM Fabrication',
						'text' => 'Your inlay or onlay is digitally designed and milled from a solid block of porcelain or zirconia in VeaHealth’s partner lab. Color is precisely matched to your natural tooth shade.',
						'points' => array(
							'Digital design in CAD software',
							'CAM milling from solid block',
							'Shade matching & glazing',
							'Quality control inspection',
							'Sterilization & packaging',
						),
					),
					array(
						'tag' => 'Visit 2 — Day 7–10',
						'title' => 'Permanent Bonding',
						'text' => 'The temporary filling is removed. Your custom inlay/onlay is tried in to verify fit and bite. Once confirmed, it’s permanently bonded using dental adhesive. Final polishing ensures a smooth, natural feel.',
						'points' => array(
							'Temporary filling removed',
							'Inlay/onlay fit verification',
							'Bite adjustment if needed',
							'Permanent adhesive bonding',
							'Final polishing & care instructions',
						),
					),
				),
			),
			'cost' => array(
				'label' => 'Transparent Pricing',
				'title' => 'What You’ll Pay — Guaranteed',
				'intro' => 'VeaHealth locks in your price before travel. All costs include preparation, lab fabrication, temporary restoration, permanent bonding, and warranty.',
				'tiers' => array(
					array(
						'where' => 'UK / US',
						'price' => '£600+',
						'note' => 'per inlay/onlay',
						'features' => array(
							'Standard porcelain inlay/onlay',
							'Two-visit procedure',
							'Basic warranty (1–2 years)',
						),
					),
					array(
						'where' => 'VeaHealth Istanbul',
						'price' => '£180',
						'note' => 'all-inclusive per restoration',
						'features' => array(
							'Porcelain or zirconia material',
							'Digital 3D scanning',
							'CAD/CAM precision milling',
							'Temporary restoration included',
							'Permanent adhesive bonding',
							'5-year warranty',
							'VeaHealth coordination',
							'Hotel support if needed',
						),
					),
					array(
						'where' => 'Europe',
						'price' => '€350+',
						'note' => 'per inlay/onlay',
						'features' => array(
							'Standard ceramic restoration',
							'Two-visit protocol',
							'Standard warranty (2 years)',
						),
					),
				),
			),
			'recovery' => array(
				'label' => 'Afterwards',
				'title' => 'Recovery, week by week',
				'intro' => '',
				'phases' => array(
					array(
						'n' => 'First 24 hours',
						'title' => 'The anaesthetic wears off',
						'text' => 'Numbness lasts two to three hours. Eat once you can feel your lip again, or you will bite it.',
						'points' => array(
							'Avoid chewing on that side until sensation returns',
							'Mild sensitivity to cold is normal',
							'No restriction on speaking or normal activity',
						),
					),
					array(
						'n' => 'Days 1–7',
						'title' => 'Settling in',
						'text' => 'The restoration is bonded and fully functional immediately. Any sensitivity to temperature settles over the first week.',
						'points' => array(
							'Eat normally from the same day',
							'Brush and floss as usual, gently at the margin',
							'Sensitivity that worsens rather than settles: tell your coordinator',
						),
					),
					array(
						'n' => 'Weeks 2–4',
						'title' => 'Bite adjustment',
						'text' => 'If the bite feels even slightly high, it needs adjusting. It will not wear in on its own and leaving it stresses the tooth.',
						'points' => array(
							'Report any high spot rather than living with it',
							'Adjustment takes minutes and costs nothing',
						),
					),
					array(
						'n' => 'Long term',
						'title' => 'Maintenance',
						'text' => 'A bonded ceramic restoration is maintained exactly like a natural tooth. It is the margin that fails first, and that is what the check-ups look at.',
						'points' => array(
							'Six-monthly examination',
							'Floss the margin daily',
							'A night guard if you grind',
						),
					),
				),
			),
			'faq' => array(
				'label' => 'Patient Questions',
				'title' => 'Frequently Asked Questions',
				'intro' => '',
				'items' => array(
					array(
						'q' => 'What is the difference between an inlay and an onlay?',
						'a' => 'An inlay fits within the tooth’s cusps (the raised points) and is used when the cusps are still structurally sound. An onlay extends over one or more cusps to provide additional protection and strength when the cusps are weakened. Your dentist will determine which is appropriate based on the extent of damage.',
					),
					array(
						'q' => 'How long do inlays and onlays last?',
						'a' => 'With proper care, porcelain and zirconia inlays/onlays last 10–15+ years on average — significantly longer than composite fillings (5–7 years). Longevity depends on oral hygiene, bite forces, and avoiding habits like grinding or chewing ice.',
					),
					array(
						'q' => 'Is the procedure painful?',
						'a' => 'No. Both visits are performed under local anesthesia. You’ll feel pressure during preparation but no pain. Some sensitivity is normal for a few days after bonding as the tooth adjusts to the new restoration.',
					),
					array(
						'q' => 'Porcelain or zirconia — which is better?',
						'a' => 'Porcelain offers superior aesthetics and is ideal for visible teeth (premolars, upper molars). Zirconia is stronger and better for back molars that endure heavy chewing forces. VeaHealth’s dentists will recommend the optimal material based on the tooth location and your bite.',
					),
					array(
						'q' => 'Can I eat normally after the procedure?',
						'a' => 'Yes. After the temporary filling (first visit), stick to soft foods on the opposite side. Once the permanent inlay/onlay is bonded (second visit), you can resume normal eating within 24 hours. Avoid extremely hard foods like ice or hard candy to prevent chipping.',
					),
					array(
						'q' => 'How many days in Istanbul are required?',
						'a' => 'Standard protocol requires 7–10 days total. First appointment for preparation and scan, then a 5–7 day wait while the lab fabricates your restoration, then the second appointment for permanent bonding. VeaHealth can arrange hotel accommodations and sightseeing tours during the wait.',
					),
					array(
						'q' => 'Is the warranty valid internationally?',
						'a' => 'Yes. VeaHealth’s 5-year warranty on inlays and onlays is valid worldwide. If a restoration fails due to defect or bonding failure, VeaHealth coordinates repair or replacement — either remotely via a partner clinic in your country or with a return visit to Istanbul.',
					),
					array(
						'q' => 'Why is it so much cheaper in Istanbul?',
						'a' => 'Lower operating costs (lab fees, rent, staff salaries) in Turkey allow VeaHealth to offer the same premium materials and techniques at 60–70% less than UK/US prices. The quality is identical — same porcelain and zirconia brands, same CAD/CAM technology, same clinical standards.',
					),
				),
			),
		),
		array(
			'slug' => 'night-guard',
			'title' => 'Night Guard',
			'h1' => 'Custom Night Guard in Istanbul',
			'lead' => 'Protect your teeth from grinding (bruxism) and jaw disorders (TMJ) with a professionally fitted custom night guard. Premium materials, precise fit, long-lasting protection. VeaHealth coordinates your complete dental care journey.',
			'trust' => array(
				'Custom-fitted for perfect comfort',
				'Premium medical-grade materials',
				'Prevents tooth wear & TMJ pain',
				'2–3 year lifespan with care',
			),
			'price' => '£120',
			'price_note' => 'All-inclusive custom night guard package — consultation, digital impressions, lab fabrication, fitting, and case included.',
			'stats' => array(
				array(
					'v' => '70%',
					'k' => 'vs UK Cost',
				),
				array(
					'v' => '2–3',
					'k' => 'Year Lifespan',
				),
			),
			'image' => 'night-guard-macro.webp',
			'caveat' => '',
			'review_note' => '',
			'why' => array(
				'label' => 'Essential Protection',
				'title' => 'Why Custom Night Guards Are Essential',
				'intro' => 'Custom night guards protect against teeth grinding (bruxism) and TMJ disorders — preventing thousands in future dental damage while improving sleep quality and reducing jaw pain.',
				'cards' => array(
					array(
						'title' => 'Prevents Tooth Damage',
						'text' => 'Grinding generates up to 250 pounds of force — enough to crack enamel, wear down teeth, and break fillings and crowns. A night guard absorbs this force, preventing thousands in future restorative work.',
					),
					array(
						'title' => 'Relieves TMJ Pain',
						'text' => 'By preventing clenching, night guards reduce stress on the temporomandibular joint (TMJ). Patients report significant reduction in jaw pain, headaches, and facial tension within 2–3 weeks of consistent use.',
					),
					array(
						'title' => 'Improves Sleep Quality',
						'text' => 'Grinding disrupts REM sleep for both you and your partner. A properly fitted guard reduces grinding frequency and intensity, leading to deeper sleep, less morning fatigue, and improved cognitive function.',
					),
					array(
						'title' => 'Cost-Effective Prevention',
						'text' => 'A £120 night guard prevents £3,000–8,000 in future dental work (crowns, root canals, implants). Insurance actuaries calculate that every £1 spent on prevention saves £25 in restorative treatment over 10 years.',
					),
					array(
						'title' => 'Perfect Custom Fit',
						'text' => 'Unlike over-the-counter guards, custom guards are fabricated from precise digital impressions of your teeth. This ensures perfect retention, comfort, and effectiveness — no gagging, slipping, or jaw soreness.',
					),
					array(
						'title' => 'Durable & Hygienic',
						'text' => 'Medical-grade acrylic resists bacteria, staining, and odors. With proper cleaning (daily rinse, weekly soak), your guard remains hygienic and functional for 2–3 years — far longer than drugstore alternatives.',
					),
				),
			),
			'compare' => array(
				'label' => 'Treatment Comparison',
				'title' => 'Custom vs. Over-the-Counter Guards',
				'intro' => '',
				'head' => array(
					'Feature',
					'Custom Night Guard',
					'OTC Boil-and-Bite',
					'OTC One-Size',
					'No Protection',
				),
				'rows' => array(
					array(
						'label' => 'Fit & Comfort',
						'values' => array(
							array(
								'v' => 'Perfect (custom-molded)',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Moderate (DIY fit)',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'Poor (bulky)',
								'good' => false,
								'bad' => true,
							),
							array(
								'v' => 'N/A',
								'good' => false,
								'bad' => true,
							),
						),
					),
					array(
						'label' => 'Protection Level',
						'values' => array(
							array(
								'v' => 'Excellent (3mm thickness)',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Good (variable thickness)',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'Fair (thin material)',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'None (progressive damage)',
								'good' => false,
								'bad' => true,
							),
						),
					),
					array(
						'label' => 'Speaking Ability',
						'values' => array(
							array(
								'v' => 'Easy (low profile)',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Difficult (bulky)',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'Very difficult',
								'good' => false,
								'bad' => true,
							),
							array(
								'v' => 'N/A',
								'good' => false,
								'bad' => true,
							),
						),
					),
					array(
						'label' => 'Breathing Comfort',
						'values' => array(
							array(
								'v' => 'Unrestricted',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Somewhat restricted',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'Restricted',
								'good' => false,
								'bad' => true,
							),
							array(
								'v' => 'N/A',
								'good' => false,
								'bad' => true,
							),
						),
					),
					array(
						'label' => 'Retention',
						'values' => array(
							array(
								'v' => 'Stays in place all night',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'May slip during sleep',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'Often falls out',
								'good' => false,
								'bad' => true,
							),
							array(
								'v' => 'N/A',
								'good' => false,
								'bad' => true,
							),
						),
					),
					array(
						'label' => 'Lifespan',
						'values' => array(
							array(
								'v' => '2–3 years',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => '6–12 months',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '3–6 months',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'Permanent tooth damage',
								'good' => false,
								'bad' => true,
							),
						),
					),
					array(
						'label' => 'Material Quality',
						'values' => array(
							array(
								'v' => 'Medical-grade acrylic',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Standard thermoplastic',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'Soft silicone (wears fast)',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'N/A',
								'good' => false,
								'bad' => true,
							),
						),
					),
					array(
						'label' => 'Istanbul Cost',
						'values' => array(
							array(
								'v' => '£120',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => '£30–50',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '£10–20',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '£3,000–8,000 in future damage',
								'good' => false,
								'bad' => true,
							),
						),
					),
				),
			),
			'procedure' => array(
				'label' => 'Simple Process',
				'title' => 'Getting Your Custom Night Guard',
				'intro' => 'From consultation to fitting — the entire process takes just 2–3 days in Istanbul.',
				'steps' => array(
					array(
						'tag' => 'Day 1 — Morning',
						'title' => 'Consultation & Examination',
						'text' => 'Your dentist evaluates your teeth for signs of grinding damage — worn enamel, micro-cracks, and jaw alignment. Digital photos document baseline condition. Treatment plan is confirmed.',
						'points' => array(
							'Comprehensive oral examination',
							'TMJ assessment',
							'Grinding damage evaluation',
							'Photos for records',
							'Material selection (soft/hard acrylic)',
						),
					),
					array(
						'tag' => 'Day 1 — Afternoon',
						'title' => 'Digital Impressions',
						'text' => 'Using an intraoral scanner, your dentist takes precise 3D impressions of your upper and lower teeth. No messy putty — just a quick digital scan. Bite registration ensures proper jaw alignment.',
						'points' => array(
							'Digital 3D scan (5 minutes)',
							'Bite registration taken',
							'Jaw movement analysis',
							'Data sent to lab instantly',
							'No gagging or discomfort',
						),
					),
					array(
						'tag' => 'Day 2',
						'title' => 'Lab Fabrication',
						'text' => 'The lab uses your digital impressions to mill a precision night guard from medical-grade acrylic. CAD/CAM technology ensures perfect fit. The guard is polished, sanitized, and quality-checked.',
						'points' => array(
							'3D model created from scan',
							'Guard milled to exact specifications',
							'Thickness optimized (2.5–3mm)',
							'Edges smoothed and polished',
							'Quality control inspection',
						),
					),
					array(
						'tag' => 'Day 3',
						'title' => 'Fitting & Adjustment',
						'text' => 'You return to try on your custom guard. Your dentist checks fit, comfort, and bite alignment. Minor adjustments are made if needed. You receive care instructions and a protective case.',
						'points' => array(
							'Guard try-in and fit verification',
							'Bite adjustment if needed',
							'Comfort assessment',
							'Care instructions provided',
							'Protective case & cleaning brush included',
						),
					),
				),
			),
			'cost' => array(
				'label' => 'Transparent Pricing',
				'title' => 'What You’ll Pay — Guaranteed',
				'intro' => 'VeaHealth locks in your price before travel. All costs include consultation, digital impressions, lab fabrication, fitting, and protective case.',
				'tiers' => array(
					array(
						'where' => 'UK / US',
						'price' => '£400+',
						'note' => 'per guard',
						'features' => array(
							'Custom dental night guard',
							'Dental impressions',
							'Lab fabrication',
							'Fitting appointment',
							'Basic protective case',
							'1-year warranty',
						),
					),
					array(
						'where' => 'VeaHealth Istanbul',
						'price' => '£120',
						'note' => 'all-inclusive',
						'features' => array(
							'Premium medical-grade acrylic',
							'Digital 3D impressions (no putty)',
							'CAD/CAM precision fabrication',
							'Professional fitting & adjustment',
							'Premium ventilated case',
							'Cleaning brush & instructions',
							'2-year warranty',
							'Airport transfers',
							'24/7 VeaHealth support',
						),
					),
					array(
						'where' => 'Europe',
						'price' => '€250+',
						'note' => 'per guard',
						'features' => array(
							'Custom night guard',
							'Standard impressions',
							'Lab fabrication',
							'Fitting included',
							'Basic case',
							'1-year warranty',
						),
					),
				),
			),
			'recovery' => array(
				'label' => 'Afterwards',
				'title' => 'Recovery, week by week',
				'intro' => '',
				'phases' => array(
					array(
						'n' => 'First nights',
						'title' => 'Getting used to it',
						'text' => 'It feels bulky for the first three or four nights and most people salivate more at first. Both settle.',
						'points' => array(
							'Wear it every night from the start',
							'Increased salivation for a few nights is normal',
							'Take it out if you wake with sharp pain, and report it',
						),
					),
					array(
						'n' => 'Week 1',
						'title' => 'Fit check',
						'text' => 'It should seat without force and come off without a struggle. Pressure on one tooth means it needs adjusting.',
						'points' => array(
							'No rocking, no single pressure point',
							'Rinse in cold water after each use',
							'Never in hot water — it distorts',
						),
					),
					array(
						'n' => 'Weeks 2–8',
						'title' => 'Symptoms ease',
						'text' => 'Morning jaw ache and headache usually reduce over the first few weeks. The guard protects the teeth; it does not stop the grinding itself.',
						'points' => array(
							'Note whether morning symptoms are changing',
							'Persistent facial pain deserves a separate opinion',
						),
					),
					array(
						'n' => 'Ongoing',
						'title' => 'Replacement',
						'text' => 'A guard wears out. Once it has worn through anywhere it is no longer protecting the tooth underneath.',
						'points' => array(
							'Inspect for wear-through at check-ups',
							'Bring it to every appointment',
							'Expect to replace it periodically',
						),
					),
				),
			),
			'faq' => array(
				'label' => 'Patient Questions',
				'title' => 'Frequently Asked Questions',
				'intro' => '',
				'items' => array(
					array(
						'q' => 'How do I know if I need a night guard?',
						'a' => 'Common signs include: waking with jaw pain or headaches, worn/flat teeth surfaces, tooth sensitivity, clicking or popping jaw, partner hearing grinding at night, or visible cracks in teeth. Your dentist can definitively diagnose bruxism during examination.',
					),
					array(
						'q' => 'Is a custom guard more comfortable than OTC guards?',
						'a' => 'Yes — dramatically. Custom guards are precisely molded to your teeth, so they stay in place without bulk or gagging. Patients report forgetting they’re wearing them within 2–3 nights. OTC guards are often bulky, slip during sleep, and cause gagging or drooling.',
					),
					array(
						'q' => 'How long does a night guard last?',
						'a' => '2–3 years with proper care for most patients. Heavy grinders may need replacement sooner (12–18 months). Signs of wear include visible thinning, cracks, or loss of fit. Regular cleaning and storage in the provided case maximizes lifespan.',
					),
					array(
						'q' => 'Can I wear it on upper or lower teeth?',
						'a' => 'Upper arch guards are most common as they’re less intrusive and easier to wear. Lower guards are recommended for patients with gag reflexes or specific bite issues. Your dentist will recommend the optimal position based on your anatomy and grinding pattern.',
					),
					array(
						'q' => 'How do I clean my night guard?',
						'a' => 'Rinse with cold water after each use. Brush gently with soft toothbrush and non-abrasive soap daily. Soak weekly in denture cleaner or diluted white vinegar (1:1) for 30 minutes. Never use hot water or abrasive toothpaste — this can warp or scratch the acrylic.',
					),
					array(
						'q' => 'Will it stop my grinding completely?',
						'a' => 'No — but that’s not the goal. You may still grind, but the guard absorbs the force, preventing damage to your teeth. Most patients report 60–80% reduction in grinding intensity within 3–4 weeks as the jaw muscles adapt and relax.',
					),
					array(
						'q' => 'Can I wear it with braces or implants?',
						'a' => 'Yes, but timing matters. If you currently have braces, wait until they’re removed — your bite is changing too frequently. With implants, crowns, or bridges, a custom guard is essential to protect your investment. VeaHealth’s dentists design guards around existing restorations.',
					),
					array(
						'q' => 'Is the warranty valid internationally?',
						'a' => 'Yes. VeaHealth’s 2-year warranty covers manufacturing defects and premature wear — valid worldwide. If issues arise after you return home, VeaHealth coordinates a replacement remotely or via a local affiliated dentist in your country.',
					),
				),
			),
		),
		array(
			'slug' => 'zirconium-crown',
			'title' => 'Zirconium Crown',
			'h1' => 'Premium Zirconium Crowns in Istanbul',
			'lead' => 'Metal-free dental crowns crafted from high-strength zirconia ceramic. Natural translucency, biocompatible, and built to last 15–20+ years. VeaHealth coordinates your entire journey with verified clinics, expert ceramists, and complete aftercare support.',
			'trust' => array(
				'FDA-approved zirconia ceramics',
				'Digital precision workflow',
				'Same-visit shade matching',
				'3–5 year warranty included',
			),
			'price' => '£180',
			'price_note' => 'All-inclusive zirconium crown package — tooth preparation, digital impression, lab fabrication, final cementation, and warranty.',
			'stats' => array(
				array(
					'v' => '70%',
					'k' => 'vs UK Cost',
				),
				array(
					'v' => '15–20',
					'k' => 'Year Lifespan',
				),
			),
			'image' => 'zirconia-crowns-macro.webp',
			'caveat' => '',
			'review_note' => '',
			'why' => array(
				'label' => 'Clinical Advantages',
				'title' => 'Why Zirconium Crowns Are the Gold Standard',
				'intro' => 'Zirconia combines the strength of metal with the aesthetics of porcelain — offering a biocompatible, metal-free solution that blends seamlessly with natural teeth.',
				'cards' => array(
					array(
						'title' => 'Superior Strength',
						'text' => 'Zirconia’s flexural strength (900–1200 MPa) exceeds porcelain-fused-to-metal crowns, making it ideal for posterior teeth subjected to high bite forces. Fracture resistance is clinically proven in 10+ year studies.',
					),
					array(
						'title' => 'Natural Aesthetics',
						'text' => 'Modern zirconia allows light translucency that mimics natural enamel. Multi-layered shading and surface staining create lifelike color gradients. No dark metal margin visible at the gumline — ever.',
					),
					array(
						'title' => '100% Biocompatible',
						'text' => 'Zirconia is completely metal-free — no risk of galvanic reactions, metal allergies, or gum discoloration. Tissue-friendly surface promotes healthy gingival attachment and reduces plaque retention.',
					),
					array(
						'title' => 'Digital Precision',
						'text' => 'VeaHealth’s partner labs use CAD/CAM milling for micron-level accuracy. Intraoral scanners eliminate messy impressions. Same-day adjustments ensure perfect occlusion before you leave Istanbul.',
					),
					array(
						'title' => 'Long-Term Value',
						'text' => '15–20 year average lifespan with proper hygiene. Studies show 95%+ survival at 10 years. Maintenance is minimal — standard brushing, flossing, and biannual cleanings. No special care protocols required.',
					),
					array(
						'title' => 'Minimal Prep',
						'text' => 'Zirconia crowns require less tooth reduction than metal-ceramic crowns — preserving more of your natural structure. Conservative margins mean healthier long-term outcomes and easier future revisions if ever needed.',
					),
				),
			),
			'compare' => array(
				'label' => 'Material Comparison',
				'title' => 'Zirconium vs. Other Crown Materials',
				'intro' => '',
				'head' => array(
					'Feature',
					'Zirconium Crown',
					'Porcelain-Fused-to-Metal',
					'Full Porcelain',
					'Gold Crown',
				),
				'rows' => array(
					array(
						'label' => 'Strength (MPa)',
						'values' => array(
							array(
								'v' => '900–1200',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => '400–600',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '150–400',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '200–350',
								'good' => false,
								'bad' => false,
							),
						),
					),
					array(
						'label' => 'Natural Appearance',
						'values' => array(
							array(
								'v' => 'Excellent',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Good (metal visible)',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'Excellent',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'Poor (visible metal)',
								'good' => false,
								'bad' => true,
							),
						),
					),
					array(
						'label' => 'Metal-Free',
						'values' => array(
							array(
								'v' => 'Yes',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'No',
								'good' => false,
								'bad' => true,
							),
							array(
								'v' => 'Yes',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'No',
								'good' => false,
								'bad' => true,
							),
						),
					),
					array(
						'label' => 'Biocompatibility',
						'values' => array(
							array(
								'v' => '100%',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Good (allergy risk)',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '100%',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Good (allergy risk)',
								'good' => false,
								'bad' => false,
							),
						),
					),
					array(
						'label' => 'Gum Discoloration',
						'values' => array(
							array(
								'v' => 'None',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Possible (metal ions)',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'None',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Possible',
								'good' => false,
								'bad' => false,
							),
						),
					),
					array(
						'label' => 'Best For',
						'values' => array(
							array(
								'v' => 'All teeth (front & back)',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Back teeth only',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'Front teeth only',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'Back teeth (non-aesthetic)',
								'good' => false,
								'bad' => false,
							),
						),
					),
					array(
						'label' => 'Average Lifespan',
						'values' => array(
							array(
								'v' => '15–20+ years',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => '10–15 years',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '7–12 years',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '15–20 years',
								'good' => false,
								'bad' => false,
							),
						),
					),
					array(
						'label' => 'Istanbul Cost',
						'values' => array(
							array(
								'v' => '£180',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => '£140',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '£160',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '£220',
								'good' => false,
								'bad' => false,
							),
						),
					),
				),
			),
			'procedure' => array(
				'label' => 'Treatment Journey',
				'title' => 'Your Zirconium Crown Procedure',
				'intro' => 'From digital scan to final cementation — the entire process typically requires 2 clinic visits over 3–5 days in Istanbul.',
				'steps' => array(
					array(
						'tag' => 'Day 1 — Morning',
						'title' => 'Consultation & Diagnosis',
						'text' => 'Your dentist performs a comprehensive exam with digital X-rays and intraoral photos. Existing restoration (if any) is evaluated. Treatment plan is confirmed with shade selection under natural lighting.',
						'points' => array(
							'Full oral health assessment',
							'Bite analysis and occlusion check',
							'Custom shade matching session',
							'Treatment timeline confirmed',
							'Final quote approval',
						),
					),
					array(
						'tag' => 'Day 1 — Afternoon',
						'title' => 'Tooth Preparation',
						'text' => 'The tooth is prepared under local anesthesia — removing decay (if present) and shaping the surface to create space for the crown. A temporary crown is placed immediately to protect the tooth and maintain aesthetics.',
						'points' => array(
							'Local anesthesia applied (painless procedure)',
							'Conservative tooth reduction (1–1.5mm)',
							'Digital intraoral scan taken',
							'Temporary crown cemented',
							'Data sent to lab for fabrication',
						),
					),
					array(
						'tag' => 'Day 2–4',
						'title' => 'Lab Fabrication',
						'text' => 'Your crown is milled from a single block of premium zirconia using CAD/CAM technology. A master ceramist applies custom layering, staining, and glazing to match your natural teeth perfectly.',
						'points' => array(
							'3D design from intraoral scan',
							'High-strength zirconia block milled',
							'Multi-layered color characterization',
							'Surface texturing for light reflection',
							'Quality control and pre-sintering',
						),
					),
					array(
						'tag' => 'Day 5',
						'title' => 'Final Placement',
						'text' => 'The temporary crown is removed and the zirconium crown is test-fitted. Your dentist checks fit, bite, and aesthetics. Once perfect, the crown is permanently cemented using biocompatible resin adhesive.',
						'points' => array(
							'Temporary crown removal',
							'Try-in with bite adjustment',
							'Shade verification under multiple lights',
							'Permanent cementation',
							'Post-op care instructions and warranty docs',
						),
					),
				),
			),
			'cost' => array(
				'label' => 'Transparent Pricing',
				'title' => 'What You’ll Pay — Guaranteed',
				'intro' => 'VeaHealth locks in your price before travel. No hidden fees, no surprise charges. All costs include materials, labor, warranty, and VeaHealth coordination.',
				'tiers' => array(
					array(
						'where' => 'UK / US',
						'price' => '£600–900',
						'note' => 'per crown',
						'features' => array(
							'Standard zirconia crown',
							'Local anesthesia',
							'Temporary crown',
							'Basic warranty (1–2 years)',
							'Follow-up visit included',
						),
					),
					array(
						'where' => 'VeaHealth Istanbul',
						'price' => '£180',
						'note' => 'all-inclusive',
						'features' => array(
							'Premium zirconia (Ivoclar, 3M, Prettau)',
							'Digital workflow (CAD/CAM)',
							'Custom shade layering',
							'Temporary crown included',
							'3–5 year international warranty',
							'Airport transfers',
							'Hotel coordination support',
							'24/7 VeaHealth concierge',
						),
					),
					array(
						'where' => 'Europe',
						'price' => '€400–700',
						'note' => 'per crown',
						'features' => array(
							'Mid-range zirconia',
							'Standard lab fabrication',
							'Temporary crown',
							'Limited warranty (2 years)',
							'Follow-up included',
						),
					),
				),
			),
			'recovery' => array(
				'label' => 'Post-Treatment',
				'title' => 'Recovery & Maintenance',
				'intro' => 'Zirconium crowns have minimal downtime. Most patients resume normal eating within 24 hours and experience zero complications when proper oral hygiene is maintained.',
				'phases' => array(
					array(
						'n' => '1',
						'title' => 'Immediate Aftercare',
						'text' => '',
						'points' => array(
							'Mild sensitivity (cold/hot) normal',
							'Avoid sticky/hard foods',
							'Chew on opposite side',
							'No alcohol or smoking',
							'Use prescribed mouthwash',
						),
					),
					array(
						'n' => '2',
						'title' => 'Adjustment Period',
						'text' => '',
						'points' => array(
							'Sensitivity typically resolves',
							'Resume normal diet gradually',
							'Monitor bite for discomfort',
							'Gentle brushing around crown',
							'Report any sharp edges',
						),
					),
					array(
						'n' => '3',
						'title' => 'Full Integration',
						'text' => '',
						'points' => array(
							'Crown feels completely natural',
							'Normal chewing restored',
							'Gum tissue healed',
							'No temperature sensitivity',
							'Regular brushing and flossing',
						),
					),
					array(
						'n' => '4',
						'title' => 'Ongoing Care',
						'text' => '',
						'points' => array(
							'Brush 2× daily with soft brush',
							'Floss daily (critical for margins)',
							'Biannual professional cleanings',
							'Avoid ice chewing or grinding',
							'15–20+ year lifespan expected',
						),
					),
				),
			),
			'evidence' => array(
				'label' => 'Clinical Evidence',
				'title' => 'What the Studies Show',
				'intro' => '',
				'items' => array(
					array(
						'figure' => '95–97%',
						'text' => 'Survival rate of zirconia crowns at 10 years in multiple systematic reviews — matching or exceeding metal-ceramic crowns with superior aesthetics and zero metal exposure.',
						'source' => 'Sailer et al. (2015) · Clinical Oral Investigations',
					),
					array(
						'figure' => '1.2%',
						'text' => 'Annual technical complication rate (chipping, fracture) for monolithic zirconia crowns — significantly lower than porcelain-fused-to-metal crowns (3.8% annually).',
						'source' => 'Pjetursson et al. (2015) · Systematic review',
					),
					array(
						'figure' => '100%',
						'text' => 'Biocompatibility rating — zirconia shows no cytotoxic effects, no allergic potential, and excellent tissue integration. Gingival health is maintained or improved in long-term studies.',
						'source' => 'Journal of Prosthetic Dentistry · Biocompatibility studies',
					),
				),
			),
			'faq' => array(
				'label' => 'Patient Questions',
				'title' => 'Frequently Asked Questions',
				'intro' => '',
				'items' => array(
					array(
						'q' => 'Is getting a zirconium crown painful?',
						'a' => 'The procedure is performed under local anesthesia — you’ll feel pressure but no pain during tooth preparation. Post-procedure, mild sensitivity to hot/cold is normal for 24–72 hours and resolves with over-the-counter pain relief. Most patients report minimal discomfort.',
					),
					array(
						'q' => 'How long does a zirconium crown last?',
						'a' => 'With proper oral hygiene, zirconia crowns last 15–20+ years on average. Studies confirm 95%+ survival at 10 years. Longevity depends on oral hygiene, avoiding hard foods (ice, nuts), and managing grinding with a night guard if needed.',
					),
					array(
						'q' => 'Will the crown look natural?',
						'a' => 'Yes. Modern zirconia offers excellent translucency and can be custom-shaded to match your natural teeth precisely. Multi-layered characterization replicates the subtle color gradients found in real enamel. No dark metal margin will ever show at the gumline.',
					),
					array(
						'q' => 'Can I get a zirconium crown on a front tooth?',
						'a' => 'Absolutely. Zirconia is ideal for anterior (front) teeth due to its metal-free composition, light translucency, and natural appearance. VeaHealth’s ceramists specialize in creating highly aesthetic anterior crowns that blend seamlessly with your smile.',
					),
					array(
						'q' => 'How many trips to Istanbul are required?',
						'a' => 'Typically one 4–5 day visit. Day 1: consultation and tooth prep. Days 2–4: lab fabrication. Day 5: final placement. If you need multiple crowns or additional treatments, the timeline extends but remains efficient. VeaHealth coordinates everything to minimize your time away from home.',
					),
					array(
						'q' => 'Is the warranty valid internationally?',
						'a' => 'Yes. VeaHealth’s 3–5 year warranty covers manufacturing defects, premature fracture, and decementation — valid worldwide. If a warranty claim arises, VeaHealth coordinates replacement remotely or via a local affiliated dentist in your home country.',
					),
					array(
						'q' => 'What brand of zirconia will be used?',
						'a' => 'VeaHealth’s partner labs use premium brands like Ivoclar Vivadent, 3M Lava, or Prettau — all FDA-approved and CE-certified. The specific brand and batch number are documented in your treatment file and provided at completion. This is a contractual guarantee.',
					),
					array(
						'q' => 'Can smokers get zirconium crowns?',
						'a' => 'Yes, but smoking increases the risk of gum disease around the crown margins and can stain the cement over time. VeaHealth strongly recommends reducing or stopping smoking before and after treatment to ensure optimal healing and long-term crown health.',
					),
				),
			),
		),
		array(
			'slug' => 'e-max-lumineers',
			'title' => 'E-max Lumineers',
			'h1' => 'Transform Your Smile with E-max Lumineers',
			'lead' => 'Ultra-thin, no-prep porcelain veneers in Istanbul. Made from advanced lithium disilicate ceramic for unmatched translucency and strength. Minimal tooth preparation. Natural-looking results. VeaHealth coordinates your complete cosmetic transformation.',
			'trust' => array(
				'Ultra-thin (0.2–0.5mm thickness)',
				'Minimal to no tooth preparation',
				'Premium E-max ceramic',
				'10-year warranty included',
			),
			'price' => '£220',
			'price_note' => 'Per veneer — includes consultation, digital design, minimal prep, E-max fabrication, bonding, and 10-year warranty.',
			'stats' => array(
				array(
					'v' => '70%',
					'k' => 'vs UK Cost',
				),
				array(
					'v' => '3–5',
					'k' => 'Days in Istanbul',
				),
			),
			'image' => 'ceramic-veneers-macro.webp',
			'caveat' => '',
			'review_note' => '',
			'why' => array(
				'label' => 'Premium Veneers',
				'title' => 'Why E-max Lumineers Are Superior',
				'intro' => 'E-max Lumineers combine the strength of lithium disilicate ceramic with ultra-thin design — offering unmatched aesthetics with minimal tooth alteration.',
				'cards' => array(
					array(
						'title' => 'Minimal Tooth Preparation',
						'text' => 'Ultra-thin design (0.2–0.5mm) requires little to no enamel removal — preserving your natural tooth structure. Many patients need zero preparation, making the procedure reversible in some cases and significantly less invasive than traditional veneers.',
					),
					array(
						'title' => 'Exceptional Translucency',
						'text' => 'E-max lithium disilicate ceramic mimics natural enamel’s light-transmitting properties perfectly. Unlike opaque traditional veneers, E-max reflects light naturally — creating depth, vitality, and a lifelike appearance that’s indistinguishable from real teeth.',
					),
					array(
						'title' => 'Superior Strength',
						'text' => 'Despite being ultra-thin, E-max has a flexural strength of 400–500 MPa — 4× stronger than traditional porcelain veneers. This allows thinner veneers that resist chipping and fracture while maintaining structural integrity for 15–20+ years.',
					),
					array(
						'title' => 'Stain Resistant',
						'text' => 'E-max ceramic is non-porous and highly resistant to staining from coffee, wine, tea, and tobacco. The glazed surface remains smooth and bright indefinitely — no special maintenance required beyond normal brushing and flossing.',
					),
					array(
						'title' => 'Biocompatible',
						'text' => 'E-max is 100% biocompatible with no allergic potential. The smooth ceramic surface promotes healthy gum tissue and prevents bacterial adhesion better than composite veneers. Long-term gingival health is excellent in clinical studies.',
					),
					array(
						'title' => 'Rapid Results',
						'text' => 'Digital design and CAD/CAM fabrication allow same-visit try-ins. Most patients complete their E-max Lumineers in 3–5 days in Istanbul — consultation, preparation, fabrication, and bonding all in one trip with immediate results.',
					),
				),
			),
			'compare' => array(
				'label' => 'Veneer Comparison',
				'title' => 'E-max Lumineers vs. Other Veneers',
				'intro' => '',
				'head' => array(
					'Feature',
					'E-max Lumineers',
					'Traditional Veneers',
					'Composite Veneers',
					'Minimal Prep Veneers',
				),
				'rows' => array(
					array(
						'label' => 'Thickness',
						'values' => array(
							array(
								'v' => '0.2–0.5mm',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => '0.5–1.0mm',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '0.3–0.7mm',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '0.3–0.6mm',
								'good' => false,
								'bad' => false,
							),
						),
					),
					array(
						'label' => 'Tooth Preparation',
						'values' => array(
							array(
								'v' => 'Minimal/None',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Significant (0.5–1mm)',
								'good' => false,
								'bad' => true,
							),
							array(
								'v' => 'Minimal',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'Minimal',
								'good' => false,
								'bad' => false,
							),
						),
					),
					array(
						'label' => 'Translucency',
						'values' => array(
							array(
								'v' => 'Excellent (natural)',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Good',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'Poor (opaque)',
								'good' => false,
								'bad' => true,
							),
							array(
								'v' => 'Very Good',
								'good' => false,
								'bad' => false,
							),
						),
					),
					array(
						'label' => 'Strength (MPa)',
						'values' => array(
							array(
								'v' => '400–500 MPa',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => '100–150 MPa',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '50–80 MPa',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '100–200 MPa',
								'good' => false,
								'bad' => false,
							),
						),
					),
					array(
						'label' => 'Stain Resistance',
						'values' => array(
							array(
								'v' => 'Excellent',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Very Good',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'Poor (stains easily)',
								'good' => false,
								'bad' => true,
							),
							array(
								'v' => 'Very Good',
								'good' => false,
								'bad' => false,
							),
						),
					),
					array(
						'label' => 'Lifespan',
						'values' => array(
							array(
								'v' => '15–20+ years',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => '10–15 years',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '5–7 years',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '10–15 years',
								'good' => false,
								'bad' => false,
							),
						),
					),
					array(
						'label' => 'Reversible',
						'values' => array(
							array(
								'v' => 'Often (no prep)',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'No (enamel removed)',
								'good' => false,
								'bad' => true,
							),
							array(
								'v' => 'Yes',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Often',
								'good' => false,
								'bad' => false,
							),
						),
					),
					array(
						'label' => 'Istanbul Cost (per tooth)',
						'values' => array(
							array(
								'v' => '£220',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => '£180',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '£100',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '£200',
								'good' => false,
								'bad' => false,
							),
						),
					),
				),
			),
			'procedure' => array(
				'label' => 'Treatment Journey',
				'title' => 'Your E-max Lumineer Procedure',
				'intro' => 'From consultation to final bonding — the entire process typically requires one 3–5 day visit to Istanbul.',
				'steps' => array(
					array(
						'tag' => 'Day 1 — Morning',
						'title' => 'Consultation & Design',
						'text' => 'Your dentist performs a comprehensive smile assessment with digital photography and intraoral scans. Together you design your ideal smile — selecting shade, shape, and length. Digital smile design software shows you the final result before any tooth preparation.',
						'points' => array(
							'Comprehensive oral examination',
							'Digital smile design (DSD) session',
							'Shade matching under natural light',
							'3D digital impressions',
							'Treatment plan confirmation',
						),
					),
					array(
						'tag' => 'Day 1 — Afternoon',
						'title' => 'Minimal Preparation',
						'text' => 'Under local anesthesia (if needed), your teeth receive minimal surface preparation — typically just cleaning and light etching. For many patients, zero enamel removal is required. Temporary veneers are placed to protect teeth during fabrication.',
						'points' => array(
							'Local anesthesia (optional — often unnecessary)',
							'Minimal surface preparation (0.2–0.3mm max)',
							'Final digital impression scan',
							'Temporary veneers bonded',
							'Data sent to lab for fabrication',
						),
					),
					array(
						'tag' => 'Day 2–4',
						'title' => 'E-max Fabrication',
						'text' => 'Your veneers are milled from a single block of E-max lithium disilicate ceramic using CAD/CAM technology. A master ceramist applies custom layering, characterization, and glazing to match your natural teeth perfectly.',
						'points' => array(
							'3D design from digital scans',
							'High-strength E-max block milled',
							'Multi-layered color characterization',
							'Surface texturing for natural reflection',
							'Quality control and sintering',
						),
					),
					array(
						'tag' => 'Day 4–5',
						'title' => 'Final Bonding',
						'text' => 'Temporary veneers are removed and your E-max Lumineers are test-fitted. Your dentist checks fit, bite, and aesthetics. Once perfect, each veneer is bonded permanently using advanced resin adhesive under controlled isolation.',
						'points' => array(
							'Temporary veneers removed',
							'Try-in with shade verification',
							'Bite adjustment and edge refinement',
							'Permanent bonding with resin cement',
							'Final polish and care instructions',
						),
					),
				),
			),
			'cost' => array(
				'label' => 'Transparent Pricing',
				'title' => 'What You’ll Pay — Guaranteed',
				'intro' => 'VeaHealth locks in your price before travel. All costs include consultation, minimal prep, E-max fabrication, bonding, and 10-year warranty.',
				'tiers' => array(
					array(
						'where' => 'UK / US',
						'price' => '£700+',
						'note' => 'per veneer',
						'features' => array(
							'Standard veneer consultation',
							'Tooth preparation required',
							'Mid-range ceramic',
							'Temporary veneers',
							'2-year warranty',
							'No travel support',
						),
					),
					array(
						'where' => 'VeaHealth Istanbul',
						'price' => '£220',
						'note' => 'per veneer',
						'features' => array(
							'Premium E-max lithium disilicate',
							'Digital smile design (DSD)',
							'Minimal to no tooth preparation',
							'CAD/CAM precision milling',
							'Custom shade layering',
							'10-year warranty',
							'Airport VIP transfers',
							'Hotel coordination support',
							'24/7 VeaHealth concierge',
						),
					),
					array(
						'where' => 'Europe',
						'price' => '€450+',
						'note' => 'per veneer',
						'features' => array(
							'Standard veneer protocol',
							'Moderate tooth preparation',
							'Mid-range ceramic',
							'Temporary veneers',
							'3-year warranty',
							'Limited travel assistance',
						),
					),
				),
			),
			'recovery' => array(
				'label' => 'Post-Treatment',
				'title' => 'Aftercare & Maintenance',
				'intro' => 'E-max Lumineers require minimal recovery and simple maintenance. Most patients resume normal activities immediately with zero downtime.',
				'phases' => array(
					array(
						'n' => '1',
						'title' => 'Immediate Aftercare',
						'text' => '',
						'points' => array(
							'Mild sensitivity possible (rare)',
							'Avoid very hard/sticky foods',
							'Soft diet recommended',
							'Normal brushing and flossing',
							'No smoking or dark beverages',
						),
					),
					array(
						'n' => '2',
						'title' => 'Adjustment Period',
						'text' => '',
						'points' => array(
							'Veneers feel completely natural',
							'Resume normal diet gradually',
							'Any bite sensitivity resolves',
							'Gums adapt to new contours',
							'Full confidence when smiling',
						),
					),
					array(
						'n' => '3',
						'title' => 'Complete Integration',
						'text' => '',
						'points' => array(
							'Veneers feel like natural teeth',
							'Full chewing function restored',
							'No dietary restrictions',
							'Gum tissue fully healed',
							'Normal oral hygiene routine',
						),
					),
					array(
						'n' => '4',
						'title' => 'Ongoing Care',
						'text' => '',
						'points' => array(
							'Brush 2× daily with soft brush',
							'Floss daily (essential)',
							'Biannual professional cleanings',
							'Avoid ice chewing or nail biting',
							'15–20+ year lifespan expected',
						),
					),
				),
			),
			'evidence' => array(
				'label' => 'Clinical Evidence',
				'title' => 'What the Studies Show',
				'intro' => '',
				'items' => array(
					array(
						'figure' => '95–98%',
						'text' => 'Survival rate of E-max veneers at 10 years in multiple clinical studies — matching or exceeding traditional veneers despite requiring significantly less tooth preparation.',
						'source' => 'Guess et al. (2018) · Journal of Esthetic Dentistry',
					),
					array(
						'figure' => '0.8%',
						'text' => 'Annual failure rate for E-max veneers — primarily due to improper bonding or extreme parafunctional habits (grinding). Fracture rate is remarkably low given ultra-thin design.',
						'source' => 'Systematic review · Veneer longevity studies',
					),
					array(
						'figure' => '100%',
						'text' => 'Patient satisfaction with aesthetics of E-max veneers in long-term follow-up studies. The superior translucency and natural light reflection create results indistinguishable from natural enamel.',
						'source' => 'Journal of Prosthetic Dentistry · Patient satisfaction studies',
					),
				),
			),
			'faq' => array(
				'label' => 'Patient Questions',
				'title' => 'Frequently Asked Questions',
				'intro' => '',
				'items' => array(
					array(
						'q' => 'Do E-max Lumineers require tooth grinding?',
						'a' => 'Minimal to none. E-max Lumineers are ultra-thin (0.2–0.5mm) and often require zero enamel removal. In cases where slight preparation is needed, it’s limited to surface etching only — preserving your natural tooth structure almost entirely. This makes the procedure reversible in many cases.',
					),
					array(
						'q' => 'How long do E-max Lumineers last?',
						'a' => '15–20+ years with proper care. E-max lithium disilicate ceramic is 4× stronger than traditional porcelain, resulting in excellent long-term survival rates. Studies confirm 95%+ survival at 10 years. With good oral hygiene and biannual cleanings, many patients keep their veneers for decades.',
					),
					array(
						'q' => 'Will E-max Lumineers look natural?',
						'a' => 'Yes. E-max has exceptional translucency that mimics natural enamel perfectly. Unlike opaque composite veneers, E-max transmits light naturally — creating depth, vitality, and a lifelike appearance. Custom shade layering ensures seamless integration with your natural teeth. Results are indistinguishable from real enamel.',
					),
					array(
						'q' => 'Can E-max Lumineers fix gaps and crooked teeth?',
						'a' => 'Yes. E-max Lumineers can close small gaps, correct minor rotations, and reshape irregularly sized or positioned teeth without orthodontics. However, severe misalignment may require orthodontic correction first. VeaHealth’s dentists assess your case during the digital consultation and recommend the best approach.',
					),
					array(
						'q' => 'How many veneers do I need?',
						'a' => 'Most patients choose 6–10 veneers for the upper front teeth (the “smile zone”). Lower teeth may also be treated if desired. The exact number depends on your smile design goals, tooth proportions, and how many teeth show when you smile. VeaHealth helps you determine the optimal number during consultation.',
					),
					array(
						'q' => 'How many trips to Istanbul are required?',
						'a' => 'Typically one 3–5 day visit. Day 1: consultation and minimal prep. Days 2–4: lab fabrication. Day 5: final bonding. The entire transformation happens in a single trip with immediate results. No return visits required unless you need adjustments (rare).',
					),
					array(
						'q' => 'Will E-max Lumineers stain like natural teeth?',
						'a' => 'No. E-max ceramic is non-porous and highly resistant to staining from coffee, wine, tea, and tobacco. The glazed surface remains bright indefinitely with normal brushing. Unlike natural enamel or composite veneers, E-max maintains its original shade permanently without whitening treatments.',
					),
					array(
						'q' => 'Can I whiten my teeth after getting veneers?',
						'a' => 'E-max veneers don’t respond to whitening treatments, but they also don’t need them — they never discolor. If you’re whitening natural teeth, do it before getting veneers so your dentist can match the veneer shade to your desired whiteness level. Your natural teeth can be whitened later, but veneers will remain their original shade.',
					),
				),
			),
		),
		array(
			'slug' => 'hybrid-prosthesis-porcelain',
			'title' => 'Hybrid Prosthesis — Porcelain',
			'h1' => 'Hybrid Prosthesis Porcelain in Istanbul',
			'lead' => 'Premium porcelain-acrylic hybrid restoration on dental implants. Combines natural porcelain teeth with durable acrylic gum base for optimal aesthetics and repairability. Implant-supported, fixed solution. VeaHealth coordinates your complete transformation.',
			'trust' => array(
				'Natural porcelain teeth',
				'Durable acrylic gum base',
				'Easy to repair if damaged',
				'3-year warranty included',
			),
			'price' => '£3,800',
			'price_note' => 'All-inclusive hybrid prosthesis package per arch — implants, surgery, temporary teeth, final porcelain-acrylic restoration, and warranty.',
			'stats' => array(
				array(
					'v' => '70%',
					'k' => 'vs UK Cost',
				),
				array(
					'v' => '10–15',
					'k' => 'Year Lifespan',
				),
			),
			'image' => 'full-arch-prosthesis-macro.webp',
			'caveat' => '',
			'review_note' => '',
			'why' => array(
				'label' => 'Optimal Balance',
				'title' => 'Why Hybrid Prosthesis Offers the Best of Both Worlds',
				'intro' => 'Hybrid prostheses combine the natural aesthetics of porcelain teeth with the durability and repairability of an acrylic gum base — offering an ideal middle ground between full zirconia and traditional acrylic.',
				'cards' => array(
					array(
						'title' => 'Natural Porcelain Teeth',
						'text' => 'Individual porcelain teeth are crafted to match your natural shade, translucency, and contours. Unlike acrylic, porcelain doesn’t stain or discolor over time, maintaining a pristine appearance for years.',
					),
					array(
						'title' => 'Easy Repairability',
						'text' => 'If a tooth chips or breaks, the acrylic base allows for simple chair-side repairs without removing the entire prosthesis. This is a major advantage over monolithic zirconia, which requires lab work for any damage.',
					),
					array(
						'title' => 'Cost-Effective Option',
						'text' => 'Hybrid prostheses cost 20–30% less than full zirconia while delivering comparable aesthetics. For patients on a budget who still want superior appearance, this is the ideal choice.',
					),
					array(
						'title' => 'Natural Gum Aesthetics',
						'text' => 'The acrylic gum base is custom-shaded to match your natural tissue color and can be contoured to recreate realistic gum architecture. Pink acrylic looks more natural than pink porcelain in most cases.',
					),
					array(
						'title' => 'Lighter Weight',
						'text' => 'Hybrid prostheses are significantly lighter than full zirconia bridges, reducing stress on implants and providing greater comfort — especially for upper arch restorations where weight is more noticeable.',
					),
					array(
						'title' => 'Proven Longevity',
						'text' => 'With proper care, hybrid prostheses last 10–15 years before needing replacement. The acrylic may require professional polishing every 2–3 years to maintain optimal shine, but this is a quick, inexpensive procedure.',
					),
				),
			),
			'compare' => array(
				'label' => 'Material Comparison',
				'title' => 'Hybrid vs. Other Prosthesis Types',
				'intro' => '',
				'head' => array(
					'Feature',
					'Hybrid Porcelain-Acrylic',
					'Full Zirconia',
					'Full Acrylic',
				),
				'rows' => array(
					array(
						'label' => 'Tooth Material',
						'values' => array(
							array(
								'v' => 'Porcelain (stain-resistant)',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Monolithic zirconia',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Acrylic (stains easily)',
								'good' => false,
								'bad' => true,
							),
						),
					),
					array(
						'label' => 'Gum Base Material',
						'values' => array(
							array(
								'v' => 'Acrylic (natural-looking)',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Pink porcelain',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'Acrylic',
								'good' => true,
								'bad' => false,
							),
						),
					),
					array(
						'label' => 'Aesthetics',
						'values' => array(
							array(
								'v' => 'Excellent',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Excellent',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Good (fades over time)',
								'good' => false,
								'bad' => false,
							),
						),
					),
					array(
						'label' => 'Repairability',
						'values' => array(
							array(
								'v' => 'Easy (chair-side)',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Difficult (requires lab)',
								'good' => false,
								'bad' => true,
							),
							array(
								'v' => 'Easy',
								'good' => true,
								'bad' => false,
							),
						),
					),
					array(
						'label' => 'Weight',
						'values' => array(
							array(
								'v' => 'Light',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Heavy',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'Lightest',
								'good' => true,
								'bad' => false,
							),
						),
					),
					array(
						'label' => 'Average Lifespan',
						'values' => array(
							array(
								'v' => '10–15 years',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => '15–20+ years',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => '5–8 years',
								'good' => false,
								'bad' => false,
							),
						),
					),
					array(
						'label' => 'Maintenance',
						'values' => array(
							array(
								'v' => 'Polish every 2–3 years',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'Minimal',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Polish annually',
								'good' => false,
								'bad' => false,
							),
						),
					),
					array(
						'label' => 'Istanbul Cost (per arch)',
						'values' => array(
							array(
								'v' => '£3,800',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => '£5,200',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '£2,800',
								'good' => false,
								'bad' => false,
							),
						),
					),
				),
			),
			'procedure' => array(
				'label' => 'Treatment Journey',
				'title' => 'Your Hybrid Prosthesis Procedure',
				'intro' => 'From implant placement to final hybrid restoration — typically requires two visits to Istanbul over 5–6 months.',
				'steps' => array(
					array(
						'tag' => 'Pre-Arrival',
						'title' => 'Digital Planning',
						'text' => 'VeaHealth coordinates comprehensive diagnostics including 3D CBCT scan, X-rays, and digital treatment planning. Your team designs the implant configuration and hybrid prosthesis virtually.',
						'points' => array(
							'Medical history review via video',
							'3D CBCT scan & X-rays analyzed',
							'Implant surgical guide designed',
							'Final treatment plan confirmed',
							'Travel & accommodation arranged',
						),
					),
					array(
						'tag' => 'Day 1–2 — Istanbul',
						'title' => 'Implant Surgery',
						'text' => 'Under sedation, 4–6 implants are placed per arch. Failing teeth are extracted. Temporary acrylic teeth are attached same-day so you never go without a smile.',
						'points' => array(
							'IV sedation or general anesthesia',
							'Tooth extractions if needed',
							'4–6 implants placed per arch',
							'Temporary prosthesis attached',
							'Post-op medications & instructions',
						),
					),
					array(
						'tag' => 'Month 1–5',
						'title' => 'Osseointegration',
						'text' => 'Implants fuse with jawbone over 4–6 months. You wear temporary teeth and return home. VeaHealth monitors healing remotely with regular photo check-ins.',
						'points' => array(
							'Bone integration progresses',
							'Temporary teeth functional',
							'Gradual diet progression',
							'Remote monitoring every 2 weeks',
							'No travel required',
						),
					),
					array(
						'tag' => 'Month 5–6 — Return Visit',
						'title' => 'Final Hybrid Prosthesis',
						'text' => 'You return to Istanbul for 4–5 days. Digital impressions are taken. Your custom hybrid prosthesis (porcelain teeth + acrylic gum + titanium framework) is fabricated and permanently attached.',
						'points' => array(
							'Temporary prosthesis removed',
							'Digital impressions & bite registration',
							'Hybrid prosthesis crafted (2–3 days)',
							'Try-in with adjustments',
							'Permanent screw-retention & warranty',
						),
					),
				),
			),
			'cost' => array(
				'label' => 'Transparent Pricing',
				'title' => 'What You’ll Pay — Guaranteed',
				'intro' => 'VeaHealth locks in your price before travel. All costs include implants, surgery, temporary teeth, final hybrid prosthesis, and warranty.',
				'tiers' => array(
					array(
						'where' => 'UK / US',
						'price' => '£12,000+',
						'note' => 'per arch',
						'features' => array(
							'Hybrid prosthesis procedure',
							'Standard implants',
							'Temporary teeth',
							'Porcelain-acrylic hybrid',
							'2-year warranty',
						),
					),
					array(
						'where' => 'VeaHealth Istanbul',
						'price' => '£3,800',
						'note' => 'all-inclusive per arch',
						'features' => array(
							'All-on-4 or All-on-6 technique',
							'Straumann or Nobel Biocare implants',
							'3D-guided surgery',
							'Same-day temporary prosthesis',
							'Premium porcelain-acrylic hybrid',
							'Lifetime warranty on implants',
							'3-year warranty on prosthesis',
							'Airport VIP transfers',
							'7 nights hotel support',
							'24/7 VeaHealth concierge',
						),
					),
					array(
						'where' => 'Europe',
						'price' => '€7,500+',
						'note' => 'per arch',
						'features' => array(
							'Standard hybrid protocol',
							'Mid-range implants',
							'Temporary teeth',
							'Basic hybrid prosthesis',
							'2-year warranty',
						),
					),
				),
			),
			'recovery' => array(
				'label' => 'Afterwards',
				'title' => 'Recovery, week by week',
				'intro' => '',
				'phases' => array(
					array(
						'n' => 'Days 1–3',
						'title' => 'Immediately after surgery',
						'text' => 'Swelling peaks around the second day. You leave with a fixed provisional bridge, so you are never without teeth.',
						'points' => array(
							'Cold compresses for the first 48 hours',
							'Liquids and very soft food only',
							'Sleep with your head raised',
							'Take the prescribed medication on schedule',
						),
					),
					array(
						'n' => 'Weeks 1–2',
						'title' => 'Soft diet',
						'text' => 'Sutures dissolve or are removed. Comfort improves quickly, but the implants underneath are not yet integrated and the diet protects them.',
						'points' => array(
							'Soft food only — nothing that needs real force',
							'Prescribed rinse, no vigorous swilling',
							'No smoking: it is the single biggest risk to integration',
						),
					),
					array(
						'n' => 'Months 2–4',
						'title' => 'Integration',
						'text' => 'The implants fuse to the bone. This is the part that cannot be hurried and the reason the final bridge is not fitted yet.',
						'points' => array(
							'Keep the provisional scrupulously clean',
							'Remote review with your coordinator',
							'Report any looseness immediately',
						),
					),
					array(
						'n' => 'Final visit',
						'title' => 'The definitive bridge',
						'text' => 'You return to Istanbul for the permanent prosthesis, fitted after the tissue has settled to its final shape.',
						'points' => array(
							'Second trip, usually 5–7 days',
							'Bite refined over more than one appointment',
							'Hygiene routine taught for the finished bridge',
						),
					),
				),
			),
			'faq' => array(
				'label' => 'Patient Questions',
				'title' => 'Frequently Asked Questions',
				'intro' => '',
				'items' => array(
					array(
						'q' => 'What is a hybrid prosthesis?',
						'a' => 'A hybrid prosthesis combines porcelain teeth with an acrylic gum base, supported by a titanium framework that screws onto dental implants. It offers the natural appearance of porcelain with the repairability and lighter weight of acrylic — an ideal middle ground between full zirconia and traditional acrylic dentures.',
					),
					array(
						'q' => 'How long does a hybrid prosthesis last?',
						'a' => 'With proper care, hybrid prostheses last 10–15 years on average. The porcelain teeth are highly durable and stain-resistant. The acrylic gum base may require professional polishing every 2–3 years to maintain shine. Eventually, the entire prosthesis will need replacement due to normal wear.',
					),
					array(
						'q' => 'Can a hybrid prosthesis be repaired if damaged?',
						'a' => 'Yes — this is one of the major advantages. If a porcelain tooth chips or fractures, it can often be repaired chair-side without removing the entire prosthesis. The acrylic base allows for easy bonding and modification. Full zirconia, by contrast, requires lab work for any repair.',
					),
					array(
						'q' => 'Is hybrid better than full zirconia?',
						'a' => 'Hybrid offers advantages in repairability, cost, and weight, while zirconia excels in long-term durability and minimal maintenance. Hybrid is ideal for patients who want excellent aesthetics at a lower cost with easier future repairs. Zirconia is best for those prioritizing maximum longevity and stain resistance.',
					),
					array(
						'q' => 'Does the acrylic gum base stain?',
						'a' => 'High-quality acrylic is resistant to staining but not completely immune. Smoking, coffee, and red wine can cause gradual discoloration over years. Professional polishing every 2–3 years restores the original appearance. This is a minor maintenance requirement compared to the benefits of repairability and natural aesthetics.',
					),
					array(
						'q' => 'How many trips to Istanbul are required?',
						'a' => 'Two visits: the first for implant surgery and temporary teeth (7 days), and a second visit 5–6 months later for the final hybrid prosthesis (4–5 days). The healing phase in between is managed remotely by VeaHealth with no travel required.',
					),
					array(
						'q' => 'Is the warranty valid internationally?',
						'a' => 'Yes. VeaHealth’s lifetime warranty on implants and 3-year warranty on the hybrid prosthesis are valid worldwide. If a warranty issue arises after you return home, VeaHealth coordinates resolution remotely or via a local affiliated clinic in your country.',
					),
					array(
						'q' => 'Can I eat normally with a hybrid prosthesis?',
						'a' => 'Yes. After full healing (4–6 months), you can eat all foods without restriction — including steak, nuts, and apples. Chewing power is restored to 90–95% of natural teeth. Avoid extremely hard objects like ice or hard candy to prevent chipping the porcelain teeth.',
					),
				),
			),
		),
		array(
			'slug' => 'hybrid-prosthesis-zirconium',
			'title' => 'Hybrid Prosthesis — Zirconium',
			'h1' => 'Hybrid Prosthesis Zirconium in Istanbul',
			'lead' => 'Premium zirconia-acrylic hybrid restoration on dental implants. Combines superior strength of zirconia teeth with comfortable acrylic gum base for maximum durability and natural aesthetics. Implant-supported, fixed solution. VeaHealth coordinates your complete transformation.',
			'trust' => array(
				'Superior zirconia teeth',
				'Lightweight acrylic gum base',
				'Maximum strength & durability',
				'5-year warranty included',
			),
			'price' => '£4,800',
			'price_note' => 'All-inclusive hybrid zirconium package per arch — implants, surgery, temporary teeth, final zirconia-acrylic restoration, and extended warranty.',
			'stats' => array(
				array(
					'v' => '70%',
					'k' => 'vs UK Cost',
				),
				array(
					'v' => '15–20',
					'k' => 'Year Lifespan',
				),
			),
			'image' => 'zirconia-hybrid-prosthesis-macro.webp',
			'caveat' => '',
			'review_note' => '',
			'why' => array(
				'label' => 'Premium Material',
				'title' => 'Why Hybrid Zirconium is the Ultimate Choice',
				'intro' => 'Hybrid zirconia prostheses combine the exceptional strength and stain-resistance of zirconia teeth with the natural appearance and comfort of an acrylic gum base — offering superior performance over traditional acrylic.',
				'cards' => array(
					array(
						'title' => 'Superior Zirconia Teeth',
						'text' => 'Individual zirconia teeth are the strongest ceramic material in dentistry — fracture-resistant, completely stain-proof, and capable of lasting 15–20+ years without discoloration or wear.',
					),
					array(
						'title' => 'Maximum Durability',
						'text' => 'Zirconia is biocompatible, non-porous, and resists chipping better than porcelain. Combined with a titanium framework, hybrid zirconium prostheses deliver exceptional long-term reliability.',
					),
					array(
						'title' => 'Natural Translucency',
						'text' => 'Modern zirconia replicates the light-transmitting properties of natural enamel. Custom shading and contouring create a lifelike appearance indistinguishable from real teeth.',
					),
					array(
						'title' => 'Perfect Gum Aesthetics',
						'text' => 'The acrylic gum base is custom-shaded to match your natural tissue color and can be sculpted to recreate realistic gum architecture — far more natural-looking than pink porcelain.',
					),
					array(
						'title' => 'Lightweight Comfort',
						'text' => 'Despite superior strength, hybrid zirconium is lighter than full monolithic zirconia — reducing stress on implants and providing greater comfort, especially for upper arch restorations.',
					),
					array(
						'title' => 'Repairability',
						'text' => 'If a zirconia tooth chips (rare), the acrylic base allows for easier chair-side repairs compared to monolithic zirconia. Simple maintenance extends the lifespan of your restoration.',
					),
				),
			),
			'compare' => array(
				'label' => 'Material Comparison',
				'title' => 'Hybrid Zirconium vs. Other Prosthesis Types',
				'intro' => '',
				'head' => array(
					'Feature',
					'Hybrid Zirconium-Acrylic',
					'Full Monolithic Zirconia',
					'Hybrid Porcelain-Acrylic',
					'Full Acrylic',
				),
				'rows' => array(
					array(
						'label' => 'Tooth Material',
						'values' => array(
							array(
								'v' => 'Zirconia (strongest)',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Monolithic zirconia',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Porcelain',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'Acrylic',
								'good' => false,
								'bad' => true,
							),
						),
					),
					array(
						'label' => 'Gum Base Material',
						'values' => array(
							array(
								'v' => 'Acrylic (natural)',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Pink zirconia/porcelain',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'Acrylic',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Acrylic',
								'good' => true,
								'bad' => false,
							),
						),
					),
					array(
						'label' => 'Strength & Durability',
						'values' => array(
							array(
								'v' => 'Excellent',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Maximum',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Very Good',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'Fair',
								'good' => false,
								'bad' => true,
							),
						),
					),
					array(
						'label' => 'Stain Resistance',
						'values' => array(
							array(
								'v' => 'Excellent',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Excellent',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Very Good',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Poor',
								'good' => false,
								'bad' => true,
							),
						),
					),
					array(
						'label' => 'Aesthetics',
						'values' => array(
							array(
								'v' => 'Excellent',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Excellent',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Excellent',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Good',
								'good' => false,
								'bad' => false,
							),
						),
					),
					array(
						'label' => 'Repairability',
						'values' => array(
							array(
								'v' => 'Moderate (easier than full zirc)',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Difficult',
								'good' => false,
								'bad' => true,
							),
							array(
								'v' => 'Easy',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Easy',
								'good' => true,
								'bad' => false,
							),
						),
					),
					array(
						'label' => 'Weight',
						'values' => array(
							array(
								'v' => 'Light',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Heavier',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'Light',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Lightest',
								'good' => true,
								'bad' => false,
							),
						),
					),
					array(
						'label' => 'Average Lifespan',
						'values' => array(
							array(
								'v' => '15–20 years',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => '20+ years',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => '10–15 years',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '5–8 years',
								'good' => false,
								'bad' => false,
							),
						),
					),
					array(
						'label' => 'Istanbul Cost (per arch)',
						'values' => array(
							array(
								'v' => '£4,800',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => '£6,500',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '£3,800',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '£2,800',
								'good' => false,
								'bad' => false,
							),
						),
					),
				),
			),
			'procedure' => array(
				'label' => 'Treatment Journey',
				'title' => 'Your Hybrid Zirconium Procedure',
				'intro' => 'From implant placement to final hybrid restoration — typically requires two visits to Istanbul over 5–6 months.',
				'steps' => array(
					array(
						'tag' => 'Pre-Arrival',
						'title' => 'Digital Planning',
						'text' => 'VeaHealth coordinates comprehensive diagnostics including 3D CBCT scan, X-rays, and digital treatment planning. Your team designs the implant configuration and hybrid zirconium prosthesis virtually.',
						'points' => array(
							'Medical history review via video',
							'3D CBCT scan & X-rays analyzed',
							'Implant surgical guide designed',
							'Final treatment plan confirmed',
							'Travel & accommodation arranged',
						),
					),
					array(
						'tag' => 'Day 1–2 — Istanbul',
						'title' => 'Implant Surgery',
						'text' => 'Under sedation, 4–6 implants are placed per arch. Failing teeth are extracted. Temporary acrylic teeth are attached same-day so you never go without a smile.',
						'points' => array(
							'IV sedation or general anesthesia',
							'Tooth extractions if needed',
							'4–6 implants placed per arch',
							'Temporary prosthesis attached',
							'Post-op medications & instructions',
						),
					),
					array(
						'tag' => 'Month 1–5',
						'title' => 'Osseointegration',
						'text' => 'Implants fuse with jawbone over 4–6 months. You wear temporary teeth and return home. VeaHealth monitors healing remotely with regular photo check-ins.',
						'points' => array(
							'Bone integration progresses',
							'Temporary teeth functional',
							'Gradual diet progression',
							'Remote monitoring every 2 weeks',
							'No travel required',
						),
					),
					array(
						'tag' => 'Month 5–6 — Return Visit',
						'title' => 'Final Hybrid Zirconium Prosthesis',
						'text' => 'You return to Istanbul for 4–5 days. Digital impressions are taken. Your custom hybrid zirconium prosthesis (zirconia teeth + acrylic gum + titanium framework) is fabricated and permanently attached.',
						'points' => array(
							'Temporary prosthesis removed',
							'Digital impressions & bite registration',
							'Hybrid zirconium crafted (2–3 days)',
							'Try-in with adjustments',
							'Permanent screw-retention & warranty',
						),
					),
				),
			),
			'cost' => array(
				'label' => 'Transparent Pricing',
				'title' => 'What You’ll Pay — Guaranteed',
				'intro' => 'VeaHealth locks in your price before travel. All costs include implants, surgery, temporary teeth, final hybrid zirconium prosthesis, and warranty.',
				'tiers' => array(
					array(
						'where' => 'UK / US',
						'price' => '£15,000+',
						'note' => 'per arch',
						'features' => array(
							'Hybrid zirconium procedure',
							'Standard implants',
							'Temporary teeth',
							'Zirconia-acrylic hybrid',
							'2-year warranty',
						),
					),
					array(
						'where' => 'VeaHealth Istanbul',
						'price' => '£4,800',
						'note' => 'all-inclusive per arch',
						'features' => array(
							'All-on-4 or All-on-6 technique',
							'Straumann or Nobel Biocare implants',
							'3D-guided surgery',
							'Same-day temporary prosthesis',
							'Premium zirconia-acrylic hybrid',
							'Lifetime warranty on implants',
							'5-year warranty on prosthesis',
							'Airport VIP transfers',
							'7 nights hotel support',
							'24/7 VeaHealth concierge',
						),
					),
					array(
						'where' => 'Europe',
						'price' => '€9,500+',
						'note' => 'per arch',
						'features' => array(
							'Standard hybrid protocol',
							'Mid-range implants',
							'Temporary teeth',
							'Basic hybrid prosthesis',
							'2-year warranty',
						),
					),
				),
			),
			'recovery' => array(
				'label' => 'Afterwards',
				'title' => 'Recovery, week by week',
				'intro' => '',
				'phases' => array(
					array(
						'n' => 'Days 1–3',
						'title' => 'Immediately after surgery',
						'text' => 'Swelling peaks around the second day. You leave with a fixed provisional bridge, so you are never without teeth.',
						'points' => array(
							'Cold compresses for the first 48 hours',
							'Liquids and very soft food only',
							'Sleep with your head raised',
							'Take the prescribed medication on schedule',
						),
					),
					array(
						'n' => 'Weeks 1–2',
						'title' => 'Soft diet',
						'text' => 'Sutures dissolve or are removed. Comfort improves quickly, but the implants underneath are not yet integrated and the diet protects them.',
						'points' => array(
							'Soft food only — nothing that needs real force',
							'Prescribed rinse, no vigorous swilling',
							'No smoking: it is the single biggest risk to integration',
						),
					),
					array(
						'n' => 'Months 2–4',
						'title' => 'Integration',
						'text' => 'The implants fuse to the bone. This is the part that cannot be hurried and the reason the final bridge is not fitted yet.',
						'points' => array(
							'Keep the provisional scrupulously clean',
							'Remote review with your coordinator',
							'Report any looseness immediately',
						),
					),
					array(
						'n' => 'Final visit',
						'title' => 'The definitive bridge',
						'text' => 'You return to Istanbul for the permanent prosthesis, fitted after the tissue has settled to its final shape.',
						'points' => array(
							'Second trip, usually 5–7 days',
							'Bite refined over more than one appointment',
							'Hygiene routine taught for the finished bridge',
						),
					),
				),
			),
			'faq' => array(
				'label' => 'Patient Questions',
				'title' => 'Frequently Asked Questions',
				'intro' => '',
				'items' => array(
					array(
						'q' => 'What is a hybrid zirconium prosthesis?',
						'a' => 'A hybrid zirconium prosthesis combines high-strength zirconia teeth with an acrylic gum base, supported by a titanium framework that screws onto dental implants. It offers the exceptional durability and stain-resistance of zirconia with the natural appearance and comfort of acrylic — superior to traditional acrylic while more affordable than full monolithic zirconia.',
					),
					array(
						'q' => 'How long does a hybrid zirconium prosthesis last?',
						'a' => 'With proper care, hybrid zirconium prostheses last 15–20 years on average. The zirconia teeth are extremely durable and stain-proof. The acrylic gum base may require professional polishing every 3–4 years to maintain shine. This lifespan is significantly longer than traditional acrylic (5–8 years) and comparable to full zirconia.',
					),
					array(
						'q' => 'Is hybrid zirconium better than hybrid porcelain?',
						'a' => 'Yes, zirconia is stronger, more fracture-resistant, and more stain-proof than porcelain. Hybrid zirconium offers superior longevity (15–20 years vs 10–15 years for porcelain) and requires less maintenance. The cost difference is approximately 25% higher for zirconia, making it the premium choice for patients prioritizing maximum durability.',
					),
					array(
						'q' => 'Can a hybrid zirconium prosthesis be repaired if damaged?',
						'a' => 'Yes. Although zirconia teeth rarely chip due to their exceptional strength, the acrylic base allows for easier repairs compared to full monolithic zirconia. If damage occurs, chair-side bonding is often possible. Full monolithic zirconia requires lab work for any repair, making hybrid zirconium more practical long-term.',
					),
					array(
						'q' => 'Does the acrylic gum base stain over time?',
						'a' => 'High-quality acrylic is resistant to staining but not immune. Smoking, coffee, and red wine can cause gradual discoloration over years. Professional polishing every 3–4 years restores the original appearance. This is a minor trade-off considering the comfort, natural aesthetics, and repairability advantages of the acrylic gum base.',
					),
					array(
						'q' => 'How many trips to Istanbul are required?',
						'a' => 'Two visits: the first for implant surgery and temporary teeth (7 days), and a second visit 5–6 months later for the final hybrid zirconium prosthesis (4–5 days). The healing phase in between is managed remotely by VeaHealth with no travel required.',
					),
					array(
						'q' => 'Is the warranty valid internationally?',
						'a' => 'Yes. VeaHealth’s lifetime warranty on implants and 5-year warranty on the hybrid zirconium prosthesis are valid worldwide. If a warranty issue arises after you return home, VeaHealth coordinates resolution remotely or via a local affiliated clinic in your country.',
					),
					array(
						'q' => 'Can I eat normally with a hybrid zirconium prosthesis?',
						'a' => 'Yes. After full healing (4–6 months), you can eat all foods without restriction — including steak, nuts, and apples. Chewing power is restored to 90–95% of natural teeth. The zirconia teeth are exceptionally strong and can handle normal biting forces. Avoid extremely hard objects like ice to prevent rare chipping.',
					),
				),
			),
		),
		array(
			'slug' => 'sapphire-fue',
			'title' => 'Sapphire FUE',
			'h1' => 'Sapphire FUE Hair Transplant in Istanbul',
			'lead' => 'Advanced Sapphire FUE technique using precision sapphire blades for micro-channel creation. Natural hairline design, maximum graft survival (95%+), minimal scarring. 4000–5000 grafts in one session. VeaHealth coordinates your complete hair restoration journey.',
			'trust' => array(
				'Sapphire blade precision technology',
				'4000–5000 grafts per session',
				'Natural hairline design',
				'Lifetime graft warranty',
			),
			'price' => '£1,800',
			'price_note' => 'All-inclusive Sapphire FUE package — consultation, hairline design, extraction, implantation, PRP treatment, medications, and 12-month follow-up.',
			'stats' => array(
				array(
					'v' => '70%',
					'k' => 'vs UK Cost',
				),
				array(
					'v' => '95%+',
					'k' => 'Graft Survival',
				),
			),
			'image' => 'sapphire-fue-blade-macro.webp',
			'caveat' => '',
			'review_note' => '',
			'why' => array(
				'label' => 'Advanced Technology',
				'title' => 'Why Sapphire FUE Is Superior',
				'intro' => 'Sapphire FUE uses precision-cut sapphire blades instead of steel, creating smaller micro-channels for follicle implantation. This results in faster healing, higher graft survival, and more natural density.',
				'cards' => array(
					array(
						'title' => 'Precision Micro-Channels',
						'text' => 'Sapphire blades create channels 30% smaller than steel blades — reducing trauma, minimizing scarring, and allowing tighter graft placement for maximum natural density. Channels match follicle size exactly.',
					),
					array(
						'title' => '95%+ Graft Survival',
						'text' => 'Sapphire’s smooth, sharp edge creates cleaner incisions with less tissue damage. This preserves graft viability during implantation, achieving survival rates 10–15% higher than traditional steel FUE.',
					),
					array(
						'title' => 'Faster Healing',
						'text' => 'Smaller incisions mean less tissue disruption and faster recovery. Most patients see complete healing within 7–10 days compared to 14–21 days with steel FUE. Scabbing resolves faster with minimal scarring.',
					),
					array(
						'title' => 'Natural Density',
						'text' => 'Sapphire’s precision allows 50–60 grafts per cm² placement — matching natural hair density. Traditional FUE achieves only 35–40 grafts/cm². This creates a fuller, more authentic appearance from day one.',
					),
					array(
						'title' => 'Reduced Tissue Damage',
						'text' => 'Sapphire’s antibacterial properties and smooth surface reduce infection risk and inflammation. Less trauma to recipient area means less shock loss of existing hair — preserving your natural hair alongside transplanted follicles.',
					),
					array(
						'title' => 'Permanent Results',
						'text' => 'Follicles transplanted from the permanent “donor zone” (back of head) are genetically resistant to DHT. They retain this resistance after transplantation, growing naturally for life with zero maintenance required.',
					),
				),
			),
			'compare' => array(
				'label' => 'Technique Comparison',
				'title' => 'Sapphire FUE vs. Other Methods',
				'intro' => '',
				'head' => array(
					'Feature',
					'Sapphire FUE',
					'Steel FUE',
					'FUT (Strip Method)',
					'DHI (Pen Method)',
				),
				'rows' => array(
					array(
						'label' => 'Channel Size',
						'values' => array(
							array(
								'v' => '0.6–0.8mm (smallest)',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => '0.9–1.2mm',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '1.0–1.5mm',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '0.6–0.8mm',
								'good' => false,
								'bad' => false,
							),
						),
					),
					array(
						'label' => 'Graft Survival Rate',
						'values' => array(
							array(
								'v' => '95–98%',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => '85–90%',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '90–92%',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '92–95%',
								'good' => false,
								'bad' => false,
							),
						),
					),
					array(
						'label' => 'Healing Time',
						'values' => array(
							array(
								'v' => '7–10 days',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => '14–21 days',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '21–30 days',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '10–14 days',
								'good' => false,
								'bad' => false,
							),
						),
					),
					array(
						'label' => 'Scarring',
						'values' => array(
							array(
								'v' => 'Minimal (invisible)',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Minimal',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'Linear scar',
								'good' => false,
								'bad' => true,
							),
							array(
								'v' => 'Minimal',
								'good' => false,
								'bad' => false,
							),
						),
					),
					array(
						'label' => 'Density (grafts/cm²)',
						'values' => array(
							array(
								'v' => '50–60',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => '35–40',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '40–45',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '45–55',
								'good' => false,
								'bad' => false,
							),
						),
					),
					array(
						'label' => 'Tissue Trauma',
						'values' => array(
							array(
								'v' => 'Very Low',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Moderate',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'High',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'Low',
								'good' => false,
								'bad' => false,
							),
						),
					),
					array(
						'label' => 'Grafts Per Session',
						'values' => array(
							array(
								'v' => '4000–5000',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => '3000–4000',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '3000–4000',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '3500–4500',
								'good' => false,
								'bad' => false,
							),
						),
					),
					array(
						'label' => 'Istanbul Cost',
						'values' => array(
							array(
								'v' => '£1,800',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => '£1,500',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '£1,400',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '£2,200',
								'good' => false,
								'bad' => false,
							),
						),
					),
				),
			),
			'procedure' => array(
				'label' => 'Treatment Journey',
				'title' => 'Your Sapphire FUE Procedure',
				'intro' => 'From consultation to full growth — the complete journey typically requires one 2-day visit to Istanbul followed by 12 months of natural hair growth.',
				'steps' => array(
					array(
						'tag' => 'Pre-Arrival',
						'title' => 'Digital Hair Analysis',
						'text' => 'Before you travel, VeaHealth coordinates a comprehensive scalp analysis via photos and video consultation. Your surgeon assesses donor area density, calculates available grafts, and designs your new hairline digitally.',
						'points' => array(
							'Medical history & photo analysis',
							'Donor area density assessment',
							'Norwood scale classification',
							'Hairline design consultation',
							'Graft count estimation (4000–5000)',
						),
					),
					array(
						'tag' => 'Day 1 — Istanbul (Morning)',
						'title' => 'Final Consultation & Design',
						'text' => 'Your surgeon performs in-person scalp examination, confirms graft count, and draws your new hairline with a surgical marker. You approve the design before proceeding. Blood tests and pre-op photos are taken.',
						'points' => array(
							'In-person scalp examination',
							'Final hairline design approval',
							'Blood tests for safety',
							'Pre-operative photography',
							'Consent forms signed',
						),
					),
					array(
						'tag' => 'Day 1 — Istanbul (Afternoon)',
						'title' => 'Extraction & Implantation',
						'text' => 'Under local anesthesia, follicles are extracted one by one from the donor area using micro-punch tools. Sapphire blades create recipient channels. Grafts are implanted immediately. The entire procedure takes 6–8 hours.',
						'points' => array(
							'Local anesthesia (painless)',
							'Donor area shaving',
							'4000–5000 grafts extracted individually',
							'Sapphire blade channel creation',
							'Graft implantation with precise angulation',
						),
					),
					array(
						'tag' => 'Day 2 — Istanbul',
						'title' => 'Post-Op Care & Departure',
						'text' => 'Your surgeon removes bandages, performs the first hair wash, and provides PRP treatment to accelerate healing. You receive detailed aftercare instructions, medications (antibiotics, painkillers), and special shampoo before returning home.',
						'points' => array(
							'Bandage removal',
							'First professional hair wash',
							'PRP injection treatment',
							'Aftercare kit provided',
							'Cleared to fly home (same day)',
						),
					),
					array(
						'tag' => 'Month 1–12',
						'title' => 'Growth & Monitoring',
						'text' => 'Transplanted hair sheds after 2–4 weeks (normal). New growth begins at month 3. Full density achieved by month 12. VeaHealth monitors your progress remotely via monthly photo updates and video check-ins.',
						'points' => array(
							'Shock shedding (week 2–4) — normal',
							'New growth visible (month 3)',
							'50% density (month 6)',
							'90% density (month 9)',
							'Final result (month 12)',
						),
					),
				),
			),
			'cost' => array(
				'label' => 'Transparent Pricing',
				'title' => 'What You’ll Pay — Guaranteed',
				'intro' => 'VeaHealth locks in your price before travel. All costs include consultation, surgery, PRP treatment, medications, aftercare kit, and 12-month follow-up.',
				'tiers' => array(
					array(
						'where' => 'UK / US',
						'price' => '£6,000+',
						'note' => '4000 grafts',
						'features' => array(
							'Standard FUE technique',
							'4000 grafts average',
							'Basic aftercare',
							'6-month follow-up',
							'No travel support',
						),
					),
					array(
						'where' => 'VeaHealth Istanbul',
						'price' => '£1,800',
						'note' => 'all-inclusive 4000–5000 grafts',
						'features' => array(
							'Sapphire FUE advanced technique',
							'4000–5000 grafts per session',
							'Natural hairline design',
							'PRP treatment included',
							'Premium medications & shampoo',
							'Lifetime graft warranty',
							'12-month remote monitoring',
							'Airport VIP transfers',
							'2 nights hotel included',
							'24/7 VeaHealth concierge',
						),
					),
					array(
						'where' => 'Europe',
						'price' => '€4,000+',
						'note' => '4000 grafts',
						'features' => array(
							'Standard FUE or Sapphire',
							'4000 grafts average',
							'Basic PRP option',
							'Limited follow-up',
							'Minimal travel assistance',
						),
					),
				),
			),
			'recovery' => array(
				'label' => 'Post-Treatment',
				'title' => 'Recovery & Growth Timeline',
				'intro' => 'Sapphire FUE recovery is fast and predictable. Most patients return to work within 5–7 days, with full hair growth achieved by 12 months.',
				'phases' => array(
					array(
						'n' => '1',
						'title' => 'Initial Healing',
						'text' => '',
						'points' => array(
							'Redness & mild swelling (normal)',
							'No touching transplanted area',
							'Sleep with head elevated',
							'Gentle washing after day 3',
							'Scabs form and shed naturally',
						),
					),
					array(
						'n' => '2',
						'title' => 'Shock Shedding',
						'text' => '',
						'points' => array(
							'Transplanted hair sheds (expected)',
							'Follicles remain intact in scalp',
							'Return to normal activities',
							'Light exercise permitted',
							'No heavy lifting yet',
						),
					),
					array(
						'n' => '3',
						'title' => 'New Growth Phase',
						'text' => '',
						'points' => array(
							'New hair emerges (month 3)',
							'Initially thin and fine',
							'30–50% density visible',
							'Progressive thickening',
							'Resume all activities',
						),
					),
					array(
						'n' => '4',
						'title' => 'Final Result',
						'text' => '',
						'points' => array(
							'90% density achieved (month 9)',
							'Full maturation (month 12)',
							'Hair thickens and strengthens',
							'Natural styling possible',
							'Permanent lifetime result',
						),
					),
				),
			),
			'evidence' => array(
				'label' => 'Clinical Evidence',
				'title' => 'What the Studies Show',
				'intro' => '',
				'items' => array(
					array(
						'figure' => '95–98%',
						'text' => 'Graft survival rate with Sapphire FUE technique — 10–15% higher than traditional steel FUE due to reduced trauma and precision channel creation.',
						'source' => 'Journal of Cosmetic Dermatology · Sapphire FUE outcomes',
					),
					array(
						'figure' => '30%',
						'text' => 'Smaller incision size compared to steel blades — resulting in faster healing, less scarring, and ability to place grafts closer together for natural density.',
						'source' => 'International Journal of Trichology · Blade comparison study',
					),
					array(
						'figure' => 'Lifetime',
						'text' => 'Permanence of transplanted hair — follicles from the DHT-resistant donor zone retain their genetic resistance after transplantation, growing naturally for life.',
						'source' => 'Dermatologic Surgery · Long-term FUE follow-up',
					),
				),
			),
			'faq' => array(
				'label' => 'Patient Questions',
				'title' => 'Frequently Asked Questions',
				'intro' => '',
				'items' => array(
					array(
						'q' => 'Is Sapphire FUE painful?',
						'a' => 'The procedure is performed under local anesthesia — no pain during surgery, only mild pressure. Post-op discomfort is minimal (mild soreness) and managed with over-the-counter painkillers. Most patients describe it as less painful than expected.',
					),
					array(
						'q' => 'How long does the transplanted hair last?',
						'a' => 'Lifetime. Follicles transplanted from the permanent donor zone (back of head) are genetically resistant to DHT hormone and retain this resistance after transplantation. They grow naturally for life with zero maintenance or medications required.',
					),
					array(
						'q' => 'When will I see results?',
						'a' => 'Transplanted hair sheds after 2–4 weeks (normal). New growth begins at month 3. You’ll see 50% density by month 6, 90% by month 9, and full final result by month 12. Results are permanent and continue improving for 18 months.',
					),
					array(
						'q' => 'Will there be visible scarring?',
						'a' => 'No. Sapphire FUE creates micro-channels (0.6–0.8mm) that heal completely within 7–10 days, leaving no visible scarring. The donor area can be worn short (even buzzed) with no detection. Unlike FUT, there is no linear scar.',
					),
					array(
						'q' => 'How many grafts will I need?',
						'a' => 'Depends on your Norwood classification and coverage goals. Typical ranges: hairline restoration (1500–2500 grafts), crown filling (2000–3000 grafts), full coverage (4000–5000 grafts). VeaHealth’s surgeons provide exact counts during pre-treatment assessment.',
					),
					array(
						'q' => 'Can I fly home immediately after?',
						'a' => 'Yes. You can fly the day after surgery (day 2). Most patients stay 2–3 nights in Istanbul total — day 1 for procedure, day 2 for post-op care and first wash, then fly home. VeaHealth coordinates all logistics.',
					),
					array(
						'q' => 'Is the warranty valid internationally?',
						'a' => 'Yes. VeaHealth’s lifetime graft warranty covers transplanted follicles that fail to grow (< 2% incidence). Valid worldwide with full documentation. If a warranty claim arises, VeaHealth coordinates resolution remotely or via re-treatment.',
					),
					array(
						'q' => 'Am I a good candidate?',
						'a' => 'Most men and women with pattern hair loss are candidates. Requirements: sufficient donor area density, realistic expectations, good general health. Not suitable for: diffuse unpatterned alopecia, alopecia areata, active scalp infections. VeaHealth provides free eligibility assessment via photo analysis.',
					),
				),
			),
		),
		array(
			'slug' => 'dhi-hair-transplant',
			'title' => 'DHI Hair Transplant',
			'h1' => 'DHI Hair Transplant in Istanbul',
			'lead' => 'Direct Hair Implantation using the Choi Implanter Pen — extract and implant in single motion. No channel pre-opening, maximum control over angle & depth. Minimal bleeding, faster healing. 3500–4500 grafts per session. VeaHealth coordinates your complete DHI journey.',
			'trust' => array(
				'Choi Implanter Pen technology',
				'3500–4500 grafts per session',
				'No shaving option available',
				'Lifetime graft warranty',
			),
			'price' => '£2,200',
			'price_note' => 'All-inclusive DHI package — consultation, Choi Implanter Pen technique, extraction, direct implantation, PRP treatment, medications, and 12-month follow-up.',
			'stats' => array(
				array(
					'v' => '70%',
					'k' => 'vs UK Cost',
				),
				array(
					'v' => '95%+',
					'k' => 'Graft Survival',
				),
			),
			'image' => 'dhi-implanter-pen-macro.webp',
			'caveat' => '',
			'review_note' => '',
			'why' => array(
				'label' => 'Advanced Technology',
				'title' => 'Why DHI Is The Premium Choice',
				'intro' => 'DHI (Direct Hair Implantation) uses the Choi Implanter Pen to extract and implant follicles in one motion without pre-opening channels. This results in maximum control, minimal bleeding, and faster recovery.',
				'cards' => array(
					array(
						'title' => 'Precision Micro-Channels',
						'text' => 'Sapphire blades create channels 30% smaller than steel blades — reducing trauma, minimizing scarring, and allowing tighter graft placement for maximum natural density. Channels match follicle size exactly.',
					),
					array(
						'title' => '95%+ Graft Survival',
						'text' => 'Sapphire’s smooth, sharp edge creates cleaner incisions with less tissue damage. This preserves graft viability during implantation, achieving survival rates 10–15% higher than traditional steel FUE.',
					),
					array(
						'title' => 'Faster Healing',
						'text' => 'Smaller incisions mean less tissue disruption and faster recovery. Most patients see complete healing within 7–10 days compared to 14–21 days with steel FUE. Scabbing resolves faster with minimal scarring.',
					),
					array(
						'title' => 'Natural Density',
						'text' => 'Sapphire’s precision allows 50–60 grafts per cm² placement — matching natural hair density. Traditional FUE achieves only 35–40 grafts/cm². This creates a fuller, more authentic appearance from day one.',
					),
					array(
						'title' => 'Reduced Tissue Damage',
						'text' => 'Sapphire’s antibacterial properties and smooth surface reduce infection risk and inflammation. Less trauma to recipient area means less shock loss of existing hair — preserving your natural hair alongside transplanted follicles.',
					),
					array(
						'title' => 'Permanent Results',
						'text' => 'Follicles transplanted from the permanent “donor zone” (back of head) are genetically resistant to DHT. They retain this resistance after transplantation, growing naturally for life with zero maintenance required.',
					),
				),
			),
			'compare' => array(
				'label' => 'Technique Comparison',
				'title' => 'Sapphire FUE vs. Other Methods',
				'intro' => '',
				'head' => array(
					'Feature',
					'Sapphire FUE',
					'Steel FUE',
					'FUT (Strip Method)',
					'DHI (Pen Method)',
				),
				'rows' => array(
					array(
						'label' => 'Channel Size',
						'values' => array(
							array(
								'v' => '0.6–0.8mm (smallest)',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => '0.9–1.2mm',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '1.0–1.5mm',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '0.6–0.8mm',
								'good' => false,
								'bad' => false,
							),
						),
					),
					array(
						'label' => 'Graft Survival Rate',
						'values' => array(
							array(
								'v' => '95–98%',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => '85–90%',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '90–92%',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '92–95%',
								'good' => false,
								'bad' => false,
							),
						),
					),
					array(
						'label' => 'Healing Time',
						'values' => array(
							array(
								'v' => '7–10 days',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => '14–21 days',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '21–30 days',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '10–14 days',
								'good' => false,
								'bad' => false,
							),
						),
					),
					array(
						'label' => 'Scarring',
						'values' => array(
							array(
								'v' => 'Minimal (invisible)',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Minimal',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'Linear scar',
								'good' => false,
								'bad' => true,
							),
							array(
								'v' => 'Minimal',
								'good' => false,
								'bad' => false,
							),
						),
					),
					array(
						'label' => 'Density (grafts/cm²)',
						'values' => array(
							array(
								'v' => '50–60',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => '35–40',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '40–45',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '45–55',
								'good' => false,
								'bad' => false,
							),
						),
					),
					array(
						'label' => 'Tissue Trauma',
						'values' => array(
							array(
								'v' => 'Very Low',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => 'Moderate',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'High',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => 'Low',
								'good' => false,
								'bad' => false,
							),
						),
					),
					array(
						'label' => 'Grafts Per Session',
						'values' => array(
							array(
								'v' => '4000–5000',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => '3000–4000',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '3000–4000',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '3500–4500',
								'good' => false,
								'bad' => false,
							),
						),
					),
					array(
						'label' => 'Istanbul Cost',
						'values' => array(
							array(
								'v' => '£1,800',
								'good' => true,
								'bad' => false,
							),
							array(
								'v' => '£1,500',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '£1,400',
								'good' => false,
								'bad' => false,
							),
							array(
								'v' => '£2,200',
								'good' => false,
								'bad' => false,
							),
						),
					),
				),
			),
			'procedure' => array(
				'label' => 'Treatment Journey',
				'title' => 'Your Sapphire FUE Procedure',
				'intro' => 'From consultation to full growth — the complete journey typically requires one 2-day visit to Istanbul followed by 12 months of natural hair growth.',
				'steps' => array(
					array(
						'tag' => 'Pre-Arrival',
						'title' => 'Digital Hair Analysis',
						'text' => 'Before you travel, VeaHealth coordinates a comprehensive scalp analysis via photos and video consultation. Your surgeon assesses donor area density, calculates available grafts, and designs your new hairline digitally.',
						'points' => array(
							'Medical history & photo analysis',
							'Donor area density assessment',
							'Norwood scale classification',
							'Hairline design consultation',
							'Graft count estimation (4000–5000)',
						),
					),
					array(
						'tag' => 'Day 1 — Istanbul (Morning)',
						'title' => 'Final Consultation & Design',
						'text' => 'Your surgeon performs in-person scalp examination, confirms graft count, and draws your new hairline with a surgical marker. You approve the design before proceeding. Blood tests and pre-op photos are taken.',
						'points' => array(
							'In-person scalp examination',
							'Final hairline design approval',
							'Blood tests for safety',
							'Pre-operative photography',
							'Consent forms signed',
						),
					),
					array(
						'tag' => 'Day 1 — Istanbul (Afternoon)',
						'title' => 'Extraction & Implantation',
						'text' => 'Under local anesthesia, follicles are extracted one by one from the donor area using micro-punch tools. Sapphire blades create recipient channels. Grafts are implanted immediately. The entire procedure takes 6–8 hours.',
						'points' => array(
							'Local anesthesia (painless)',
							'Donor area shaving',
							'4000–5000 grafts extracted individually',
							'Sapphire blade channel creation',
							'Graft implantation with precise angulation',
						),
					),
					array(
						'tag' => 'Day 2 — Istanbul',
						'title' => 'Post-Op Care & Departure',
						'text' => 'Your surgeon removes bandages, performs the first hair wash, and provides PRP treatment to accelerate healing. You receive detailed aftercare instructions, medications (antibiotics, painkillers), and special shampoo before returning home.',
						'points' => array(
							'Bandage removal',
							'First professional hair wash',
							'PRP injection treatment',
							'Aftercare kit provided',
							'Cleared to fly home (same day)',
						),
					),
					array(
						'tag' => 'Month 1–12',
						'title' => 'Growth & Monitoring',
						'text' => 'Transplanted hair sheds after 2–4 weeks (normal). New growth begins at month 3. Full density achieved by month 12. VeaHealth monitors your progress remotely via monthly photo updates and video check-ins.',
						'points' => array(
							'Shock shedding (week 2–4) — normal',
							'New growth visible (month 3)',
							'50% density (month 6)',
							'90% density (month 9)',
							'Final result (month 12)',
						),
					),
				),
			),
			'cost' => array(
				'label' => 'Transparent Pricing',
				'title' => 'What You’ll Pay — Guaranteed',
				'intro' => 'VeaHealth locks in your price before travel. All costs include consultation, surgery, PRP treatment, medications, aftercare kit, and 12-month follow-up.',
				'tiers' => array(
					array(
						'where' => 'UK / US',
						'price' => '£6,000+',
						'note' => '4000 grafts',
						'features' => array(
							'Standard FUE technique',
							'4000 grafts average',
							'Basic aftercare',
							'6-month follow-up',
							'No travel support',
						),
					),
					array(
						'where' => 'VeaHealth Istanbul',
						'price' => '£1,800',
						'note' => 'all-inclusive 4000–5000 grafts',
						'features' => array(
							'Sapphire FUE advanced technique',
							'4000–5000 grafts per session',
							'Natural hairline design',
							'PRP treatment included',
							'Premium medications & shampoo',
							'Lifetime graft warranty',
							'12-month remote monitoring',
							'Airport VIP transfers',
							'2 nights hotel included',
							'24/7 VeaHealth concierge',
						),
					),
					array(
						'where' => 'Europe',
						'price' => '€4,000+',
						'note' => '4000 grafts',
						'features' => array(
							'Standard FUE or Sapphire',
							'4000 grafts average',
							'Basic PRP option',
							'Limited follow-up',
							'Minimal travel assistance',
						),
					),
				),
			),
			'recovery' => array(
				'label' => 'Post-Treatment',
				'title' => 'Recovery & Growth Timeline',
				'intro' => 'Sapphire FUE recovery is fast and predictable. Most patients return to work within 5–7 days, with full hair growth achieved by 12 months.',
				'phases' => array(
					array(
						'n' => '1',
						'title' => 'Initial Healing',
						'text' => '',
						'points' => array(
							'Redness & mild swelling (normal)',
							'No touching transplanted area',
							'Sleep with head elevated',
							'Gentle washing after day 3',
							'Scabs form and shed naturally',
						),
					),
					array(
						'n' => '2',
						'title' => 'Shock Shedding',
						'text' => '',
						'points' => array(
							'Transplanted hair sheds (expected)',
							'Follicles remain intact in scalp',
							'Return to normal activities',
							'Light exercise permitted',
							'No heavy lifting yet',
						),
					),
					array(
						'n' => '3',
						'title' => 'New Growth Phase',
						'text' => '',
						'points' => array(
							'New hair emerges (month 3)',
							'Initially thin and fine',
							'30–50% density visible',
							'Progressive thickening',
							'Resume all activities',
						),
					),
					array(
						'n' => '4',
						'title' => 'Final Result',
						'text' => '',
						'points' => array(
							'90% density achieved (month 9)',
							'Full maturation (month 12)',
							'Hair thickens and strengthens',
							'Natural styling possible',
							'Permanent lifetime result',
						),
					),
				),
			),
			'evidence' => array(
				'label' => 'Clinical Evidence',
				'title' => 'What the Studies Show',
				'intro' => '',
				'items' => array(
					array(
						'figure' => '95–98%',
						'text' => 'Graft survival rate with Sapphire FUE technique — 10–15% higher than traditional steel FUE due to reduced trauma and precision channel creation.',
						'source' => 'Journal of Cosmetic Dermatology · Sapphire FUE outcomes',
					),
					array(
						'figure' => '30%',
						'text' => 'Smaller incision size compared to steel blades — resulting in faster healing, less scarring, and ability to place grafts closer together for natural density.',
						'source' => 'International Journal of Trichology · Blade comparison study',
					),
					array(
						'figure' => 'Lifetime',
						'text' => 'Permanence of transplanted hair — follicles from the DHT-resistant donor zone retain their genetic resistance after transplantation, growing naturally for life.',
						'source' => 'Dermatologic Surgery · Long-term FUE follow-up',
					),
				),
			),
			'faq' => array(
				'label' => 'Patient Questions',
				'title' => 'Frequently Asked Questions',
				'intro' => '',
				'items' => array(
					array(
						'q' => 'Is Sapphire FUE painful?',
						'a' => 'The procedure is performed under local anesthesia — no pain during surgery, only mild pressure. Post-op discomfort is minimal (mild soreness) and managed with over-the-counter painkillers. Most patients describe it as less painful than expected.',
					),
					array(
						'q' => 'How long does the transplanted hair last?',
						'a' => 'Lifetime. Follicles transplanted from the permanent donor zone (back of head) are genetically resistant to DHT hormone and retain this resistance after transplantation. They grow naturally for life with zero maintenance or medications required.',
					),
					array(
						'q' => 'When will I see results?',
						'a' => 'Transplanted hair sheds after 2–4 weeks (normal). New growth begins at month 3. You’ll see 50% density by month 6, 90% by month 9, and full final result by month 12. Results are permanent and continue improving for 18 months.',
					),
					array(
						'q' => 'Will there be visible scarring?',
						'a' => 'No. Sapphire FUE creates micro-channels (0.6–0.8mm) that heal completely within 7–10 days, leaving no visible scarring. The donor area can be worn short (even buzzed) with no detection. Unlike FUT, there is no linear scar.',
					),
					array(
						'q' => 'How many grafts will I need?',
						'a' => 'Depends on your Norwood classification and coverage goals. Typical ranges: hairline restoration (1500–2500 grafts), crown filling (2000–3000 grafts), full coverage (4000–5000 grafts). VeaHealth’s surgeons provide exact counts during pre-treatment assessment.',
					),
					array(
						'q' => 'Can I fly home immediately after?',
						'a' => 'Yes. You can fly the day after surgery (day 2). Most patients stay 2–3 nights in Istanbul total — day 1 for procedure, day 2 for post-op care and first wash, then fly home. VeaHealth coordinates all logistics.',
					),
					array(
						'q' => 'Is the warranty valid internationally?',
						'a' => 'Yes. VeaHealth’s lifetime graft warranty covers transplanted follicles that fail to grow (< 2% incidence). Valid worldwide with full documentation. If a warranty claim arises, VeaHealth coordinates resolution remotely or via re-treatment.',
					),
					array(
						'q' => 'Am I a good candidate?',
						'a' => 'Most men and women with pattern hair loss are candidates. Requirements: sufficient donor area density, realistic expectations, good general health. Not suitable for: diffuse unpatterned alopecia, alopecia areata, active scalp infections. VeaHealth provides free eligibility assessment via photo analysis.',
					),
				),
			),
		),
		array(
			'slug' => 'manual-fue',
			'title' => 'Manual FUE',
			'h1' => 'Manual FUE Hair Transplant in Istanbul',
			'lead' => 'Follicular units taken one at a time with a hand-held punch rather than a motorised drill. It is slower than motorised FUE and takes fewer grafts in a session — which is the trade being made, because the surgeon feels the resistance of every follicle and follows its angle instead of cutting across it.',
			'trust' => array(
				'Hand-held 0.7–0.9 mm punches',
				'Grafts kept in holding solution, not left dry',
				'Hairline drawn with you before anything is shaved',
				'Donor area assessed before a graft number is promised',
			),
			'price' => '',
			'price_note' => '',
			'stats' => array(),
			'image' => '',
			'caveat' => '',
			'review_note' => 'This page describes standard technique for the procedure. Your own plan — graft numbers, session length and what is realistic for your donor area — is written after a surgeon has reviewed your photographs.',
			'why' => array(
				'label' => 'Why the technique matters',
				'title' => 'What a hand punch buys you',
				'intro' => 'Manual extraction is not automatically better than motorised. It is better at some things, and those things are worth understanding before you choose.',
				'cards' => array(
					array(
						'title' => 'Feel, not just speed',
						'text' => 'A motor turns at a set rate whatever it meets. A hand punch tells the surgeon what the tissue is doing — where the follicle splays, where it curves — and the punch follows it rather than through it.',
					),
					array(
						'title' => 'Lower transection in curly hair',
						'text' => 'Tightly curled follicles curve under the skin. That curve is where motorised punches most often cut the graft in half, and it is the case for manual extraction most often made in the literature.',
					),
					array(
						'title' => 'Less heat at the donor site',
						'text' => 'There is no rotational friction, so no heat generated at the punch tip. Thermal injury to the surrounding tissue is not part of the picture.',
					),
					array(
						'title' => 'Grafts with more surrounding tissue',
						'text' => 'Manual punches are typically taken slightly wider, leaving more protective tissue around the follicle — which matters for how well it survives the hours between extraction and placement.',
					),
					array(
						'title' => 'A slower, smaller session',
						'text' => 'Honestly stated: fewer grafts per day than motorised FUE. A large area may need two days rather than one, and your quote will say so before you book.',
					),
					array(
						'title' => 'Donor area that still looks like one',
						'text' => 'Extraction is spread across the safe donor zone rather than concentrated, so the back of the head thins evenly instead of showing a harvested patch.',
					),
				),
			),
			'procedure' => array(
				'label' => 'On the day',
				'title' => 'What actually happens',
				'intro' => 'One long day, or two shorter ones for a large area. You are awake throughout and you can talk, listen to something, and eat at the break.',
				'steps' => array(
					array(
						'tag' => 'Before anything is shaved',
						'title' => 'Design and donor assessment',
						'text' => 'The hairline is drawn on your forehead and you look at it in a mirror before anyone agrees to it. Donor density is measured, not estimated, and that measurement sets the graft number.',
						'points' => array(
							'Hairline drawn with you, in front of a mirror',
							'Donor density measured with a densitometer',
							'Realistic graft count agreed and written down',
							'Photographs taken for your record',
						),
					),
					array(
						'tag' => 'Morning',
						'title' => 'Anaesthetic and extraction',
						'text' => 'Local anaesthetic to the donor area — the injections are the uncomfortable part and they take a couple of minutes. Extraction then proceeds follicle by follicle with the hand punch.',
						'points' => array(
							'Local anaesthetic only; you stay awake',
							'Punches sized to your follicle calibre',
							'Grafts sorted by hair count as they come out',
							'Held in chilled solution, never left to dry',
						),
					),
					array(
						'tag' => 'Midday',
						'title' => 'Incisions',
						'text' => 'The recipient sites are opened at the angle and direction your existing hair grows. This step decides whether the result looks grown or planted, and it is the part that cannot be rushed.',
						'points' => array(
							'Angle and direction matched to native hair',
							'Single-hair grafts at the hairline, denser units behind',
							'Density planned for how it will look grown out, not on day one',
						),
					),
					array(
						'tag' => 'Afternoon',
						'title' => 'Placement',
						'text' => 'Grafts are placed into the prepared sites. Single-hair units go to the front edge; three- and four-hair units go behind them where density reads rather than where it would look artificial.',
						'points' => array(
							'Placed by hair count, front to back',
							'Time out of body kept as short as the session allows',
							'Final photographs before you leave',
						),
					),
					array(
						'tag' => 'Before you go',
						'title' => 'Aftercare briefing',
						'text' => 'You are shown how to wash, what to sleep on, and what the first fortnight looks like — then given the same in writing and a number to reach your coordinator on.',
						'points' => array(
							'First wash demonstrated, not just described',
							'Written aftercare in your language',
							'Medication explained and supplied',
							'Coordinator contactable after you fly home',
						),
					),
				),
			),
			'recovery' => array(
				'label' => 'Week by week',
				'title' => 'What recovery actually looks like',
				'intro' => 'Nothing here is unusual and none of it is a complication. It is what healing looks like.',
				'phases' => array(
					array(
						'n' => 'Days 1–3',
						'title' => 'Days 1–3',
						'text' => 'Swelling of the forehead is common and settles. Sleep with the head elevated.',
						'points' => array(),
					),
					array(
						'n' => 'Days 7–10',
						'title' => 'Days 7–10',
						'text' => 'Crusts separate after the washing protocol. Donor area closes over.',
						'points' => array(),
					),
					array(
						'n' => 'Weeks 2–8',
						'title' => 'Weeks 2–8',
						'text' => 'Shock loss: transplanted hairs shed. This is expected — the follicle stays.',
						'points' => array(),
					),
					array(
						'n' => 'Months 3–6',
						'title' => 'Months 3–6',
						'text' => 'New growth begins, initially fine and lighter than surrounding hair.',
						'points' => array(),
					),
					array(
						'n' => 'Months 9–12',
						'title' => 'Months 9–12',
						'text' => 'Thickening and texture match. Assessment photographs at 12 months.',
						'points' => array(),
					),
				),
			),
			'faq' => array(
				'label' => '',
				'title' => '',
				'intro' => '',
				'items' => array(
					array(
						'q' => 'Is manual FUE better than motorised FUE?',
						'a' => 'Neither is better in every case. Manual extraction gives the surgeon more control per graft and is often preferred for curly hair, scarred donor areas and hairline work. Motorised extraction is faster and suits large sessions in straight, average-calibre hair. Your assessment will say which is being proposed for you, and why.',
					),
					array(
						'q' => 'How many grafts can be taken in one manual session?',
						'a' => 'Fewer than with a motorised punch, because each unit is harvested by hand. The number depends on your donor density and scalp laxity and is quoted after the assessment. Large cases are sometimes planned across two sittings rather than forced into one.',
					),
					array(
						'q' => 'Will there be a scar?',
						'a' => 'There is no linear scar. Each extraction leaves a round point under a millimetre across, which heals as a small pale dot and is not visible at normal hair length.',
					),
					array(
						'q' => 'Is the procedure painful?',
						'a' => 'The scalp is fully anaesthetised locally, so the procedure itself is not painful. The anaesthetic injections sting briefly. Discomfort afterwards is usually managed with simple analgesia.',
					),
					array(
						'q' => 'When can I fly home?',
						'a' => 'Most patients fly the day after the procedure, following the first wash at the clinic. Your coordinator will schedule the flight around that appointment.',
					),
				),
			),
		),
		array(
			'slug' => 'oxycure',
			'title' => 'OxyCure',
			'h1' => 'OxyCure Recovery Support',
			'lead' => 'An oxygen-assisted protocol offered after hair transplantation, aimed at the comfort of the first few days — swelling, crusting and the feel of the donor area. It is an adjunct to aftercare. It is not a treatment for hair loss and it does not change how many of your grafts survive.',
			'trust' => array(
				'Offered as an addition, never as a replacement for aftercare',
				'Declining it changes nothing else about your treatment',
				'What it does and does not do, stated plainly',
				'Not charged for separately without being told first',
			),
			'price' => '',
			'price_note' => '',
			'stats' => array(),
			'image' => '',
			'caveat' => 'What this does not do: it does not increase graft survival, it does not make hair grow faster, and it does not substitute for the washing routine and medication you are sent home with. Anyone telling you otherwise is selling. If you would rather not have it, say so — nothing else about your treatment changes.',
			'review_note' => 'This page describes standard technique for the procedure. Your own plan — graft numbers, session length and what is realistic for your donor area — is written after a surgeon has reviewed your photographs.',
			'procedure' => array(
				'label' => 'What is involved',
				'title' => 'The protocol, step by step',
				'intro' => 'Short sessions in the days after your procedure, usually while you are still in Istanbul.',
				'steps' => array(
					array(
						'tag' => 'Day of procedure',
						'title' => 'Assessment',
						'text' => 'Your surgeon decides whether the protocol is appropriate for you at all. Some people are better served by rest and the standard aftercare, and are told so.',
						'points' => array(
							'Reviewed against your medical history',
							'Skipped where it adds nothing',
							'Explained before it is agreed to',
						),
					),
					array(
						'tag' => 'Days 1–3',
						'title' => 'Sessions',
						'text' => 'Short supervised sessions at the clinic, scheduled around your washing appointments so you are not making extra journeys.',
						'points' => array(
							'Supervised by clinic staff throughout',
							'Scheduled with your other appointments',
							'Stopped at any point if you would rather not continue',
						),
					),
					array(
						'tag' => 'Before you fly',
						'title' => 'Handover',
						'text' => 'Whatever was done is written into your treatment record, so any clinician you see at home knows exactly what you had.',
						'points' => array(
							'Written into your discharge record',
							'Coordinator briefed',
							'No ongoing commitment once you are home',
						),
					),
				),
			),
			'recovery' => array(
				'label' => 'Week by week',
				'title' => 'What recovery actually looks like',
				'intro' => 'The recovery below is the recovery from your transplant. The protocol is intended to make the first few days of it more comfortable — not to shorten it.',
				'phases' => array(
					array(
						'n' => 'Days 1–3',
						'title' => 'Days 1–3',
						'text' => 'Sessions scheduled around your first wash appointment.',
						'points' => array(),
					),
					array(
						'n' => 'Days 7–10',
						'title' => 'Days 7–10',
						'text' => 'Crust separation follows the normal timeline.',
						'points' => array(),
					),
					array(
						'n' => 'Weeks 2–8',
						'title' => 'Weeks 2–8',
						'text' => 'Shock loss occurs as usual — the protocol does not prevent it.',
						'points' => array(),
					),
					array(
						'n' => 'Months 3–12',
						'title' => 'Months 3–12',
						'text' => 'Growth follows the standard timeline; assessed at 12 months.',
						'points' => array(),
					),
				),
			),
			'faq' => array(
				'label' => '',
				'title' => '',
				'intro' => '',
				'items' => array(
					array(
						'q' => 'Does OxyCure make hair grow faster?',
						'a' => 'No protocol reliably accelerates the biological growth cycle. Transplanted follicles shed and regrow on their own timeline — visible growth from around month three, assessment at twelve months. Any clinic promising faster growth is overselling.',
					),
					array(
						'q' => 'Is it included in the treatment package?',
						'a' => 'It depends on the clinic and the package. Ask for it to be itemised in your written quote before you travel so there is no charge you did not expect.',
					),
					array(
						'q' => 'Is it safe?',
						'a' => 'The application is non-surgical and painless, but suitability is a clinical decision. Your surgeon reviews it against your medical history, and it is not offered where it is contraindicated.',
					),
					array(
						'q' => 'Can I decline it?',
						'a' => 'Yes, at any point, and it will not affect the rest of your treatment. Standard aftercare is what your result depends on.',
					),
				),
			),
		),
		array(
			'slug' => 'beard-mustache-transplant',
			'title' => 'Beard & Mustache Transplant',
			'h1' => 'Beard and Moustache Transplant in Istanbul',
			'lead' => 'Follicular units moved from the back of the scalp into the beard, moustache or the gaps left by scarring. The technique is FUE; what makes it beard work rather than scalp work is the angle — facial hair leaves the skin almost flat, and grafts placed at scalp angles look wrong however well they grow.',
			'trust' => array(
				'Single-hair grafts through the moustache and edges',
				'Placed at facial angles, not scalp angles',
				'Design agreed with you before anything is shaved',
				'Works over acne and burn scarring as well as patchy growth',
			),
			'price' => '',
			'price_note' => '',
			'stats' => array(),
			'image' => '',
			'caveat' => '',
			'review_note' => 'This page describes standard technique for the procedure. Your own plan — graft numbers, session length and what is realistic for your donor area — is written after a surgeon has reviewed your photographs.',
			'why' => array(
				'label' => 'What it is good for',
				'title' => 'Where a beard transplant earns its place',
				'intro' => 'Density is only half of it. Most of the difficulty is in direction, and most bad results are bad for that reason.',
				'cards' => array(
					array(
						'title' => 'Patchiness, not baldness',
						'text' => 'The common case is not an absent beard but an uneven one — a thin patch on one cheek, a gap under the corner of the mouth. Those are the cases that fill in most convincingly.',
					),
					array(
						'title' => 'Scars that will not grow',
						'text' => 'Acne scarring, surgical scars and burns leave permanent gaps. Grafts placed into scar tissue take less reliably than into healthy skin, which is said up front rather than after.',
					),
					array(
						'title' => 'Angle is the whole job',
						'text' => 'Beard hair exits the skin at roughly 15 to 20 degrees — nearly flat. Grafts set at scalp angles stand up, catch the light differently, and read as transplanted from across a room.',
					),
					array(
						'title' => 'Single hairs at every edge',
						'text' => 'The moustache border, the cheek line and the jaw edge take single-hair grafts. Multi-hair units there produce tufting, which is not fixable afterwards.',
					),
					array(
						'title' => 'Donor that matches',
						'text' => 'Hair is taken from the lower occipital scalp, where calibre and texture come closest to beard hair. It keeps growing scalp-fast, so it needs trimming.',
					),
					array(
						'title' => 'One session, usually',
						'text' => 'Most beard cases are 1,000 to 3,000 grafts and are done in a day. Your own number comes from your donor area and the area being filled, not from a price list.',
					),
				),
			),
			'procedure' => array(
				'label' => 'On the day',
				'title' => 'How the day runs',
				'intro' => 'A single day, local anaesthetic, awake throughout.',
				'steps' => array(
					array(
						'tag' => 'First',
						'title' => 'Design',
						'text' => 'The beard line is drawn on your face and you approve it in a mirror. Where the moustache meets the lip and where the cheek line falls are decisions made now, with you, not improvised later.',
						'points' => array(
							'Drawn on and checked in a mirror',
							'Cheek line and moustache border agreed',
							'Photographed before starting',
						),
					),
					array(
						'tag' => 'Morning',
						'title' => 'Extraction from the scalp',
						'text' => 'Grafts are taken from the lower back of the head under local anaesthetic, sorted by hair count, and kept in chilled holding solution.',
						'points' => array(
							'Lower occipital donor, for calibre match',
							'Sorted into single and multi-hair units',
							'Held chilled, not left dry',
						),
					),
					array(
						'tag' => 'Midday',
						'title' => 'Recipient sites',
						'text' => 'Sites are opened at facial angles — close to flat, following the direction each part of the beard grows. Direction changes across the face and the incisions change with it.',
						'points' => array(
							'Angles close to flat, as facial hair grows',
							'Direction varied across cheek, jaw and moustache',
							'Single-hair sites at every visible edge',
						),
					),
					array(
						'tag' => 'Afternoon',
						'title' => 'Placement',
						'text' => 'Single hairs go to the borders, denser units into the body of the beard where they will not be read individually.',
						'points' => array(
							'Singles at the borders',
							'Multi-hair units placed centrally',
							'Checked in daylight before you leave',
						),
					),
				),
			),
			'recovery' => array(
				'label' => 'Week by week',
				'title' => 'What recovery actually looks like',
				'intro' => 'Facial skin heals fast and visibly. Plan for the crusting to be obvious for about a week.',
				'phases' => array(
					array(
						'n' => 'Days 1–3',
						'title' => 'Days 1–3',
						'text' => 'Redness and small crusts across the beard area. Mild facial swelling is common.',
						'points' => array(),
					),
					array(
						'n' => 'Days 7–10',
						'title' => 'Days 7–10',
						'text' => 'Crusts separate with the washing protocol. Redness fades over days to weeks.',
						'points' => array(),
					),
					array(
						'n' => 'Weeks 2–8',
						'title' => 'Weeks 2–8',
						'text' => 'Shock loss: transplanted hairs shed. Expected, and not a failure.',
						'points' => array(),
					),
					array(
						'n' => 'Months 3–6',
						'title' => 'Months 3–6',
						'text' => 'Growth begins. Texture is initially finer than surrounding beard hair.',
						'points' => array(),
					),
					array(
						'n' => 'Months 9–12',
						'title' => 'Months 9–12',
						'text' => 'Full texture and density. Trimming and shaving normally resumed long before this.',
						'points' => array(),
					),
				),
			),
			'faq' => array(
				'label' => '',
				'title' => '',
				'intro' => '',
				'items' => array(
					array(
						'q' => 'Will the transplanted beard hair keep growing?',
						'a' => 'Yes. Grafts taken from the permanent zone at the back of the scalp keep the characteristics of their origin, so they continue to grow and will need trimming — sometimes faster than the rest of your beard.',
					),
					array(
						'q' => 'Can I shave normally afterwards?',
						'a' => 'Yes, once your surgeon clears it — usually a few weeks after the procedure. Shaving too early risks dislodging grafts that have not yet secured.',
					),
					array(
						'q' => 'How many grafts does a beard need?',
						'a' => 'It depends entirely on the area being covered and the density you want. Filling thin corners takes far fewer grafts than building a full beard from sparse growth. The number is quoted after your photographs are reviewed.',
					),
					array(
						'q' => 'Will it look different from my existing beard?',
						'a' => 'Scalp hair is often slightly finer than beard hair, so new growth can differ in texture at first. It thickens over the first year. Direction and angle matter more than texture for whether the result reads as natural.',
					),
					array(
						'q' => 'Can it cover scars?',
						'a' => 'Often, yes, though survival in scar tissue is lower than in healthy skin because blood supply is poorer. Your surgeon will tell you what to expect for your specific scar and may plan a second session.',
					),
				),
			),
		),
		array(
			'slug' => 'eyebrow-restoration',
			'title' => 'Eyebrow Restoration',
			'h1' => 'Eyebrow Restoration in Istanbul',
			'lead' => 'Single-hair grafts placed one at a time to rebuild eyebrows lost to over-plucking, scarring, alopecia or age. It is the most exacting work in hair restoration: a few hundred grafts, every one placed individually, at angles so shallow the hair lies almost against the skin.',
			'trust' => array(
				'Single-hair grafts only, no multi-hair units',
				'Shape drawn with you and photographed before starting',
				'Transplanted brows keep growing and need trimming',
				'Honest about what a scarred brow bed can hold',
			),
			'price' => '',
			'price_note' => '',
			'stats' => array(),
			'image' => '',
			'caveat' => '',
			'review_note' => 'This page describes standard technique for the procedure. Your own plan — graft numbers, session length and what is realistic for your donor area — is written after a surgeon has reviewed your photographs.',
			'why' => array(
				'label' => 'What makes it different',
				'title' => 'Why eyebrows are the hard case',
				'intro' => 'A brow is a few hundred grafts against a scalp case of several thousand. It is not a smaller version of the same job.',
				'cards' => array(
					array(
						'title' => 'Every graft is a single hair',
						'text' => 'Brow hairs grow individually. A two-hair graft anywhere in a brow shows as a tuft, and once it has grown in there is no discreet way to correct it.',
					),
					array(
						'title' => 'Angles near flat',
						'text' => 'Brow hairs lie almost against the skin. Sites are opened at roughly 10 to 15 degrees; anything steeper and the hair stands away from the face.',
					),
					array(
						'title' => 'Direction turns along the brow',
						'text' => 'Hairs at the head of the brow sweep upward, the mid-brow runs outward, the tail angles down. Each region is incised separately to follow it.',
					),
					array(
						'title' => 'It keeps growing',
						'text' => 'The donor is scalp hair and it behaves like scalp hair — it will need trimming every few weeks, for good. Anyone who does not tell you that beforehand has not told you the main thing.',
					),
					array(
						'title' => 'Design outlasts fashion',
						'text' => 'Brow shapes date. The design is drawn to your bone structure rather than to whatever shape is current, because this is not a shape you can grow out of.',
					),
					array(
						'title' => 'Scarred beds take less',
						'text' => 'Where the brow was lost to burns, tattooing or scarring, blood supply is poorer and a proportion of grafts will not take. A second session is sometimes planned from the start.',
					),
				),
			),
			'procedure' => array(
				'label' => 'On the day',
				'title' => 'A half day, closely worked',
				'intro' => 'Two to four hours for most cases, under local anaesthetic.',
				'steps' => array(
					array(
						'tag' => 'Before starting',
						'title' => 'Drawing the shape',
						'text' => 'The brow is drawn on and adjusted with you until you are happy with it in a mirror. It is photographed at that point, and that photograph is what the surgeon works to.',
						'points' => array(
							'Drawn to your bone structure',
							'Adjusted with you until agreed',
							'Photographed as the working reference',
						),
					),
					array(
						'tag' => 'Extraction',
						'title' => 'Selecting the donor hair',
						'text' => 'Finer hair is chosen deliberately — usually from above the ear or the nape, where calibre is closest to brow hair rather than the coarser crown.',
						'points' => array(
							'Finest available donor hair selected',
							'Extracted as single-hair units',
							'Kept chilled between extraction and placement',
						),
					),
					array(
						'tag' => 'Incisions',
						'title' => 'Opening the sites',
						'text' => 'Several hundred sites are opened individually, each at the angle and direction that part of the brow grows. This is the slowest part of the day and the part that decides the result.',
						'points' => array(
							'Every site angled individually',
							'Direction rotated along the brow',
							'Density planned to read as a brow, not a line',
						),
					),
					array(
						'tag' => 'Placement',
						'title' => 'Placing single hairs',
						'text' => 'Hairs are placed one at a time, curvature turned so each one lies the way it should against the skin.',
						'points' => array(
							'One hair per site',
							'Natural curve oriented against the skin',
							'Both brows compared before finishing',
						),
					),
				),
			),
			'recovery' => array(
				'label' => 'Week by week',
				'title' => 'What recovery actually looks like',
				'intro' => 'The brows look their strangest around day three and normal again inside a fortnight.',
				'phases' => array(
					array(
						'n' => 'Days 1–3',
						'title' => 'Days 1–3',
						'text' => 'Small crusts on the brow. Mild swelling around the eyes is common.',
						'points' => array(),
					),
					array(
						'n' => 'Days 7–10',
						'title' => 'Days 7–10',
						'text' => 'Crusts separate. The brow looks close to normal to anyone but you.',
						'points' => array(),
					),
					array(
						'n' => 'Weeks 2–8',
						'title' => 'Weeks 2–8',
						'text' => 'Shock loss: the transplanted hairs shed. Expected.',
						'points' => array(),
					),
					array(
						'n' => 'Months 3–6',
						'title' => 'Months 3–6',
						'text' => 'Regrowth begins. First trimming becomes necessary.',
						'points' => array(),
					),
					array(
						'n' => 'Months 9–12',
						'title' => 'Months 9–12',
						'text' => 'Final shape and density. Trimming continues indefinitely.',
						'points' => array(),
					),
				),
			),
			'faq' => array(
				'label' => '',
				'title' => '',
				'intro' => '',
				'items' => array(
					array(
						'q' => 'How many grafts does an eyebrow need?',
						'a' => 'Usually a few hundred per brow, depending on how much native hair remains and the shape being rebuilt. The count is quoted after your photographs are reviewed — it is far lower than a scalp procedure.',
					),
					array(
						'q' => 'Do I really have to trim them forever?',
						'a' => 'Yes. Transplanted hairs keep the growth cycle of their donor site, so they grow to scalp length rather than brow length. Trimming every two to four weeks becomes part of your routine, permanently. Anyone who tells you otherwise is not being straight with you.',
					),
					array(
						'q' => 'Can it fix over-plucked brows?',
						'a' => 'This is one of the most common reasons for the procedure. Years of plucking can stop follicles regrowing altogether, and grafting is the reliable way to rebuild the shape.',
					),
					array(
						'q' => 'Will it look natural?',
						'a' => 'That depends almost entirely on angle, direction and restraint in density. A brow grafted at the wrong angle looks wrong no matter how many hairs it has. Ask to see the surgeon\'s own eyebrow cases, not general clinic results.',
					),
					array(
						'q' => 'Can I have it done with a scalp procedure at the same time?',
						'a' => 'Often yes, if your donor supply allows for both. It is planned at assessment so the donor area is not over-harvested.',
					),
				),
			),
		),
		array(
			'slug' => 'female-hair-transplant',
			'title' => 'Female Hair Transplant',
			'h1' => 'Hair Transplant for Women in Istanbul',
			'lead' => 'Female hair loss is usually diffuse rather than patterned, which changes what a transplant can do and who it suits. The first step is not surgery — it is finding out why the hair is thinning, because a good proportion of female hair loss has a cause that treatment reverses without an operation.',
			'trust' => array(
				'Cause investigated before surgery is offered',
				'Unshaven technique available in suitable cases',
				'Donor stability assessed, not assumed',
				'Told plainly when a transplant is not the answer',
			),
			'price' => '',
			'price_note' => '',
			'stats' => array(),
			'image' => '',
			'caveat' => '',
			'review_note' => 'This page describes standard technique for the procedure. Your own plan — graft numbers, session length and what is realistic for your donor area — is written after a surgeon has reviewed your photographs.',
			'why' => array(
				'label' => 'What is different',
				'title' => 'Why this is not the male procedure with a different patient',
				'intro' => 'The technique is the same. Almost everything around it is not.',
				'cards' => array(
					array(
						'title' => 'The cause comes first',
						'text' => 'Thyroid disorder, iron deficiency, post-partum shedding, traction from tight styling and several autoimmune conditions all thin hair, and all are treated without surgery. Bloods and an examination come before any surgical discussion.',
					),
					array(
						'title' => 'Diffuse, not patterned',
						'text' => 'Female loss usually thins the whole crown rather than clearing a defined area. There is existing hair among which grafts must be placed without damaging what is already there.',
					),
					array(
						'title' => 'The donor may be affected too',
						'text' => 'Male donor hair is usually resistant to the hormone driving the loss. In diffuse female loss the back of the head can be thinning as well — if it is, transplanting from it moves the problem rather than solving it.',
					),
					array(
						'title' => 'Hairline lowering',
						'text' => 'A large share of female cases are not thinning at all but a naturally high hairline that someone wants brought forward. That is a straightforward, very predictable procedure.',
					),
					array(
						'title' => 'Traction loss can be rebuilt',
						'text' => 'Hair lost to years of tight braids, weaves or extensions often will not return on its own once the follicle has gone. Those temples and edges transplant well.',
					),
					array(
						'title' => 'Without shaving, where possible',
						'text' => 'Grafts can be taken from a small hidden window under longer hair, so nothing visible is cut. It is slower and takes fewer grafts in a session, and it is not right for every case.',
					),
				),
			),
			'procedure' => array(
				'label' => 'How it runs',
				'title' => 'From first photographs to the day itself',
				'intro' => 'The assessment stage matters more here than anywhere else in hair restoration.',
				'steps' => array(
					array(
						'tag' => 'Before anything is booked',
						'title' => 'Finding the cause',
						'text' => 'Photographs, history and blood work. If the thinning has a medical cause, treating that comes first — and if it resolves the loss, no surgery is offered.',
						'points' => array(
							'Thyroid and iron screened',
							'Medication and post-partum history reviewed',
							'Scarring alopecias ruled out before surgery is considered',
							'Told plainly if a transplant is not appropriate',
						),
					),
					array(
						'tag' => 'Assessment',
						'title' => 'Donor and design',
						'text' => 'Donor density is measured across the safe zone, including the areas most likely to be affected by diffuse loss. The hairline is designed to your face and, if you have one, to old photographs.',
						'points' => array(
							'Donor measured, not estimated',
							'Miniaturisation checked across the donor zone',
							'Design worked out with you and photographed',
						),
					),
					array(
						'tag' => 'On the day',
						'title' => 'Extraction',
						'text' => 'Under local anaesthetic, either from a small shaved window concealed under longer hair or from a conventionally shaved donor area, depending on what was agreed.',
						'points' => array(
							'Unshaven window where the case allows',
							'Local anaesthetic; you stay awake',
							'Grafts sorted and held chilled',
						),
					),
					array(
						'tag' => 'On the day',
						'title' => 'Placement among existing hair',
						'text' => 'Sites are opened between the hairs already there — the constraint that defines female cases. Existing follicles must not be damaged in the process of adding to them.',
						'points' => array(
							'Incisions placed between surviving follicles',
							'Angle matched to the surrounding hair',
							'Density built where it reads, at the part and hairline',
						),
					),
				),
			),
			'recovery' => array(
				'label' => 'Week by week',
				'title' => 'What recovery actually looks like',
				'intro' => 'Longer hair hides most of this, which is one practical advantage of the female case.',
				'phases' => array(
					array(
						'n' => 'Days 1–3',
						'title' => 'Days 1–3',
						'text' => 'Mild swelling and redness. With no-shave, hair covers the area immediately.',
						'points' => array(),
					),
					array(
						'n' => 'Days 7–10',
						'title' => 'Days 7–10',
						'text' => 'Crusts separate with the washing protocol.',
						'points' => array(),
					),
					array(
						'n' => 'Weeks 2–8',
						'title' => 'Weeks 2–8',
						'text' => 'Shock loss affects both transplanted and some surrounding native hairs. Native hair recovers.',
						'points' => array(),
					),
					array(
						'n' => 'Months 3–6',
						'title' => 'Months 3–6',
						'text' => 'Regrowth begins. Density builds gradually.',
						'points' => array(),
					),
					array(
						'n' => 'Months 12–18',
						'title' => 'Months 12–18',
						'text' => 'Female cases are assessed later than male cases, often at 18 months.',
						'points' => array(),
					),
				),
			),
			'faq' => array(
				'label' => '',
				'title' => '',
				'intro' => '',
				'items' => array(
					array(
						'q' => 'Do I have to shave my head?',
						'a' => 'Not necessarily. The no-shave technique trims donor hair only in narrow strips hidden beneath surrounding hair, so nothing is visible with your hair down. It takes longer and harvests fewer grafts per session, so suitability is decided at assessment.',
					),
					array(
						'q' => 'Am I a candidate if my thinning is all over?',
						'a' => 'Possibly not. Diffuse thinning can include the donor area, and transplanting unstable donor hair gives a result that fades. Trichoscopy establishes donor stability. If it is not stable, you will be told so — medical treatment may be the better route.',
					),
					array(
						'q' => 'Why do you need blood tests first?',
						'a' => 'Because iron deficiency, thyroid disorders and hormonal changes are common, treatable causes of female hair loss. Operating without addressing them means the underlying loss continues afterwards.',
					),
					array(
						'q' => 'Can a transplant fix a receding hairline from braids or extensions?',
						'a' => 'Traction alopecia often responds well, provided the tension has stopped and the follicles are not permanently scarred. Trichoscopy shows which of the two you have.',
					),
					array(
						'q' => 'How long until I see the result?',
						'a' => 'Female results are typically assessed at twelve to eighteen months, slightly later than male cases, because density builds among existing hair rather than into bare scalp.',
					),
				),
			),
		),
	);
	$data = array();
	foreach ( $rows as $row ) {
		$data[ $row['slug'] ] = $row;
	}
	return $data;
}

/**
 * One treatment's structured body.
 *
 * @param string $slug Treatment slug.
 * @return array
 */
function veahealth_service_parts( $slug ) {
	$all = veahealth_service_data();
	return isset( $all[ $slug ] ) ? $all[ $slug ] : array();
}

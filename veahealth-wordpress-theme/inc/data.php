<?php
/**
 * Patient results, clinic photography and the journey steps.
 *
 * Every photograph referenced here was supplied by the clinic. The before
 * and after images are real patients, not stock and not generated.
 *
 * @package VeaHealth
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Before and after cases shown with the drag-to-compare slider. */
function veahealth_results() {
	return array(
		array(
			'img' => 'full-arch-implants-zirconium-crowns-male-patient-55',
			'alt' => 'Before and after full-arch implant treatment with zirconium crowns, male patient aged 55',
			'title' => 'Full-arch implants + zirconium crowns',
			'meta' => 'Male, 55 · United Kingdom',
			'detail' => '6 implants, 24 zirconium crowns',
		),
		array(
			'img' => 'hollywood-smile-zirconium-crowns-female-patient',
			'alt' => 'Before and after smile transformation with zirconium crowns, female patient',
			'title' => 'Hollywood smile with zirconium crowns',
			'meta' => 'Female · International patient',
			'detail' => 'Upper and lower arch',
		),
		array(
			'img' => 'full-mouth-restoration-male-patient',
			'alt' => 'Before and after full mouth restoration, male patient',
			'title' => 'Full mouth restoration',
			'meta' => 'Male · International patient',
			'detail' => 'Implants and fixed prosthesis',
		),
		array(
			'img' => 'smile-makeover-veneers-female-patient',
			'alt' => 'Before and after smile makeover with veneers, female patient',
			'title' => 'Smile makeover with veneers',
			'meta' => 'Female · International patient',
			'detail' => 'E-max veneers, upper arch',
		),
		array(
			'img' => 'smile-design-crowns-female-patient',
			'alt' => 'Before and after digital smile design with ceramic crowns, female patient',
			'title' => 'Digital smile design with crowns',
			'meta' => 'Female · International patient',
			'detail' => 'Full smile line correction',
		),
		array(
			'img' => 'orthodontic-smile-correction-young-female-patient',
			'alt' => 'Before and after smile correction, young female patient',
			'title' => 'Smile correction',
			'meta' => 'Female · International patient',
			'detail' => 'Alignment and shade correction',
		),
	);
}

/** Photographs of the partner clinic. */
function veahealth_clinic_images() {
	return array(
		array( 'img' => 'vea-health-clinic-lounge-istanbul', 'alt' => 'VeaHealth partner clinic lounge in Istanbul with designer lighting' ),
		array( 'img' => 'vea-health-treatment-room-istanbul', 'alt' => 'Treatment room at a VeaHealth partner clinic in Istanbul' ),
		array( 'img' => 'vea-health-reception-istanbul', 'alt' => 'Reception area of a VeaHealth partner clinic in Istanbul' ),
		array( 'img' => 'vea-health-waiting-area-istanbul', 'alt' => 'Patient waiting area at a VeaHealth partner clinic in Istanbul' ),
		array( 'img' => 'hybrid-prosthesis-zirconium-detail', 'alt' => 'Close-up of a zirconium hybrid prosthesis produced for a VeaHealth patient' ),
	);
}

/** The four stages of the patient journey. */
function veahealth_journey() {
	return array(
		array(
			'title' => __( 'Remote assessment', 'veahealth' ),
			'meta'  => __( 'Before you travel', 'veahealth' ),
			'text'  => __( 'You send photographs and any recent X-rays through the enquiry form or WhatsApp. A partner dentist reviews them and returns a written treatment plan with a fixed, itemised price — before you commit to anything.', 'veahealth' ),
			'img'   => 'journey-travel-flatlay',
			'alt'   => __( 'Passport, boarding pass and sunglasses laid out on linen before a medical trip', 'veahealth' ),
			'list'  => array(
				__( 'Photo and X-ray review by a partner dentist', 'veahealth' ),
				__( 'Written plan with a fixed, itemised quote', 'veahealth' ),
				__( 'Video call with your coordinator if you want one', 'veahealth' ),
			),
		),
		array(
			'title' => __( 'Arrival and transfer', 'veahealth' ),
			'meta'  => __( 'Day one', 'veahealth' ),
			'text'  => __( 'You are met at Istanbul Airport and driven to your hotel. Your coordinator handles the schedule, the clinic appointments and translation for the whole stay.', 'veahealth' ),
			'img'   => 'journey-vip-transfer-istanbul',
			'alt'   => __( 'Black executive sedan waiting at the arrivals terminal of Istanbul Airport at night', 'veahealth' ),
			'list'  => array(
				__( 'Private airport pickup on arrival', 'veahealth' ),
				__( 'Hotel booked and coordinated with your treatment dates', 'veahealth' ),
				__( 'English-speaking coordinator with you at every appointment', 'veahealth' ),
			),
		),
		array(
			'title' => __( 'Accommodation', 'veahealth' ),
			'meta'  => __( 'Throughout your stay', 'veahealth' ),
			'text'  => __( 'Partner hotels are chosen for proximity to the clinic and for rest — recovery is part of the treatment, not an afterthought.', 'veahealth' ),
			'img'   => 'journey-hotel-bosphorus-suite',
			'alt'   => __( 'Hotel suite in Istanbul with a window overlooking the Bosphorus in morning light', 'veahealth' ),
			'list'  => array(
				__( 'Hotel within short reach of the clinic', 'veahealth' ),
				__( 'Transfers between hotel and clinic every treatment day', 'veahealth' ),
				__( 'Quiet rooms suited to post-operative rest', 'veahealth' ),
			),
		),
		array(
			'title' => __( 'Treatment and planning', 'veahealth' ),
			'meta'  => __( 'At the clinic', 'veahealth' ),
			'text'  => __( 'It starts with what you want — the result you have in mind and what matters most to you. The digital scans and smile design are then built around that, and the dentist takes you through the plan on screen. Nothing begins until you have seen it, changed what you wanted, and agreed.', 'veahealth' ),
			'img'   => 'dsd-plan-explained',
			'alt'   => __( 'Dentist pointing at a wall screen showing a digital smile design while a patient looks on in a consultation room', 'veahealth' ),
			'list'  => array(
				__( 'The dentist asks what result you want before anything is planned', 'veahealth' ),
				__( 'The plan is shown on screen and changed with you until you agree', 'veahealth' ),
				__( 'Shade matched under natural light', 'veahealth' ),
			),
		),
	);
}

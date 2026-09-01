<?php
/**
 * The company pages, in every language.
 *
 * These pages carry no body text of their own — their prose lives in the page
 * templates and is translated through gettext like the rest of the interface.
 * What is stored per page is a title, a slug and an excerpt, and that is all
 * this file has to supply.
 *
 * Slugs are translated rather than transliterated. A French reader searching
 * for "le parcours" should find a URL that says so, and Arabic URLs are shown
 * decoded by every current browser — the percent-encoding is only how they
 * travel. Translated slugs also mean no two languages ever want the same one,
 * which is what would otherwise leave WordPress appending -2 to a page.
 *
 * @package VeaHealth
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @return array<string,array<string,array{title:string,slug:string,excerpt:string}>>
 *         Keyed by the English slug, then by language.
 */
function veahealth_pages_i18n() {
	return array(

		'journey' => array(
			'fr' => array(
				'title'   => 'Le parcours',
				'slug'    => 'le-parcours',
				'excerpt' => 'Comment se déroule réellement un traitement à Istanbul : évaluation à distance, devis écrit, transfert aéroport, hôtel, soins et suivi une fois rentré.',
			),
			'ar' => array(
				'title'   => 'الرحلة',
				'slug'    => 'الرحلة',
				'excerpt' => 'كيف يسير العلاج في إسطنبول فعلاً: تقييم عن بُعد، عرض سعر مكتوب، نقل من المطار، فندق، علاج، ومتابعة بعد عودتك.',
			),
			'es' => array(
				'title'   => 'El recorrido',
				'slug'    => 'el-recorrido',
				'excerpt' => 'Cómo funciona realmente un tratamiento en Estambul: evaluación a distancia, presupuesto por escrito, traslado desde el aeropuerto, hotel, tratamiento y seguimiento al volver a casa.',
			),
		),

		'before-after' => array(
			'fr' => array(
				'title'   => 'Avant et après',
				'slug'    => 'avant-apres',
				'excerpt' => 'Photographies avant et après de patients VeaHealth soignés à Istanbul, avec un curseur de comparaison.',
			),
			'ar' => array(
				'title'   => 'قبل وبعد',
				'slug'    => 'قبل-وبعد',
				'excerpt' => 'صور قبل وبعد لمرضى VeaHealth عولجوا في إسطنبول، مع أداة مقارنة بالسحب.',
			),
			'es' => array(
				'title'   => 'Antes y después',
				'slug'    => 'antes-y-despues',
				'excerpt' => 'Fotografías de antes y después de pacientes de VeaHealth tratados en Estambul, con un control deslizante para comparar.',
			),
		),

		'gallery' => array(
			'fr' => array(
				'title'   => 'Clinique et installations',
				'slug'    => 'clinique-installations',
				'excerpt' => 'Photographies et film de la clinique partenaire VeaHealth à Istanbul : salles de soins, laboratoire et espaces patients.',
			),
			'ar' => array(
				'title'   => 'العيادة والمرافق',
				'slug'    => 'العيادة-والمرافق',
				'excerpt' => 'صور وفيلم من العيادة الشريكة لـVeaHealth في إسطنبول: غرف العلاج، المختبر، ومناطق المرضى.',
			),
			'es' => array(
				'title'   => 'Clínica e instalaciones',
				'slug'    => 'clinica-instalaciones',
				'excerpt' => 'Fotografías y vídeo de la clínica asociada de VeaHealth en Estambul: salas de tratamiento, laboratorio y zonas de pacientes.',
			),
		),

		'about' => array(
			'fr' => array(
				'title'   => 'À propos',
				'slug'    => 'a-propos',
				'excerpt' => 'VeaHealth est un coordinateur de tourisme médical à Istanbul travaillant avec des cliniques partenaires agréées. Ce que nous faisons, ce que nous ne faisons pas, et les questions à poser à tout coordinateur.',
			),
			'ar' => array(
				'title'   => 'من نحن',
				'slug'    => 'من-نحن',
				'excerpt' => 'VeaHealth منسّق سياحة علاجية في إسطنبول يعمل مع عيادات شريكة مرخّصة. ما نقوم به، وما لا نقوم به، والأسئلة التي تستحق أن تُطرح على أي منسّق.',
			),
			'es' => array(
				'title'   => 'Quiénes somos',
				'slug'    => 'quienes-somos',
				'excerpt' => 'VeaHealth es un coordinador de turismo médico en Estambul que trabaja con clínicas asociadas autorizadas. Lo que hacemos, lo que no hacemos y las preguntas que conviene hacer a cualquier coordinador.',
			),
		),

		'contact' => array(
			'fr' => array(
				'title'   => 'Évaluation gratuite',
				'slug'    => 'evaluation-gratuite',
				'excerpt' => 'Envoyez des photos et vos radiographies récentes pour une évaluation gratuite. Un dentiste partenaire renvoie un plan de traitement détaillé à prix ferme, par écrit.',
			),
			'ar' => array(
				'title'   => 'تقييم مجاني',
				'slug'    => 'تقييم-مجاني',
				'excerpt' => 'أرسل صوراً وأي أشعة حديثة للحصول على تقييم مجاني. يعيد إليك طبيب شريك خطة علاج مفصّلة بسعر ثابت، مكتوبة.',
			),
			'es' => array(
				'title'   => 'Evaluación gratuita',
				'slug'    => 'evaluacion-gratuita',
				'excerpt' => 'Envíe fotos y radiografías recientes para una evaluación gratuita. Un dentista asociado le devuelve un plan de tratamiento detallado con precio cerrado, por escrito.',
			),
		),

		'blog' => array(
			'fr' => array(
				'title'   => 'Journal',
				'slug'    => 'journal',
				'excerpt' => 'Notes sur les soins, le voyage et le discernement, pour les patients qui hésitent encore à partir.',
			),
			'ar' => array(
				'title'   => 'المدوّنة',
				'slug'    => 'المدونة',
				'excerpt' => 'ملاحظات عن العلاج والسفر والتمييز، لمرضى ما زالوا يقرّرون هل يسافرون.',
			),
			'es' => array(
				'title'   => 'Blog',
				'slug'    => 'blog-es',
				'excerpt' => 'Notas sobre tratamiento, viaje y criterio, para pacientes que aún están decidiendo si viajar.',
			),
		),

		'home' => array(
			'fr' => array(
				'title'   => 'Accueil',
				'slug'    => 'accueil',
				'excerpt' => 'VeaHealth coordonne les soins dentaires et la greffe de cheveux à Istanbul : un plan écrit et un prix ferme avant le départ, transferts et hôtel organisés, et un suivi une fois rentré.',
			),
			'ar' => array(
				'title'   => 'الرئيسية',
				'slug'    => 'الرئيسية',
				'excerpt' => 'تنسّق VeaHealth علاج الأسنان وزراعة الشعر في إسطنبول: خطة مكتوبة وسعر ثابت قبل السفر، نقل وفندق مرتَّبان، ومتابعة بعد عودتك.',
			),
			'es' => array(
				'title'   => 'Inicio',
				'slug'    => 'inicio',
				'excerpt' => 'VeaHealth coordina tratamientos dentales y de trasplante capilar en Estambul: plan por escrito y precio cerrado antes de viajar, traslados y hotel organizados, y seguimiento al volver a casa.',
			),
		),
	);
}

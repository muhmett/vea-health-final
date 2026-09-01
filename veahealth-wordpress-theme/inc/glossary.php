<?php
/**
 * The clinical vocabulary, fixed before anything is translated.
 *
 * Forty-three terms carry the treatment pages. Left to be decided sentence by
 * sentence, one of them comes out two ways on two pages and the reader notices
 * — on a medical site that reads as carelessness about the medicine, not about
 * the writing. So they are decided once, here, and every translation draws
 * from this.
 *
 * ON ARABIC, WHICH IS THE HARD ONE.
 *
 * The word a textbook uses and the word a patient types into Google are often
 * not the same word, and choosing either alone loses something real. Write only
 * "غَرْسة سنّية" and nobody searching for an implant finds the page; write only
 * "زراعة" and the page reads like an advert rather than a clinic. So each term
 * carries both: `term` is what patients say and what the page leads with,
 * `sci` is the precise form, given once alongside it on first use.
 *
 * Register is Modern Standard Arabic. Patients come from the Gulf, the Levant
 * and North Africa; no dialect is common to them, and none is right for
 * medicine.
 *
 * Where `note` exists it records a decision that could otherwise be
 * second-guessed, or a place where the industry's usual wording is wrong.
 *
 * French is metropolitan; Spanish is European (es-ES), which is where most
 * Spanish-speaking patients travelling to Türkiye come from.
 *
 * @package VeaHealth
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @return array<string,array{ar:array{term:string,sci?:string,note?:string},fr:string,es:string}>
 */
function veahealth_glossary() {
	return array(

		/* ---------------------------------------------------------------
		   Dental — the implant itself
		   --------------------------------------------------------------- */

		'dental implant' => array(
			'ar' => array( 'term' => 'زراعة الأسنان', 'sci' => 'غَرْسة سنّية' ),
			'fr' => 'implant dentaire',
			'es' => 'implante dental',
		),
		'implant' => array(
			'ar' => array( 'term' => 'زرعة', 'sci' => 'غَرْسة',
				'note' => 'The fixture itself. Patients say زرعة; غرسة is the precise noun.' ),
			'fr' => 'implant',
			'es' => 'implante',
		),
		'abutment' => array(
			'ar' => array( 'term' => 'الدعامة', 'sci' => 'دِعامة الغرسة' ),
			'fr' => 'pilier implantaire',
			'es' => 'pilar',
		),
		'osseointegration' => array(
			'ar' => array( 'term' => 'الاندماج العظمي', 'sci' => 'التحام العظم بالغرسة' ),
			'fr' => 'ostéo-intégration',
			'es' => 'osteointegración',
		),
		'crown' => array(
			'ar' => array( 'term' => 'تلبيسة', 'sci' => 'تاج سنّي',
				'note' => 'تلبيسة is what patients across the Gulf and Levant say and search; تاج is the term a dentist writes.' ),
			'fr' => 'couronne',
			'es' => 'corona',
		),
		'zirconia' => array(
			'ar' => array( 'term' => 'الزيركون', 'sci' => 'الزِركونيا',
				'note' => 'Searched overwhelmingly as زيركون. Both spellings kept so either finds the page.' ),
			'fr' => 'zircone',
			'es' => 'circonio',
		),
		'veneer' => array(
			'ar' => array( 'term' => 'فينير', 'sci' => 'قشرة خزفية',
				'note' => 'Never «عدسات الأسنان» — Egyptian marketing coinage, not a clinical term.' ),
			'fr' => 'facette dentaire',
			'es' => 'carilla dental',
		),
		'prosthesis' => array(
			'ar' => array( 'term' => 'التركيبة', 'sci' => 'تعويض سنّي ثابت' ),
			'fr' => 'prothèse',
			'es' => 'prótesis',
		),
		'provisional' => array(
			'ar' => array( 'term' => 'مؤقت', 'sci' => 'تعويض مؤقت' ),
			'fr' => 'provisoire',
			'es' => 'provisional',
		),

		/* ---------------------------------------------------------------
		   Dental — surgery and bone
		   --------------------------------------------------------------- */

		'extraction' => array(
			'ar' => array( 'term' => 'خلع السن', 'sci' => 'قلع سنّي' ),
			'fr' => 'extraction',
			'es' => 'extracción',
		),
		'socket' => array(
			'ar' => array( 'term' => 'تجويف السن', 'sci' => 'السِنخ' ),
			'fr' => 'alvéole',
			'es' => 'alvéolo',
		),
		'bone graft' => array(
			'ar' => array( 'term' => 'ترقيع العظم', 'sci' => 'تطعيم عظمي' ),
			'fr' => 'greffe osseuse',
			'es' => 'injerto óseo',
		),
		'sinus lift' => array(
			'ar' => array( 'term' => 'رفع الجيب الفكّي', 'sci' => 'رفع الجيب الفكّي العلوي' ),
			'fr' => 'élévation du sinus',
			'es' => 'elevación de seno',
		),
		'all-on-4' => array(
			'ar' => array( 'term' => 'All-on-4', 'sci' => 'تعويض الفك الكامل على أربع غرسات',
				'note' => 'Kept in Latin: it is a trademarked protocol name and patients search it as written.' ),
			'fr' => 'All-on-4',
			'es' => 'All-on-4',
		),
		'all-on-6' => array(
			'ar' => array( 'term' => 'All-on-6', 'sci' => 'تعويض الفك الكامل على ست غرسات' ),
			'fr' => 'All-on-6',
			'es' => 'All-on-6',
		),
		'occlusion' => array(
			'ar' => array( 'term' => 'الإطباق', 'sci' => 'الإطباق السنّي' ),
			'fr' => 'occlusion',
			'es' => 'oclusión',
		),
		'gum' => array(
			'ar' => array( 'term' => 'اللثة', 'sci' => 'اللثة' ),
			'fr' => 'gencive',
			'es' => 'encía',
		),
		'periodontal' => array(
			'ar' => array( 'term' => 'أمراض اللثة', 'sci' => 'نسيج ما حول السن' ),
			'fr' => 'parodontal',
			'es' => 'periodontal',
		),
		'root canal' => array(
			'ar' => array( 'term' => 'سحب العصب', 'sci' => 'معالجة لبّ السن',
				'note' => 'سحب العصب is inaccurate but universal; the precise form is given beside it once.' ),
			'fr' => 'traitement de canal',
			'es' => 'endodoncia',
		),
		'whitening' => array(
			'ar' => array( 'term' => 'تبييض الأسنان', 'sci' => 'تبييض الأسنان' ),
			'fr' => 'blanchiment dentaire',
			'es' => 'blanqueamiento dental',
		),
		'bruxism' => array(
			'ar' => array( 'term' => 'صرير الأسنان', 'sci' => 'الجَز على الأسنان' ),
			'fr' => 'bruxisme',
			'es' => 'bruxismo',
		),

		/* ---------------------------------------------------------------
		   Hair restoration
		   --------------------------------------------------------------- */

		'hair transplant' => array(
			'ar' => array( 'term' => 'زراعة الشعر', 'sci' => 'زراعة الشعر' ),
			'fr' => 'greffe de cheveux',
			'es' => 'trasplante capilar',
		),
		'graft' => array(
			'ar' => array( 'term' => 'طُعم', 'sci' => 'طُعم شعري',
				'note' => 'NOT بُصيلة. A graft holds one to four hairs; a follicle is one. Clinics quote graft counts and let patients read them as hairs, which inflates the apparent result. The two words stay distinct on this site.' ),
			'fr' => 'greffon',
			'es' => 'injerto',
		),
		'follicle' => array(
			'ar' => array( 'term' => 'بُصيلة', 'sci' => 'جُريب شعري' ),
			'fr' => 'follicule',
			'es' => 'folículo',
		),
		'follicular unit' => array(
			'ar' => array( 'term' => 'وحدة مسامية', 'sci' => 'وحدة جُريبية' ),
			'fr' => 'unité folliculaire',
			'es' => 'unidad folicular',
		),
		'fue' => array(
			'ar' => array( 'term' => 'تقنية FUE', 'sci' => 'اقتطاف الوحدات المسامية' ),
			'fr' => 'FUE (extraction d’unités folliculaires)',
			'es' => 'FUE (extracción de unidades foliculares)',
		),
		'dhi' => array(
			'ar' => array( 'term' => 'تقنية DHI', 'sci' => 'الزراعة المباشرة بقلم تشوي' ),
			'fr' => 'DHI (implantation directe)',
			'es' => 'DHI (implantación directa)',
		),
		'sapphire' => array(
			'ar' => array( 'term' => 'الياقوت (سفير)', 'sci' => 'شفرات الياقوت',
				'note' => 'The sapphire is the blade that opens the channel, not the graft. Worth saying plainly: the wording in this market often implies otherwise.' ),
			'fr' => 'saphir',
			'es' => 'zafiro',
		),
		'donor area' => array(
			'ar' => array( 'term' => 'المنطقة المانحة', 'sci' => 'المنطقة المانحة' ),
			'fr' => 'zone donneuse',
			'es' => 'zona donante',
		),
		'recipient area' => array(
			'ar' => array( 'term' => 'المنطقة المستقبِلة', 'sci' => 'المنطقة المستقبِلة' ),
			'fr' => 'zone receveuse',
			'es' => 'zona receptora',
		),
		'hairline' => array(
			'ar' => array( 'term' => 'خط الشعر الأمامي', 'sci' => 'خط الشعر الأمامي' ),
			'fr' => 'ligne frontale',
			'es' => 'línea frontal',
		),
		'density' => array(
			'ar' => array( 'term' => 'الكثافة', 'sci' => 'كثافة الشعر' ),
			'fr' => 'densité',
			'es' => 'densidad',
		),
		'shock loss' => array(
			'ar' => array( 'term' => 'التساقط الصدمي', 'sci' => 'التساقط الصدمي المؤقت',
				'note' => 'Say «مؤقت» every time. Patients meet this at week three and think the transplant failed.' ),
			'fr' => 'chute de choc',
			'es' => 'caída por shock',
		),
		'prp' => array(
			'ar' => array( 'term' => 'حقن البلازما PRP', 'sci' => 'البلازما الغنية بالصفائح' ),
			'fr' => 'PRP (plasma riche en plaquettes)',
			'es' => 'PRP (plasma rico en plaquetas)',
		),
		'mesotherapy' => array(
			'ar' => array( 'term' => 'الميزوثيرابي', 'sci' => 'المعالجة الوسطية' ),
			'fr' => 'mésothérapie',
			'es' => 'mesoterapia',
		),

		/* ---------------------------------------------------------------
		   Imaging, anaesthesia, logistics
		   --------------------------------------------------------------- */

		'cbct' => array(
			'ar' => array( 'term' => 'أشعة CBCT', 'sci' => 'التصوير المقطعي المخروطي' ),
			'fr' => 'CBCT (cone beam)',
			'es' => 'CBCT (haz cónico)',
		),
		'panoramic' => array(
			'ar' => array( 'term' => 'أشعة بانورامية', 'sci' => 'صورة شعاعية بانورامية' ),
			'fr' => 'panoramique dentaire',
			'es' => 'radiografía panorámica',
		),
		'local anaesthetic' => array(
			'ar' => array( 'term' => 'تخدير موضعي', 'sci' => 'تخدير موضعي' ),
			'fr' => 'anesthésie locale',
			'es' => 'anestesia local',
		),
		'sedation' => array(
			'ar' => array( 'term' => 'التخدير الواعي', 'sci' => 'التركين الواعي' ),
			'fr' => 'sédation consciente',
			'es' => 'sedación consciente',
		),
		'general anaesthesia' => array(
			'ar' => array( 'term' => 'تخدير كلي', 'sci' => 'تخدير عام' ),
			'fr' => 'anesthésie générale',
			'es' => 'anestesia general',
		),
		'session' => array(
			'ar' => array( 'term' => 'جلسة', 'sci' => 'جلسة علاجية' ),
			'fr' => 'séance',
			'es' => 'sesión',
		),
		'consultation' => array(
			'ar' => array( 'term' => 'استشارة', 'sci' => 'استشارة طبية' ),
			'fr' => 'consultation',
			'es' => 'consulta',
		),
		'treatment plan' => array(
			'ar' => array( 'term' => 'خطة العلاج', 'sci' => 'الخطة العلاجية' ),
			'fr' => 'plan de traitement',
			'es' => 'plan de tratamiento',
		),
		'follow-up' => array(
			'ar' => array( 'term' => 'المتابعة', 'sci' => 'المتابعة بعد العلاج' ),
			'fr' => 'suivi',
			'es' => 'seguimiento',
		),
	);
}

/**
 * One term in one language.
 *
 * @param string $key  Glossary key, lower case.
 * @param string $lang Language code.
 * @param bool   $sci  Return the precise form rather than the searched one.
 * @return string Empty when the term is not in the glossary.
 */
function veahealth_term( $key, $lang, $sci = false ) {
	$all = veahealth_glossary();
	$key = strtolower( trim( $key ) );
	if ( ! isset( $all[ $key ][ $lang ] ) ) {
		return '';
	}
	$entry = $all[ $key ][ $lang ];
	if ( ! is_array( $entry ) ) {
		return (string) $entry;
	}
	return $sci && ! empty( $entry['sci'] ) ? $entry['sci'] : $entry['term'];
}

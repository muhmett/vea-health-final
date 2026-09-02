<?php
/**
 * The company pages, in every language.
 *
 * Most of these pages carry no body text of their own — their prose lives in
 * the page templates and is translated through gettext like the rest of the
 * interface. What is stored per page is a title, a slug and an excerpt, and
 * for those pages that is all this file has to supply.
 *
 * The three legal pages are the exception. Their text is stored in the page
 * itself, so each language needs its own body, and it is kept here beside the
 * title rather than in the gettext catalogue: a policy is one document, read
 * and amended as a whole, not a hundred loose sentences.
 *
 * A translated policy is the clinic's own binding statement in that language,
 * not a convenience — it should be read by someone who can hold the clinic to
 * it before it is relied on.
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
				/*
				 * Not "blog": slugs are unique per post type, the English page
				 * already holds it, and WordPress would have suffixed this one
				 * into /es/blog-2/. "Artículos" is what the section is.
				 */
				'title'   => 'Artículos',
				'slug'    => 'articulos',
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
		'privacy-policy' => array(
			'fr' => array(
				'title'   => 'Politique de confidentialité',
				'slug'    => 'politique-confidentialite',
				'excerpt' => 'Ce que nous collectons lorsque vous nous écrivez, pourquoi nous le conservons, combien de temps, et comment le faire supprimer.',
				'content' => <<<'VH_L_0'
<h2 data-anim="up" style="margin-top:clamp(34px,4vw,52px);font-size:var(--step-2)">Qui est responsable</h2><p class="mt-24" data-anim="up">VeaHealth, établie à Istanbul, en Türkiye, est responsable du traitement des données personnelles collectées via ce site. Vous pouvez nous joindre à <a href="mailto:info@veahealthturkey.com">info@veahealthturkey.com</a> ou au <bdi dir="ltr">+90 531 432 92 15</bdi>.</p><h2 data-anim="up" style="margin-top:clamp(34px,4vw,52px);font-size:var(--step-2)">Ce que nous collectons</h2><p class="mt-24" data-anim="up"><b>Lorsque vous utilisez le formulaire de demande :</b> votre nom, votre adresse e-mail, votre numéro de téléphone, votre pays, les traitements que vous avez sélectionnés, la période de voyage que vous indiquez et tout ce que vous écrivez dans le champ message.</p><p class="mt-24" data-anim="up"><b>Lorsque vous envoyez des photographies ou des radiographies :</b> des images de vos dents, de votre bouche, de votre cuir chevelu ou de votre visage, ainsi que toute information clinique que vous choisissez d’y joindre. Au sens de l’article 9 du RGPD, il s’agit de données de santé, une catégorie particulière de données personnelles. Nous ne les traitons que sur la base de votre consentement explicite, donné au moment où vous envoyez le formulaire ou les images, et uniquement pour préparer et discuter une évaluation de traitement.</p><p class="mt-24" data-anim="up"><b>Lorsque vous acceptez les cookies de mesure d’audience :</b> des données d’usage agrégées indiquant quelles pages sont consultées. Aucune balise de mesure d’audience n’est chargée avant votre acceptation — voir la <a href="%VH_HOME%/politique-cookies/">politique cookies</a>.</p><h2 data-anim="up" style="margin-top:clamp(34px,4vw,52px);font-size:var(--step-2)">Pourquoi nous l’utilisons</h2><p class="mt-24" data-anim="up">Pour étudier votre dossier avec une clinique partenaire, préparer un plan de traitement et un devis, organiser le voyage et les rendez-vous si vous décidez de poursuivre, et vous répondre ensuite. Nous ne vendons pas vos données et nous ne les partageons pas à des fins publicitaires.</p><h2 data-anim="up" data-vh="share" style="margin-top:clamp(34px,4vw,52px);font-size:var(--step-2)">Avec qui nous le partageons</h2><p class="mt-24" data-anim="up">La clinique partenaire et les praticiens qui participent à la préparation ou à la réalisation de votre plan de traitement, ainsi que l’hôtel ou le prestataire de transfert lorsqu’une réservation est faite pour vous. Nos prestataires de messagerie et d’hébergement traitent les données pour notre compte, dans le cadre d’un contrat.</p><p class="mt-24" data-anim="up">La Türkiye se situe en dehors de l’Espace économique européen. Si vous vous trouvez dans l’EEE ou au Royaume-Uni, vos données sont transférées vers la Türkiye sur la base de votre consentement explicite à l’évaluation, transfert nécessaire pour vous fournir ce que vous avez demandé.</p><h2 data-anim="up" style="margin-top:clamp(34px,4vw,52px);font-size:var(--step-2)">Combien de temps nous les conservons</h2><p class="mt-24" data-anim="up">Les demandes qui n’aboutissent pas à un traitement sont supprimées dans un délai de 24 mois. Lorsque le traitement a lieu, les dossiers sont conservés pendant la durée imposée par les obligations turques de conservation des dossiers de santé, et détenus par la clinique traitante.</p><h2 data-anim="up" style="margin-top:clamp(34px,4vw,52px);font-size:var(--step-2)">Vos droits</h2><p class="mt-24" data-anim="up">Vous pouvez demander une copie des données que nous détenons sur vous, en demander la rectification, en demander l’effacement, demander la limitation de leur utilisation, ou retirer votre consentement à tout moment — y compris le consentement à la conservation de photographies cliniques. Le retrait du consentement ne remet pas en cause les traitements déjà effectués.</p><p class="mt-24" data-anim="up">Écrivez à <a href="mailto:info@veahealthturkey.com">info@veahealthturkey.com</a> et nous répondrons sous 30 jours. Si vous vous trouvez dans l’EEE ou au Royaume-Uni et que notre réponse ne vous satisfait pas, vous pouvez saisir l’autorité de protection des données de votre pays.</p><h2 data-anim="up" style="margin-top:clamp(34px,4vw,52px);font-size:var(--step-2)">Sécurité</h2><p class="mt-24" data-anim="up">Ce site est servi en HTTPS. Les données de la demande sont transmises chiffrées et leur accès est limité aux coordinateurs et aux praticiens qui en ont besoin pour traiter votre dossier.</p>
<p class="mt-48" style="font-size:.84rem;color:var(--ink-3)">Dernière mise à jour le 28 août 2026.
Questions à propos de cette page : <a href="mailto:info@veahealthturkey.com">info@veahealthturkey.com</a>.</p>
VH_L_0,
			),
			'ar' => array(
				'title'   => 'سياسة الخصوصية',
				'slug'    => 'سياسة-الخصوصية',
				'excerpt' => 'ما الذي نجمعه عند استفسارك، ولماذا نحتفظ به، وكم من الوقت، وكيف تطلب حذفه.',
				'content' => <<<'VH_L_1'
<h2 data-anim="up" style="margin-top:clamp(34px,4vw,52px);font-size:var(--step-2)">من المسؤول</h2><p class="mt-24" data-anim="up">شركة VeaHealth، ومقرّها إسطنبول في تركيا، هي المتحكّم في البيانات الشخصية التي تُجمع عبر هذا الموقع. يمكنك الوصول إلينا على <a href="mailto:info@veahealthturkey.com">info@veahealthturkey.com</a> أو على <bdi dir="ltr">+90 531 432 92 15</bdi>.</p><h2 data-anim="up" style="margin-top:clamp(34px,4vw,52px);font-size:var(--step-2)">ما الذي نجمعه</h2><p class="mt-24" data-anim="up"><b>عند استخدامك نموذج الاستفسار:</b> اسمك، وبريدك الإلكتروني، ورقم هاتفك، وبلدك، والعلاجات التي اخترتها، وموعد السفر الذي حدّدته، وكل ما تكتبه في خانة الرسالة.</p><p class="mt-24" data-anim="up"><b>عند إرسالك صوراً أو أشعّة:</b> صور أسنانك أو فمك أو فروة رأسك أو وجهك، وأي معلومات سريرية تختار إرفاقها. وبموجب المادة 9 من اللائحة العامة لحماية البيانات (GDPR) تُعدّ هذه بيانات صحية، وهي فئة خاصة من البيانات الشخصية. لا نعالجها إلا استناداً إلى موافقتك الصريحة، التي تمنحها عند إرسال النموذج أو الصور، ولغرض واحد لا غير: إعداد تقييم علاجي ومناقشته معك.</p><p class="mt-24" data-anim="up"><b>عند قبولك ملفات تعريف الارتباط الخاصة بالتحليلات:</b> بيانات استخدام مجمّعة عن الصفحات التي تُزار. ولا يُحمَّل أي وسم تحليلات قبل قبولك — انظر <a href="%VH_HOME%/سياسة-ملفات-تعريف-الارتباط/">سياسة ملفات تعريف الارتباط</a>.</p><h2 data-anim="up" style="margin-top:clamp(34px,4vw,52px);font-size:var(--step-2)">لماذا نستخدمها</h2><p class="mt-24" data-anim="up">لمراجعة حالتك مع عيادة شريكة، وإعداد خطة علاج وعرض سعر، وترتيب السفر والمواعيد إن قرّرت المضيّ قدماً، وللردّ عليك بعد ذلك. لا نبيع بياناتك ولا نشاركها لأغراض إعلانية.</p><h2 data-anim="up" data-vh="share" style="margin-top:clamp(34px,4vw,52px);font-size:var(--step-2)">مع من نشاركها</h2><p class="mt-24" data-anim="up">العيادة الشريكة والأطباء المعالجون المشاركون في إعداد خطة علاجك أو تنفيذها، والفندق أو شركة النقل عند إجراء حجز لك. ويعالج مزوّدو البريد الإلكتروني والاستضافة لدينا البيانات نيابةً عنّا وبموجب عقد.</p><p class="mt-24" data-anim="up">تقع تركيا خارج المنطقة الاقتصادية الأوروبية. وإذا كنت في المنطقة الاقتصادية الأوروبية أو في المملكة المتحدة، تُنقل بياناتك إلى تركيا استناداً إلى موافقتك الصريحة على التقييم، وهو نقل لازم لتقديم ما طلبته.</p><h2 data-anim="up" style="margin-top:clamp(34px,4vw,52px);font-size:var(--step-2)">كم من الوقت نحتفظ بها</h2><p class="mt-24" data-anim="up">تُحذف الاستفسارات التي لا تؤدي إلى علاج خلال 24 شهراً. أمّا إذا تمّ العلاج فتُحفظ السجلات طوال المدة التي تفرضها التزامات حفظ السجلات الصحية في تركيا، وتحتفظ بها العيادة المعالِجة.</p><h2 data-anim="up" style="margin-top:clamp(34px,4vw,52px);font-size:var(--step-2)">حقوقك</h2><p class="mt-24" data-anim="up">يمكنك أن تطلب نسخة من البيانات التي نحتفظ بها عنك، أو تطلب تصحيحها، أو حذفها، أو تقييد استخدامها، أو أن تسحب موافقتك في أي وقت — بما في ذلك الموافقة على الاحتفاظ بالصور السريرية. وسحب الموافقة لا يؤثّر على المعالجة التي تمّت قبله.</p><p class="mt-24" data-anim="up">اكتب إلى <a href="mailto:info@veahealthturkey.com">info@veahealthturkey.com</a> وسنردّ خلال 30 يوماً. وإذا كنت في المنطقة الاقتصادية الأوروبية أو في المملكة المتحدة ولم يُرضِك ردّنا، يمكنك تقديم شكوى إلى هيئة حماية البيانات في بلدك.</p><h2 data-anim="up" style="margin-top:clamp(34px,4vw,52px);font-size:var(--step-2)">الأمان</h2><p class="mt-24" data-anim="up">يُقدَّم هذا الموقع عبر HTTPS. وتُنقل بيانات الاستفسار مشفّرة، والوصول إليها مقصور على المنسّقين والأطباء الذين يحتاجونها للتعامل مع حالتك.</p>
<p class="mt-48" style="font-size:.84rem;color:var(--ink-3)">آخر تحديث 28 أغسطس 2026.
للأسئلة حول هذه الصفحة: <a href="mailto:info@veahealthturkey.com">info@veahealthturkey.com</a>.</p>
VH_L_1,
			),
			'es' => array(
				'title'   => 'Política de privacidad',
				'slug'    => 'politica-de-privacidad',
				'excerpt' => 'Qué recogemos cuando nos consulta, por qué lo conservamos, cuánto tiempo y cómo pedir que se elimine.',
				'content' => <<<'VH_L_2'
<h2 data-anim="up" style="margin-top:clamp(34px,4vw,52px);font-size:var(--step-2)">Quién es responsable</h2><p class="mt-24" data-anim="up">VeaHealth, con sede en Estambul (Türkiye), es la responsable del tratamiento de los datos personales recogidos a través de este sitio web. Puede escribirnos a <a href="mailto:info@veahealthturkey.com">info@veahealthturkey.com</a> o llamarnos al <bdi dir="ltr">+90 531 432 92 15</bdi>.</p><h2 data-anim="up" style="margin-top:clamp(34px,4vw,52px);font-size:var(--step-2)">Qué recogemos</h2><p class="mt-24" data-anim="up"><b>Cuando utiliza el formulario de consulta:</b> su nombre, su dirección de correo electrónico, su número de teléfono, su país, los tratamientos que ha seleccionado, las fechas de viaje que indica y todo lo que escriba en el campo de mensaje.</p><p class="mt-24" data-anim="up"><b>Cuando envía fotografías o radiografías:</b> imágenes de sus dientes, su boca, su cuero cabelludo o su rostro, y cualquier información clínica que decida incluir. Conforme al artículo 9 del RGPD se trata de datos de salud, una categoría especial de datos personales. Solo los tratamos sobre la base de su consentimiento explícito, prestado al enviar el formulario o las imágenes, y únicamente para preparar y comentar una evaluación de tratamiento.</p><p class="mt-24" data-anim="up"><b>Cuando acepta las cookies analíticas:</b> datos de uso agregados sobre qué páginas se visitan. No se carga ninguna etiqueta analítica hasta que usted acepta — véase la <a href="%VH_HOME%/politica-de-cookies/">política de cookies</a>.</p><h2 data-anim="up" style="margin-top:clamp(34px,4vw,52px);font-size:var(--step-2)">Para qué los usamos</h2><p class="mt-24" data-anim="up">Para revisar su caso con una clínica asociada, preparar un plan de tratamiento y un presupuesto, organizar el viaje y las citas si decide seguir adelante, y responderle después. No vendemos sus datos ni los compartimos con fines publicitarios.</p><h2 data-anim="up" data-vh="share" style="margin-top:clamp(34px,4vw,52px);font-size:var(--step-2)">Con quién los compartimos</h2><p class="mt-24" data-anim="up">La clínica asociada y los profesionales que intervienen en la preparación o la realización de su plan de tratamiento, y el hotel o el proveedor de traslados cuando se hace una reserva para usted. Nuestros proveedores de correo electrónico y de alojamiento tratan los datos por cuenta nuestra en virtud de un contrato.</p><p class="mt-24" data-anim="up">Türkiye está fuera del Espacio Económico Europeo. Si usted se encuentra en el EEE o en el Reino Unido, sus datos se transfieren a Türkiye sobre la base de su consentimiento explícito a la evaluación, transferencia necesaria para prestarle lo que ha solicitado.</p><h2 data-anim="up" style="margin-top:clamp(34px,4vw,52px);font-size:var(--step-2)">Cuánto tiempo los conservamos</h2><p class="mt-24" data-anim="up">Las consultas que no dan lugar a un tratamiento se eliminan en un plazo de 24 meses. Cuando el tratamiento se lleva a cabo, los historiales se conservan durante el periodo que exigen las obligaciones turcas de conservación de historiales sanitarios, en poder de la clínica que trata al paciente.</p><h2 data-anim="up" style="margin-top:clamp(34px,4vw,52px);font-size:var(--step-2)">Sus derechos</h2><p class="mt-24" data-anim="up">Puede pedir una copia de los datos que tenemos sobre usted, pedirnos que los corrijamos, que los eliminemos, que limitemos su uso, o retirar su consentimiento en cualquier momento — incluido el consentimiento para conservar fotografías clínicas. La retirada del consentimiento no afecta al tratamiento ya realizado.</p><p class="mt-24" data-anim="up">Escriba a <a href="mailto:info@veahealthturkey.com">info@veahealthturkey.com</a> y le responderemos en un plazo de 30 días. Si se encuentra en el EEE o en el Reino Unido y nuestra respuesta no le satisface, puede reclamar ante la autoridad de protección de datos de su país.</p><h2 data-anim="up" style="margin-top:clamp(34px,4vw,52px);font-size:var(--step-2)">Seguridad</h2><p class="mt-24" data-anim="up">Este sitio se sirve mediante HTTPS. Los datos de la consulta se transmiten cifrados y el acceso a ellos se limita a los coordinadores y profesionales que los necesitan para gestionar su caso.</p>
<p class="mt-48" style="font-size:.84rem;color:var(--ink-3)">Última actualización: 28 de agosto de 2026.
Preguntas sobre esta página: <a href="mailto:info@veahealthturkey.com">info@veahealthturkey.com</a>.</p>
VH_L_2,
			),
		),

		'cookie-policy' => array(
			'fr' => array(
				'title'   => 'Politique cookies',
				'slug'    => 'politique-cookies',
				'excerpt' => 'Quels cookies ce site dépose, lesquels attendent votre accord, et comment changer d’avis.',
				'content' => <<<'VH_L_3'
<h2 data-anim="up" style="margin-top:clamp(34px,4vw,52px);font-size:var(--step-2)">Stockage essentiel</h2><p class="mt-24" data-anim="up">Ce site enregistre une seule valeur dans votre navigateur, <code>vh-consent</code>, qui garde en mémoire le choix que vous avez fait afin que la bannière ne réapparaisse pas à chaque page. Elle ne contient aucun identifiant et ne nous est jamais transmise.</p><h2 data-anim="up" style="margin-top:clamp(34px,4vw,52px);font-size:var(--step-2)">Mesure d’audience — uniquement avec votre accord</h2><p class="mt-24" data-anim="up">Si vous choisissez « Accepter la mesure d’audience », nous chargeons Google Analytics pour savoir quelles pages aident les patients à décider. Les adresses IP sont anonymisées. Si vous choisissez « Essentiels uniquement », ou si vous ignorez la bannière, aucun script de mesure d’audience n’est chargé — ni différé, ni mis en file d’attente : pas chargé.</p><h2 data-anim="up" style="margin-top:clamp(34px,4vw,52px);font-size:var(--step-2)">Publicité</h2><p class="mt-24" data-anim="up">Ce site ne dépose aucun cookie publicitaire ni de suivi entre sites.</p><h2 data-anim="up" style="margin-top:clamp(34px,4vw,52px);font-size:var(--step-2)">Changer d’avis</h2><p class="mt-24" data-anim="up">Effacez les données de ce site dans les réglages de votre navigateur et la bannière réapparaîtra lors de votre prochaine visite, vous laissant choisir autrement.</p><h2 data-anim="up" style="margin-top:clamp(34px,4vw,52px);font-size:var(--step-2)">Contenus intégrés</h2><p class="mt-24" data-anim="up">Les vidéos de ce site sont servies depuis notre propre serveur et ne déposent aucun cookie tiers. Suivre un lien vers Facebook, Instagram, YouTube ou WhatsApp vous conduit sur ces services, qui déposent leurs propres cookies selon leurs propres politiques.</p>
<p class="mt-48" style="font-size:.84rem;color:var(--ink-3)">Dernière mise à jour le 28 août 2026.
Questions à propos de cette page : <a href="mailto:info@veahealthturkey.com">info@veahealthturkey.com</a>.</p>
VH_L_3,
			),
			'ar' => array(
				'title'   => 'سياسة ملفات تعريف الارتباط',
				'slug'    => 'سياسة-ملفات-تعريف-الارتباط',
				'excerpt' => 'أي ملفات تعريف ارتباط يضعها هذا الموقع، وأيّها ينتظر موافقتك، وكيف تغيّر رأيك.',
				'content' => <<<'VH_L_4'
<h2 data-anim="up" style="margin-top:clamp(34px,4vw,52px);font-size:var(--step-2)">التخزين الضروري</h2><p class="mt-24" data-anim="up">يخزّن هذا الموقع قيمة واحدة في متصفّحك، <code>vh-consent</code>، تسجّل الاختيار الذي اتخذته بشأن ملفات تعريف الارتباط حتى لا يظهر الشريط من جديد في كل صفحة. وهي لا تحتوي على أي معرّف ولا تصلنا أبداً.</p><h2 data-anim="up" style="margin-top:clamp(34px,4vw,52px);font-size:var(--step-2)">التحليلات — بموافقتك وحدها</h2><p class="mt-24" data-anim="up">إذا اخترت «قبول التحليلات»، نُحمّل Google Analytics لنعرف أي الصفحات تساعد المرضى على اتخاذ قرارهم. وتُخفى عناوين IP. وإذا اخترت «الضروري فقط»، أو تجاهلت الشريط، فلا يُحمَّل أي سكربت تحليلات إطلاقاً — لا مؤجَّلاً ولا في طابور انتظار: لا يُحمَّل.</p><h2 data-anim="up" style="margin-top:clamp(34px,4vw,52px);font-size:var(--step-2)">الإعلانات</h2><p class="mt-24" data-anim="up">لا يضع هذا الموقع أي ملفات تعريف ارتباط إعلانية أو للتتبّع عبر المواقع.</p><h2 data-anim="up" style="margin-top:clamp(34px,4vw,52px);font-size:var(--step-2)">تغيير اختيارك</h2><p class="mt-24" data-anim="up">امسح بيانات هذا الموقع من إعدادات متصفّحك وسيظهر الشريط من جديد في زيارتك التالية، فتتمكّن من اختيار غير ما اخترت.</p><h2 data-anim="up" style="margin-top:clamp(34px,4vw,52px);font-size:var(--step-2)">المحتوى المضمَّن</h2><p class="mt-24" data-anim="up">تُقدَّم مقاطع الفيديو في هذا الموقع من خادمنا نحن ولا تضع أي ملفات تعريف ارتباط لطرف ثالث. أمّا اتّباع رابط إلى فيسبوك أو إنستغرام أو يوتيوب أو واتساب فينقلك إلى تلك الخدمات، وهي تضع ملفاتها هي وفق سياساتها هي.</p>
<p class="mt-48" style="font-size:.84rem;color:var(--ink-3)">آخر تحديث 28 أغسطس 2026.
للأسئلة حول هذه الصفحة: <a href="mailto:info@veahealthturkey.com">info@veahealthturkey.com</a>.</p>
VH_L_4,
			),
			'es' => array(
				'title'   => 'Política de cookies',
				'slug'    => 'politica-de-cookies',
				'excerpt' => 'Qué cookies instala este sitio, cuáles esperan su consentimiento y cómo cambiar de opinión.',
				'content' => <<<'VH_L_5'
<h2 data-anim="up" style="margin-top:clamp(34px,4vw,52px);font-size:var(--step-2)">Almacenamiento esencial</h2><p class="mt-24" data-anim="up">Este sitio guarda un único valor en su navegador, <code>vh-consent</code>, que registra la elección que hizo sobre las cookies para que el aviso no vuelva a aparecer en cada página. No contiene ningún identificador y nunca se nos envía.</p><h2 data-anim="up" style="margin-top:clamp(34px,4vw,52px);font-size:var(--step-2)">Analítica — solo con su consentimiento</h2><p class="mt-24" data-anim="up">Si elige «Aceptar analítica», cargamos Google Analytics para ver qué páginas ayudan a los pacientes a decidir. Las direcciones IP se anonimizan. Si elige «Solo esenciales», o ignora el aviso, no se carga ningún script de analítica en absoluto — ni diferido, ni en cola: no se carga.</p><h2 data-anim="up" style="margin-top:clamp(34px,4vw,52px);font-size:var(--step-2)">Publicidad</h2><p class="mt-24" data-anim="up">Este sitio no instala cookies publicitarias ni de seguimiento entre sitios.</p><h2 data-anim="up" style="margin-top:clamp(34px,4vw,52px);font-size:var(--step-2)">Cambiar su elección</h2><p class="mt-24" data-anim="up">Borre los datos de este sitio en los ajustes de su navegador y el aviso volverá a aparecer en su próxima visita, para que pueda elegir de otro modo.</p><h2 data-anim="up" style="margin-top:clamp(34px,4vw,52px);font-size:var(--step-2)">Contenido incrustado</h2><p class="mt-24" data-anim="up">El vídeo de este sitio se sirve desde nuestro propio servidor y no instala cookies de terceros. Seguir un enlace a Facebook, Instagram, YouTube o WhatsApp le lleva a esos servicios, que instalan sus propias cookies según sus propias políticas.</p>
<p class="mt-48" style="font-size:.84rem;color:var(--ink-3)">Última actualización: 28 de agosto de 2026.
Preguntas sobre esta página: <a href="mailto:info@veahealthturkey.com">info@veahealthturkey.com</a>.</p>
VH_L_5,
			),
		),

		'terms' => array(
			'fr' => array(
				'title'   => 'Conditions d’utilisation',
				'slug'    => 'conditions-utilisation',
				'excerpt' => 'Ce qu’est VeaHealth, ce qu’elle n’est pas, et les limites de ce qui est publié ici.',
				'content' => <<<'VH_L_6'
<h2 data-anim="up" style="margin-top:clamp(34px,4vw,52px);font-size:var(--step-2)">Ce qu’est VeaHealth</h2><p class="mt-24" data-anim="up">VeaHealth est un coordinateur de tourisme médical établi à Istanbul. Nous organisons les évaluations, les plans de traitement, les rendez-vous, les transferts et l’hébergement avec des cliniques partenaires agréées. <b>Nous ne dispensons pas nous-mêmes de soins médicaux ou dentaires.</b> Les soins sont dispensés par la clinique partenaire et ses praticiens, qui sont responsables des soins cliniques qu’ils délivrent.</p><h2 data-anim="up" style="margin-top:clamp(34px,4vw,52px);font-size:var(--step-2)">Ce site ne constitue pas un avis médical</h2><p class="mt-24" data-anim="up">Les pages de traitement de ce site décrivent les interventions en termes généraux. Elles ne sont ni un diagnostic, ni un plan de traitement, ni un substitut à un examen par un praticien qualifié. Seul un praticien qui vous a examiné et a pris connaissance de vos antécédents médicaux peut déterminer si une intervention vous convient.</p><h2 data-anim="up" style="margin-top:clamp(34px,4vw,52px);font-size:var(--step-2)">Prix</h2><p class="mt-24" data-anim="up">Les prix affichés sont des prix de forfait indicatifs à Istanbul à la date de publication et peuvent changer. Le seul prix qui engage qui que ce soit est celui inscrit dans le devis individuel qui vous est remis après l’évaluation. Si un plan doit être modifié en cours de traitement, toute modification de prix est convenue avec vous avant que les actes supplémentaires ne soient réalisés.</p><h2 data-anim="up" style="margin-top:clamp(34px,4vw,52px);font-size:var(--step-2)">Résultats</h2><p class="mt-24" data-anim="up">Les photographies avant et après publiées sur ce site sont celles de patients de VeaHealth, utilisées avec leur accord. Elles montrent ce qui a été obtenu pour ces personnes. Les résultats dépendent de la qualité osseuse, de la santé des gencives et du cuir chevelu, de la réponse à la cicatrisation, des antécédents médicaux et des soins postopératoires, et aucun résultat n’est garanti.</p><h2 data-anim="up" style="margin-top:clamp(34px,4vw,52px);font-size:var(--step-2)">Garantie</h2><p class="mt-24" data-anim="up">Les conditions de garantie diffèrent selon le traitement et selon la clinique et sont précisées dans le plan de traitement écrit qui vous est remis. Lisez ce qui est couvert et ce qui est exclu avant d’accepter un plan.</p><h2 data-anim="up" style="margin-top:clamp(34px,4vw,52px);font-size:var(--step-2)">Liens</h2><p class="mt-24" data-anim="up">Ce site renvoie vers des services tiers tels que WhatsApp et les plateformes sociales. Nous ne sommes responsables ni de leur contenu ni de la manière dont ils traitent vos données.</p><h2 data-anim="up" style="margin-top:clamp(34px,4vw,52px);font-size:var(--step-2)">Droit applicable</h2><p class="mt-24" data-anim="up">Les présentes conditions sont régies par le droit de la République de Türkiye. Rien ici ne limite les droits que vous tenez, en tant que consommateur, du droit de votre pays de résidence.</p>
<p class="mt-48" style="font-size:.84rem;color:var(--ink-3)">Dernière mise à jour le 28 août 2026.
Questions à propos de cette page : <a href="mailto:info@veahealthturkey.com">info@veahealthturkey.com</a>.</p>
VH_L_6,
			),
			'ar' => array(
				'title'   => 'شروط الاستخدام',
				'slug'    => 'شروط-الاستخدام',
				'excerpt' => 'ما هي VeaHealth، وما ليست هي، وحدود ما يُنشر هنا.',
				'content' => <<<'VH_L_7'
<h2 data-anim="up" style="margin-top:clamp(34px,4vw,52px);font-size:var(--step-2)">ما هي VeaHealth</h2><p class="mt-24" data-anim="up">VeaHealth منسّق سياحة علاجية مقرّه إسطنبول. نرتّب التقييمات وخطط العلاج والمواعيد والنقل والإقامة مع عيادات شريكة مرخّصة. <b>نحن لا نقدّم العلاج الطبي أو علاج الأسنان بأنفسنا.</b> فالعلاج تقدّمه العيادة الشريكة وأطبّاؤها، وهم المسؤولون عن الرعاية السريرية التي يقدّمونها.</p><h2 data-anim="up" style="margin-top:clamp(34px,4vw,52px);font-size:var(--step-2)">هذا الموقع ليس استشارة طبية</h2><p class="mt-24" data-anim="up">تصف صفحات العلاج في هذا الموقع الإجراءات بصورة عامة. وهي ليست تشخيصاً ولا خطة علاج ولا بديلاً عن فحص طبيب مؤهَّل. ولا يمكن تحديد ما إذا كان إجراء ما مناسباً لك إلا من طبيب فحصك واطّلع على تاريخك الطبي.</p><h2 data-anim="up" style="margin-top:clamp(34px,4vw,52px);font-size:var(--step-2)">الأسعار</h2><p class="mt-24" data-anim="up">الأسعار المعروضة أسعار باقات استرشادية في إسطنبول وقت النشر وهي قابلة للتغيير. والسعر الوحيد المُلزِم لأي طرف هو المكتوب في عرض السعر الفردي الذي يصدر لك بعد التقييم. وإذا لزم تغيير الخطة أثناء العلاج، يُتَّفق معك على أي تغيير في السعر قبل تنفيذ العمل الإضافي.</p><h2 data-anim="up" style="margin-top:clamp(34px,4vw,52px);font-size:var(--step-2)">النتائج</h2><p class="mt-24" data-anim="up">صور «قبل وبعد» المنشورة في هذا الموقع هي لمرضى VeaHealth، وتُستخدم بإذنهم. وهي تُظهر ما تحقّق لأولئك الأشخاص. وتتوقّف النتائج على جودة العظم، وصحة اللثة وفروة الرأس، واستجابة الالتئام، والتاريخ الطبي، والعناية بعد العلاج، ولا تُضمَن أي نتيجة.</p><h2 data-anim="up" style="margin-top:clamp(34px,4vw,52px);font-size:var(--step-2)">الضمان</h2><p class="mt-24" data-anim="up">تختلف شروط الضمان باختلاف العلاج والعيادة، وهي مبيَّنة في خطة العلاج المكتوبة التي تصدر لك. اقرأ ما يشمله الضمان وما يستثنيه قبل أن تقبل أي خطة.</p><h2 data-anim="up" style="margin-top:clamp(34px,4vw,52px);font-size:var(--step-2)">الروابط</h2><p class="mt-24" data-anim="up">يحيل هذا الموقع إلى خدمات طرف ثالث مثل واتساب ومنصات التواصل. ولسنا مسؤولين عن محتواها ولا عن تعاملها مع بياناتك.</p><h2 data-anim="up" style="margin-top:clamp(34px,4vw,52px);font-size:var(--step-2)">القانون الواجب التطبيق</h2><p class="mt-24" data-anim="up">تخضع هذه الشروط لقوانين الجمهورية التركية. ولا شيء هنا يحدّ من أي حقوق للمستهلك تتمتّع بها بموجب قانون بلد إقامتك.</p>
<p class="mt-48" style="font-size:.84rem;color:var(--ink-3)">آخر تحديث 28 أغسطس 2026.
للأسئلة حول هذه الصفحة: <a href="mailto:info@veahealthturkey.com">info@veahealthturkey.com</a>.</p>
VH_L_7,
			),
			'es' => array(
				'title'   => 'Condiciones de uso',
				'slug'    => 'condiciones-de-uso',
				'excerpt' => 'Qué es VeaHealth, qué no es, y los límites de lo que aquí se publica.',
				'content' => <<<'VH_L_8'
<h2 data-anim="up" style="margin-top:clamp(34px,4vw,52px);font-size:var(--step-2)">Qué es VeaHealth</h2><p class="mt-24" data-anim="up">VeaHealth es un coordinador de turismo médico con sede en Estambul. Organizamos evaluaciones, planes de tratamiento, citas, traslados y alojamiento con clínicas asociadas autorizadas. <b>No prestamos nosotros mismos tratamiento médico ni dental.</b> El tratamiento lo presta la clínica asociada y sus profesionales, que son responsables de la atención clínica que ofrecen.</p><h2 data-anim="up" style="margin-top:clamp(34px,4vw,52px);font-size:var(--step-2)">Este sitio no es asesoramiento médico</h2><p class="mt-24" data-anim="up">Las páginas de tratamiento de este sitio describen los procedimientos en términos generales. No son un diagnóstico, ni un plan de tratamiento, ni un sustituto del examen por un profesional cualificado. Si un procedimiento es adecuado para usted solo puede determinarlo un profesional que le haya examinado y haya revisado su historial médico.</p><h2 data-anim="up" style="margin-top:clamp(34px,4vw,52px);font-size:var(--step-2)">Precios</h2><p class="mt-24" data-anim="up">Los precios mostrados son precios de paquete orientativos en Estambul en el momento de la publicación y pueden cambiar. El único precio que vincula a alguien es el que figura en el presupuesto individual que se le emite tras la evaluación. Si un plan debe cambiar durante el tratamiento, cualquier cambio de precio se acuerda con usted antes de realizar el trabajo adicional.</p><h2 data-anim="up" style="margin-top:clamp(34px,4vw,52px);font-size:var(--step-2)">Resultados</h2><p class="mt-24" data-anim="up">Las fotografías de antes y después publicadas en este sitio son de pacientes de VeaHealth y se utilizan con su permiso. Muestran lo que se consiguió en esas personas. Los resultados dependen de la calidad ósea, la salud de las encías y del cuero cabelludo, la respuesta de cicatrización, el historial médico y los cuidados posteriores, y ningún resultado está garantizado.</p><h2 data-anim="up" style="margin-top:clamp(34px,4vw,52px);font-size:var(--step-2)">Garantía</h2><p class="mt-24" data-anim="up">Las condiciones de garantía varían según el tratamiento y la clínica y se detallan en el plan de tratamiento por escrito que se le entrega. Lea qué cubre y qué excluye antes de aceptar un plan.</p><h2 data-anim="up" style="margin-top:clamp(34px,4vw,52px);font-size:var(--step-2)">Enlaces</h2><p class="mt-24" data-anim="up">Este sitio enlaza a servicios de terceros como WhatsApp y plataformas sociales. No somos responsables de su contenido ni del tratamiento que hagan de sus datos.</p><h2 data-anim="up" style="margin-top:clamp(34px,4vw,52px);font-size:var(--step-2)">Ley aplicable</h2><p class="mt-24" data-anim="up">Estas condiciones se rigen por las leyes de la República de Türkiye. Nada de lo aquí dispuesto limita los derechos que como consumidor le correspondan según la ley de su país de residencia.</p>
<p class="mt-48" style="font-size:.84rem;color:var(--ink-3)">Última actualización: 28 de agosto de 2026.
Preguntas sobre esta página: <a href="mailto:info@veahealthturkey.com">info@veahealthturkey.com</a>.</p>
VH_L_8,
			),
		),
	);
}

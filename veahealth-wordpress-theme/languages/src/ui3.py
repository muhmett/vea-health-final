# -*- coding: utf-8 -*-
# The journey stages, which live in a data array rather than in a template.
T = {
"Remote assessment": ("Évaluation à distance", "تقييم عن بُعد", "Evaluación a distancia"),
"Arrival and transfer": ("Arrivée et transfert", "الوصول والنقل", "Llegada y traslado"),
"Accommodation": ("Hébergement", "الإقامة", "Alojamiento"),
"Treatment and planning": ("Traitement et planification", "العلاج والتخطيط", "Tratamiento y planificación"),
"Before you travel": ("Avant votre départ", "قبل السفر", "Antes de viajar"),
"Day one": ("Jour un", "اليوم الأول", "Día uno"),
"Throughout your stay": ("Pendant tout votre séjour", "طوال إقامتك", "Durante toda su estancia"),
"At the clinic": ("À la clinique", "في العيادة", "En la clínica"),

"You send photographs and any recent X-rays through the enquiry form or WhatsApp. A partner dentist reviews them and returns a written treatment plan with a fixed, itemised price — before you commit to anything.": (
 "Vous envoyez des photos et vos radiographies récentes via le formulaire ou WhatsApp. Un dentiste partenaire les examine et renvoie un plan de traitement écrit à prix ferme et détaillé — avant tout engagement de votre part.",
 "ترسل صوراً وأي أشعة حديثة عبر نموذج الطلب أو واتساب. يراجعها طبيب شريك ويعيد إليك خطة علاج مكتوبة بسعر ثابت ومفصّل — قبل أن تلتزم بأي شيء.",
 "Usted envía fotos y radiografías recientes por el formulario o WhatsApp. Un dentista asociado las revisa y devuelve un plan de tratamiento por escrito con un precio cerrado y desglosado, antes de que se comprometa a nada."),
"You are met at Istanbul Airport and driven to your hotel. Your coordinator handles the schedule, the clinic appointments and translation for the whole stay.": (
 "On vous accueille à l’aéroport d’Istanbul et on vous conduit à votre hôtel. Votre coordinateur gère le planning, les rendez-vous à la clinique et la traduction pendant tout le séjour.",
 "نستقبلك في مطار إسطنبول ونوصلك إلى فندقك. ويتكفّل منسّقك بالجدول ومواعيد العيادة والترجمة طوال الإقامة.",
 "Le recibimos en el aeropuerto de Estambul y le llevamos a su hotel. Su coordinador se encarga del calendario, las citas en la clínica y la traducción durante toda la estancia."),
"Partner hotels are chosen for proximity to the clinic and for rest — recovery is part of the treatment, not an afterthought.": (
 "Les hôtels partenaires sont choisis pour leur proximité avec la clinique et pour le repos — la récupération fait partie du traitement, ce n’est pas un détail.",
 "تُختار الفنادق الشريكة لقربها من العيادة وللراحة — فالتعافي جزء من العلاج، لا أمر ثانوي.",
 "Los hoteles asociados se eligen por su cercanía a la clínica y por el descanso: la recuperación forma parte del tratamiento, no es un añadido."),
"Digital scans, smile design and the treatment itself, carried out by the partner clinical team. You see the plan on screen and approve it before work begins.": (
 "Empreintes numériques, conception du sourire et traitement lui-même, réalisés par l’équipe clinique partenaire. Vous voyez le plan à l’écran et l’approuvez avant que le travail commence.",
 "مسوحات رقمية، وتصميم للابتسامة، والعلاج نفسه، ينفّذه الفريق السريري الشريك. ترى الخطة على الشاشة وتوافق عليها قبل أن يبدأ العمل.",
 "Escaneados digitales, diseño de sonrisa y el propio tratamiento, realizados por el equipo clínico asociado. Usted ve el plan en pantalla y lo aprueba antes de empezar."),

"Passport, boarding pass and sunglasses laid out on linen before a medical trip": (
 "Passeport, carte d’embarquement et lunettes de soleil posés sur du lin avant un voyage médical",
 "جواز سفر وبطاقة صعود ونظارة شمسية مرتّبة على قماش كتّان قبل رحلة علاجية",
 "Pasaporte, tarjeta de embarque y gafas de sol sobre lino antes de un viaje médico"),
"Black executive sedan waiting at the arrivals terminal of Istanbul Airport at night": (
 "Berline noire attendant au terminal des arrivées de l’aéroport d’Istanbul, de nuit",
 "سيارة سيدان سوداء تنتظر عند صالة الوصول بمطار إسطنبول ليلاً",
 "Sedán negro esperando en la terminal de llegadas del aeropuerto de Estambul, de noche"),
"Hotel suite in Istanbul with a window overlooking the Bosphorus in morning light": (
 "Suite d’hôtel à Istanbul avec une fenêtre donnant sur le Bosphore au petit matin",
 "جناح فندقي في إسطنبول بنافذة تطل على البوسفور في ضوء الصباح",
 "Suite de hotel en Estambul con una ventana que da al Bósforo con luz de la mañana"),
"Consultation room with a wall screen showing a three-dimensional dental scan": (
 "Salle de consultation avec un écran mural affichant un scan dentaire en trois dimensions",
 "غرفة استشارة بشاشة جدارية تعرض مسحاً سنّياً ثلاثي الأبعاد",
 "Sala de consulta con una pantalla mural que muestra un escaneado dental tridimensional"),

"Photo and X-ray review by a partner dentist": (
 "Examen des photos et radiographies par un dentiste partenaire",
 "مراجعة الصور والأشعة من طبيب شريك",
 "Revisión de fotos y radiografías por un dentista asociado"),
"Written plan with a fixed, itemised quote": (
 "Plan écrit avec un devis ferme et détaillé",
 "خطة مكتوبة بعرض سعر ثابت ومفصّل",
 "Plan por escrito con presupuesto cerrado y desglosado"),
"Video call with your coordinator if you want one": (
 "Appel vidéo avec votre coordinateur si vous le souhaitez",
 "مكالمة فيديو مع منسّقك إن رغبت",
 "Videollamada con su coordinador si lo desea"),
"Private airport pickup on arrival": (
 "Accueil privé à l’aéroport à votre arrivée",
 "استقبال خاص في المطار عند وصولك",
 "Recogida privada en el aeropuerto a su llegada"),
"Hotel booked and coordinated with your treatment dates": (
 "Hôtel réservé et coordonné avec vos dates de traitement",
 "فندق محجوز ومنسَّق مع مواعيد علاجك",
 "Hotel reservado y coordinado con sus fechas de tratamiento"),
"English-speaking coordinator with you at every appointment": (
 "Coordinateur anglophone présent à chaque rendez-vous",
 "منسّق يتحدث الإنجليزية معك في كل موعد",
 "Coordinador de habla inglesa con usted en cada cita"),
"Hotel within short reach of the clinic": (
 "Hôtel à courte distance de la clinique",
 "فندق على مسافة قصيرة من العيادة",
 "Hotel a poca distancia de la clínica"),
"Transfers between hotel and clinic every treatment day": (
 "Transferts entre l’hôtel et la clinique chaque jour de soins",
 "تنقّلات بين الفندق والعيادة كل يوم علاج",
 "Traslados entre el hotel y la clínica cada día de tratamiento"),
"Quiet rooms suited to post-operative rest": (
 "Chambres calmes adaptées au repos postopératoire",
 "غرف هادئة تناسب الراحة بعد العملية",
 "Habitaciones tranquilas adecuadas para el descanso postoperatorio"),
"Intraoral scanning and digital smile design": (
 "Empreinte optique intrabuccale et conception numérique du sourire",
 "مسح داخل الفم وتصميم رقمي للابتسامة",
 "Escaneado intraoral y diseño digital de sonrisa"),
"Plan reviewed and approved with you before treatment": (
 "Plan revu et approuvé avec vous avant le traitement",
 "خطة تُراجع وتُعتمد معك قبل العلاج",
 "Plan revisado y aprobado con usted antes del tratamiento"),
"Shade matched under natural light": (
 "Teinte choisie à la lumière naturelle",
 "مطابقة اللون تحت الضوء الطبيعي",
 "Color igualado con luz natural"),
}

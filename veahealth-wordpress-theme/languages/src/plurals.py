# -*- coding: utf-8 -*-
# Arabic takes six forms, so a plural is six strings, not two. Getting this
# wrong is the difference between "٣ علاجات" and "٣ علاج".
P = {
 ("%d treatment", "%d treatments"): {
   'fr_FR': ["%d traitement", "%d traitements"],
   'es_ES': ["%d tratamiento", "%d tratamientos"],
   'ar': ["لا توجد علاجات", "علاج واحد", "علاجان",
          "%d علاجات", "%d علاجاً", "%d علاج"],
 },
 ("%d page matched.", "%d pages matched."): {
   'fr_FR': ["%d page correspondante.", "%d pages correspondantes."],
   'es_ES': ["%d página coincidente.", "%d páginas coincidentes."],
   'ar': ["لم تتطابق أي صفحة.", "تطابقت صفحة واحدة.", "تطابقت صفحتان.",
          "تطابقت %d صفحات.", "تطابقت %d صفحة.", "تطابقت %d صفحة."],
 },
}

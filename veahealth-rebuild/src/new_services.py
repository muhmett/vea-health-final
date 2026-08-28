# -*- coding: utf-8 -*-
"""
Content for the five treatments that appeared in the old main menu but never
had a page behind them (the menu items pointed at http://OxyCure,
http://Manual%20FUE and so on — the label had been typed into the URL field).

These are general, factual descriptions of each procedure. Prices are shown as
"on request" rather than invented: quote every one of them from the clinic's
own price list before publishing.
"""

NEW_PAGES = {
    "manual-fue": dict(
        nav_title="Manual FUE",
        title="Manual FUE Hair Transplant Istanbul Turkey – VeaHealth | Technique & Recovery",
        description="Manual FUE hair transplant in Istanbul with VeaHealth. Hand-held micro-punch "
                    "extraction, graft-by-graft control, natural hairline design. Free assessment "
                    "from your photographs.",
        h1='Manual FUE <em>Hair Transplant</em> in Istanbul',
        lead="Follicular units harvested one at a time with a hand-held micro-punch. Slower than "
             "motorised extraction, and deliberately so — the surgeon controls the angle and depth "
             "of every single graft.",
        trust=["Hand-held punch, 0.7–0.9 mm", "Graft-by-graft angle control",
               "No linear scar", "Local anaesthesia"],
        why_title="Why a surgeon would choose manual extraction",
        why=[
            ("Maximum control per graft",
             "The punch is turned by hand, so rotation speed, depth and angle are adjusted for each "
             "follicle rather than set once for the whole session. In curly or coarse hair, where "
             "follicles curve beneath the skin, that control reduces transection."),
            ("Less thermal and mechanical stress",
             "There is no motor, so there is no friction heat at the punch tip. Grafts spend less "
             "time under mechanical load, which matters for the fine, single-hair units used along "
             "the hairline."),
            ("Suited to difficult donor areas",
             "Scarred donor zones, previously harvested areas and very tight skin are easier to work "
             "manually, where the surgeon can feel resistance change through the instrument."),
            ("Slower by design",
             "A manual session harvests fewer grafts per hour than a motorised one. For large "
             "sessions your surgeon may recommend combining techniques, or planning two sittings."),
        ],
        procedure=[
            ("Consultation and design", "Day 1 — morning",
             "Donor density is measured, the Norwood or Ludwig pattern is classified and the hairline "
             "is drawn with you, standing, in natural light. Blood tests are taken.",
             ["Donor density measured with a densitometer", "Pattern classified and photographed",
              "Hairline drawn and agreed with you before shaving", "Pre-operative blood work"]),
            ("Extraction", "Day 1 — after design",
             "Under local anaesthesia the surgeon harvests follicular units individually with a "
             "hand-held punch. Grafts are counted, sorted by hair count and held in cooled solution.",
             ["Local anaesthesia to the donor area", "Punch diameter selected for your hair calibre",
              "Grafts sorted into single, double and triple units", "Cooled holding solution"]),
            ("Channel opening and implantation", "Day 1 — afternoon",
             "Recipient sites are opened at the angle and direction of your original growth, then "
             "grafts are placed — single hairs at the hairline, denser units behind it.",
             ["Sites opened to match natural growth direction", "Single-hair units along the front line",
              "Density graded from front to crown", "Session length depends on graft count"]),
            ("Aftercare and follow-up", "Day 2 onward",
             "First wash is done at the clinic and the technique shown to you. You are given a written "
             "aftercare protocol and your coordinator stays reachable after you fly home.",
             ["First wash performed and taught at the clinic", "Written aftercare protocol",
              "Follow-up photographs at 3, 6 and 12 months", "Coordinator reachable after you return"]),
        ],
        timeline=[
            ("Days 1–3", "Swelling of the forehead is common and settles. Sleep with the head elevated."),
            ("Days 7–10", "Crusts separate after the washing protocol. Donor area closes over."),
            ("Weeks 2–8", "Shock loss: transplanted hairs shed. This is expected — the follicle stays."),
            ("Months 3–6", "New growth begins, initially fine and lighter than surrounding hair."),
            ("Months 9–12", "Thickening and texture match. Assessment photographs at 12 months."),
        ],
        faqs=[
            ("Is manual FUE better than motorised FUE?",
             "Neither is better in every case. Manual extraction gives the surgeon more control per "
             "graft and is often preferred for curly hair, scarred donor areas and hairline work. "
             "Motorised extraction is faster and suits large sessions in straight, average-calibre "
             "hair. Your assessment will say which is being proposed for you, and why."),
            ("How many grafts can be taken in one manual session?",
             "Fewer than with a motorised punch, because each unit is harvested by hand. The number "
             "depends on your donor density and scalp laxity and is quoted after the assessment. "
             "Large cases are sometimes planned across two sittings rather than forced into one."),
            ("Will there be a scar?",
             "There is no linear scar. Each extraction leaves a round point under a millimetre across, "
             "which heals as a small pale dot and is not visible at normal hair length."),
            ("Is the procedure painful?",
             "The scalp is fully anaesthetised locally, so the procedure itself is not painful. The "
             "anaesthetic injections sting briefly. Discomfort afterwards is usually managed with "
             "simple analgesia."),
            ("When can I fly home?",
             "Most patients fly the day after the procedure, following the first wash at the clinic. "
             "Your coordinator will schedule the flight around that appointment."),
        ],
    ),

    "oxycure": dict(
        nav_title="OxyCure",
        title="OxyCure Post-Operative Protocol Istanbul – VeaHealth | Graft Recovery Support",
        description="OxyCure oxygen-assisted recovery support after hair transplantation in Istanbul "
                    "with VeaHealth. What the protocol involves, when it is offered and what it does "
                    "not replace.",
        h1='OxyCure <em>Recovery Support</em> After Transplantation',
        lead="An oxygen-assisted post-operative protocol offered by some partner clinics alongside "
             "standard aftercare. It supports the healing environment around freshly placed grafts. "
             "It is an adjunct to the aftercare protocol, not a replacement for it.",
        trust=["Offered as an adjunct", "Applied after graft placement",
               "Painless, non-surgical", "Availability varies by clinic"],
        why_title="What the protocol is for",
        why=[
            ("Supporting the first days",
             "The days immediately after implantation are when grafts are most vulnerable, before "
             "they establish their own blood supply. Post-operative protocols aim to keep the "
             "recipient area clean, calm and well perfused during that window."),
            ("Non-surgical and painless",
             "The application is topical and takes place at the clinic. There is no incision, no "
             "anaesthetic and no downtime added to your schedule."),
            ("Alongside, never instead of, standard aftercare",
             "Washing technique, sleeping position, avoiding sun and friction, and the medication "
             "your surgeon prescribes remain the things that most affect your result. No adjunct "
             "protocol changes that."),
            ("Ask what the evidence is",
             "Adjunct recovery protocols vary between clinics and the published evidence base is "
             "limited. Ask your surgeon directly what they expect it to add in your case, and decline "
             "it without hesitation if the answer is not specific."),
        ],
        procedure=[
            ("Assessment", "Before it is offered",
             "Your surgeon decides whether the protocol is appropriate for your case at all. It is "
             "not offered by every partner clinic and is not appropriate for every patient.",
             ["Reviewed against your medical history", "Not offered where contraindicated",
              "Availability confirmed before you travel"]),
            ("Application", "After implantation",
             "Applied at the clinic in the hours or days following the procedure, depending on the "
             "protocol your clinic uses. Sessions are short.",
             ["Topical, non-surgical application", "Short sessions at the clinic",
              "Scheduled around your existing appointments"]),
            ("Standard aftercare continues", "Throughout",
             "The written aftercare protocol runs unchanged: washing technique, medication, sleeping "
             "position and activity restrictions.",
             ["First wash taught at the clinic", "Written protocol to take home",
              "Coordinator reachable after you fly"]),
        ],
        timeline=[
            ("Days 1–3", "Sessions scheduled around your first wash appointment."),
            ("Days 7–10", "Crust separation follows the normal timeline."),
            ("Weeks 2–8", "Shock loss occurs as usual — the protocol does not prevent it."),
            ("Months 3–12", "Growth follows the standard timeline; assessed at 12 months."),
        ],
        faqs=[
            ("Does OxyCure make hair grow faster?",
             "No protocol reliably accelerates the biological growth cycle. Transplanted follicles "
             "shed and regrow on their own timeline — visible growth from around month three, "
             "assessment at twelve months. Any clinic promising faster growth is overselling."),
            ("Is it included in the treatment package?",
             "It depends on the clinic and the package. Ask for it to be itemised in your written "
             "quote before you travel so there is no charge you did not expect."),
            ("Is it safe?",
             "The application is non-surgical and painless, but suitability is a clinical decision. "
             "Your surgeon reviews it against your medical history, and it is not offered where it "
             "is contraindicated."),
            ("Can I decline it?",
             "Yes, at any point, and it will not affect the rest of your treatment. Standard "
             "aftercare is what your result depends on."),
        ],
    ),

    "beard-mustache-transplant": dict(
        nav_title="Beard & Mustache Transplant",
        title="Beard & Mustache Transplant Istanbul Turkey – VeaHealth | Facial Hair Restoration",
        description="Beard and moustache transplant in Istanbul with VeaHealth. Follicular unit "
                    "grafting to fill patchy growth, scars and thin corners. Free assessment from "
                    "your photographs.",
        h1='Beard &amp; Mustache <em>Transplant</em> in Istanbul',
        lead="Follicular units taken from the back of the scalp and placed into the beard area at "
             "the flat, low angle facial hair actually grows at. Used to fill patchy zones, thin "
             "corners, scars and gaps along the jawline.",
        trust=["Grafts from the occipital scalp", "Low implantation angle",
               "Single-hair units at the border", "Local anaesthesia"],
        why_title="What makes facial hair different",
        why=[
            ("A much flatter angle",
             "Beard hair leaves the skin at a far shallower angle than scalp hair. Sites opened at "
             "a scalp angle produce a bristly, artificial look. This is the single detail that most "
             "separates a natural beard result from an obvious one."),
            ("Almost all single-hair grafts",
             "Facial hair grows predominantly as single hairs. Multi-hair units placed in the beard "
             "produce visible tufting, so grafts are dissected down and placed one hair at a time "
             "across the visible border."),
            ("Density is built, not filled",
             "Beard density is a matter of distribution as much as count. Placement follows the "
             "existing growth pattern so new hair merges with what is already there rather than "
             "sitting in a patch."),
            ("Scars and gaps",
             "Grafting into scar tissue is possible but behaves differently — blood supply is poorer, "
             "and survival rates are lower than in healthy skin. Your surgeon should tell you this "
             "before you agree, and may plan a second pass."),
        ],
        procedure=[
            ("Assessment and design", "Day 1 — morning",
             "Donor density is measured and the beard outline drawn with you, seated and upright, so "
             "the line is judged the way it will actually be seen.",
             ["Donor density measured", "Beard border drawn and agreed with you",
              "Existing growth direction mapped", "Pre-operative blood work"]),
            ("Extraction", "Day 1",
             "Follicular units are harvested from the occipital scalp under local anaesthesia and "
             "sorted, with single-hair units set aside for the border.",
             ["Local anaesthesia to the donor area", "Units sorted by hair count",
              "Single-hair units reserved for the visible edge", "Cooled holding solution"]),
            ("Implantation", "Day 1 — afternoon",
             "Recipient sites are opened at the flat angle of natural beard growth and grafts placed "
             "following the existing direction across cheeks, jawline and moustache.",
             ["Sites opened at facial growth angle", "Single hairs along the border",
              "Direction matched to existing beard", "Moustache and jawline treated separately"]),
            ("Aftercare", "Day 2 onward",
             "First wash at the clinic, then a written protocol. No shaving of the transplanted area "
             "until your surgeon clears it.",
             ["First wash taught at the clinic", "No shaving until cleared",
              "Written aftercare protocol", "Follow-up at 3, 6 and 12 months"]),
        ],
        timeline=[
            ("Days 1–3", "Redness and small crusts across the beard area. Mild facial swelling is common."),
            ("Days 7–10", "Crusts separate with the washing protocol. Redness fades over days to weeks."),
            ("Weeks 2–8", "Shock loss: transplanted hairs shed. Expected, and not a failure."),
            ("Months 3–6", "Growth begins. Texture is initially finer than surrounding beard hair."),
            ("Months 9–12", "Full texture and density. Trimming and shaving normally resumed long before this."),
        ],
        faqs=[
            ("Will the transplanted beard hair keep growing?",
             "Yes. Grafts taken from the permanent zone at the back of the scalp keep the "
             "characteristics of their origin, so they continue to grow and will need trimming — "
             "sometimes faster than the rest of your beard."),
            ("Can I shave normally afterwards?",
             "Yes, once your surgeon clears it — usually a few weeks after the procedure. Shaving "
             "too early risks dislodging grafts that have not yet secured."),
            ("How many grafts does a beard need?",
             "It depends entirely on the area being covered and the density you want. Filling thin "
             "corners takes far fewer grafts than building a full beard from sparse growth. The "
             "number is quoted after your photographs are reviewed."),
            ("Will it look different from my existing beard?",
             "Scalp hair is often slightly finer than beard hair, so new growth can differ in texture "
             "at first. It thickens over the first year. Direction and angle matter more than texture "
             "for whether the result reads as natural."),
            ("Can it cover scars?",
             "Often, yes, though survival in scar tissue is lower than in healthy skin because blood "
             "supply is poorer. Your surgeon will tell you what to expect for your specific scar and "
             "may plan a second session."),
        ],
    ),

    "eyebrow-restoration": dict(
        nav_title="Eyebrow Restoration",
        title="Eyebrow Restoration Istanbul Turkey – VeaHealth | Eyebrow Hair Transplant",
        description="Eyebrow restoration in Istanbul with VeaHealth. Single-hair grafting to rebuild "
                    "shape and density after over-plucking, scarring or hair loss. Free assessment "
                    "from your photographs.",
        h1='Eyebrow <em>Restoration</em> in Istanbul',
        lead="Single-hair grafts placed at the very flat angle eyebrow hair grows at, following the "
             "direction that changes across the brow. The most detail-dependent procedure in hair "
             "restoration, and the least forgiving of shortcuts.",
        trust=["Single-hair grafts only", "Angle close to the skin surface",
               "Direction mapped across the brow", "Trimming required afterwards"],
        why_title="Why eyebrows are the hardest case",
        why=[
            ("Every graft is a single hair",
             "There is no hiding a multi-hair unit in an eyebrow. Grafts are dissected to single "
             "hairs and placed individually — a few hundred of them, one at a time."),
            ("The angle is almost flat",
             "Eyebrow hairs lie nearly against the skin. Sites opened even slightly too steep produce "
             "hairs that stand up and never lie down, which is the classic sign of a poor result."),
            ("Direction changes across the brow",
             "Hairs at the head of the brow grow upward, through the body they fan outward, and at "
             "the tail they point down and out. Each zone is opened separately."),
            ("They will need trimming",
             "Scalp hair keeps a scalp growth cycle, so transplanted eyebrow hairs grow longer than "
             "native brow hair and need trimming every few weeks, permanently. This is not a "
             "complication — it is how the procedure works, and you should factor it in."),
        ],
        procedure=[
            ("Design", "Day 1 — morning",
             "The brow shape is drawn with you sitting upright, eyes open, and checked against your "
             "facial proportions. Nothing starts until you agree the drawn shape.",
             ["Shape drawn with you, seated and upright",
              "Checked against facial proportions and expression",
              "Growth direction mapped by zone", "Photographs taken for the record"]),
            ("Extraction", "Day 1",
             "A small number of follicular units are harvested from the finest available donor hair "
             "and dissected into single-hair grafts.",
             ["Finest donor hair selected", "Units dissected to single hairs",
              "Local anaesthesia", "Cooled holding solution"]),
            ("Implantation", "Day 1",
             "Recipient sites are opened at a very flat angle, direction varied by zone, and single "
             "hairs placed one at a time across head, body and tail.",
             ["Sites opened almost parallel to the skin",
              "Direction varied across head, body and tail",
              "Single hairs placed individually", "Density kept deliberately natural"]),
            ("Aftercare", "Day 2 onward",
             "Careful washing, no rubbing, and no makeup on the brow area until cleared. Trimming "
             "instructions are given once growth starts.",
             ["Gentle washing technique taught at the clinic",
              "No makeup on the area until cleared",
              "Trimming schedule explained", "Follow-up at 3, 6 and 12 months"]),
        ],
        timeline=[
            ("Days 1–3", "Small crusts on the brow. Mild swelling around the eyes is common."),
            ("Days 7–10", "Crusts separate. The brow looks close to normal to anyone but you."),
            ("Weeks 2–8", "Shock loss: the transplanted hairs shed. Expected."),
            ("Months 3–6", "Regrowth begins. First trimming becomes necessary."),
            ("Months 9–12", "Final shape and density. Trimming continues indefinitely."),
        ],
        faqs=[
            ("How many grafts does an eyebrow need?",
             "Usually a few hundred per brow, depending on how much native hair remains and the "
             "shape being rebuilt. The count is quoted after your photographs are reviewed — it is "
             "far lower than a scalp procedure."),
            ("Do I really have to trim them forever?",
             "Yes. Transplanted hairs keep the growth cycle of their donor site, so they grow to "
             "scalp length rather than brow length. Trimming every two to four weeks becomes part of "
             "your routine, permanently. Anyone who tells you otherwise is not being straight with you."),
            ("Can it fix over-plucked brows?",
             "This is one of the most common reasons for the procedure. Years of plucking can stop "
             "follicles regrowing altogether, and grafting is the reliable way to rebuild the shape."),
            ("Will it look natural?",
             "That depends almost entirely on angle, direction and restraint in density. A brow "
             "grafted at the wrong angle looks wrong no matter how many hairs it has. Ask to see the "
             "surgeon's own eyebrow cases, not general clinic results."),
            ("Can I have it done with a scalp procedure at the same time?",
             "Often yes, if your donor supply allows for both. It is planned at assessment so the "
             "donor area is not over-harvested."),
        ],
    ),

    "female-hair-transplant": dict(
        nav_title="Female Hair Transplant",
        title="Female Hair Transplant Istanbul Turkey – VeaHealth | No-Shave & Partial Shave",
        description="Female hair transplant in Istanbul with VeaHealth. No-shave and partial-shave "
                    "techniques for female pattern loss, traction alopecia and hairline lowering. "
                    "Medical assessment first.",
        h1='Female <em>Hair Transplant</em> in Istanbul',
        lead="No-shave and partial-shave techniques for female pattern loss, traction alopecia and "
             "hairline lowering. Female hair loss has more possible causes than male loss, so the "
             "assessment comes first — and surgery is not always the right answer.",
        trust=["No-shave option available", "Medical assessment before surgery",
               "Blood work reviewed first", "Partial-shave under existing hair"],
        why_title="Why the assessment matters more here",
        why=[
            ("Diffuse loss is not always surgical",
             "Female pattern loss is often diffuse rather than patterned, and diffuse thinning can "
             "also affect the donor area. Transplanting from a donor zone that is itself thinning "
             "produces a result that fades. A trichoscopic assessment establishes whether your donor "
             "supply is stable enough."),
            ("Causes that surgery will not fix",
             "Thyroid disorders, iron deficiency, hormonal changes, post-partum shedding and some "
             "medications all cause hair loss that returns once treated — and returns after surgery "
             "too if left untreated. Blood work is reviewed before any procedure is agreed."),
            ("Traction alopecia",
             "Loss along the hairline from years of tension — tight styles, extensions, braids — is "
             "often a good surgical candidate, provided the tension has stopped and the follicles "
             "have not been permanently scarred."),
            ("Hairline lowering",
             "A naturally high hairline is not hair loss and is one of the more predictable female "
             "cases, since donor supply is intact and the goal is a defined amount of forward "
             "movement rather than density restoration."),
        ],
        procedure=[
            ("Medical assessment", "Before anything is scheduled",
             "Trichoscopy of both recipient and donor areas, plus blood work. Reversible causes are "
             "identified and treated before surgery is considered. If the assessment says medical "
             "treatment first, that is the recommendation you will get.",
             ["Trichoscopic examination of donor and recipient zones",
              "Blood work including ferritin, thyroid and vitamin D",
              "Reversible causes treated before surgery is considered",
              "Written opinion even if the answer is not to operate"]),
            ("Design", "Day 1 — morning",
             "The hairline is drawn to female proportions — a rounded rather than angular shape, and "
             "temporal points preserved rather than recreated as in male cases.",
             ["Hairline drawn to female proportions",
              "Rounded shape, temporal points preserved",
              "Parting line and density priorities agreed with you"]),
            ("Extraction and implantation", "Day 1",
             "With the no-shave technique, donor hair is trimmed only in narrow strips hidden beneath "
             "the surrounding hair, so nothing is visible once the hair is down. Grafts are then "
             "placed between existing hairs.",
             ["No-shave or partial-shave, discussed at assessment",
              "Donor strips hidden under existing hair",
              "Grafts placed between existing hairs without damaging them",
              "Session length depends on graft count"]),
            ("Aftercare and medical follow-up", "After the procedure",
             "Aftercare protocol plus continuation of any medical treatment for the underlying cause. "
             "Ongoing loss in untreated areas will continue otherwise.",
             ["First wash taught at the clinic",
              "Medical treatment for underlying causes continued",
              "Follow-up at 3, 6 and 12 months",
              "Coordinator reachable after you fly home"]),
        ],
        timeline=[
            ("Days 1–3", "Mild swelling and redness. With no-shave, hair covers the area immediately."),
            ("Days 7–10", "Crusts separate with the washing protocol."),
            ("Weeks 2–8", "Shock loss affects both transplanted and some surrounding native hairs. Native hair recovers."),
            ("Months 3–6", "Regrowth begins. Density builds gradually."),
            ("Months 12–18", "Female cases are assessed later than male cases, often at 18 months."),
        ],
        faqs=[
            ("Do I have to shave my head?",
             "Not necessarily. The no-shave technique trims donor hair only in narrow strips hidden "
             "beneath surrounding hair, so nothing is visible with your hair down. It takes longer "
             "and harvests fewer grafts per session, so suitability is decided at assessment."),
            ("Am I a candidate if my thinning is all over?",
             "Possibly not. Diffuse thinning can include the donor area, and transplanting unstable "
             "donor hair gives a result that fades. Trichoscopy establishes donor stability. If it is "
             "not stable, you will be told so — medical treatment may be the better route."),
            ("Why do you need blood tests first?",
             "Because iron deficiency, thyroid disorders and hormonal changes are common, treatable "
             "causes of female hair loss. Operating without addressing them means the underlying loss "
             "continues afterwards."),
            ("Can a transplant fix a receding hairline from braids or extensions?",
             "Traction alopecia often responds well, provided the tension has stopped and the "
             "follicles are not permanently scarred. Trichoscopy shows which of the two you have."),
            ("How long until I see the result?",
             "Female results are typically assessed at twelve to eighteen months, slightly later than "
             "male cases, because density builds among existing hair rather than into bare scalp."),
        ],
    ),
}

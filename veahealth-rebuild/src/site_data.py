# -*- coding: utf-8 -*-
"""Site-wide configuration and content data for veahealthturkey.com."""

SITE = {
    "domain": "https://veahealthturkey.com",
    "name": "VeaHealth Turkey",
    "legal_name": "VeaHealth",
    "tagline": "Dental & hair restoration in Istanbul, coordinated end to end",
    "email": "info@veahealthturkey.com",
    "phone": "+90 531 432 92 15",
    "phone_href": "+905314329215",
    "whatsapp": "https://wa.me/905314329215",
    # street address as published in the old site's own footer
    "street": "Merkez, Hasat Sk. No:52",
    "postcode": "34381",
    "district": "Şişli",
    "city": "Istanbul",
    "country": "Turkey",
    "country_code": "TR",
    # Google Analytics / Tag ID. Left empty on purpose: the tag only loads
    # after the visitor accepts cookies. Put the real G-XXXX id here.
    "ga_id": "",
    # Where the enquiry form POSTs. Replace with your own handler
    # (send.php ships in this bundle) or a service such as Formspree.
    "form_endpoint": "/send.php",
    "social": {
        "facebook": "https://www.facebook.com/",
        "instagram": "https://www.instagram.com/",
        "youtube": "https://www.youtube.com/",
    },
}

# --------------------------------------------------------------------------
# Service catalogue.
#   slug      – URL segment under /services/
#   src       – file in extracted/ carrying the original long-form content
#   group     – navigation grouping
#   art       – hero/preview image in assets/img/art
#   alt       – alt text for that image
#   blurb     – short card description (used on hub pages)
# Entries with src=None are new pages: they were advertised in the old main
# menu but never had a page behind them.
# --------------------------------------------------------------------------
SERVICES = [
    # ---- Oral surgery & implants ----
    dict(slug="immediate-dental-implants", nav_title="Immediate Dental Implants", src="services_immediate_dental_implants_",
         group="Oral surgery & implants", art="dental-implant-zirconia-crown-macro",
         alt="Titanium dental implant and zirconia crown photographed on a dark slate surface",
         blurb="Extraction and implant placement in a single appointment, leaving with fixed teeth the same day."),
    dict(slug="single-dental-implants", nav_title="Single Dental Implants", src="services_single_dental_implants_",
         group="Oral surgery & implants", art="jawbone-implant-3d-render",
         alt="Anatomical render of a single titanium implant anchored in the jawbone",
         blurb="Replace one missing tooth permanently, without touching the healthy teeth on either side."),
    dict(slug="full-mouth-dental-implants", nav_title="Full Mouth Dental Implants", src="services_full_mouth_dental_implants_",
         group="Oral surgery & implants", art="full-arch-prosthesis-macro",
         alt="Full-arch dental prosthesis on a titanium bar, photographed on dark slate",
         blurb="Complete arch restoration using the All-on-4 and All-on-6 techniques."),
    dict(slug="all-on-4-dental-implants", nav_title="All-on-4 Dental Implants", src="services_all_on_4_dental_implants_",
         group="Oral surgery & implants", art="all-on-4-bridge-3d-render",
         alt="Render of a full fixed bridge supported by four angled titanium implants",
         blurb="A full fixed arch supported by four implants, placed and loaded in one visit."),
    dict(slug="all-on-6-dental-implants", nav_title="All-on-6 Dental Implants", src="services_all_on_6_dental_implants_",
         group="Oral surgery & implants", art="full-arch-prosthesis-macro",
         alt="Full-arch prosthesis on a titanium bar, showing the implant connection points",
         blurb="Six implants for greater load distribution and long-term stability."),
    dict(slug="zygomatic-implants", nav_title="Zygomatic Implants", src="services_zygomatic_implants_",
         group="Oral surgery & implants", art="sinus-lift-3d-render",
         alt="Render of the upper jaw and cheekbone region where zygomatic implants anchor",
         blurb="For severe upper-jaw bone loss — anchored in the cheekbone, with no grafting required."),
    dict(slug="bone-graft", nav_title="Bone Graft", src="services_bone_graft_",
         group="Oral surgery & implants", art="bone-graft-3d-render",
         alt="Render of granular bone graft material being placed into a jawbone defect",
         blurb="Rebuilding jawbone volume so implants have a solid foundation."),
    dict(slug="sinus-lift", nav_title="Sinus Lift", src="services_sinus_lift_",
         group="Oral surgery & implants", art="sinus-lift-3d-render",
         alt="Cross-section render of the maxillary sinus lifted above the tooth roots",
         blurb="Maxillary sinus augmentation to create implant height in the upper jaw."),
    dict(slug="onlay-inlay", nav_title="Inlay & Onlay", src="services_onlay_inlay_",
         group="Oral surgery & implants", art="ceramic-veneers-macro",
         alt="Thin ceramic restorations catching studio light on a dark slate surface",
         blurb="Precision porcelain or zirconia restorations where a filling is not enough."),
    dict(slug="night-guard", nav_title="Night Guard", src="services_night_guard_",
         group="Oral surgery & implants", art="night-guard-macro",
         alt="Transparent custom dental night guard on a dark slate surface",
         blurb="Custom-fitted protection against bruxism and TMJ strain."),

    # ---- Crowns & veneers ----
    dict(slug="zirconium-crown", nav_title="Zirconium Crown", src="services_zirconium_crown_",
         group="Crowns & veneers", art="zirconia-crowns-macro",
         alt="Three zirconia dental crowns photographed on dark slate",
         blurb="Metal-free crowns with the strength of zirconia and the translucency of enamel."),
    dict(slug="e-max-lumineers", nav_title="E-max Lumineers", src="services_e_max_lumineers_",
         group="Crowns & veneers", art="ceramic-veneers-macro",
         alt="Ultra-thin translucent ceramic veneer shells fanned out on dark slate",
         blurb="Ultra-thin, minimal-prep veneers for a natural smile transformation."),
    dict(slug="hybrid-prosthesis-porcelain", nav_title="Hybrid Prosthesis — Porcelain", src="services_hybrid_prosthesis_porcelain_",
         group="Crowns & veneers", art="full-arch-prosthesis-macro",
         alt="Porcelain hybrid full-arch prosthesis mounted on a titanium bar",
         blurb="Porcelain-acrylic full-arch restoration on implants."),
    dict(slug="hybrid-prosthesis-zirconium", nav_title="Hybrid Prosthesis — Zirconium", src="services_hybrid_prosthesis_zirconium_",
         group="Crowns & veneers", art="zirconia-hybrid-prosthesis-macro",
         alt="Monolithic zirconia full-arch prosthesis on a titanium bar, lit from the edge",
         blurb="Zirconia-reinforced full-arch restoration — the strongest hybrid option."),

    # ---- Hair restoration ----
    dict(slug="sapphire-fue", nav_title="Sapphire FUE", src="services_sapphire_fue_",
         group="Hair restoration", art="sapphire-fue-blade-macro",
         alt="Surgical sapphire blade instrument photographed in macro",
         blurb="Sapphire-blade channel opening for denser packing and faster healing."),
    dict(slug="dhi-hair-transplant", nav_title="DHI Hair Transplant", src="services_dhi_hair_transplant_",
         group="Hair restoration", art="dhi-implanter-pen-macro",
         alt="Choi implanter pen instrument photographed in macro",
         blurb="Direct implantation with the Choi pen — no pre-opened channels, maximum control."),

    # ---- Pages that were in the menu but never existed ----
    dict(slug="manual-fue", nav_title="Manual FUE", src=None, group="Hair restoration", art="manual-punch-instruments-macro",
         alt="Set of hand-held surgical micro punches of different diameters on dark slate",
         blurb="Hand-held punch extraction for maximum graft-by-graft control.",
         new=True),
    dict(slug="oxycure", nav_title="OxyCure", src=None, group="Hair restoration", art="hair-restoration-suite",
         alt="Hair restoration treatment suite with a single reclining chair at dusk",
         blurb="Oxygen-assisted post-operative support protocol for graft survival.",
         new=True),
    dict(slug="beard-mustache-transplant", nav_title="Beard & Mustache Transplant", src=None, group="Hair restoration", art="dhi-implanter-pen-macro",
         alt="Precision implanter instrument used for facial hair restoration",
         blurb="Facial hair restoration following the natural direction of beard growth.",
         new=True),
    dict(slug="eyebrow-restoration", nav_title="Eyebrow Restoration", src=None, group="Hair restoration", art="sapphire-fue-blade-macro",
         alt="Fine sapphire-tipped surgical instrument used in eyebrow restoration",
         blurb="Single-hair grafting to rebuild eyebrow shape and density.",
         new=True),
    dict(slug="female-hair-transplant", nav_title="Female Hair Transplant", src=None, group="Hair restoration", art="hair-restoration-suite",
         alt="Calm hair restoration treatment room prepared for a procedure",
         blurb="No-shave and partial-shave techniques designed for female pattern loss.",
         new=True),
]

GROUP_ORDER = ["Oral surgery & implants", "Crowns & veneers", "Hair restoration"]

# --------------------------------------------------------------------------
# Real patient results. Every image below is a photograph supplied by the
# clinic; none of them are generated or stock.
# --------------------------------------------------------------------------
RESULTS = [
    dict(img="full-arch-implants-zirconium-crowns-male-patient-55",
         alt="Before and after full-arch implant treatment with zirconium crowns, male patient aged 55",
         title="Full-arch implants + zirconium crowns",
         meta="Male, 55 · United Kingdom", detail="6 implants, 24 zirconium crowns"),
    dict(img="hollywood-smile-zirconium-crowns-female-patient",
         alt="Before and after smile transformation with zirconium crowns, female patient",
         title="Hollywood smile with zirconium crowns",
         meta="Female · International patient", detail="Upper and lower arch"),
    dict(img="full-mouth-restoration-male-patient",
         alt="Before and after full mouth restoration, male patient",
         title="Full mouth restoration",
         meta="Male · International patient", detail="Implants and fixed prosthesis"),
    dict(img="smile-makeover-veneers-female-patient",
         alt="Before and after smile makeover with veneers, female patient",
         title="Smile makeover with veneers",
         meta="Female · International patient", detail="E-max veneers, upper arch"),
    dict(img="smile-design-crowns-female-patient",
         alt="Before and after digital smile design with ceramic crowns, female patient",
         title="Digital smile design with crowns",
         meta="Female · International patient", detail="Full smile line correction"),
    dict(img="orthodontic-smile-correction-young-female-patient",
         alt="Before and after smile correction, young female patient",
         title="Smile correction",
         meta="Female · International patient", detail="Alignment and shade correction"),
]

CLINIC = [
    dict(img="vea-health-clinic-lounge-istanbul", alt="VeaHealth partner clinic lounge in Istanbul with designer lighting"),
    dict(img="vea-health-treatment-room-istanbul", alt="Treatment room at a VeaHealth partner clinic in Istanbul"),
    dict(img="vea-health-reception-istanbul", alt="Reception area of a VeaHealth partner clinic in Istanbul"),
    dict(img="vea-health-waiting-area-istanbul", alt="Patient waiting area at a VeaHealth partner clinic in Istanbul"),
    dict(img="hybrid-prosthesis-zirconium-detail", alt="Close-up of a zirconium hybrid prosthesis produced for a VeaHealth patient"),
]

JOURNEY = [
    dict(t="Remote assessment", m="Before you travel",
         d="You send photographs and any recent X-rays through the enquiry form or WhatsApp. "
           "A partner dentist reviews them and returns a written treatment plan with a fixed, "
           "itemised price — before you commit to anything.",
         img="journey-travel-flatlay",
         alt="Passport, boarding pass and sunglasses laid out on linen before a medical trip",
         list=["Photo and X-ray review by a partner dentist",
               "Written plan with a fixed, itemised quote",
               "Video call with your coordinator if you want one"]),
    dict(t="Arrival and transfer", m="Day one",
         d="You are met at Istanbul Airport and driven to your hotel. Your coordinator handles "
           "the schedule, the clinic appointments and translation for the whole stay.",
         img="journey-vip-transfer-istanbul",
         alt="Black executive sedan waiting at the arrivals terminal of Istanbul Airport at night",
         list=["Private airport pickup on arrival",
               "Hotel booked and coordinated with your treatment dates",
               "English-speaking coordinator with you at every appointment"]),
    dict(t="Accommodation", m="Throughout your stay",
         d="Partner hotels are chosen for proximity to the clinic and for rest — recovery is "
           "part of the treatment, not an afterthought.",
         img="journey-hotel-bosphorus-suite",
         alt="Hotel suite in Istanbul with a window overlooking the Bosphorus in morning light",
         list=["Hotel within short reach of the clinic",
               "Transfers between hotel and clinic every treatment day",
               "Quiet rooms suited to post-operative rest"]),
    dict(t="Treatment and planning", m="At the clinic",
         d="Digital scans, smile design and the treatment itself, carried out by the partner "
           "clinical team. You see the plan on screen and approve it before work begins.",
         img="dsd-consultation-room",
         alt="Consultation room with a wall screen showing a three-dimensional dental scan",
         list=["Intraoral scanning and digital smile design",
               "Plan reviewed and approved with you before treatment",
               "Shade matched under natural light"]),
]

TRUST = [
    "Verified partner clinics in Istanbul",
    "Written quote before you travel",
    "Airport transfers and hotel coordinated",
    "English-speaking patient coordinator",
    "Premium implant systems",
    "Aftercare support once you are home",
]

# --------------------------------------------------------------------------
# Blog — the two existing posts, preserved.
# --------------------------------------------------------------------------
POSTS = [
    dict(slug="are-cosmetic-dentistry-operations-age-restricted",
         src="are_cosmetic_dentistry_operations_age_restricted_",
         title="Are cosmetic dentistry operations age restricted?",
         desc="Where age genuinely matters in cosmetic dentistry, where it does not, and what a "
              "clinic should check before treating a younger or older patient.",
         date="2026-02-04", cover="blog-cover-dental-ceramic-sand",
         alt="Ceramic tooth form resting on rippled sand, lit by a single soft light"),
    dict(slug="smile-makeover-transforming-confidence-through-dentistry",
         src="smile_makeover_transforming_confidence_through_dentistry_",
         title="Smile makeover: transforming confidence through dentistry",
         desc="What a smile makeover actually involves, which treatments it combines, and how to "
              "judge whether the result will look like you.",
         date="2026-02-04", cover="journey-travel-flatlay",
         alt="Calm flat-lay of travel items on linen in warm morning light"),
]

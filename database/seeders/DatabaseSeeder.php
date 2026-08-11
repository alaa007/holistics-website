<?php

namespace Database\Seeders;

use App\Models\AboutContent;
use App\Models\HomeSlide;
use App\Models\PageSeo;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Specialty;
use App\Models\Stat;
use App\Models\TeamMember;
use App\Models\User;
use App\Models\ValueItem;
use App\Models\WhyUsItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@holistics-care.com'],
            ['name' => 'System Admin', 'password' => Hash::make('123456'), 'email_verified_at' => now()]
        );

        $this->seedSettings();
        $this->seedAboutContent();
        $this->seedHomeSlides();
        $this->seedStats();
        $this->seedServices();
        $this->seedValues();
        $this->seedWhyUs();
        $this->seedTeam();
        $this->seedPageSeo();
    }

    private function seedPageSeo(): void
    {
        $pages = [
            [
                'route_name' => 'home',
                'label' => 'Home',
                'meta_title_en' => 'Holistics — Integrated Home Healthcare & Medical Supplies in Amman, Jordan',
                'meta_title_ar' => 'هوليستكس — رعاية صحية منزلية ومستلزمات طبية متكاملة في عمّان، الأردن',
                'meta_description_en' => 'Holistics provides home healthcare, professional nursing, physiotherapy, medical equipment and supplies in Amman, Jordan. Healing the whole you.',
                'meta_description_ar' => 'تقدّم هوليستكس خدمات الرعاية الصحية المنزلية والتمريض الاحترافي والعلاج الطبيعي والمعدات والمستلزمات الطبية في عمّان، الأردن. شفاءٌ يشمل الإنسان كاملاً.',
            ],
            [
                'route_name' => 'about',
                'label' => 'About Us',
                'meta_title_en' => 'About Us — Holistics Medical Supplies & Care',
                'meta_title_ar' => 'من نحن — هوليستكس للمستلزمات والرعاية الطبية',
                'meta_description_en' => "Learn about Holistics' mission, vision, values, and leadership team — an integrated home healthcare provider based in Amman, Jordan.",
                'meta_description_ar' => 'تعرّف على رسالة هوليستكس ورؤيتها وقيمها وفريقها القيادي — مزوّد رعاية صحية منزلية متكاملة مقرّه عمّان، الأردن.',
            ],
            [
                'route_name' => 'services.index',
                'label' => 'Services',
                'meta_title_en' => 'Our Services — Holistics Medical Supplies & Care',
                'meta_title_ar' => 'خدماتنا — هوليستكس للمستلزمات والرعاية الطبية',
                'meta_description_en' => "Explore Holistics' full range of home healthcare, nursing, physiotherapy, equipment supply, and patient care services in Amman, Jordan.",
                'meta_description_ar' => 'اكتشف مجموعة هوليستكس الكاملة من خدمات الرعاية الصحية المنزلية والتمريض والعلاج الطبيعي وتوريد المعدات ورعاية المرضى في عمّان، الأردن.',
            ],
            [
                'route_name' => 'team',
                'label' => 'Medical Team',
                'meta_title_en' => 'Our Medical Team — Holistics',
                'meta_title_ar' => 'فريقنا الطبي — هوليستكس',
                'meta_description_en' => "Meet the doctors, nurses, and specialists behind Holistics' integrated home healthcare services in Amman, Jordan.",
                'meta_description_ar' => 'تعرّف على الأطباء والممرضين والاختصاصيين الذين يقدّمون خدمات الرعاية الصحية المنزلية المتكاملة في هوليستكس بعمّان، الأردن.',
            ],
            [
                'route_name' => 'contact',
                'label' => 'Contact',
                'meta_title_en' => 'Contact Us — Holistics',
                'meta_title_ar' => 'اتصل بنا — هوليستكس',
                'meta_description_en' => 'Get in touch with Holistics for home healthcare, nursing, physiotherapy, and medical supply services in Amman, Jordan.',
                'meta_description_ar' => 'تواصل مع هوليستكس للحصول على خدمات الرعاية الصحية المنزلية والتمريض والعلاج الطبيعي والمستلزمات الطبية في عمّان، الأردن.',
            ],
            [
                // Title and description always come from the service itself
                // (title_en / short_en are required), so only the share image
                // and noindex toggle on this row have any effect.
                'route_name' => 'services.show',
                'label' => 'Service Detail Pages',
                'meta_title_en' => null,
                'meta_title_ar' => null,
                'meta_description_en' => null,
                'meta_description_ar' => null,
            ],
        ];

        foreach ($pages as $page) {
            PageSeo::updateOrCreate(['route_name' => $page['route_name']], $page);
        }
    }

    private function seedSettings(): void
    {
        Setting::updateOrCreate(['id' => 1], [
            'brand_name' => 'HOLISTICS',
            'tagline_en' => 'Healing the whole you',
            'tagline_ar' => 'شفاءٌ يشمل الإنسان كاملاً',
            'whatsapp_number' => '962781818211',
            'phone_display' => '+962 78 181 8211',
            'phone_href' => 'tel:+962781818211',
            'email' => 'info@holistics-care.com',
            'address_en' => 'Al-Dawha Medical Complex, Amman, Jordan',
            'address_ar' => 'مجمع الدوحة الطبي، عمّان، الأردن',
            'map_query' => '31.9526877,35.900444',
            'seo_title_suffix_en' => 'Holistics',
            'seo_title_suffix_ar' => 'هوليستكس',
            'seo_title_en' => 'Holistics — Integrated Home Healthcare in Amman, Jordan',
            'seo_title_ar' => 'هوليستكس — رعاية صحية منزلية متكاملة في عمّان، الأردن',
            'seo_description_en' => 'Holistics provides integrated home healthcare, nursing, physiotherapy, and medical supplies in Amman, Jordan.',
            'seo_description_ar' => 'تقدّم هوليستكس رعاية صحية منزلية متكاملة وخدمات تمريض وعلاج طبيعي ومستلزمات طبية في عمّان، الأردن.',
            'footer_about_en' => 'Integrated home healthcare, medical supplies, and physiotherapy solutions — delivering compassionate, patient-centered care with international standards.',
            'footer_about_ar' => 'رعاية صحية منزلية متكاملة، ومستلزمات طبية، وحلول للعلاج الطبيعي — نقدّمها بعناية إنسانية تتمحور حول المريض، ووفق معايير دولية.',
        ]);
    }

    private function seedAboutContent(): void
    {
        AboutContent::updateOrCreate(['id' => 1], [
            'hero_title_en' => 'Healthcare that treats the whole person',
            'hero_title_ar' => 'رعاية صحية تُعنى بالإنسان كاملاً',
            'hero_text_en' => 'Founded in 2025 in Amman, Jordan, Holistics is a trusted provider of home healthcare services, medical supplies, and physiotherapy solutions — delivering care with international standards and genuine compassion.',
            'hero_text_ar' => 'تأسست هوليستكس عام 2025 في عمّان، الأردن، لتكون مزوّداً موثوقاً لخدمات الرعاية الصحية المنزلية والمستلزمات الطبية وحلول العلاج الطبيعي — نقدّم الرعاية وفق معايير دولية وبعناية إنسانية صادقة.',
            'who_we_are_p1_en' => 'Holistics is an Amman, Jordan-based provider of integrated home healthcare and medical support services. Through our multidisciplinary team, we deliver personalized, patient-centered care across the continuum of health — including nursing, wound care, post-operative and post-hospitalization care, therapeutic nutrition, physiotherapy, psychological support, diagnostic services, medical supplies, and home companion services.',
            'who_we_are_p1_ar' => 'هوليستكس شركة مقرّها عمّان، الأردن، متخصصة في تقديم خدمات الرعاية الصحية المنزلية والدعم الطبي المتكاملة. ومن خلال فريقنا متعدد التخصصات، نقدّم رعاية شخصية تتمحور حول المريض وتغطي مراحل الرعاية الصحية كافة — بما في ذلك التمريض، والعناية بالجروح، والرعاية بعد العمليات الجراحية وما بعد الخروج من المستشفى، والتغذية العلاجية، والعلاج الطبيعي، والدعم النفسي، والخدمات التشخيصية، والمستلزمات الطبية، وخدمات المرافقة المنزلية.',
            'who_we_are_p2_en' => 'We are committed to providing quality-assured healthcare that meets the highest national and international standards, bringing compassionate, safe, and professional care directly to every patient\'s home.',
            'who_we_are_p2_ar' => 'نلتزم بتقديم رعاية صحية مضمونة الجودة تلبي أعلى المعايير الوطنية والدولية، ونوصل الرعاية الآمنة والاحترافية بروح إنسانية إلى منزل كل مريض مباشرة.',
            'vision_en' => 'To become Jordan\'s leading integrated healthcare provider, recognized for excellence in home healthcare, rehabilitation, and medical supply services — while making quality healthcare accessible to every community.',
            'vision_ar' => 'أن نصبح المزوّد الرائد للرعاية الصحية المتكاملة في الأردن، ومرجعاً في التميّز بخدمات الرعاية المنزلية والتأهيل والمستلزمات الطبية — مع جعل الرعاية الصحية عالية الجودة في متناول كل مجتمع.',
            'mission_en' => 'To provide comprehensive healthcare services and medical solutions that promote healing, independence, and well-being through professional excellence, innovation, and compassionate care.',
            'mission_ar' => 'أن نقدّم خدمات رعاية صحية وحلولاً طبية شاملة تعزّز الشفاء والاستقلالية والعافية، من خلال التميّز المهني والابتكار والرعاية الإنسانية.',
            'commitment_en' => 'Healthcare is more than a service — it is a commitment to improving lives. We support patients throughout their healthcare journey with reliable medical care, advanced rehabilitation, and quality medical supplies that empower people to live healthier, safer, more independent lives.',
            'commitment_ar' => 'الرعاية الصحية أكثر من مجرد خدمة — إنها التزام بتحسين حياة الناس. نرافق المرضى في رحلتهم الصحية برعاية طبية موثوقة، وتأهيل متقدم، ومستلزمات طبية عالية الجودة تمكّنهم من حياة أوفر صحة وأماناً واستقلالية.',
            'team_intro_en' => 'At Holistics, our strength lies in a multidisciplinary team of experienced healthcare professionals dedicated to delivering safe, compassionate, and evidence-based care. Working together with our network of medical consultants across various specialties, we ensure that every patient receives personalized, high-quality care tailored to their individual needs.',
            'team_intro_ar' => 'تكمن قوتنا في هوليستكس في فريق متعدد التخصصات من محترفي الرعاية الصحية ذوي الخبرة، الملتزمين بتقديم رعاية آمنة وإنسانية قائمة على الأدلة العلمية. وبالتعاون مع شبكتنا من الاستشاريين الطبيين في مختلف التخصصات، نضمن أن يحظى كل مريض برعاية شخصية عالية الجودة مصمّمة وفق احتياجاته الفردية.',
            'advisory_note_en' => 'Our services are supported by a distinguished network of consultant physicians from a wide range of medical and surgical specialties. Their expertise provides clinical oversight, multidisciplinary collaboration, and access to the latest evidence-based medical practices, ensuring the highest standards of patient care.',
            'advisory_note_ar' => 'تحظى خدماتنا بدعم شبكة متميزة من الأطباء الاستشاريين في نطاق واسع من التخصصات الطبية والجراحية. وتوفّر خبراتهم إشرافاً سريرياً وتعاوناً متعدد التخصصات ووصولاً إلى أحدث الممارسات الطبية القائمة على الأدلة، بما يضمن أعلى معايير رعاية المرضى.',
        ]);
    }

    private function seedHomeSlides(): void
    {
        $slides = [
            [
                'eyebrow_en' => 'Integrated Healthcare, At Home',
                'heading_prefix_en' => 'We Heal',
                'heading_highlight_en' => 'the Whole You',
                'text_en' => 'Home healthcare, nursing, physiotherapy, and medical supplies — all under one trusted roof in Amman, Jordan.',
                'cta1_label_en' => 'Our Services', 'cta1_url' => '/services',
                'cta2_label_en' => 'Contact Us', 'cta2_url' => '/contact',
                'order' => 1,
            ],
            [
                'eyebrow_en' => 'Care That Comes To You',
                'heading_prefix_en' => 'Skilled Nursing &',
                'heading_highlight_en' => 'Home Visits',
                'text_en' => 'Certified nurses and doctors delivering hands-on, compassionate care in the comfort of your own home — on your schedule.',
                'cta1_label_en' => 'Meet Our Team', 'cta1_url' => '/team',
                'cta2_label_en' => 'Book a Visit', 'cta2_url' => '/contact',
                'order' => 2,
            ],
            [
                'eyebrow_en' => 'Equipment You Can Rely On',
                'heading_prefix_en' => 'Modern Equipment &',
                'heading_highlight_en' => 'Reliable Supply',
                'text_en' => 'From mobility aids to consumables, we keep patients and clinics equipped with quality medical essentials.',
                'cta1_label_en' => 'View Equipment Supply', 'cta1_url' => '/services/equipment-supply',
                'cta2_label_en' => 'Contact Us', 'cta2_url' => '/contact',
                'order' => 3,
            ],
        ];
        foreach ($slides as $s) {
            HomeSlide::updateOrCreate(['order' => $s['order']], $s);
        }
    }

    private function seedStats(): void
    {
        $stats = [
            ['icon' => 'calendar', 'label_en' => 'Founded in 2025', 'order' => 1],
            ['icon' => 'clock', 'label_en' => '24/7 Home Visit Support', 'order' => 2],
            ['icon' => 'award', 'label_en' => 'Certified Healthcare Professionals', 'order' => 3],
            ['icon' => 'map-pin', 'label_en' => 'Proudly Based in Amman, Jordan', 'order' => 4],
        ];
        foreach ($stats as $s) {
            Stat::updateOrCreate(['order' => $s['order']], $s);
        }
    }

    private function seedServices(): void
    {
        $services = [
            ['slug' => 'home-healthcare', 'icon' => 'home', 'title_en' => 'Home Healthcare Services',
                'short_en' => 'Comprehensive medical care delivered in the comfort of your own home.',
                'overview_en' => 'Our Home Healthcare Services bring qualified medical professionals directly to your doorstep, so you or your loved ones can receive attentive, high-quality care without the stress of a hospital visit. From routine check-ups to ongoing condition management, our team coordinates every visit around your schedule and needs.',
                'included_en' => "Initial in-home health assessment\nCoordinated care plans with your physician\nVital signs monitoring and health tracking\nMedication management and reminders\nRegular follow-up visits",
                'who_en' => 'Ideal for patients recovering from illness or surgery, individuals managing chronic conditions, and families who want consistent, professional care at home.'],
            ['slug' => 'nursing-care', 'icon' => 'heart', 'title_en' => 'Professional Nursing Care',
                'short_en' => 'Certified nurses providing skilled, compassionate care tailored to each patient.',
                'overview_en' => 'Our Professional Nursing Care service places certified, experienced nurses at your side for wound care, injections, IV therapy, post-operative support, and everyday health monitoring — delivered with the empathy every patient deserves.',
                'included_en' => "Certified nurse visits, scheduled around you\nWound care and dressing changes\nInjections, IV therapy, and medication administration\nHealth monitoring and reporting to your physician\nSupport for elderly and post-surgical patients",
                'who_en' => 'Ideal for patients who need regular clinical attention but prefer to recover in a familiar, comfortable environment.'],
            ['slug' => 'physiotherapy', 'icon' => 'activity', 'title_en' => 'Physiotherapy & Rehabilitation',
                'short_en' => 'Personalized rehabilitation programs to restore mobility and independence.',
                'overview_en' => 'Our licensed physiotherapists design personalized rehabilitation programs to help patients regain strength, mobility, and independence after injury, surgery, or illness — all delivered at home with the latest evidence-based techniques.',
                'included_en' => "Personalized assessment and treatment plan\nMobility and strength-building exercises\nPost-surgical and post-injury rehabilitation\nPain management techniques\nProgress tracking and plan adjustments",
                'who_en' => 'Ideal for patients recovering from surgery, stroke, or injury, and anyone working to regain strength and mobility.'],
            ['slug' => 'equipment-supply', 'icon' => 'briefcase', 'title_en' => 'Medical Equipment Supply',
                'short_en' => 'A wide range of modern, reliable medical equipment for home and clinical use.',
                'overview_en' => 'We supply and deliver a wide range of medical equipment — from mobility aids to advanced monitoring devices — ensuring every patient has access to reliable, well-maintained tools for safe and effective home care.',
                'included_en' => "Hospital beds, wheelchairs, and mobility aids\nOxygen concentrators and respiratory equipment\nPatient monitors and diagnostic devices\nDelivery, setup, and usage guidance\nOngoing servicing and support",
                'who_en' => 'Ideal for patients and families setting up a home-care environment, and clinics or facilities equipping their space.'],
            ['slug' => 'medical-consumables', 'icon' => 'package', 'title_en' => 'Medical Consumables',
                'short_en' => 'Dependable supply of quality medical consumables, delivered when you need them.',
                'overview_en' => 'From dressings and gloves to catheters and diagnostic supplies, we ensure a steady, quality-checked supply of medical consumables so patients and caregivers are never caught without essentials.',
                'included_en' => "Wound care dressings and bandages\nGloves, masks, and hygiene supplies\nCatheters, tubing, and related supplies\nDiagnostic and testing consumables\nRecurring/scheduled delivery options",
                'who_en' => 'Ideal for home-care patients, caregivers, and clinics that need a dependable consumables supply chain.'],
            ['slug' => 'patient-care-programs', 'icon' => 'users', 'title_en' => 'Patient Care Programs',
                'short_en' => 'Structured, ongoing care programs built around each patient\'s individual journey.',
                'overview_en' => 'Our Patient Care Programs combine nursing, therapy, equipment, and consultation into one coordinated plan — built around each patient\'s condition, goals, and family circumstances, and adjusted as needs evolve.',
                'included_en' => "Individualized care plan and goal-setting\nCoordinated team of nurses, therapists, and consultants\nRegular progress reviews with family updates\nFlexible scheduling as needs change\nSingle point of contact for care coordination",
                'who_en' => 'Ideal for patients with complex or long-term needs who benefit from one coordinated care plan rather than separate, disconnected services.'],
            ['slug' => 'home-medical-visits', 'icon' => 'map-pin', 'title_en' => 'Home Medical Visits',
                'short_en' => 'On-demand doctor and specialist visits, brought directly to your home.',
                'overview_en' => 'When getting to a clinic isn\'t practical, our Home Medical Visits bring the doctor to you — for consultations, check-ups, and follow-ups — reducing stress and waiting time for patients and families alike.',
                'included_en' => "Scheduled and on-demand doctor visits\nGeneral consultations and check-ups\nFollow-up visits for ongoing conditions\nCoordination with specialists as needed\nClear visit summaries for your records",
                'who_en' => 'Ideal for elderly patients, those with mobility challenges, and families who prefer the convenience of care at home.'],
            ['slug' => 'long-term-care', 'icon' => 'shield', 'title_en' => 'Long-Term Care Solutions',
                'short_en' => 'Sustained, reliable support for patients who need ongoing, extended care.',
                'overview_en' => 'Our Long-Term Care Solutions are designed for patients who require sustained support over months or years — combining nursing, therapy, and equipment into a stable, dependable care routine that adapts as needs change.',
                'included_en' => "Extended care planning and scheduling\nConsistent nursing and support staff\nRegular health and equipment reviews\nFamily communication and updates\nFlexible adjustment as conditions evolve",
                'who_en' => 'Ideal for patients with chronic conditions, age-related needs, or disabilities requiring continuous, dependable support.'],
            ['slug' => 'healthcare-consultation', 'icon' => 'message-circle', 'title_en' => 'Healthcare Consultation',
                'short_en' => 'Expert guidance to help you understand conditions, options, and next steps.',
                'overview_en' => 'Not sure what kind of care is right for you or a loved one? Our Healthcare Consultation service connects you with experienced professionals who can explain your options clearly and help you build the right care plan.',
                'included_en' => "One-on-one consultation with a healthcare professional\nGuidance on care options and next steps\nHelp choosing the right service package\nSecond-opinion style guidance where appropriate\nReferrals to specialists when needed",
                'who_en' => 'Ideal for families navigating a new diagnosis or care decision, and anyone unsure where to start.'],
            ['slug' => 'equipment-maintenance', 'icon' => 'settings', 'title_en' => 'Medical Equipment Maintenance & Support',
                'short_en' => 'Keeping your medical equipment safe, accurate, and reliably operational.',
                'overview_en' => 'Medical equipment is only as good as its upkeep. Our maintenance and support service keeps devices calibrated, safe, and functioning correctly — with responsive support whenever something needs attention.',
                'included_en' => "Scheduled equipment inspections and servicing\nCalibration and safety checks\nResponsive repair and troubleshooting support\nReplacement parts and consumable swaps\nUsage guidance for patients and caregivers",
                'who_en' => 'Ideal for patients and clinics with existing equipment who want to ensure it stays safe and reliable over time.'],
        ];
        foreach ($services as $i => $s) {
            $s['order'] = $i + 1;
            Service::updateOrCreate(['slug' => $s['slug']], $s);
        }
    }

    private function seedValues(): void
    {
        $values = [
            ['icon' => 'heart', 'title_en' => 'Compassion', 'text_en' => 'We care for every patient with empathy, dignity, and respect.'],
            ['icon' => 'award', 'title_en' => 'Excellence', 'text_en' => 'We strive for the highest standards in every service we provide.'],
            ['icon' => 'shield', 'title_en' => 'Integrity', 'text_en' => 'We conduct our work with honesty, transparency, and professionalism.'],
            ['icon' => 'target', 'title_en' => 'Innovation', 'text_en' => 'We continuously improve our services through modern healthcare solutions.'],
            ['icon' => 'users', 'title_en' => 'Collaboration', 'text_en' => 'We work closely with patients, families, physicians, and partners for the best outcomes.'],
        ];
        foreach ($values as $i => $v) {
            $v['order'] = $i + 1;
            ValueItem::updateOrCreate(['title_en' => $v['title_en']], $v);
        }
    }

    private function seedWhyUs(): void
    {
        $items = [
            ['icon' => 'award', 'text_en' => 'Highly qualified healthcare professionals'],
            ['icon' => 'target', 'text_en' => 'Personalized treatment plans tailored to each patient\'s needs'],
            ['icon' => 'shield', 'text_en' => 'Reliable, compassionate, and ethical care'],
            ['icon' => 'briefcase', 'text_en' => 'High-quality medical equipment and supplies'],
            ['icon' => 'clock', 'text_en' => 'Fast response and continuous patient support'],
            ['icon' => 'star', 'text_en' => 'Commitment to international healthcare standards'],
            ['icon' => 'check-circle', 'text_en' => 'Comprehensive healthcare solutions under one roof'],
        ];
        foreach ($items as $i => $it) {
            $it['order'] = $i + 1;
            WhyUsItem::updateOrCreate(['text_en' => $it['text_en']], $it);
        }
    }

    private function seedTeam(): void
    {
        $leadership = [
            ['name' => 'Abdalla Al-Tal', 'credentials' => 'MBA', 'role_en' => 'Executive Director',
                'bio_en' => 'An experienced healthcare executive with extensive work experience in Australia and the United States, in addition to expertise in the leadership and management of healthcare organizations and multidisciplinary teams. Committed to operational excellence, quality improvement, and patient-centered care.'],
            ['name' => 'Zaid Al-Salty', 'credentials' => 'RN, MSc, PhD Candidate', 'role_en' => 'Director of Nursing Services',
                'bio_en' => 'A highly experienced nursing leader with extensive clinical and academic expertise in managing complex medical and surgical patients. Currently pursuing a PhD, he oversees nursing quality, clinical governance, and the delivery of safe, evidence-based patient care.'],
            ['name' => 'Saham Al-Athamneh', 'credentials' => 'PT', 'role_en' => 'Consultant of Rehabilitation & Physiotherapy',
                'bio_en' => 'With more than 30 years of experience in the Royal Medical Services, Saham brings extensive expertise in rehabilitation and physiotherapy. Advanced training in Europe has further strengthened his skills in comprehensive rehabilitation programs and functional recovery.'],
            ['name' => 'Dr. Hala Al-Najjar', 'credentials' => 'PharmD', 'role_en' => 'Director of Clinical Pharmacy & Therapeutic Nutrition',
                'bio_en' => 'A clinical pharmacist with expertise in pharmaceutical care and therapeutic nutrition, with a background in the pharmaceutical industry and regulatory affairs. She oversees clinical pharmacy services, medication management, nutritional support, and patient education — ensuring safe, evidence-based, and integrated care.'],
        ];
        foreach ($leadership as $i => $l) {
            $l['is_leadership'] = true;
            $l['order'] = $i + 1;
            TeamMember::updateOrCreate(['name' => $l['name']], $l);
        }

        $directory = [
            ['specialty' => 'general-medicine', 'specialty_label_en' => 'General Medicine', 'role_en' => 'General Practitioner',
                'bio_en' => 'Oversees general consultations and coordinates each patient\'s overall care plan.'],
            ['specialty' => 'nursing', 'specialty_label_en' => 'Nursing', 'role_en' => 'Registered Nurse',
                'bio_en' => 'Delivers hands-on clinical care, wound care, and medication support at home.'],
            ['specialty' => 'physiotherapy', 'specialty_label_en' => 'Physiotherapy', 'role_en' => 'Physiotherapist',
                'bio_en' => 'Designs and guides rehabilitation programs to restore mobility and strength.'],
            ['specialty' => 'critical-care', 'specialty_label_en' => 'Critical Care', 'role_en' => 'ICU & Critical Care Nurse',
                'bio_en' => 'Provides advanced monitoring and support for patients with complex medical needs.'],
            ['specialty' => 'geriatric-care', 'specialty_label_en' => 'Geriatric Care', 'role_en' => 'Geriatric Care Specialist',
                'bio_en' => 'Focuses on the specific health and comfort needs of elderly patients.'],
            ['specialty' => 'care-coordination', 'specialty_label_en' => 'Care Coordination', 'role_en' => 'Patient Care Coordinator',
                'bio_en' => 'The single point of contact who keeps every patient\'s care plan on track.'],
        ];
        foreach ($directory as $i => $d) {
            $specialty = Specialty::updateOrCreate(
                ['slug' => $d['specialty']],
                ['label_en' => $d['specialty_label_en'], 'order' => $i + 1]
            );

            TeamMember::updateOrCreate(
                ['specialty_id' => $specialty->id, 'role_en' => $d['role_en']],
                [
                    'specialty_id' => $specialty->id,
                    'role_en' => $d['role_en'],
                    'bio_en' => $d['bio_en'],
                    'is_leadership' => false,
                    'order' => $i + 1,
                ]
            );
        }
    }
}

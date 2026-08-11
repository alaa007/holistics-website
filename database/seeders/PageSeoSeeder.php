<?php

namespace Database\Seeders;

use App\Models\PageSeo;
use Illuminate\Database\Seeder;

/**
 * Kept separate from DatabaseSeeder so it can be run on its own:
 *
 *     php artisan db:seed --class=PageSeoSeeder --force
 *
 * Page SEO rows map one-to-one onto routes and cannot be created from the
 * admin panel, so a deployment needs this to populate them. Running the full
 * DatabaseSeeder instead would reset every other content record to its
 * seeded default and wipe any edits made through the panel.
 *
 * Existing rows are matched on route_name, so re-running it is safe.
 */
class PageSeoSeeder extends Seeder
{
    public function run(): void
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
}

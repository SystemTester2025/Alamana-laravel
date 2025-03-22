<?php

namespace Database\Seeders;

use App\Models\Section;
use App\Models\SectionPart;
use Illuminate\Database\Seeder;

class SectionPartSeeder extends Seeder
{
    /**
     * Seeds the section_parts table with additional text from the frontend.
     * This follows the Single Responsibility Principle by focusing only on seeding section parts.
     *
     * @return void
     */
    public function run(): void
    {
        // Clear existing section parts
        SectionPart::truncate();
        
        // Get section IDs for reference
        $heroSection = Section::where('key', 'hero')->first();
        $featuresSection = Section::where('key', 'features')->first();
        $companySection = Section::where('key', 'company')->first();
        $managementSection = Section::where('key', 'management')->first();
        $productsSection = Section::where('key', 'products')->first();
        $contactSection = Section::where('key', 'contact')->first();
        $valuesSection = Section::where('key', 'values')->first();
        
        // Features Section Parts
        if ($featuresSection) {
            SectionPart::create([
                'title' => 'شبكة واسعة',
                'desc' => 'نتعاون مع أفضل الموردين في جميع أنحاء العالم',
                'section_id' => $featuresSection->id,
                'key' => 'feature_network',
                'sort_order' => 1,
                'image' => 'images/features/features-network.svg',
            ]);
            
            SectionPart::create([
                'title' => 'جودة عالية',
                'desc' => 'نقدم لك منتجات طازجة وفاخرة بأعلى معايير الجودة',
                'section_id' => $featuresSection->id,
                'key' => 'feature_quality',
                'sort_order' => 2,
                'image' => 'images/features/features-quality.svg',
            ]);
            
            SectionPart::create([
                'title' => 'خدمة متميزة',
                'desc' => 'نحرص على توفير خدمة عملاء مميزة، وتقديم حلول مرنة تناسب احتياجاتك',
                'section_id' => $featuresSection->id,
                'key' => 'feature_service',
                'sort_order' => 3,
                'image' => 'images/features/features-service.svg',
            ]);
        }
        
        // Company Section Parts
        if ($companySection) {
            SectionPart::create([
                'title' => 'ما الفوائد التي ستحصل عليها عند التعاون معنا',
                'desc' => 'نتميز بخبرة طويلة في مجال استيراد وتصدير المنتجات الزراعية الجافة نعمل على توفير مجموعة من المنتجات عالية الجودة التي تلبي احتياجات السوق',
                'section_id' => $companySection->id,
                'key' => 'company_benefits',
                'sort_order' => 1,
            ]);
            SectionPart::create([
                'title' => 'الشركه',
                'desc' => 'تأسست شركة الأمانة للاستيراد و التصدير عام ٢٠١٢ لتعمل في مجال استيراد و تصدير الحاصلات الزراعية الجافة لذلك فهي أصبحت تمتلك اقوي فريق عمل يتقي المحاصيل ذات الجودة العالية و فرزها و تنقيتها تصديرها لكل بلدان العالم مثل العراق و رومانيا و تركيا و اسبانيا ..... الخ و لسعي الشركة للتوسعات في هذا المجال',
                'section_id' => $companySection->id,
                'key' => 'company_about',
                'image' => 'images/firm-section/firm-bg.jpeg',
                'sort_order' => 1,
            ]);
        }
        
        // Management Section Parts
        if ($managementSection) {
            SectionPart::create([
                'title' => 'إدارة الشركة',
                'desc' => 'في شركة الأمانة، يقودنا فريق إداري متميز ذو خبرة طويلة في صناعة الاستيراد والتصدير، حيث نؤمن أن القيادة الحكيمة والتخطيط الاستراتيجي هما أساس نجاحنا المستمر. يتمتع كل عضو في فريق الإدارة بمعرفة واسعة بمتطلبات السوق الزراعي، مما يعزز قدرتنا على تقديم حلول مبتكرة تلبي احتياجات عملائنا',
                'section_id' => $managementSection->id,
                'key' => 'management_company',
                'sort_order' => 1,
            ]);
            
            SectionPart::create([
                'title' => 'المدير العام',
                'desc' => 'بخبرة تمتد لأكثر من 12 سنوات في مجال التجارة الدولية والقطاع الزراعي، يتولى [اسم المدير العام] قيادة [اسم الشركة] برؤية استراتيجية تهدف إلى النمو المستدام والتوسع في الأسواق العالمية. من خلال مهاراته القيادية، ساهم في تعزيز علاقات الشركة مع شركائها والعملاء في مختلف أنحاء العالم',
                'section_id' => $managementSection->id,
                'key' => 'management_general',
                'sort_order' => 2,
            ]);
            
            SectionPart::create([
                'title' => 'فريق العمل',
                'desc' => 'يضم فريق إدارة شركة الأمانة مجموعة من المتخصصين في مجالات متعددة، مثل الاستيراد التصدير، اللوجستيات والتسويق. يعمل الفريق بتنسيق تام لضمان تقديم أفضل تجربة لعملائنا ويحرص على تنفيذ استراتيجيات مبتكرة تعزز من فعالية العمل في كل جانب من جوانب العملية التجارية',
                'section_id' => $managementSection->id,
                'key' => 'management_team',
                'sort_order' => 3,
            ]);
            
            SectionPart::create([
                'title' => 'قيمنا',
                'desc' => 'الابتكار: نسعى دائمًا لتقديم حلول جديدة ومبتكرة لتحسين عملياتنا التجارية
الاحترافية: التزامنا بمعايير الجودة والتميز في كل خطوة
الشفافية: نؤمن بالتعامل بشفافية مع عملائنا وشركائنا، لضمان أفضل نتائج ممكنة',
                'section_id' => $managementSection->id,
                'key' => 'management_values',
                'sort_order' => 4,
            ]);
            
            SectionPart::create([
                'title' => 'أسعار مناسبة',
                'desc' => '<div class="image-overlay">
                                    <p class="image-text">نحرص على تقديم<br>أسعار مناسبة تناسب<br>جميع أنواع الأسواق</p>
                                </div>
',
                'section_id' => $managementSection->id,
                'key' => 'management_prices',
                'image' => 'images/products/amana-product.jpeg',
                'sort_order' => 5,
            ]);
        }
        
        // Contact Section Parts
        if ($contactSection) {
            SectionPart::create([
                'title' => 'العنوان',
                'desc' => '<p>طريق السادات كفرداود عند مشارق التحرير</p>
                        <p>بجوار الكلية الجديدة/المنوفية/مصر</p>',
                'section_id' => $contactSection->id,
                'key' => 'contact_address',
                'image' => 'images/footer/footer.jpg',
                'sort_order' => 1,
            ]);
            
            SectionPart::create([
                'title' => 'تليفون+واتس اب',
                'desc' => '<div class="contact-phones">
                        <div class="phone-column">
                            <div class="phone-number">01003103589</div>
                            <div class="phone-number">01024113153</div>
                        </div>
                        <div class="phone-column">
                            <div class="phone-number">01009594480</div>
                            <div class="phone-number">01093809980</div>
                            <div class="phone-number">01000766218</div>
                        </div>
                    </div>',
                'section_id' => $contactSection->id,
                'key' => 'contact_phones',
                'sort_order' => 2,
            ]);

            SectionPart::create([
                'title' => 'الموقع',
                'desc' => 'https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d6913.681934278306!2d30.9359!3d30.0759!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2seg!4v1645568556012!5m2!1sen!2seg',
                'section_id' => $contactSection->id,
                'key' => 'contact_map',
                'sort_order' => 2,
            ]);
        }
        
        // Product Counter in Hero Section
        if ($heroSection) {
            SectionPart::create([
                'title' => 'منتجات',
                'desc' => '+10',
                'section_id' => $heroSection->id,
                'key' => 'hero_product_counter',
                'sort_order' => 1,
            ]);
            
            SectionPart::create([
                'title' => 'اكتشف المزيد',
                'desc' => '',
                'section_id' => $heroSection->id,
                'key' => 'hero_scroll_down',
                'sort_order' => 2,
            ]);
        }
    }
} 
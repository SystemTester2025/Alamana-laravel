<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SectionSeeder extends Seeder
{
    /**
     * Seeds the sections table with data extracted from the frontend blade template.
     * This follows the Single Responsibility Principle by focusing only on seeding sections.
     *
     * @return void
     */
    public function run(): void
    {
        // Clear existing sections
        Section::truncate();
        
        // Hero Section
        Section::create([
            'name' => 'القسم الرئيسي',
            'slug' => 'hero-section',
            'title' => 'نحن جسر بين الطبيعة',
            'sub' => 'والأسواق العالمية',
            'desc' => 'قسم الصفحة الرئيسية الذي يعرض العنوان الرئيسي للموقع',
            'key' => 'hero',
        ]);
        
        // Features Section
        Section::create([
            'name' => 'المميزات',
            'slug' => 'features-section',
            'title' => 'المميزات',
            'sub' => 'ما يميزنا',
            'desc' => 'شبكة واسعة، جودة عالية، خدمة متميزة',
            'key' => 'features',
        ]);
        
        // Company Section
        Section::create([
            'name' => 'عن الشركة',
            'slug' => 'company-section',
            'title' => 'الشركة',
            'sub' => 'ما الفوائد التي ستحصل عليها عند التعاون معنا',
            'desc' => 'تأسست شركة الأمانة للاستيراد و التصدير عام ٢٠١٢ لتعمل في مجال استيراد و تصدير الحاصلات الزراعية الجافة لذلك فهي أصبحت تمتلك اقوي فريق عمل يتقي المحاصيل ذات الجودة العالية و فرزها و تنقيتها تصديرها لكل بلدان العالم مثل العراق و رومانيا و تركيا و اسبانيا ..... الخ و لسعي الشركة للتوسعات في هذا المجال',
            'key' => 'company',
        ]);
        
        // Management Section
        Section::create([
            'name' => 'عن الإدارة',
            'slug' => 'management-section',
            'title' => 'الإدارة',
            'sub' => 'المدير العام',
            'desc' => 'في شركة الأمانة، يقودنا فريق إداري متميز ذو خبرة طويلة في صناعة الاستيراد والتصدير، حيث نؤمن أن القيادة الحكيمة والتخطيط الاستراتيجي هما أساس نجاحنا المستمر.',
            'key' => 'management',
        ]);
        
        // Products Section
        Section::create([
            'name' => 'المنتجات',
            'slug' => 'products-section',
            'title' => 'المنتجات',
            'sub' => 'منتجاتنا',
            'desc' => 'مجموعة متنوعة من المنتجات الزراعية عالية الجودة',
            'key' => 'products',
        ]);
        
        // Contact Section
        Section::create([
            'name' => 'تواصل معنا',
            'slug' => 'contact-section',
            'title' => 'اتصل بنا',
            'sub' => 'معلومات الاتصال',
            'desc' => 'طريق السادات كفرداود عند مشارق التحرير، بجوار الكلية الجديدة/المنوفية/مصر',
            'key' => 'contact',
        ]);
        
        // Values Section (from accordion)
        Section::create([
            'name' => 'قيمنا',
            'slug' => 'values-section',
            'title' => 'قيمنا',
            'sub' => 'مبادئنا',
            'desc' => 'الابتكار: نسعى دائمًا لتقديم حلول جديدة ومبتكرة لتحسين عملياتنا التجارية. الاحترافية: التزامنا بمعايير الجودة والتميز في كل خطوة. الشفافية: نؤمن بالتعامل بشفافية مع عملائنا وشركائنا، لضمان أفضل نتائج ممكنة.',
            'key' => 'values',
        ]);
    }
} 
<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Make sure we don't create duplicate settings
        if (Setting::count() === 0) {
            Setting::create([
                'title' => 'الأمانة للاستيراد والتصدير',
                'description' => 'شركة متخصصة في استيراد وتصدير المنتجات الزراعية',
                'email' => 'info@alamana.com',
                'phone' => '01003103589',
                'logo'=>'images/logo/logo.svg',
                'favicon'=>'images/logo/favicon.svg',
                'footer_logo'=>'images/logo/footer_logo.svg',
                'address' => 'طريق السادات كفرداود عند مشارق التحرير، بجوار الكلية الجديدة/المنوفية/مصر',
                'facebook' => 'https://facebook.com/alamana',
                'twitter' => 'https://twitter.com/alamana',
                'instagram' => 'https://instagram.com/alamana',
                'linkedin' => 'https://linkedin.com/company/alamana',
            ]);
        }
    }
} 
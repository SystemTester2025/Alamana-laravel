<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'title' => 'عدس',
                'sub_title' => 'عدس مصري فاخر',
                'description' => 'عدس مصري ذو جودة عالية. يتميز بحبوب كبيرة متساوية الحجم ولون أحمر زاهي.',
                'category' => 'البقوليات',
                'sort_order' => 1,
                'featured' => true,
                'image' => 'images/products/dora.jpg',
            ],
            [
                'title' => 'فصوليا بيضاء',
                'sub_title' => 'فصوليا بيضاء خالية من الشوائب',
                'description' => 'فصوليا بيضاء مصرية ذات جودة ممتازة، خالية من الشوائب والحشرات.',
                'category' => 'البقوليات',
                'sort_order' => 2,
                'featured' => true,
                'image' => 'images/products/fasolia.jpg',
            ],
            [
                'title' => 'حمص',
                'sub_title' => 'حمص مصري فاخر',
                'description' => 'حمص مصري ذو جودة عالية، يتميز بحبوب كبيرة متساوية الحجم.',
                'category' => 'البقوليات',
                'sort_order' => 3,
                'featured' => true,
                'image' => 'images/products/homos.jpg',
            ],
            [
                'title' => 'ترمس',
                'sub_title' => 'ترمس مصري',
                'description' => 'ترمس مصري ذو جودة عالية، مناسب للتصدير.',
                'category' => 'البقوليات',
                'sort_order' => 4,
                'featured' => false,
                'image' => 'images/products/trms.jpg',
            ],
            [
                'title' => 'ذرة فشار',
                'sub_title' => 'ذرة فشار عالية الجودة',
                'description' => 'ذرة فشار ذات جودة عالية، تتميز بنسبة انتفاخ ممتازة.',
                'category' => 'الحبوب',
                'sort_order' => 5,
                'featured' => false,
                'image' => 'images/products/roz.jpg',
            ],
            [
                'title' => 'فول',
                'sub_title' => 'فول مصري',
                'description' => 'فول مصري ذو جودة عالية، يتميز بحبوب كبيرة متساوية الحجم.',
                'category' => 'البقوليات',
                'sort_order' => 6,
                'featured' => false,
                'image' => 'images/products/fol.jpg',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
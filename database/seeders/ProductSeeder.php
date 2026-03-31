<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // Liquor
            [
                'sku'                 => 'LIQ-001',
                'name'                => 'Johnnie Walker Black Label',
                'category'            => 'Liquor',
                'price'               => 38.90,
                'stock'               => 50,
                'availability_status' => 'available',
                'short_description'   => '12-year-old blended Scotch whisky with a smooth, deep character.',
            ],
            [
                'sku'                 => 'LIQ-002',
                'name'                => 'Hennessy VS Cognac',
                'category'            => 'Liquor',
                'price'               => 45.00,
                'stock'               => 30,
                'availability_status' => 'available',
                'short_description'   => 'Classic French cognac with notes of fruit and oak.',
            ],
            [
                'sku'                 => 'LIQ-003',
                'name'                => 'Grey Goose Vodka 1L',
                'category'            => 'Liquor',
                'price'               => 42.50,
                'stock'               => 25,
                'availability_status' => 'available',
                'short_description'   => 'Premium French vodka, smooth and pure.',
            ],
            [
                'sku'                 => 'LIQ-004',
                'name'                => 'Macallan 12 Year Old',
                'category'            => 'Liquor',
                'price'               => 72.00,
                'stock'               => 15,
                'availability_status' => 'available',
                'short_description'   => 'Single malt Scotch whisky matured in sherry-seasoned oak casks.',
            ],

            // Perfume
            [
                'sku'                 => 'PRF-001',
                'name'                => 'Chanel No. 5 EDP 100ml',
                'category'            => 'Perfume',
                'price'               => 110.00,
                'stock'               => 20,
                'availability_status' => 'available',
                'short_description'   => 'Timeless floral-aldehyde fragrance, an icon of feminine elegance.',
            ],
            [
                'sku'                 => 'PRF-002',
                'name'                => 'Dior Sauvage EDT 100ml',
                'category'            => 'Perfume',
                'price'               => 89.00,
                'stock'               => 18,
                'availability_status' => 'available',
                'short_description'   => 'Bold and fresh with top notes of bergamot and Ambroxan.',
            ],
            [
                'sku'                 => 'PRF-003',
                'name'                => 'Tom Ford Black Orchid 50ml',
                'category'            => 'Perfume',
                'price'               => 135.00,
                'stock'               => 10,
                'availability_status' => 'available',
                'short_description'   => 'Luxurious and sensual dark floral fragrance.',
            ],
            [
                'sku'                 => 'PRF-004',
                'name'                => 'Jo Malone Lime Basil & Mandarin 100ml',
                'category'            => 'Perfume',
                'price'               => 95.00,
                'stock'               => 0,
                'availability_status' => 'unavailable',
                'short_description'   => 'Distinctive and refreshing cologne with a peppery edge.',
            ],

            // Tobacco
            [
                'sku'                 => 'TOB-001',
                'name'                => 'Marlboro Red (Carton of 10)',
                'category'            => 'Tobacco',
                'price'               => 55.00,
                'stock'               => 100,
                'availability_status' => 'available',
                'short_description'   => 'Classic full-flavour cigarettes, carton of 10 packs.',
            ],
            [
                'sku'                 => 'TOB-002',
                'name'                => 'Cohiba Siglo IV Cigars (Pack of 5)',
                'category'            => 'Tobacco',
                'price'               => 68.00,
                'stock'               => 12,
                'availability_status' => 'available',
                'short_description'   => 'Premium Cuban cigars with a rich, smooth flavour profile.',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}

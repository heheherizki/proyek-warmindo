<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        Product::create([
            'name' => 'Indomie Goreng Original',
            'description' => 'Indomie goreng klasik dengan bumbu original.',
            'price' => 8000,
            'image_url' => 'products/mie-goreng-spesial.png'
            ]);

        Product::create([
            'name' => 'Indomie Rebus Kari Ayam',
            'description' => 'Indomie kuah dengan rasa kari ayam yang hangat.',
            'price' => 8000,
            'image_url' => 'products/mie-rebus-kari.png'
            ]);

        Product::create([
            'name' => 'Es Teh Manis',
            'description' => 'Minuman teh manis dingin yang menyegarkan.',
            'price' => 4000,
            'image_url' => 'products/es-teh-jumbo.png'
            ]);

        Product::create([
            'name' => 'Roti Bakar Cokelat',
            'description' => 'Manis dan renyah, teman sempurna Indomie.',
            'price' => 10000,
            'image_url' => 'products/roti-bakar-coklat.png'
            ]);
    }
}

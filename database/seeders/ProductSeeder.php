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
            'description' => 'Indomie goreng original dengan topping telur dan sayuran.',
            'price' => 16000,
            'image_url' => 'products/indomie-goreng-original.png',
            'is_featured' => false,
            ]);
        
        Product::create([
            'name' => 'Indomie Sambal Matah',
            'description' => 'Indomie goreng dengan topping sambal matah khas Bali, ditambah suwiran ayam dan bawang goreng.',
            'price' => 17000,
            'image_url' => 'products/indomie-sambal-matah.png',
            'is_featured' => false,
            ]);

        Product::create([
            'name' => 'Indomie Mozarella Melt',
            'description' => 'Indomie goreng dengan lelehan keju mozarella dan sosis panggang di atasnya.',
            'price' => 20000,
            'image_url' => 'products/indomie-mozarella.png',
            'is_featured' => true,
            ]);

        Product::create([
            'name' => 'Indomie Rendang Crispy',
            'description' => 'Indomie dengan topping daging rendang kering dan sambal ijo Padang.',
            'price' => 22000,
            'image_url' => 'products/indomie-rendang.png',
            'is_featured' => true,
            ]);

        Product::create([
            'name' => 'Indomie Ayam Geprek Lava',
            'description' => 'Indomie goreng dengan ayam geprek pedas level 1–5 sesuai selera pelanggan.',
            'price' => 19000,
            'image_url' => 'products/indomie-geprek-lava.png',
            'is_featured' => false,
            ]);
        
        Product::create([
            'name' => 'Indomie Kuah Susu Keju',
            'description' => 'Indomie kuah creamy berbasis susu dan taburan keju parut di atasnya.',
            'price' => 18000,
            'image_url' => 'products/indomie-susu-keju.png',
            'is_featured' => false,
            ]);

        Product::create([
            'name' => 'Indomie Kari Original',
            'description' => 'Indomie kuah dengan bumbu kari original, telur rebus, dan perasan jeruk nipis.',
            'price' => 18000,
            'image_url' => 'products/indomie-kari-original.png',
            'is_featured' => true,
            ]);
        
        Product::create([
            'name' => 'Indomie Kari Jepang',
            'description' => 'Indomie kuah dengan bumbu kari Jepang kental, potongan ayam, dan wortel rebus.',
            'price' => 20000,
            'image_url' => 'products/indomie-kari-jepang.png',
            'is_featured' => false,
            ]);

        Product::create([
            'name' => 'Indomie Seafood Creamy',
            'description' => 'Indomie kuah susu dengan topping udang, crab stick, dan daun bawang.',
            'price' => 22000,
            'image_url' => 'products/indomie-seafood-creamy.png',
            'is_featured' => false,
            ]);

        Product::create([
            'name' => 'Indomie Sambal Ijo Padang',
            'description' => 'Indomie goreng dengan sambal ijo khas Padang dan ayam suwir. Pedas gurih menggugah selera.',
            'price' => 17000,
            'image_url' => 'products/indomie-sambal-ijo.png',
            'is_featured' => false,
            ]);

        Product::create([
            'name' => 'Indomie Carbonara',
            'description' => 'Indomie dengan saus carbonara creamy, keju parut, dan smoked beef, ala fusion barat dan lokal.',
            'price' => 23000,
            'image_url' => 'products/indomie-carbonara.png',
            'is_featured' => false,
            ]);

        Product::create([
            'name' => 'Indomie Kuah Bakso Pedas',
            'description' => 'Indomie kuah gurih dengan bakso sapi, sambal cabe rawit, dan daun seledri.',
            'price' => 17000,
            'image_url' => 'products/indomie-kuah-bakso.png',
            'is_featured' => true,
            ]);

        Product::create([
            'name' => 'Nasi Ayam Crispy Sambal Matah',
            'description' => 'Nasi hangat dengan ayam crispy goreng tepung dan sambal matah Bali segar.',
            'price' => 19000,
            'image_url' => 'products/nasi-ayam-crispy.png',
            'is_featured' => true,
            ]);

        Product::create([
            'name' => 'Nasi Telur Dadar Rawit',
            'description' => 'Nasi hangat dengan telur dadar isi irisan cabai rawit dan bawang, disajikan dengan sambal bawang.',
            'price' => 15000,
            'image_url' => 'products/nasi-telur-dadar.png',
            'is_featured' => false,
            ]);

        Product::create([
            'name' => 'Es Teh Manis',
            'description' => 'Minuman teh manis dingin yang menyegarkan.',
            'price' => 7000,
            'image_url' => 'products/es-teh-jumbo.png',
            'is_featured' => false,
            ]);

        Product::create([
            'name' => 'Es Teh Tarik',
            'description' => 'Teh kental dicampur susu kental manis dan es batu, ala mamak Malaysia.',
            'price' => 10000,
            'image_url' => 'products/es-teh-tarik.png',
            'is_featured' => false,
            ]);

        Product::create([
            'name' => 'Es Kopi Susu Gula Aren',
            'description' => 'Kopi robusta lokal dengan susu segar dan sirup gula aren khas.',
            'price' => 13000,
            'image_url' => 'products/es-kopi-susu-aren.png',
            'is_featured' => false,
            ]);

        Product::create([
            'name' => 'Es Kopi Cokelat',
            'description' => 'Perpaduan kopi robusta dengan cokelat pekat dan susu segar, disajikan dingin.',
            'price' => 14000,
            'image_url' => 'products/es-kopi-coklat.png',
            'is_featured' => false,
            ]);

        Product::create([
            'name' => 'Es Susu Regal',
            'description' => 'Minuman dingin susu segar dengan topping biskuit regal yang lembut dan manis.',
            'price' => 13000,
            'image_url' => 'products/es-susu-regal.png',
            'is_featured' => false,
            ]);

        Product::create([
            'name' => 'Es Klepon Latte',
            'description' => 'Latte creamy dengan sirup gula kelapa dan topping taburan kelapa parut unik khas Indonesia.',
            'price' => 15000,
            'image_url' => 'products/es-klepon.png',
            'is_featured' => false,
            ]);

        Product::create([
            'name' => 'Es Cokelat Creamy',
            'description' => 'Minuman cokelat kental dan manis, disajikan dingin dengan krim di atasnya.',
            'price' => 13000,
            'image_url' => 'products/es-coklat.png',
            'is_featured' => false,
            ]);

        Product::create([
            'name' => 'Es Jeruk Peras Segar',
            'description' => 'Jeruk peras asli tanpa pemanis buatan, disajikan dingin.',
            'price' => 9000,
            'image_url' => 'products/es-jeruk.png',
            'is_featured' => true,
            ]);

        Product::create([
            'name' => 'Es Yakult Lemon',
            'description' => 'Minuman segar perpaduan yakult dan lemon, rasa manis asam menyegarkan.',
            'price' => 12000,
            'image_url' => 'products/es-lemon.png',
            'is_featured' => false,
            ]);

        Product::create([
            'name' => 'Tahu Crispy Cabe Garam',
            'description' => 'Tahu goreng renyah dengan taburan bawang putih, cabai, dan daun bawang gurih pedas.',
            'price' => 12000,
            'image_url' => 'products/snack-tahu-crispi.png',
            'is_featured' => false,
            ]);

        Product::create([
            'name' => 'Pisang Goreng Cokelat Lumer',
            'description' => 'Pisang goreng krispi dengan isian cokelat leleh dan taburan gula halus.',
            'price' => 13000,
            'image_url' => 'products/snack-piscok.png',
            'is_featured' => false,
            ]);

        Product::create([
            'name' => 'Kentang Goreng Original',
            'description' => 'Kentang goreng renyah disajikan dengan saus sambal dan mayones.',
            'price' => 10000,
            'image_url' => 'products/snack-kentang-goreng.png',
            'is_featured' => false,
            ]);

        Product::create([
            'name' => 'Sosis Bakar Pedas Manis',
            'description' => 'Sosis panggang dengan bumbu saus manis pedas, cocok sebagai cemilan hangat.',
            'price' => 13000,
            'image_url' => 'products/snack-sosis-bakar.png',
            'is_featured' => true,
            ]);

        Product::create([
            'name' => 'Dimsum Ayam Saus Mentai',
            'description' => 'Dimsum ayam lembut disiram saus mentai bakar creamy dan gurih.',
            'price' => 18000,
            'image_url' => 'products/snack-dimsum.png',
            'is_featured' => false,
            ]);

        Product::create([
            'name' => 'Pudding Cokelat Regal',
            'description' => 'Puding cokelat lembut dengan topping biskuit regal dan krim vanilla.',
            'price' => 14000,
            'image_url' => 'products/snack-pudding-regal.png',
            'is_featured' => false,
            ]);

        Product::create([
            'name' => 'Pudding Matcha Susu',
            'description' => 'Puding rasa matcha dengan lapisan susu manis dan topping whipped cream.',
            'price' => 15000,
            'image_url' => 'products/snack-pudding-matcha.png',
            'is_featured' => true,
            ]);
    }
}

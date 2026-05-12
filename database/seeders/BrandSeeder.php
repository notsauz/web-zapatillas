<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            [
                'name' => 'Nike',
                'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/3/36/Logo_nike_principal.jpg',
                'description_es' => 'La marca número uno en innovación y diseño de zapatillas deportivas.',
                'description_en' => 'The number one brand in sneaker innovation and design.',
            ],
            [
                'name' => 'Adidas',
                'logo_url' => 'https://cdn-icons-png.flaticon.com/512/731/731962.png',
                'description_es' => 'Excelencia en rendimiento y estilo desde 1949.',
                'description_en' => 'Excellence in performance and style since 1949.',
            ],
            [
                'name' => 'Converse',
                'logo_url' => 'https://brandemia.org/sites/default/files/inline/images/412d6658825261.5a0afaafa77fb.jpg',
                'description_es' => 'Los clásicos icónicos de la cultura urbana.',
                'description_en' => 'Iconic classics of urban culture.',
            ],
            [
                'name' => 'Puma',
                'logo_url' => 'https://caphunters.bg/img/m/171.jpg',
                'description_es' => 'Diseño retro con tecnología moderna.',
                'description_en' => 'Retro design with modern technology.',
            ],
            [
                'name' => 'Vans',
                'logo_url' => 'https://i.ebayimg.com/images/g/t24AAOSwLu1kBlu4/s-l400.jpg',
                'description_es' => 'La marca preferida de los skaters desde los 70s.',
                'description_en' => 'The preferred brand of skaters since the 70s.',
            ],
            [
                'name' => 'New Balance',
                'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/e/ea/New_Balance_logo.svg/3840px-New_Balance_logo.svg.png',
                'description_es' => 'Comodidad y calidad sin compromisos.',
                'description_en' => 'Comfort and quality without compromise.',
            ],
            [
                'name' => 'Reebok',
                'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/5/53/Reebok_2019_logo.svg/1280px-Reebok_2019_logo.svg.png',
                'description_es' => 'Rendimiento y versatilidad para todos.',
                'description_en' => 'Performance and versatility for everyone.',
            ],
            [
                'name' => 'Saucony',
                'logo_url' => 'https://cdn.worldvectorlogo.com/logos/saucony-3.svg',
                'description_es' => 'Innovación en zapatillas para correr.',
                'description_en' => 'Innovation in running shoes.',
            ],
            [
                'name' => 'Asics',
                'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/b/b1/Asics_Logo.svg/1280px-Asics_Logo.svg.png',
                'description_es' => 'Tecnología japonesa para el confort máximo.',
                'description_en' => 'Japanese technology for maximum comfort.',
            ],
        ];

        foreach ($brands as $brand) {
            Brand::updateOrCreate(
                ['name' => $brand['name']],
                [
                    'logo_url' => $brand['logo_url'],
                    'description_es' => $brand['description_es'],
                    'description_en' => $brand['description_en'],
                ]
            );
        }
    }
}

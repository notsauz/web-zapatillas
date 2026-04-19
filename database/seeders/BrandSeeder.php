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
                'description' => 'La marca número uno en innovación y diseño de zapatillas deportivas.',
            ],
            [
                'name' => 'Adidas',
                'logo_url' => 'https://cdn-icons-png.flaticon.com/512/731/731962.png',
                'description' => 'Excelencia en rendimiento y estilo desde 1949.',
            ],
            [
                'name' => 'Converse',
                'logo_url' => 'https://brandemia.org/sites/default/files/inline/images/412d6658825261.5a0afaafa77fb.jpg',
                'description' => 'Los clásicos icónicos de la cultura urbana.',
            ],
            [
                'name' => 'Puma',
                'logo_url' => 'https://caphunters.bg/img/m/171.jpg',
                'description' => 'Diseño retro con tecnología moderna.',
            ],
            [
                'name' => 'Vans',
                'logo_url' => 'https://i.ebayimg.com/images/g/t24AAOSwLu1kBlu4/s-l400.jpg',
                'description' => 'La marca preferida de los skaters desde los 70s.',
            ],
            [
                'name' => 'New Balance',
                'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/e/ea/New_Balance_logo.svg/3840px-New_Balance_logo.svg.png',
                'description' => 'Comodidad y calidad sin compromisos.',
            ],
            [
                'name' => 'Reebok',
                'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/5/53/Reebok_2019_logo.svg/1280px-Reebok_2019_logo.svg.png',
                'description' => 'Rendimiento y versatilidad para todos.',
            ],
            [
                'name' => 'Saucony',
                'logo_url' => 'https://atlasstoked.com/img/cms/blog/imported/saucony-1024x310.jpg',
                'description' => 'Innovación en zapatillas para correr.',
            ],
            [
                'name' => 'Asics',
                'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/b/b1/Asics_Logo.svg/1280px-Asics_Logo.svg.png',
                'description' => 'Tecnología japonesa para el confort máximo.',
            ],
        ];

        foreach ($brands as $brand) {
            Brand::updateOrCreate(
                ['name' => $brand['name']],
                [
                    'logo_url' => $brand['logo_url'],
                    'description' => $brand['description'],
                ]
            );
        }
    }
}

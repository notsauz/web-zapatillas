<?php

namespace Database\Seeders;

use App\Models\Sneaker;
use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SneakersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sneakers = [
            // Nike - Hombre
            [
                'name' => 'Nike Air Jordan 1 Retro High OG',
                'sku' => 'AJ1-RET-001',
                'brand_name' => 'Nike',
                'category' => 'hombre',
                'price' => 170.00,
                'image_url' => 'https://cdn-images.farfetch-contents.com/12/96/03/49/12960349_13486594_600.jpg',
                'sizes' => ['36', '37', '38', '39', '40', '41', '42', '43', '44', '45', '46'],
                'color' => 'Rojo/Negro/Blanco',
                'description' => 'Las legendarias Air Jordan 1 Retro High. Un clásico de la NBA que definió una era. Comodidad y estilo inconfundible en cada paso.',
            ],
            [
                'name' => 'Nike Air Force 1 Premium',
                'sku' => 'NAF-001',
                'brand_name' => 'Nike',
                'category' => 'unisex',
                'price' => 110.00,
                'image_url' => 'https://static.nike.com/a/images/t_web_pdp_936_v2/f_auto,u_9ddf04c7-2a9a-4d76-add1-d15af8f0263d,c_scale,fl_relative,w_1.0,h_1.0,fl_layer_apply/2f25c092-5175-4e14-b7e2-115dd73138cd/AIR+FORCE+1+%2707+PRM.png',
                'sizes' => ['36', '37', '38', '39', '40', '41', '42', '43', '44', '45', '46'],
                'color' => 'Blanco/Plateado',
                'description' => 'El Air Force 1 es un icono del sneaker culture. Versátil, duradero y perfecto para cualquier ocasión. Imprescindible en tu colección.',
            ],
            [
                'name' => 'Nike Air Max 90 OG',
                'sku' => 'NAM90-001',
                'brand_name' => 'Nike',
                'category' => 'hombre',
                'price' => 135.00,
                'image_url' => 'https://cdn-images.farfetch-contents.com/16/07/06/97/16070697_30563905_1000.jpg',
                'sizes' => ['36', '37', '38', '39', '40', '41', '42', '43', '44', '45'],
                'color' => 'Blanco/Negro/Rojo',
                'description' => 'El Air Max 90 con su clásico Air Cushioning. Comodidad excepcional y diseño atemporal que ha perdurado décadas.',
            ],
            [
                'name' => 'Nike Blazer Mid 77',
                'sku' => 'NBZ-MID-001',
                'brand_name' => 'Nike',
                'category' => 'mujer',
                'price' => 105.00,
                'image_url' => 'https://cdn.media.amplience.net/i/frasersdev/27435030_o_a1.jpg?v=20240417082012',
                'sizes' => ['35', '36', '37', '38', '39', '40', '41'],
                'color' => 'Blanco/Gris',
                'description' => 'Nike Blazer Mid 77 vintage. Un diseño retro con toque moderno. Perfecto para un look casual y elegante.',
            ],
            [
                'name' => 'Nike SB Dunk Low Pro',
                'sku' => 'NSB-DL-001',
                'brand_name' => 'Nike',
                'category' => 'hombre',
                'price' => 125.00,
                'image_url' => 'https://static.nike.com/a/images/t_web_pdp_936_v2/f_auto,u_9ddf04c7-2a9a-4d76-add1-d15af8f0263d,c_scale,fl_relative,w_1.0,h_1.0,fl_layer_apply/d3087a3d-e6aa-4a22-88a1-764a0f0a58b8/NIKE+SB+DUNK+LOW+PRO.png',
                'sizes' => ['37', '38', '39', '40', '41', '42', '43', '44', '45'],
                'color' => 'Negro/Blanco',
                'description' => 'Nike SB Dunk Low Pro para skateboarding. Tecnología Pro para mayor soporte y durabilidad en tabla.',
            ],

            // Adidas - Diversos
            [
                'name' => 'Adidas Stan Smith',
                'sku' => 'ADS-SS-001',
                'brand_name' => 'Adidas',
                'category' => 'mujer',
                'price' => 95.00,
                'image_url' => 'https://assets.adidas.com/images/w_600,f_auto,q_auto/69721f2e7c934d909168a80e00818569_9366/Zapatilla_Stan_Smith_Blanco_M20324_01_standard.jpg',
                'sizes' => ['35', '36', '37', '38', '39', '40', '41', '42'],
                'color' => 'Blanco/Verde',
                'description' => 'El legendario Adidas Stan Smith. Diseñado en 1972, sigue siendo un clásico imprescindible de la moda.',
            ],
            [
                'name' => 'Adidas Ultraboost 21',
                'sku' => 'ADS-UB21-001',
                'brand_name' => 'Adidas',
                'category' => 'hombre',
                'price' => 180.00,
                'image_url' => 'https://www.runningxpert.com/media/catalog/product/cache/e1bfa30f5f000aa573b2ee969a7a0fde/f/y/fy0402_ftw_photo_side-lateral-center_white_1.jpg',
                'sizes' => ['35', '36', '37', '38', '39', '40', '41', '42', '43', '44'],
                'color' => 'Negro/Gris',
                'description' => 'Adidas Ultraboost 21 con máxima amortiguación Boost. La mejor opción para correr con comodidad extrema.',
            ],
            [
                'name' => 'Adidas Superstar OG',
                'sku' => 'ADS-SSO-001',
                'brand_name' => 'Adidas',
                'category' => 'unisex',
                'price' => 100.00,
                'image_url' => 'https://assets.adidas.com/images/w_600,f_auto,q_auto/a70831f36a424a20892e69ab599156ba_9366/Zapatilla_Superstar_Vintage_Blanco_JQ3254_01_00_standard.jpg',
                'sizes' => ['35', '36', '37', '38', '39', '40', '41', '42', '43', '44', '45'],
                'color' => 'Blanco/Negro',
                'description' => 'Adidas Superstar clásico con su inconfundible punta de goma. Un ícono que trasciende generaciones.',
            ],
            [
                'name' => 'Adidas NMD R1',
                'sku' => 'ADS-NMD-001',
                'brand_name' => 'Adidas',
                'category' => 'niño',
                'price' => 85.00,
                'image_url' => 'https://img01.ztat.net/article/spp-media-p1/ecefa492d69541b7a66b11a08e210f39/37a41ae1387d4f2e8db09e8e37e3d28b.jpg?imwidth=1800&filter=packshot',
                'sizes' => ['30', '31', '32', '33', '34', '35', '36', '37', '38'],
                'color' => 'Blanco/Rojo',
                'description' => 'Adidas NMD R1 para pequeños con diseño moderno. Comodidad y estilo para el día a día.',
            ],

            // Converse
            [
                'name' => 'Converse Chuck Taylor All Star High',
                'sku' => 'CON-CTA-HI',
                'brand_name' => 'Converse',
                'category' => 'unisex',
                'price' => 75.00,
                'image_url' => 'https://cdn.laredoute.com/cdn-cgi/image/width=500,height=500,fit=pad,dpr=1/products/1/3/b/13bc6c009807cd02e986b932aae58a61.jpg',
                'sizes' => ['35', '36', '37', '38', '39', '40', '41', '42', '43', '44', '45', '46'],
                'color' => 'Negro',
                'description' => 'Las icónicas Converse Chuck Taylor All Star. Un clásico que nunca falla, perfeccionadas a través del tiempo.',
            ],
            [
                'name' => 'Converse Chuck Taylor White',
                'sku' => 'CON-CTA-WH',
                'brand_name' => 'Converse',
                'category' => 'unisex',
                'price' => 75.00,
                'image_url' => 'https://www.thestreets.es/media/catalog/product/cache/2b5c0c30ec592b2d661598663b3592ba/8/f/8f86e6b92b6a1d630392bb9be45779f48eacc5c5_enkqyv58whgrgjuv.jpg',
                'sizes' => ['35', '36', '37', '38', '39', '40', '41', '42', '43', '44', '45', '46'],
                'color' => 'Blanco',
                'description' => 'Converse Chuck Taylor en blanco puro. Versátil y combinable con cualquier outfit. La base de cualquier guardarropa sneaker.',
            ],

            // Puma
            [
                'name' => 'Puma RS-X',
                'sku' => 'PMA-RSX-001',
                'brand_name' => 'Puma',
                'category' => 'hombre',
                'price' => 95.00,
                'image_url' => 'https://img01.ztat.net/article/spp-media-p1/44808b57bb5b4b7b83a08f4d89d5f60e/7f333c7af216419cb368ea7f2312464a.jpg?imwidth=1800&filter=packshot',
                'sizes' => ['36', '37', '38', '39', '40', '41', '42', '43', '44', '45'],
                'color' => 'Blanco/Rojo',
                'description' => 'Puma RS-X fusion: estilo retro 90s con tecnología moderna. Diseño revolucionario y comodidad inigualable.',
            ],
            [
                'name' => 'Puma Suede Classic',
                'sku' => 'PMA-SUE-001',
                'brand_name' => 'Puma',
                'category' => 'mujer',
                'price' => 80.00,
                'image_url' => 'https://images.puma.com/image/upload/f_auto,q_auto,b_rgb:fafafa,w_2000,h_2000/global/399781/01/sv01/fnd/EEA/fmt/png/Zapatillas-Suede-Classic-unisex',
                'sizes' => ['35', '36', '37', '38', '39', '40', '41', '42'],
                'color' => 'Rosa/Blanco',
                'description' => 'Puma Suede Classic con material premium. Diseño elegante y contemporáneo para cualquier ocasión casual.',
            ],

            // Vans
            [
                'name' => 'Vans Old Skool',
                'sku' => 'VAN-OS-001',
                'brand_name' => 'Vans',
                'category' => 'hombre',
                'price' => 75.00,
                'image_url' => 'https://welcomesk8.com/cdn/shop/products/vans-skate-old-skool-black-01_1200x1200.jpg?v=1623854588',
                'sizes' => ['36', '37', '38', '39', '40', '41', '42', '43', '44', '45', '46'],
                'color' => 'Negro/Blanco',
                'description' => 'Las legendarias Vans Old Skool con su icónica franja lateral. Símbolo de la contracultura del skate.',
            ],
            [
                'name' => 'Vans Slip-On',
                'sku' => 'VAN-SO-001',
                'brand_name' => 'Vans',
                'category' => 'unisex',
                'price' => 65.00,
                'image_url' => 'https://static.ftshp.digital/img/p/1/1/8/2/1/9/3/1182193-full_product.jpg',
                'sizes' => ['35', '36', '37', '38', '39', '40', '41', '42', '43', '44', '45'],
                'color' => 'Estampado Damier',
                'description' => 'Vans Slip-On sin cordones. Comodidad y estilo en un solo paso. Perfecta para ir al skatepark o paseo casual.',
            ],

            // New Balance
            [
                'name' => 'New Balance 574',
                'sku' => 'NB-574-001',
                'brand_name' => 'New Balance',
                'category' => 'hombre',
                'price' => 110.00,
                'image_url' => 'https://nb.scene7.com/is/image/NB/ml574evn_nb_02_i?$pdpflexf2$&wid=440&hei=440',
                'sizes' => ['36', '37', '38', '39', '40', '41', '42', '43', '44', '45'],
                'color' => 'Gris/Blanco',
                'description' => 'New Balance 574, el modelo más vendido de todos los tiempos. Comodidad garantizada y diseño clásico.',
            ],
            [
                'name' => 'New Balance 990v6',
                'sku' => 'NB-990-001',
                'brand_name' => 'New Balance',
                'category' => 'mujer',
                'price' => 185.00,
                'image_url' => 'https://cdn-images.farfetch-contents.com/20/46/66/89/20466689_50365634_600.jpg',
                'sizes' => ['36', '37', '38', '39', '40', '41'],
                'color' => 'Beige/Negro',
                'description' => 'New Balance 990v6, el buque insignia. Fabricación premium hecha en USA. Garantía de calidad y durabilidad.',
            ],

            // Reebok
            [
                'name' => 'Reebok Classic Leather',
                'sku' => 'REE-CL-001',
                'brand_name' => 'Reebok',
                'category' => 'niño',
                'price' => 65.00,
                'image_url' => 'https://cdn-images.farfetch-contents.com/22/25/09/40/22250940_52584596_1000.jpg',
                'sizes' => ['29', '30', '31', '32', '33', '34', '35', '36', '37'],
                'color' => 'Blanco',
                'description' => 'Reebok Classic Leather para niños. Comodidad, durabilidad y diseño atemporal para los pequeños.',
            ],
            [
                'name' => 'Reebok Club C 85',
                'sku' => 'REE-CC-001',
                'brand_name' => 'Reebok',
                'category' => 'hombre',
                'price' => 85.00,
                'image_url' => 'https://cdn-images.farfetch-contents.com/23/10/69/09/23106909_53297455_600.jpg',
                'sizes' => ['36', '37', '38', '39', '40', '41', '42', '43', '44', '45'],
                'color' => 'Blanco/Gris',
                'description' => 'Reebok Club C 85 vintage. Elegancia retro con tecnología de amortiguación moderna. Perfecto para cualquier estación.',
            ],

            // Saucony
            [
                'name' => 'Saucony Jazz Original',
                'sku' => 'SAU-JAZ-001',
                'brand_name' => 'Saucony',
                'category' => 'unisex',
                'price' => 75.00,
                'image_url' => 'https://cdn.deporvillage.com/cdn-cgi/image/h=960,w=768,dpr=1,f=auto,q=75,fit=contain,background=white/product-vertical/sy-s2044-715_001.jpg',
                'sizes' => ['36', '37', '38', '39', '40', '41', '42', '43', '44', '45'],
                'color' => 'Gris/Azul',
                'description' => 'Saucony Jazz Original: ligereza y estilo para el día a día. Clásico de los 80s que sigue siendo relevante.',
            ],

            // Asics
            [
                'name' => 'Asics Gel-Lyte III',
                'sku' => 'ASC-GL3-001',
                'brand_name' => 'Asics',
                'category' => 'hombre',
                'price' => 115.00,
                'image_url' => 'https://images.asics.com/is/image/asics/1191A266_101_SR_RT_GLB?$sfcc-product$',
                'sizes' => ['36', '37', '38', '39', '40', '41', '42', '43', '44'],
                'color' => 'Blanco/Negro/Azul',
                'description' => 'Asics Gel-Lyte III pionero. Diseño split-tongue único. Tecnología gel para máximo confort en cada zancada.',
            ],
        ];

        // Crear todas las zapatillas vinculadas con brand_id
        foreach ($sneakers as $sneaker) {
            $brandName = $sneaker['brand_name'];
            unset($sneaker['brand_name']);

            $brand = Brand::where('name', $brandName)->first();
            if ($brand) {
                $sneaker['brand_id'] = $brand->id;
                Sneaker::create($sneaker);
            }
        }
    }
}

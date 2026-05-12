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
                'color_es' => 'Rojo/Negro/Blanco',
                'color_en' => 'Red/Black/White',
                'description_es' => 'Las legendarias Air Jordan 1 Retro High. Un clásico de la NBA que definió una era. Comodidad y estilo inconfundible en cada paso.',
                'description_en' => 'The legendary Air Jordan 1 Retro High. An NBA classic that defined an era. Unmistakable comfort and style in every step.',
            ],
            [
                'name' => 'Nike Air Force 1 Premium',
                'sku' => 'NAF-001',
                'brand_name' => 'Nike',
                'category' => 'unisex',
                'price' => 110.00,
                'image_url' => 'https://static.nike.com/a/images/t_web_pdp_936_v2/f_auto,u_9ddf04c7-2a9a-4d76-add1-d15af8f0263d,c_scale,fl_relative,w_1.0,h_1.0,fl_layer_apply/2f25c092-5175-4e14-b7e2-115dd73138cd/AIR+FORCE+1+%2707+PRM.png',
                'sizes' => ['36', '37', '38', '39', '40', '41', '42', '43', '44', '45', '46'],
                'color_es' => 'Blanco/Plateado',
                'color_en' => 'White/Silver',
                'description_es' => 'El Air Force 1 es un icono del sneaker culture. Versátil, duradero y perfecto para cualquier ocasión. Imprescindible en tu colección.',
                'description_en' => 'The Air Force 1 is an icon of sneaker culture. Versatile, durable and perfect for any occasion. Essential in your collection.',
            ],
            [
                'name' => 'Nike Air Max 90 OG',
                'sku' => 'NAM90-001',
                'brand_name' => 'Nike',
                'category' => 'hombre',
                'price' => 135.00,
                'image_url' => 'https://cdn.shopify.com/s/files/1/2358/2817/products/air-max-90-og-volt-293380.png?v=1638813413',
                'sizes' => ['36', '37', '38', '39', '40', '41', '42', '43', '44', '45'],
                'color_es' => 'Blanco/Negro/Rojo',
                'color_en' => 'White/Black/Red',
                'description_es' => 'El Air Max 90 con su clásico Air Cushioning. Comodidad excepcional y diseño atemporal que ha perdurado décadas.',
                'description_en' => 'The Air Max 90 with its classic Air Cushioning. Exceptional comfort and timeless design that has lasted decades.',
            ],
            [
                'name' => 'Nike Blazer Mid 77',
                'sku' => 'NBZ-MID-001',
                'brand_name' => 'Nike',
                'category' => 'mujer',
                'price' => 105.00,
                'image_url' => 'https://limitedresell.com/4864-full_default/nike-blazer-mid-77-next-nature-white-black.jpg',
                'sizes' => ['35', '36', '37', '38', '39', '40', '41'],
                'color_es' => 'Blanco/Gris',
                'color_en' => 'White/Grey',
                'description_es' => 'Nike Blazer Mid 77 vintage. Un diseño retro con toque moderno. Perfecto para un look casual y elegante.',
                'description_en' => 'Nike Blazer Mid 77 vintage. A retro design with a modern touch. Perfect for a casual and elegant look.',
            ],
            [
                'name' => 'Nike SB Dunk Low Pro',
                'sku' => 'NSB-DL-001',
                'brand_name' => 'Nike',
                'category' => 'hombre',
                'price' => 125.00,
                'image_url' => 'https://static.nike.com/a/images/t_web_pdp_936_v2/f_auto,u_9ddf04c7-2a9a-4d76-add1-d15af8f0263d,c_scale,fl_relative,w_1.0,h_1.0,fl_layer_apply/d3087a3d-e6aa-4a22-88a1-764a0f0a58b8/NIKE+SB+DUNK+LOW+PRO.png',
                'sizes' => ['37', '38', '39', '40', '41', '42', '43', '44', '45'],
                'color_es' => 'Negro/Blanco',
                'color_en' => 'Black/White',
                'description_es' => 'Nike SB Dunk Low Pro para skateboarding. Tecnología Pro para mayor soporte y durabilidad en tabla.',
                'description_en' => 'Nike SB Dunk Low Pro for skateboarding. Pro technology for greater support and durability on the board.',
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
                'color_es' => 'Blanco/Verde',
                'color_en' => 'White/Green',
                'description_es' => 'El legendario Adidas Stan Smith. Diseñado en 1972, sigue siendo un clásico imprescindible de la moda.',
                'description_en' => 'The legendary Adidas Stan Smith. Designed in 1972, it remains an essential fashion classic.',
            ],
            [
                'name' => 'Adidas Ultraboost 21',
                'sku' => 'ADS-UB21-001',
                'brand_name' => 'Adidas',
                'category' => 'hombre',
                'price' => 180.00,
                'image_url' => 'https://www.runningxpert.com/media/catalog/product/cache/e1bfa30f5f000aa573b2ee969a7a0fde/f/y/fy0402_ftw_photo_side-lateral-center_white_1.jpg',
                'sizes' => ['35', '36', '37', '38', '39', '40', '41', '42', '43', '44'],
                'color_es' => 'Negro/Gris',
                'color_en' => 'Black/Grey',
                'description_es' => 'Adidas Ultraboost 21 con máxima amortiguación Boost. La mejor opción para correr con comodidad extrema.',
                'description_en' => 'Adidas Ultraboost 21 with maximum Boost cushioning. The best option for running with extreme comfort.',
            ],
            [
                'name' => 'Adidas Superstar OG',
                'sku' => 'ADS-SSO-001',
                'brand_name' => 'Adidas',
                'category' => 'unisex',
                'price' => 100.00,
                'image_url' => 'https://assets.adidas.com/images/w_600,f_auto,q_auto/a70831f36a424a20892e69ab599156ba_9366/Zapatilla_Superstar_Vintage_Blanco_JQ3254_01_00_standard.jpg',
                'sizes' => ['35', '36', '37', '38', '39', '40', '41', '42', '43', '44', '45'],
                'color_es' => 'Blanco/Negro',
                'color_en' => 'White/Black',
                'description_es' => 'Adidas Superstar clásico con su inconfundible punta de goma. Un ícono que trasciende generaciones.',
                'description_en' => 'Classic Adidas Superstar with its distinctive rubber toe. An icon that transcends generations.',
            ],
            [
                'name' => 'Adidas NMD R1',
                'sku' => 'ADS-NMD-001',
                'brand_name' => 'Adidas',
                'category' => 'niño',
                'price' => 85.00,
                'image_url' => 'https://img01.ztat.net/article/spp-media-p1/ecefa492d69541b7a66b11a08e210f39/37a41ae1387d4f2e8db09e8e37e3d28b.jpg?imwidth=1800&filter=packshot',
                'sizes' => ['30', '31', '32', '33', '34', '35', '36', '37', '38'],
                'color_es' => 'Blanco/Rojo',
                'color_en' => 'White/Red',
                'description_es' => 'Adidas NMD R1 para pequeños con diseño moderno. Comodidad y estilo para el día a día.',
                'description_en' => 'Adidas NMD R1 for kids with modern design. Comfort and style for everyday wear.',
            ],

            // Converse
            [
                'name' => 'Converse Chuck Taylor All Star High',
                'sku' => 'CON-CTA-HI',
                'brand_name' => 'Converse',
                'category' => 'unisex',
                'price' => 75.00,
                'image_url' => 'https://m.media-amazon.com/images/I/716Ju-Nv07L._AC_UY900_.jpg',
                'sizes' => ['35', '36', '37', '38', '39', '40', '41', '42', '43', '44', '45', '46'],
                'color_es' => 'Negro',
                'color_en' => 'Black',
                'description_es' => 'Las icónicas Converse Chuck Taylor All Star. Un clásico que nunca falla, perfeccionadas a través del tiempo.',
                'description_en' => 'The iconic Converse Chuck Taylor All Stars. A classic that never fails, perfected over time.',
            ],
            [
                'name' => 'Converse Chuck Taylor White',
                'sku' => 'CON-CTA-WH',
                'brand_name' => 'Converse',
                'category' => 'unisex',
                'price' => 75.00,
                'image_url' => 'https://www.thestreets.es/media/catalog/product/cache/2b5c0c30ec592b2d661598663b3592ba/8/f/8f86e6b92b6a1d630392bb9be45779f48eacc5c5_enkqyv58whgrgjuv.jpg',
                'sizes' => ['35', '36', '37', '38', '39', '40', '41', '42', '43', '44', '45', '46'],
                'color_es' => 'Blanco',
                'color_en' => 'White',
                'description_es' => 'Converse Chuck Taylor en blanco puro. Versátil y combinable con cualquier outfit. La base de cualquier guardarropa sneaker.',
                'description_en' => 'Converse Chuck Taylor in pure white. Versatile and matchable with any outfit. The foundation of any sneaker wardrobe.',
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
                'color_es' => 'Blanco/Rojo',
                'color_en' => 'White/Red',
                'description_es' => 'Puma RS-X fusion: estilo retro 90s con tecnología moderna. Diseño revolucionario y comodidad inigualable.',
                'description_en' => 'Puma RS-X fusion: retro 90s style with modern technology. Revolutionary design and unmatched comfort.',
            ],
            [
                'name' => 'Puma Suede Classic',
                'sku' => 'PMA-SUE-001',
                'brand_name' => 'Puma',
                'category' => 'mujer',
                'price' => 80.00,
                'image_url' => 'https://images.puma.com/image/upload/f_auto,q_auto,b_rgb:fafafa,w_2000,h_2000/global/399781/01/sv01/fnd/EEA/fmt/png/Zapatillas-Suede-Classic-unisex',
                'sizes' => ['35', '36', '37', '38', '39', '40', '41', '42'],
                'color_es' => 'Rosa/Blanco',
                'color_en' => 'Pink/White',
                'description_es' => 'Puma Suede Classic con material premium. Diseño elegante y contemporáneo para cualquier ocasión casual.',
                'description_en' => 'Puma Suede Classic with premium material. Elegant and contemporary design for any casual occasion.',
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
                'color_es' => 'Negro/Blanco',
                'color_en' => 'Black/White',
                'description_es' => 'Las legendarias Vans Old Skool con su icónica franja lateral. Símbolo de la contracultura del skate.',
                'description_en' => 'The legendary Vans Old Skool with its iconic side stripe. Symbol of skate counterculture.',
            ],
            [
                'name' => 'Vans Slip-On',
                'sku' => 'VAN-SO-001',
                'brand_name' => 'Vans',
                'category' => 'unisex',
                'price' => 65.00,
                'image_url' => 'https://static.ftshp.digital/img/p/1/1/8/2/1/9/3/1182193-full_product.jpg',
                'sizes' => ['35', '36', '37', '38', '39', '40', '41', '42', '43', '44', '45'],
                'color_es' => 'Estampado Damier',
                'color_en' => 'Checkered Pattern',
                'description_es' => 'Vans Slip-On sin cordones. Comodidad y estilo en un solo paso. Perfecta para ir al skatepark o paseo casual.',
                'description_en' => 'Vans Slip-On without laces. Comfort and style in one step. Perfect for the skatepark or casual stroll.',
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
                'color_es' => 'Gris/Blanco',
                'color_en' => 'Grey/White',
                'description_es' => 'New Balance 574, el modelo más vendido de todos los tiempos. Comodidad garantizada y diseño clásico.',
                'description_en' => 'New Balance 574, the best-selling model of all time. Guaranteed comfort and classic design.',
            ],
            [
                'name' => 'New Balance 990v6',
                'sku' => 'NB-990-001',
                'brand_name' => 'New Balance',
                'category' => 'mujer',
                'price' => 185.00,
                'image_url' => 'https://owp.klarna.com/product/640x640/3007084349/New-Balance-990v6-M-Grey.jpg?ph=true',
                'sizes' => ['36', '37', '38', '39', '40', '41'],
                'color_es' => 'Beige/Negro',
                'color_en' => 'Beige/Black',
                'description_es' => 'New Balance 990v6, el buque insignia. Fabricación premium hecha en USA. Garantía de calidad y durabilidad.',
                'description_en' => 'New Balance 990v6, the flagship. Premium manufacturing made in USA. Quality and durability guaranteed.',
            ],

            // Reebok
            [
                'name' => 'Reebok Classic Leather',
                'sku' => 'REE-CL-001',
                'brand_name' => 'Reebok',
                'category' => 'niño',
                'price' => 65.00,
                'image_url' => 'https://cdn.blazimg.com/1800/product/r/e/reebok-classics_2267_1_footwear_photography_side_lateral_center_view_white_000.webp',
                'sizes' => ['29', '30', '31', '32', '33', '34', '35', '36', '37'],
                'color_es' => 'Blanco',
                'color_en' => 'White',
                'description_es' => 'Reebok Classic Leather para niños. Comodidad, durabilidad y diseño atemporal para los pequeños.',
                'description_en' => 'Reebok Classic Leather for kids. Comfort, durability and timeless design for the little ones.',
            ],
            [
                'name' => 'Reebok Club C 85',
                'sku' => 'REE-CC-001',
                'brand_name' => 'Reebok',
                'category' => 'hombre',
                'price' => 85.00,
                'image_url' => 'https://www.reebok.eu/cdn/shop/files/JPG-100007797_SLC_eCom_grande.jpg?v=1756828973',
                'sizes' => ['36', '37', '38', '39', '40', '41', '42', '43', '44', '45'],
                'color_es' => 'Blanco/Gris',
                'color_en' => 'White/Grey',
                'description_es' => 'Reebok Club C 85 vintage. Elegancia retro con tecnología de amortiguación moderna. Perfecto para cualquier estación.',
                'description_en' => 'Reebok Club C 85 vintage. Retro elegance with modern cushioning technology. Perfect for any season.',
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
                'color_es' => 'Gris/Azul',
                'color_en' => 'Grey/Blue',
                'description_es' => 'Saucony Jazz Original: ligereza y estilo para el día a día. Clásico de los 80s que sigue siendo relevante.',
                'description_en' => 'Saucony Jazz Original: lightness and style for everyday wear. An 80s classic that remains relevant.',
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
                'color_es' => 'Blanco/Negro/Azul',
                'color_en' => 'White/Black/Blue',
                'description_es' => 'Asics Gel-Lyte III pionero. Diseño split-tongue único. Tecnología gel para máximo confort en cada zancada.',
                'description_en' => 'Pioneer Asics Gel-Lyte III. Unique split-tongue design. Gel technology for maximum comfort in every stride.',
            ],
        ];

        // Crear todas las zapatillas vinculadas con brand_id
        foreach ($sneakers as $data) {
            // Buscamos el ID de la marca por su nombre
            $brand = Brand::where('name', $data['brand_name'])->first();

            // Usamos updateOrCreate para evitar el error de Duplicate Entry
            Sneaker::updateOrCreate(
                ['sku' => $data['sku']], // Condición para buscar (el SKU debe ser único)
                [
                    'name' => $data['name'],
                    'category' => $data['category'],
                    'price' => $data['price'],
                    'image_url' => $data['image_url'],
                    'sizes' => $data['sizes'],
                    'color_es' => $data['color_es'] ?? $data['color'],
                    'color_en' => $data['color_en'] ?? $data['color'],
                    'description_es' => $data['description_es'] ?? $data['description'],
                    'description_en' => $data['description_en'] ?? $data['description'],
                    'brand_id' => $brand ? $brand->id : null, // Asignamos el ID de la marca
                ]
            );
        }
    }
}

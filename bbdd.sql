-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Servidor: db-zapatillas
-- Tiempo de generación: 21-04-2026 a las 15:54:31
-- Versión del servidor: 8.0.45
-- Versión de PHP: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

START TRANSACTION;

SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */
;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */
;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */
;
/*!40101 SET NAMES utf8mb4 */
;

--
-- Base de datos: `zapatillas_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `brands`
--

CREATE TABLE `brands` (
    `id` bigint UNSIGNED NOT NULL,
    `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `description` text COLLATE utf8mb4_unicode_ci,
    `logo_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `brands`
--

INSERT INTO
    `brands` (
        `id`,
        `name`,
        `description`,
        `logo_url`,
        `created_at`,
        `updated_at`
    )
VALUES (
        1,
        'Nike',
        'La marca número uno en innovación y diseño de zapatillas deportivas.',
        'https://upload.wikimedia.org/wikipedia/commons/3/36/Logo_nike_principal.jpg',
        '2026-04-17 11:31:18',
        '2026-04-17 11:31:18'
    ),
    (
        2,
        'Adidas',
        'Excelencia en rendimiento y estilo desde 1949.',
        'https://cdn-icons-png.flaticon.com/512/731/731962.png',
        '2026-04-17 11:31:18',
        '2026-04-17 11:31:18'
    ),
    (
        3,
        'Converse',
        'Los clásicos icónicos de la cultura urbana.',
        'https://brandemia.org/sites/default/files/inline/images/412d6658825261.5a0afaafa77fb.jpg',
        '2026-04-17 11:31:18',
        '2026-04-17 11:31:18'
    ),
    (
        4,
        'Puma',
        'Diseño retro con tecnología moderna.',
        'https://caphunters.bg/img/m/171.jpg',
        '2026-04-17 11:31:18',
        '2026-04-17 11:31:18'
    ),
    (
        5,
        'Vans',
        'La marca preferida de los skaters desde los 70s.',
        'https://i.ebayimg.com/images/g/t24AAOSwLu1kBlu4/s-l400.jpg',
        '2026-04-17 11:31:18',
        '2026-04-17 11:31:18'
    ),
    (
        6,
        'New Balance',
        'Comodidad y calidad sin compromisos.',
        'https://upload.wikimedia.org/wikipedia/commons/thumb/e/ea/New_Balance_logo.svg/3840px-New_Balance_logo.svg.png',
        '2026-04-17 11:31:18',
        '2026-04-17 11:31:18'
    ),
    (
        7,
        'Reebok',
        'Rendimiento y versatilidad para todos.',
        'https://upload.wikimedia.org/wikipedia/commons/thumb/5/53/Reebok_2019_logo.svg/1280px-Reebok_2019_logo.svg.png',
        '2026-04-17 11:31:18',
        '2026-04-17 11:31:18'
    ),
    (
        9,
        'Asics',
        'Tecnología japonesa para el confort máximo.',
        'https://upload.wikimedia.org/wikipedia/commons/thumb/b/b1/Asics_Logo.svg/1280px-Asics_Logo.svg.png',
        '2026-04-17 11:31:18',
        '2026-04-17 11:31:18'
    ),
    (
        18,
        'Saucony',
        'Innovación en zapatillas para correr.',
        'https://atlasstoked.com/img/cms/blog/imported/saucony-1024x310.jpg',
        '2026-04-18 07:59:04',
        '2026-04-18 07:59:04'
    );

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favorites`
--

CREATE TABLE `favorites` (
    `id` bigint UNSIGNED NOT NULL,
    `user_id` bigint UNSIGNED NOT NULL,
    `sneaker_id` bigint UNSIGNED NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `favorites`
--

INSERT INTO
    `favorites` (
        `id`,
        `user_id`,
        `sneaker_id`,
        `created_at`,
        `updated_at`
    )
VALUES (
        3,
        1,
        12,
        '2026-04-20 15:55:16',
        '2026-04-20 15:55:16'
    ),
    (
        6,
        1,
        21,
        '2026-04-20 15:56:39',
        '2026-04-20 15:56:39'
    ),
    (
        8,
        1,
        19,
        '2026-04-20 15:56:44',
        '2026-04-20 15:56:44'
    ),
    (
        9,
        1,
        11,
        '2026-04-20 15:56:48',
        '2026-04-20 15:56:48'
    ),
    (
        11,
        1,
        6,
        '2026-04-20 15:57:27',
        '2026-04-20 15:57:27'
    ),
    (
        12,
        1,
        7,
        '2026-04-20 15:57:28',
        '2026-04-20 15:57:28'
    ),
    (
        14,
        1,
        8,
        '2026-04-20 15:57:31',
        '2026-04-20 15:57:31'
    ),
    (
        16,
        1,
        10,
        '2026-04-20 15:57:35',
        '2026-04-20 15:57:35'
    ),
    (
        17,
        1,
        13,
        '2026-04-20 15:57:37',
        '2026-04-20 15:57:37'
    ),
    (
        18,
        1,
        14,
        '2026-04-20 15:57:40',
        '2026-04-20 15:57:40'
    ),
    (
        19,
        1,
        15,
        '2026-04-20 15:57:42',
        '2026-04-20 15:57:42'
    ),
    (
        20,
        1,
        16,
        '2026-04-20 15:57:44',
        '2026-04-20 15:57:44'
    ),
    (
        21,
        1,
        2,
        '2026-04-20 16:03:15',
        '2026-04-20 16:03:15'
    ),
    (
        23,
        1,
        9,
        '2026-04-20 16:06:30',
        '2026-04-20 16:06:30'
    ),
    (
        24,
        1,
        18,
        '2026-04-20 16:06:33',
        '2026-04-20 16:06:33'
    ),
    (
        25,
        1,
        17,
        '2026-04-20 16:06:33',
        '2026-04-20 16:06:33'
    ),
    (
        29,
        1,
        3,
        '2026-04-21 09:56:08',
        '2026-04-21 09:56:08'
    ),
    (
        30,
        1,
        4,
        '2026-04-21 09:56:09',
        '2026-04-21 09:56:09'
    );

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sneakers`
--

CREATE TABLE `sneakers` (
    `id` bigint UNSIGNED NOT NULL,
    `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `sku` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `brand` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `category` enum(
        'hombre',
        'mujer',
        'niño',
        'unisex'
    ) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unisex',
    `price` decimal(10, 2) NOT NULL,
    `image_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `sizes` json DEFAULT NULL,
    `color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `description` text COLLATE utf8mb4_unicode_ci,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    `brand_id` bigint UNSIGNED DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sneakers`
--

INSERT INTO
    `sneakers` (
        `id`,
        `name`,
        `sku`,
        `brand`,
        `category`,
        `price`,
        `image_url`,
        `sizes`,
        `color`,
        `description`,
        `created_at`,
        `updated_at`,
        `brand_id`
    )
VALUES (
        2,
        'Nike Air Force 1 Premium',
        'NAF-001',
        NULL,
        'unisex',
        110.00,
        'https://static.nike.com/a/images/t_web_pdp_936_v2/f_auto,u_9ddf04c7-2a9a-4d76-add1-d15af8f0263d,c_scale,fl_relative,w_1.0,h_1.0,fl_layer_apply/2f25c092-5175-4e14-b7e2-115dd73138cd/AIR+FORCE+1+%2707+PRM.png',
        '[\"36\", \"37\", \"38\", \"39\", \"40\", \"41\", \"42\", \"43\", \"44\", \"45\", \"46\"]',
        'Blanco/Plateado',
        'El Air Force 1 es un icono del sneaker culture. Versátil, duradero y perfecto para cualquier ocasión. Imprescindible en tu colección.',
        '2026-04-17 11:31:18',
        '2026-04-17 11:31:18',
        1
    ),
    (
        3,
        'Nike Air Max 90 OG',
        'NAM90-001',
        NULL,
        'hombre',
        135.00,
        'https://cdn-images.farfetch-contents.com/16/07/06/97/16070697_30563905_1000.jpg',
        '[\"36\", \"37\", \"38\", \"39\", \"40\", \"41\", \"42\", \"43\", \"44\", \"45\"]',
        'Blanco/Negro/Rojo',
        'El Air Max 90 con su clásico Air Cushioning. Comodidad excepcional y diseño atemporal que ha perdurado décadas.',
        '2026-04-17 11:31:18',
        '2026-04-17 11:31:18',
        1
    ),
    (
        4,
        'Nike Blazer Mid 77',
        'NBZ-MID-001',
        NULL,
        'mujer',
        105.00,
        'https://cdn.media.amplience.net/i/frasersdev/27435030_o_a1.jpg?v=20240417082012',
        '[\"35\", \"36\", \"37\", \"38\", \"39\", \"40\", \"41\"]',
        'Blanco/Gris',
        'Nike Blazer Mid 77 vintage. Un diseño retro con toque moderno. Perfecto para un look casual y elegante.',
        '2026-04-17 11:31:18',
        '2026-04-17 11:31:18',
        1
    ),
    (
        5,
        'Nike SB Dunk Low Pro',
        'NSB-DL-001',
        NULL,
        'hombre',
        125.00,
        'https://static.nike.com/a/images/t_web_pdp_936_v2/f_auto,u_9ddf04c7-2a9a-4d76-add1-d15af8f0263d,c_scale,fl_relative,w_1.0,h_1.0,fl_layer_apply/d3087a3d-e6aa-4a22-88a1-764a0f0a58b8/NIKE+SB+DUNK+LOW+PRO.png',
        '[\"37\", \"38\", \"39\", \"40\", \"41\", \"42\", \"43\", \"44\", \"45\"]',
        'Negro/Blanco',
        'Nike SB Dunk Low Pro para skateboarding. Tecnología Pro para mayor soporte y durabilidad en tabla.',
        '2026-04-17 11:31:18',
        '2026-04-17 11:31:18',
        1
    ),
    (
        6,
        'Adidas Stan Smith',
        'ADS-SS-001',
        NULL,
        'mujer',
        95.00,
        'https://assets.adidas.com/images/w_600,f_auto,q_auto/69721f2e7c934d909168a80e00818569_9366/Zapatilla_Stan_Smith_Blanco_M20324_01_standard.jpg',
        '[\"35\", \"36\", \"37\", \"38\", \"39\", \"40\", \"41\", \"42\"]',
        'Blanco/Verde',
        'El legendario Adidas Stan Smith. Diseñado en 1972, sigue siendo un clásico imprescindible de la moda.',
        '2026-04-17 11:31:18',
        '2026-04-17 11:31:18',
        2
    ),
    (
        7,
        'Adidas Ultraboost 21',
        'ADS-UB21-001',
        NULL,
        'hombre',
        180.00,
        'https://www.runningxpert.com/media/catalog/product/cache/e1bfa30f5f000aa573b2ee969a7a0fde/f/y/fy0402_ftw_photo_side-lateral-center_white_1.jpg',
        '[\"35\", \"36\", \"37\", \"38\", \"39\", \"40\", \"41\", \"42\", \"43\", \"44\"]',
        'Negro/Gris',
        'Adidas Ultraboost 21 con máxima amortiguación Boost. La mejor opción para correr con comodidad extrema.',
        '2026-04-17 11:31:18',
        '2026-04-17 11:31:18',
        2
    ),
    (
        8,
        'Adidas Superstar OG',
        'ADS-SSO-001',
        NULL,
        'unisex',
        100.00,
        'https://assets.adidas.com/images/w_600,f_auto,q_auto/a70831f36a424a20892e69ab599156ba_9366/Zapatilla_Superstar_Vintage_Blanco_JQ3254_01_00_standard.jpg',
        '[\"35\", \"36\", \"37\", \"38\", \"39\", \"40\", \"41\", \"42\", \"43\", \"44\", \"45\"]',
        'Blanco/Negro',
        'Adidas Superstar clásico con su inconfundible punta de goma. Un ícono que trasciende generaciones.',
        '2026-04-17 11:31:18',
        '2026-04-17 11:31:18',
        2
    ),
    (
        9,
        'Adidas NMD R1',
        'ADS-NMD-001',
        NULL,
        'niño',
        85.00,
        'https://img01.ztat.net/article/spp-media-p1/ecefa492d69541b7a66b11a08e210f39/37a41ae1387d4f2e8db09e8e37e3d28b.jpg?imwidth=1800&filter=packshot',
        '[\"30\", \"31\", \"32\", \"33\", \"34\", \"35\", \"36\", \"37\", \"38\"]',
        'Blanco/Rojo',
        'Adidas NMD R1 para pequeños con diseño moderno. Comodidad y estilo para el día a día.',
        '2026-04-17 11:31:18',
        '2026-04-17 11:31:18',
        2
    ),
    (
        10,
        'Converse Chuck Taylor All Star High',
        'CON-CTA-HI',
        NULL,
        'unisex',
        75.00,
        'https://cdn.laredoute.com/cdn-cgi/image/width=500,height=500,fit=pad,dpr=1/products/1/3/b/13bc6c009807cd02e986b932aae58a61.jpg',
        '[\"35\", \"36\", \"37\", \"38\", \"39\", \"40\", \"41\", \"42\", \"43\", \"44\", \"45\", \"46\"]',
        'Negro',
        'Las icónicas Converse Chuck Taylor All Star. Un clásico que nunca falla, perfeccionadas a través del tiempo.',
        '2026-04-17 11:31:18',
        '2026-04-17 11:31:18',
        3
    ),
    (
        11,
        'Converse Chuck Taylor White',
        'CON-CTA-WH',
        NULL,
        'unisex',
        75.00,
        'https://www.thestreets.es/media/catalog/product/cache/2b5c0c30ec592b2d661598663b3592ba/8/f/8f86e6b92b6a1d630392bb9be45779f48eacc5c5_enkqyv58whgrgjuv.jpg',
        '[\"35\", \"36\", \"37\", \"38\", \"39\", \"40\", \"41\", \"42\", \"43\", \"44\", \"45\", \"46\"]',
        'Blanco',
        'Converse Chuck Taylor en blanco puro. Versátil y combinable con cualquier outfit. La base de cualquier guardarropa sneaker.',
        '2026-04-17 11:31:18',
        '2026-04-17 11:31:18',
        3
    ),
    (
        12,
        'Puma RS-X',
        'PMA-RSX-001',
        NULL,
        'hombre',
        95.00,
        'https://img01.ztat.net/article/spp-media-p1/44808b57bb5b4b7b83a08f4d89d5f60e/7f333c7af216419cb368ea7f2312464a.jpg?imwidth=1800&filter=packshot',
        '[\"36\", \"37\", \"38\", \"39\", \"40\", \"41\", \"42\", \"43\", \"44\", \"45\"]',
        'Blanco/Rojo',
        'Puma RS-X fusion: estilo retro 90s con tecnología moderna. Diseño revolucionario y comodidad inigualable.',
        '2026-04-17 11:31:18',
        '2026-04-17 11:31:18',
        4
    ),
    (
        13,
        'Puma Suede Classic',
        'PMA-SUE-001',
        NULL,
        'mujer',
        80.00,
        'https://images.puma.com/image/upload/f_auto,q_auto,b_rgb:fafafa,w_2000,h_2000/global/399781/01/sv01/fnd/EEA/fmt/png/Zapatillas-Suede-Classic-unisex',
        '[\"35\", \"36\", \"37\", \"38\", \"39\", \"40\", \"41\", \"42\"]',
        'Rosa/Blanco',
        'Puma Suede Classic con material premium. Diseño elegante y contemporáneo para cualquier ocasión casual.',
        '2026-04-17 11:31:18',
        '2026-04-17 11:31:18',
        4
    ),
    (
        14,
        'Vans Old Skool',
        'VAN-OS-001',
        NULL,
        'hombre',
        75.00,
        'https://welcomesk8.com/cdn/shop/products/vans-skate-old-skool-black-01_1200x1200.jpg?v=1623854588',
        '[\"36\", \"37\", \"38\", \"39\", \"40\", \"41\", \"42\", \"43\", \"44\", \"45\", \"46\"]',
        'Negro/Blanco',
        'Las legendarias Vans Old Skool con su icónica franja lateral. Símbolo de la contracultura del skate.',
        '2026-04-17 11:31:18',
        '2026-04-17 11:31:18',
        5
    ),
    (
        15,
        'Vans Slip-On',
        'VAN-SO-001',
        NULL,
        'unisex',
        65.00,
        'https://static.ftshp.digital/img/p/1/1/8/2/1/9/3/1182193-full_product.jpg',
        '[\"35\", \"36\", \"37\", \"38\", \"39\", \"40\", \"41\", \"42\", \"43\", \"44\", \"45\"]',
        'Estampado Damier',
        'Vans Slip-On sin cordones. Comodidad y estilo en un solo paso. Perfecta para ir al skatepark o paseo casual.',
        '2026-04-17 11:31:18',
        '2026-04-17 11:31:18',
        5
    ),
    (
        16,
        'New Balance 574',
        'NB-574-001',
        NULL,
        'hombre',
        110.00,
        'https://nb.scene7.com/is/image/NB/ml574evn_nb_02_i?$pdpflexf2$&wid=440&hei=440',
        '[\"36\", \"37\", \"38\", \"39\", \"40\", \"41\", \"42\", \"43\", \"44\", \"45\"]',
        'Gris/Blanco',
        'New Balance 574, el modelo más vendido de todos los tiempos. Comodidad garantizada y diseño clásico.',
        '2026-04-17 11:31:18',
        '2026-04-17 11:31:18',
        6
    ),
    (
        17,
        'New Balance 990v6',
        'NB-990-001',
        NULL,
        'mujer',
        185.00,
        'https://cdn-images.farfetch-contents.com/20/46/66/89/20466689_50365634_600.jpg',
        '[\"36\", \"37\", \"38\", \"39\", \"40\", \"41\"]',
        'Beige/Negro',
        'New Balance 990v6, el buque insignia. Fabricación premium hecha en USA. Garantía de calidad y durabilidad.',
        '2026-04-17 11:31:18',
        '2026-04-17 11:31:18',
        6
    ),
    (
        18,
        'Reebok Classic Leather',
        'REE-CL-001',
        NULL,
        'niño',
        65.00,
        'https://cdn-images.farfetch-contents.com/22/25/09/40/22250940_52584596_1000.jpg',
        '[\"29\", \"30\", \"31\", \"32\", \"33\", \"34\", \"35\", \"36\", \"37\"]',
        'Blanco',
        'Reebok Classic Leather para niños. Comodidad, durabilidad y diseño atemporal para los pequeños.',
        '2026-04-17 11:31:18',
        '2026-04-17 11:31:18',
        7
    ),
    (
        19,
        'Reebok Club C 85',
        'REE-CC-001',
        NULL,
        'hombre',
        85.00,
        'https://cdn-images.farfetch-contents.com/23/10/69/09/23106909_53297455_600.jpg',
        '[\"36\", \"37\", \"38\", \"39\", \"40\", \"41\", \"42\", \"43\", \"44\", \"45\"]',
        'Blanco/Gris',
        'Reebok Club C 85 vintage. Elegancia retro con tecnología de amortiguación moderna. Perfecto para cualquier estación.',
        '2026-04-17 11:31:18',
        '2026-04-17 11:31:18',
        7
    ),
    (
        21,
        'Asics Gel-Lyte III',
        'ASC-GL3-001',
        NULL,
        'hombre',
        115.00,
        'https://images.asics.com/is/image/asics/1191A266_101_SR_RT_GLB?$sfcc-product$',
        '[\"36\", \"37\", \"38\", \"39\", \"40\", \"41\", \"42\", \"43\", \"44\"]',
        'Blanco/Negro/Azul',
        'Asics Gel-Lyte III pionero. Diseño split-tongue único. Tecnología gel para máximo confort en cada zancada.',
        '2026-04-17 11:31:18',
        '2026-04-17 11:31:18',
        9
    ),
    (
        22,
        'Nike Air Jordan 1 Retro High OG',
        'AJ1-RET-001',
        NULL,
        'hombre',
        170.00,
        'https://cdn-images.farfetch-contents.com/12/96/03/49/12960349_13486594_600.jpg',
        '[\"36\", \"37\", \"38\", \"39\", \"40\", \"41\", \"42\", \"43\", \"44\", \"45\", \"46\"]',
        'Rojo/Negro/Blanco',
        'Las legendarias Air Jordan 1 Retro High. Un clásico de la NBA que definió una era. Comodidad y estilo inconfundible en cada paso.',
        '2026-04-18 07:59:05',
        '2026-04-18 07:59:05',
        1
    );

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
    `id` bigint UNSIGNED NOT NULL,
    `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `email_verified_at` timestamp NULL DEFAULT NULL,
    `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    `is_admin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO
    `users` (
        `id`,
        `name`,
        `username`,
        `email`,
        `email_verified_at`,
        `password`,
        `remember_token`,
        `created_at`,
        `updated_at`,
        `is_admin`
    )
VALUES (
        1,
        'admin',
        'admin',
        'infotopsneakerses@gmail.com',
        '2026-04-17 11:31:18',
        '$2y$12$Ue5vxmMGRoXDXjI2ITVGuuk4uWWX6VmBMzL.GGlIgegW8xT9tZ9b.',
        'i5OErX2cd3G8oeTWsCbddy7LuadsVVCyOXdptIjdGBU4RcDLk6gNA9h2gpxa',
        '2026-04-17 11:31:18',
        '2026-04-17 11:31:18',
        1
    );

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `brands`
--
ALTER TABLE `brands`
ADD PRIMARY KEY (`id`),
ADD UNIQUE KEY `brands_name_unique` (`name`);

--
-- Indices de la tabla `favorites`
--
ALTER TABLE `favorites`
ADD PRIMARY KEY (`id`),
ADD UNIQUE KEY `favorites_user_id_sneaker_id_unique` (`user_id`, `sneaker_id`),
ADD KEY `favorites_sneaker_id_foreign` (`sneaker_id`);

--
-- Indices de la tabla `sneakers`
--
ALTER TABLE `sneakers`
ADD PRIMARY KEY (`id`),
ADD UNIQUE KEY `sneakers_sku_unique` (`sku`),
ADD KEY `sneakers_brand_id_foreign` (`brand_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
ADD PRIMARY KEY (`id`),
ADD UNIQUE KEY `users_email_unique` (`email`),
ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `brands`
--
ALTER TABLE `brands`
MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 19;

--
-- AUTO_INCREMENT de la tabla `favorites`
--
ALTER TABLE `favorites`
MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 31;

--
-- AUTO_INCREMENT de la tabla `sneakers`
--
ALTER TABLE `sneakers`
MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 25;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `favorites`
--
ALTER TABLE `favorites`
ADD CONSTRAINT `favorites_sneaker_id_foreign` FOREIGN KEY (`sneaker_id`) REFERENCES `sneakers` (`id`) ON DELETE CASCADE,
ADD CONSTRAINT `favorites_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `sneakers`
--
ALTER TABLE `sneakers`
ADD CONSTRAINT `sneakers_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE SET NULL;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */
;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */
;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */
;
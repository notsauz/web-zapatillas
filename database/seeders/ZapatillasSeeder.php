<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ZapatillasSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        DB::table('marcas')->insert([
            ['nombre' => 'Nike', 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => 'Adidas', 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => 'New Balance', 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => 'Puma', 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => 'Jordan', 'created_at' => $now, 'updated_at' => $now],
        ]);

        DB::table('modelos')->insert([
            ['nombre' => 'Air Force 1', 'marca_id' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => 'Dunk Low', 'marca_id' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => 'Air Max 90', 'marca_id' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => 'Samba', 'marca_id' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => 'Superstar', 'marca_id' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => 'Gazelle', 'marca_id' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => '550', 'marca_id' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => '993', 'marca_id' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => 'Speedcat', 'marca_id' => 4, 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => 'Suede', 'marca_id' => 4, 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => 'Air Jordan 1', 'marca_id' => 5, 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => 'Air Jordan 4', 'marca_id' => 5, 'created_at' => $now, 'updated_at' => $now],
        ]);

        DB::table('zapatillas')->insert([
            [
                'sku' => 'CW2288-111',
                'modelo_id' => 1,
                'nombre' => "Nike Air Force 1 '07 Triple White",
                'precio' => 100.00,
                'imagen_url' => 'https://static.nike.com/a/images/t_web_pdp_936_v2/f_auto,u_9ddf04c7-2a9a-4d76-add1-d15af8f0263d,c_scale,fl_relative,w_1.0,h_1.0,fl_layer_apply/b7d9211c-26e7-431a-ac24-b0540fb3c00f/AIR+FORCE+1+%2707.png',
                'tendencia' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'sku' => 'CW2288-001',
                'modelo_id' => 1,
                'nombre' => "Nike Air Force 1 '07 Triple Black",
                'precio' => 100.00,
                'imagen_url' => 'https://monode-zapas.com/cdn/shop/products/Capturadepantalla2022-05-30alas20.42.13.png?v=1668727628&width=1946',
                'tendencia' => false,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'sku' => '396472-01',
                'modelo_id' => 9,
                'nombre' => 'Puma Speedcat OG Red',
                'precio' => 90.00,
                'imagen_url' => 'https://es.aw-lab.com/dw/image/v2/BJTH_PRD/on/demandware.static/-/Sites-awlab-master-catalog/default/dw85d4da0a/images/large/8035139_0.jpg?sw=1860',
                'tendencia' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
        ]);
    }
}
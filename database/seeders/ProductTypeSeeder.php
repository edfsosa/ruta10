<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $now = Carbon::now();

        $productTypes = [
            ['name' => 'Sobre', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Caja amarilla', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Caja chica', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Caja mediana', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Caja grande', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Caja extra grande', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Atado', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Atado x3', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Bobina', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Bobinita de cables', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Bulto', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Heladera', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Cocina', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Lavarropas', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Secarropas', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Aire acondicionado', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Calefactor', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Estufa', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Termotanque', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Microondas', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Otros', 'created_at' => $now, 'updated_at' => $now],
        ];

        DB::table('product_types')->insert($productTypes);
    }
}

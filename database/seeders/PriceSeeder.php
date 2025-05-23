<?php

namespace Database\Seeders;

use App\Models\ProductType;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        // Precios base por categorías de producto
        $basePrices = [
            'Sobre'             => ['door_to_door' => 10000],
            'Caja'              => ['door_to_door' => 8500],
            'Atado'             => ['door_to_door' => 10000],
            'Bobina'            => ['door_to_door' => 10000],
            'Electrodomésticos' => ['door_to_door' => 25000],
            'Otros'             => ['door_to_door' => 10000],
        ];

        // Lista de ciudades de origen y destino
        $cityIds = [103, 6, 204, 163, 38, 107, 36, 30, 185];
        $serviceType = 'door_to_door';

        // Obtener todos los tipos de producto
        $types = ProductType::pluck('name', 'id');

        $prices = [];

        foreach ($cityIds as $fromCityId) {
            foreach ($cityIds as $toCityId) {
                if ($fromCityId === $toCityId) {
                    continue; // saltar misma ciudad
                }

                foreach ($types as $typeId => $typeName) {
                    // Determinar categoría según el nombre
                    if (Str::contains($typeName, 'Sobre')) {
                        $category = 'Sobre';
                    } elseif (Str::startsWith($typeName, 'Caja')) {
                        $category = 'Caja';
                    } elseif (Str::contains($typeName, 'Atado')) {
                        $category = 'Atado';
                    } elseif (Str::contains($typeName, 'Bobina')) {
                        $category = 'Bobina';
                    } elseif (in_array($typeName, ['Heladera', 'Cocina', 'Lavarropas', 'Secarropas', 'Aire acondicionado', 'Calefactor', 'Estufa', 'Termotanque', 'Microondas'])) {
                        $category = 'Electrodomésticos';
                    } else {
                        $category = 'Otros';
                    }

                    // Obtener precio base door_to_door
                    $priceValue = $basePrices[$category][$serviceType] ?? null;
                    if ($priceValue === null) {
                        continue;
                    }

                    $prices[] = [
                        'from_city_id'    => $fromCityId,
                        'to_city_id'      => $toCityId,
                        'product_type_id' => $typeId,
                        'service_type'    => $serviceType,
                        'price'           => $priceValue,
                        'created_at'      => $now,
                        'updated_at'      => $now,
                    ];
                }
            }
        }

        // Insertar tarifas generadas
        DB::table('prices')->insert($prices);
        $this->command->info('Prices seeded successfully.');
    }
}

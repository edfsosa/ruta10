<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AgencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $agencies = [
            ['name' => 'Agencia Carapeguá', 'address' => 'SN', 'city_id' => 212, 'phone' => '972153857', 'email' => null, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Agencia San Ignacio', 'address' => 'SN', 'city_id' => 185, 'phone' => '971172460', 'email' => null, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Agencia Coronel Bogado', 'address' => 'SN', 'city_id' => 161, 'phone' => '985769658', 'email' => null, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Agencia Encarnación', 'address' => 'SN', 'city_id' => 163, 'phone' => '985731829', 'email' => null, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Agencia Coronel Oviedo', 'address' => 'SN', 'city_id' => 38, 'phone' => '981318717', 'email' => null, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Agencia Caaguazú', 'address' => 'SN', 'city_id' => 36, 'phone' => '984425495', 'email' => null, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Agencia Villarrica', 'address' => 'SN', 'city_id' => 152, 'phone' => '981108966', 'email' => null, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Agencia San Juan Nepomuceno', 'address' => 'SN', 'city_id' => 67, 'phone' => '994161472', 'email' => null, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Agencia Campo 9', 'address' => 'SN', 'city_id' => 40, 'phone' => '981318756', 'email' => null, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Agencia CDE', 'address' => 'SN', 'city_id' => 6, 'phone' => '992713157', 'email' => null, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Agencia Santa Rita', 'address' => 'SN', 'city_id' => 24, 'phone' => '981969475', 'email' => null, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Agencia San Estanislao (Santani)', 'address' => 'SN', 'city_id' => 249, 'phone' => '982693837', 'email' => null, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Agencia Capibary', 'address' => 'SN', 'city_id' => 239, 'phone' => '983992855', 'email' => null, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Agencia Curuguaty', 'address' => 'SN', 'city_id' => 72, 'phone' => '983564495', 'email' => null, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Agencia Katueté', 'address' => 'SN', 'city_id' => 75, 'phone' => '982854988', 'email' => null, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Agencia Asunción', 'address' => 'Carios c/ Av. La Victoria', 'city_id' => 1, 'phone' => '994440139', 'email' => null, 'created_at' => $now, 'updated_at' => $now],
        ];

        DB::table('agencies')->insert($agencies);
    }
}

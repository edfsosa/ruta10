<?php

namespace Database\Seeders;

use App\Models\Agency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AgencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $agencies = [
            ['name' => 'Agencia Carapegua', 'city_id' => '212', 'phone' => '972153857'],
            ['name' => 'Agencia DEF', 'city_id' => '185', 'phone' => '971172460'],
            ['name' => 'Agencia XYZ', 'city_id' => '161', 'phone' => '985769658'],
            ['name' => 'Agencia ABC', 'city_id' => '163', 'phone' => '985731829'],
            ['name' => 'Agencia Def', 'city_id' => '38', 'phone' => '981318717'],
            ['name' => 'Agencia GHI', 'city_id' => '36', 'phone' => '984425495'],
            ['name' => 'Agencia JKL', 'city_id' => '152', 'phone' => '981108966'],
            ['name' => 'Agencia MNO', 'city_id' => '67', 'phone' => '994161472'],
            ['name' => 'Agencia PQR', 'city_id' => '41', 'phone' => '981318756'],
            ['name' => 'Agencia STU', 'city_id' => '6', 'phone' => '992713157'],
            ['name' => 'Agencia VWX', 'city_id' => '24', 'phone' => '981969475'],
            ['name' => 'Agencia YZ', 'city_id' => '249', 'phone' => '982693837'],
            ['name' => 'Agencia ABC', 'city_id' => '239', 'phone' => '983992855'],
            ['name' => 'Agencia DEF', 'city_id' => '72', 'phone' => '983564495'],
            ['name' => 'Agencia GHI', 'city_id' => '75', 'phone' => '982854988'],
            ['name' => 'Agencia JKL', 'city_id' => '1', 'phone' => '994440139'],
        ];

        foreach ($agencies as $data) {
            Agency::firstOrCreate(
                [
                    'city_id' => $data['city_id'],
                    'phone' => $data['phone']
                ]
            );
        }
    }
}

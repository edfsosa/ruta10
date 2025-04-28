<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clientes individuales
        Customer::create([
            'type' => 'individual',
            'first_name' => 'Juan',
            'last_name' => 'González',
            'full_name' => 'Juan González',
            'company_name' => null,
            'document' => '1234567',
            'phone' => '981123456',
            'email' => 'juan@example.com',
        ]);

        Customer::create([
            'type' => 'individual',
            'first_name' => 'María',
            'last_name' => 'Fernández',
            'full_name' => 'María Fernández',
            'company_name' => null,
            'document' => '2345678',
            'phone' => '981765432',
            'email' => 'maria@example.com',
        ]);

        // Clientes empresas
        Customer::create([
            'type' => 'company',
            'first_name' => null,
            'last_name' => null,
            'full_name' => null,
            'company_name' => 'Supermercado Central S.A.',
            'document' => '80012345-6',
            'phone' => '21345678',
            'email' => 'contacto@supermercadocentral.com',
        ]);

        Customer::create([
            'type' => 'company',
            'first_name' => null,
            'last_name' => null,
            'full_name' => null,
            'company_name' => 'Tech Solutions Paraguay',
            'document' => '80198765-4',
            'phone' => '21123456',
            'email' => 'info@techsolutions.com',
        ]);
    }
}

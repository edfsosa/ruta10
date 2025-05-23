<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Crear o recuperar el rol Superadministrador
        $role = Role::firstOrCreate(['name' => 'Superadministrador']);

        // 2. Crear el usuario
        $user = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name'     => 'Admin',
                'password' => Hash::make('password')
            ]
        );

        // 3. Asignar el rol
        if (! $user->hasRole($role->name)) {
            $user->assignRole($role);
        }

        $this->command->info("Usuario Superadministrador sembrado: {$user->email}");
    }
}

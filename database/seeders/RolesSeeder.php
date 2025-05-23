<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Limpiar caché de permisos y roles
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // 2. Definir roles y sus permisos
        $rolesPermissions = [
            'Superadministrador'  => Permission::pluck('name')->all(),          // todos los permisos
            'Administrador' => [
                'ver usuarios',
                'crear usuarios',
                'editar usuarios',
                'eliminar usuarios',
                'ver clientes',
                'crear clientes',
                'editar clientes',
                'eliminar clientes',
                'ver envios',
                'crear envios',
                'editar envios',
                'eliminar envios',
                'ver productos',
                'crear productos',
                'editar productos',
                'eliminar productos',
                'ver precios',
                'crear precios',
                'editar precios',
                'eliminar precios',
                'ver agencias',
                'crear agencias',
                'editar agencias',
                'eliminar agencias',
                'ver ciudades',
                'crear ciudades',
                'editar ciudades',
                'eliminar ciudades',
                'ver conductores',
                'crear conductores',
                'editar conductores',
                'eliminar conductores',
                'ver roles',
                'ver permisos',
                'crear permisos',
                'editar permisos',
                'eliminar permisos',
            ],
            'Conductor' => [
                'ver envios',
                'crear envios',
                'editar envios',
                'ver clientes',
                'crear clientes',
                'editar clientes',
                'ver productos',
                'crear productos',
                'editar productos',
                'ver precios',
                'crear precios',
                'editar precios',
            ],
            // agrega más roles según necesites...
        ];

        // 3. Crear roles y asignar permisos
        foreach ($rolesPermissions as $roleName => $perms) {
            // Crea el rol si no existe
            $role = Role::firstOrCreate(['name' => $roleName]);

            // Sincroniza permisos: crea la relación, elimina las que sobran
            $role->syncPermissions($perms);

            $this->command->info("✔ Rol '{$roleName}' creado/sincronizado con permisos: " . implode(', ', $perms));
        }
    }
}

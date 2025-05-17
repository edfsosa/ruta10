<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Limpiar caché de permisos
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // 2. Definir aquí todos los permisos que quieras crear
        $entidades = [
            'usuarios',
            'roles',
            'permisos',
            'productos',
            'envios',
            'clientes',
            'agencias',
            'ciudades',
            'conductores',
            'precios',
            // agrega los que necesites...
        ];
        $acciones = [
            'ver',
            'crear',
            'editar',
            'eliminar',
        ];
        $permissions = [];
        foreach ($entidades as $entidad) {
            foreach ($acciones as $accion) {
                $permissions[] = "$accion $entidad";
            }
        }
        
        // 3. Crear cada permiso si no existe
        foreach ($permissions as $permName) {
            Permission::firstOrCreate(['name' => $permName]);
        }

        $this->command->info('✔ Permisos registrados: ' . implode(', ', $permissions));
    }
}

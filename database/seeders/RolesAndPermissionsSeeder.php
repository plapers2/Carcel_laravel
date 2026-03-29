<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Permisos
        Permission::create(['name' => 'ver prisioneros']);
        Permission::create(['name' => 'crear visitas']);
        Permission::create(['name' => 'aprobar visitas']);
        Permission::create(['name' => 'registrar ingreso']);
        Permission::create(["name" => 'crear guardias']);
        Permission::create(["name" => 'editar guardias']);
        Permission::create(["name" => 'eliminar guardias']);
        Permission::create(["name" => 'ver guardias']);


        // Roles
        $admin = Role::create(['name' => 'admin']);
        $guardia = Role::create(['name' => 'guardia']);

        // Asignar permisos
        $admin->givePermissionTo(Permission::all());

        $guardia->givePermissionTo([
            'ver prisioneros',
            'registrar ingreso'
        ]);
    }
}

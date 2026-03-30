<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;


class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Permisos
        Permission::create(['name' => 'ver prisioneros']);
        Permission::create(['name' => "crear prisioneros"]);
        Permission::create(['name' => "editar prisioneros"]);
        Permission::create(['name' => "eliminar prisioneros"]);

        Permission::create(['name' => "ver visitas"]);
        Permission::create(['name' => 'crear visitas']);
        Permission::create(['name' => "editar visitas"]);
        Permission::create(['name' => "eliminar visitas"]);
        Permission::create(['name' => 'aprobar visitas']);

        Permission::create(['name' => "ver usuarios"]);
        Permission::create(["name" => 'crear usuarios']);
        Permission::create(["name" => 'editar usuarios']);
        Permission::create(["name" => 'eliminar usuarios']);

        Permission::create(['name' => "ver roles"]);
        Permission::create(["name" => 'crear roles']);
        Permission::create(["name" => 'editar roles']);
        Permission::create(["name" => 'eliminar roles']);

        Permission::create(['name' => "ver permisos"]);
        Permission::create(["name" => 'crear permisos']);
        Permission::create(["name" => 'editar permisos']);
        Permission::create(["name" => 'eliminar permisos']);


        Permission::create(['name' => "ver reportes"]);
        Permission::create(["name" => 'descargar reportes']);


        // Roles
        $admin = Role::create(['name' => 'admin']);
        $guardia = Role::create(['name' => 'guardia']);

        // Asignar permisos
        $admin->givePermissionTo(Permission::all());
        $guardia->givePermissionTo([
            'ver prisioneros',
            "crear prisioneros",
            "editar prisioneros",
            "eliminar prisioneros",
            'ver visitas',
            "crear visitas",
            "editar visitas",
            "eliminar visitas",
            "aprobar visitas"
        ]);

        // Asignar el rol de admin al correo
        $user = User::where('email', 'admin@admin.com')->first();
        if ($user) {
            $user->assignRole('admin');
        }
    }
}

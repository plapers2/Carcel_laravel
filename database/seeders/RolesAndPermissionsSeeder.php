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
        // permissions
        Permission::create(['name' => 'read prisoners']);
        Permission::create(['name' => "create prisoners"]);
        Permission::create(['name' => "edit prisoners"]);
        Permission::create(['name' => "delete prisoners"]);

        Permission::create(['name' => "read visits"]);
        Permission::create(['name' => 'create visits']);
        Permission::create(['name' => "edit visits"]);
        Permission::create(['name' => "delete visits"]);
        Permission::create(['name' => 'approve visits']);

        Permission::create(['name' => "read users"]);
        Permission::create(["name" => 'create users']);
        Permission::create(["name" => 'edit users']);
        Permission::create(["name" => 'delete users']);

        Permission::create(['name' => "read roles"]);
        Permission::create(["name" => 'create roles']);
        Permission::create(["name" => 'edit roles']);
        Permission::create(["name" => 'delete roles']);

        Permission::create(['name' => "read permissions"]);
        Permission::create(["name" => 'create permissions']);
        Permission::create(["name" => 'edit permissions']);
        Permission::create(["name" => 'delete permissions']);


        Permission::create(['name' => "read reportes"]);
        Permission::create(["name" => 'download reportes']);

        Permission::create(["name" => 'read dashboard']);


        // Roles
        $admin = Role::create(['name' => 'admin']);
        $guardia = Role::create(['name' => 'guard']);

        // Asignar permissions
        $admin->givePermissionTo(Permission::all());
        $guardia->givePermissionTo([
            'read prisoners',
            "create prisoners",
            "edit prisoners",
            "delete prisoners",
            'read visits',
            "create visits",
            "edit visits",
            "delete visits",
            "approve visits"
        ]);

        // Asignar el rol de admin al correo
        $user = User::where('email', 'admin@admin.com')->first();
        if ($user) {
            $user->assignRole('admin');
        }
    }
}

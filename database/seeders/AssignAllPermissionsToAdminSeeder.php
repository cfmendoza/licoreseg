<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AssignAllPermissionsToAdminSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('name', 'Admin')->first();

        if (!$adminRole) {
            $this->command->warn('Rol "Admin" no encontrado. Asegúrate de ejecutar el RoleSeeder primero.');
            return;
        }

        $permissions = Permission::all();

        $adminRole->syncPermissions($permissions);

        $this->command->info('Todos los permisos asignados al rol "Admin".');
    }
}

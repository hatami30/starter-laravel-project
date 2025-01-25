<?php

namespace Modules\RolesAndPermissions\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define permissions with module and guard_name columns
        $permissions = [
            ['name' => 'view_dashboard', 'module' => 'core', 'guard_name' => 'web'],
            
            ['name' => 'view_users', 'module' => 'users', 'guard_name' => 'web'],
            ['name' => 'create_users', 'module' => 'users', 'guard_name' => 'web'],
            ['name' => 'edit_users', 'module' => 'users', 'guard_name' => 'web'],
            ['name' => 'delete_users', 'module' => 'users', 'guard_name' => 'web'],
            ['name' => 'can_update_user_table_settings', 'module' => 'users', 'guard_name' => 'web'],

            ['name' => 'can_view_roles_and_permissions', 'module' => 'roles_and_permissions', 'guard_name' => 'web'],
            ['name' => 'can_create_roles_and_permissions', 'module' => 'roles_and_permissions', 'guard_name' => 'web'],
            ['name' => 'can_edit_roles_and_permissions', 'module' => 'roles_and_permissions', 'guard_name' => 'web'],
            ['name' => 'can_delete_roles_and_permissions', 'module' => 'roles_and_permissions', 'guard_name' => 'web'],
            ['name' => 'can_update_roles_and_permissions_table_settings', 'module' => 'roles_and_permissions', 'guard_name' => 'web'],
        ];

        // Create permissions with the module and guard_name columns
        foreach ($permissions as $permissionData) {
            Permission::updateOrCreate([
                'name' => $permissionData['name'],
                'guard_name' => $permissionData['guard_name'],
            ], [
                'module' => $permissionData['module'],
            ]);
        }
    }
}

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
            // Profile permissions
            ['name' => 'view_profile', 'module' => 'profile', 'guard_name' => 'web'],
            ['name' => 'update_profile', 'module' => 'profile', 'guard_name' => 'web'],

            // Dashboard permissions
            ['name' => 'view_dashboard', 'module' => 'dashboard', 'guard_name' => 'web'],

            // User permissions
            ['name' => 'view_users', 'module' => 'users', 'guard_name' => 'web'],
            ['name' => 'create_users', 'module' => 'users', 'guard_name' => 'web'],
            ['name' => 'edit_users', 'module' => 'users', 'guard_name' => 'web'],
            ['name' => 'delete_users', 'module' => 'users', 'guard_name' => 'web'],
            ['name' => 'update_user_table_settings', 'module' => 'users', 'guard_name' => 'web'],

            // Roles and Permissions permissions
            ['name' => 'view_roles_and_permissions', 'module' => 'roles and permissions', 'guard_name' => 'web'],
            ['name' => 'create_roles_and_permissions', 'module' => 'roles and permissions', 'guard_name' => 'web'],
            ['name' => 'edit_roles_and_permissions', 'module' => 'roles and permissions', 'guard_name' => 'web'],
            ['name' => 'delete_roles_and_permissions', 'module' => 'roles and permissions', 'guard_name' => 'web'],
            ['name' => 'update_roles_and_permissions_table_settings', 'module' => 'roles and permissions', 'guard_name' => 'web'],

            // Division permissions
            ['name' => 'view_divisions', 'module' => 'division', 'guard_name' => 'web'],
            ['name' => 'create_divisions', 'module' => 'division', 'guard_name' => 'web'],
            ['name' => 'edit_divisions', 'module' => 'division', 'guard_name' => 'web'],
            ['name' => 'delete_divisions', 'module' => 'division', 'guard_name' => 'web'],
            ['name' => 'update_division_table_settings', 'module' => 'division', 'guard_name' => 'web'],

            // Risk permissions
            ['name' => 'view_risks', 'module' => 'risk', 'guard_name' => 'web'],
            ['name' => 'create_risks', 'module' => 'risk', 'guard_name' => 'web'],
            ['name' => 'edit_risks', 'module' => 'risk', 'guard_name' => 'web'],
            ['name' => 'delete_risks', 'module' => 'risk', 'guard_name' => 'web'],
            ['name' => 'update_risk_table_settings', 'module' => 'risk', 'guard_name' => 'web'],

            // Document permissions
            ['name' => 'view_documents', 'module' => 'document', 'guard_name' => 'web'],
            ['name' => 'create_documents', 'module' => 'document', 'guard_name' => 'web'],
            ['name' => 'edit_documents', 'module' => 'document', 'guard_name' => 'web'],
            ['name' => 'delete_documents', 'module' => 'document', 'guard_name' => 'web'],
            ['name' => 'update_document_table_settings', 'module' => 'document', 'guard_name' => 'web'],
            ['name' => 'export_documents_to_excel', 'module' => 'document', 'guard_name' => 'web'],
            ['name' => 'export_documents_to_pdf', 'module' => 'document', 'guard_name' => 'web'],
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

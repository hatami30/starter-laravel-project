<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
// use Modules\Risk\Database\Seeders\RiskDatabaseSeeder;
use Modules\Roles\Database\Seeders\RolesDatabaseSeeder;
use Modules\Roles\Models\Role;
use Modules\Division\Models\Division;
use Modules\Division\Database\Seeders\DivisionDatabaseSeeder;
use Modules\RolesAndPermissions\Database\Seeders\PermissionDatabaseSeeder;
use Modules\RolesAndPermissions\Database\Seeders\RoleDatabaseSeeder;
use Modules\RolesAndPermissions\Models\Permission;
use Modules\User\Database\Seeders\UserDatabaseSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            DivisionDatabaseSeeder::class,
            UserDatabaseSeeder::class,
            PermissionDatabaseSeeder::class,
            RoleDatabaseSeeder::class,
            // RiskDatabaseSeeder::class,
        ]);
    }
}

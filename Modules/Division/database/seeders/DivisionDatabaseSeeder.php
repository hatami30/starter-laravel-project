<?php

namespace Modules\Division\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Division\Models\Division;

class DivisionDatabaseSeeder extends Seeder
{

    public function run(): void
    {
        Division::factory()->count(10)->create();
    }
}

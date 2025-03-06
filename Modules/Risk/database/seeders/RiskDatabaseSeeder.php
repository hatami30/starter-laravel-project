<?php

namespace Modules\Risk\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Risk\Models\Risk;
use Modules\Risk\Database\Factories\RiskFactory;

class RiskDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $this->call([]);
        Risk::factory(50)->create();
    }
}

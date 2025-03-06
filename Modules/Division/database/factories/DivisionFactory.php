<?php

namespace Modules\Division\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Division\Models\Division;

class DivisionFactory extends Factory
{
    protected $model = Division::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->company,
            'description' => $this->faker->paragraph,
        ];
    }
}

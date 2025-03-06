<?php

namespace Modules\User\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Modules\User\Models\User;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    protected static ?string $password;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'username' => fake()->unique()->userName(),
            'email_verified_at' => now(),
            'phone' => fake()->unique()->phoneNumber(),
            'division_id' => random_int(1, 10),
            'status' => 'active',
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}

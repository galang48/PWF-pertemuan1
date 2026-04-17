<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->words(2, true),
            'quantity' => fake()->numberBetween(1, 100),
            'price' => fake()->randomFloat(2, 1000, 100000),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
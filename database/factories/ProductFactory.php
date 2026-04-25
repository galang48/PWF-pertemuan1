<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
        ];
    }
}

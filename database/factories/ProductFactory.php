<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
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
            //
            'user_id' => User::all()->random()->id,
            'name' => $this->faker->words(2, true),
            'quantity' => $this->faker->numberBetween(1, 100),
            'price' => $this->faker->numberBetween(10000, 100000),
        ];
    }
}
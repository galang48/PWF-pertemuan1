<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $user = User::factory()->create([
            'name' => 'Ayo Belajar',
            'email' => 'belajar@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'Bob',
            'email' => 'bob@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        $categories = collect([
            'Perangkat Keras',
            'Elektronik',
            'Fashion',
            'Makanan & Minuman',
            'Kesehatan',
            'Otomotif',
            'Olahraga',
        ])->map(fn (string $name) => Category::factory()->create([
            'name' => $name,
        ]));

        Product::factory(20)
            ->state(fn () => [
                'user_id' => $user->id,
                'category_id' => $categories->random()->id,
            ])
            ->create();
    }
}

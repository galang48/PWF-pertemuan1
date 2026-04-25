<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('allows admin to manage categories', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
    ]);

    $this
        ->actingAs($admin)
        ->post(route('category.store'), [
            'name' => 'Perangkat Keras',
        ])
        ->assertRedirect(route('category.index'));

    $category = Category::where('name', 'Perangkat Keras')->first();

    expect($category)->not->toBeNull();

    $this
        ->actingAs($admin)
        ->put(route('category.update', $category), [
            'name' => 'Hardware',
        ])
        ->assertRedirect(route('category.index'));

    expect($category->fresh()->name)->toBe('Hardware');
});

it('blocks regular users from category pages', function () {
    $user = User::factory()->create([
        'role' => 'user',
    ]);

    $this
        ->actingAs($user)
        ->get(route('category.index'))
        ->assertForbidden();
});

it('shows total products for each category', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
    ]);
    $category = Category::factory()->create([
        'name' => 'Elektronik',
    ]);

    Product::factory()
        ->count(2)
        ->for($category)
        ->create();

    $this
        ->actingAs($admin)
        ->get(route('category.index'))
        ->assertOk()
        ->assertSee('Elektronik')
        ->assertSee('2');
});

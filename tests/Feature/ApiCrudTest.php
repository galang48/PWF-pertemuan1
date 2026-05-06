<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

it('returns an API token for valid credentials', function () {
    $user = User::factory()->create([
        'email' => 'api@example.com',
    ]);

    $this
        ->postJson('/api/v1/login', [
            'email' => $user->email,
            'password' => 'password',
        ])
        ->assertOk()
        ->assertJsonPath('token_type', 'Bearer')
        ->assertJsonStructure(['message', 'access_token', 'token_type']);
});

it('requires a token for category CRUD endpoints', function () {
    $this
        ->postJson('/api/v1/category', [
            'name' => 'Elektronik',
        ])
        ->assertUnauthorized();

    Sanctum::actingAs(User::factory()->create());

    $categoryId = $this
        ->postJson('/api/v1/category', [
            'name' => 'Elektronik',
        ])
        ->assertCreated()
        ->json('data.id');

    $this
        ->getJson('/api/v1/category')
        ->assertOk()
        ->assertJsonPath('data.0.name', 'Elektronik');

    $this
        ->putJson("/api/v1/category/{$categoryId}", [
            'name' => 'Hardware',
        ])
        ->assertOk()
        ->assertJsonPath('data.name', 'Hardware');

    $this
        ->deleteJson("/api/v1/category/{$categoryId}")
        ->assertNoContent();
});

it('handles product API read and protected writes', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();

    $this
        ->postJson('/api/v1/product', [
            'name' => 'Keyboard',
            'quantity' => 10,
            'price' => 250000,
            'category_id' => $category->id,
        ])
        ->assertUnauthorized();

    Sanctum::actingAs($user);

    $productId = $this
        ->postJson('/api/v1/product', [
            'name' => 'Keyboard',
            'quantity' => 10,
            'price' => 250000,
            'category_id' => $category->id,
        ])
        ->assertCreated()
        ->assertJsonPath('data.user_id', $user->id)
        ->json('data.id');

    $this
        ->getJson("/api/v1/product/{$productId}")
        ->assertOk()
        ->assertJsonPath('data.name', 'Keyboard');

    $this
        ->putJson("/api/v1/product/{$productId}", [
            'name' => 'Keyboard Pro',
            'quantity' => 12,
            'price' => 300000,
            'category_id' => $category->id,
        ])
        ->assertOk()
        ->assertJsonPath('data.name', 'Keyboard Pro');

    expect(Product::find($productId)?->name)->toBe('Keyboard Pro');

    $this
        ->deleteJson("/api/v1/product/{$productId}")
        ->assertNoContent();
});

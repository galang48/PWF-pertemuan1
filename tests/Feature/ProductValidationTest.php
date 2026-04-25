<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('validates product creation input', function () {
    $user = User::factory()->create([
        'role' => 'user',
    ]);

    $response = $this
        ->actingAs($user)
        ->from(route('product.create'))
        ->post(route('product.store'), [
            'name' => '',
            'quantity' => 'abc',
            'price' => 'abc',
        ]);

    $response
        ->assertRedirect(route('product.create'))
        ->assertSessionHasErrors(['name', 'quantity', 'price', 'category_id']);
});

it('requires category when creating a product', function () {
    $user = User::factory()->create([
        'role' => 'user',
    ]);

    $response = $this
        ->actingAs($user)
        ->from(route('product.create'))
        ->post(route('product.store'), [
            'name' => 'Keyboard',
            'quantity' => 10,
            'price' => 250000,
        ]);

    $response
        ->assertRedirect(route('product.create'))
        ->assertSessionHasErrors(['category_id']);
});

it('validates product update input', function () {
    $user = User::factory()->create([
        'role' => 'user',
    ]);
    $product = Product::factory()->for($user)->create();

    $response = $this
        ->actingAs($user)
        ->from(route('product.edit', $product))
        ->put(route('product.update', $product), [
            'name' => str_repeat('a', 256),
            'quantity' => 'abc',
            'price' => 'abc',
        ]);

    $response
        ->assertRedirect(route('product.edit', $product))
        ->assertSessionHasErrors(['name', 'quantity', 'price', 'category_id']);
});

it('assigns the authenticated user when creating a product', function () {
    $user = User::factory()->create([
        'role' => 'user',
    ]);
    $category = Category::factory()->create();

    $response = $this
        ->actingAs($user)
        ->post(route('product.store'), [
            'name' => 'Keyboard',
            'quantity' => 10,
            'price' => 250000,
            'category_id' => $category->id,
        ]);

    $response
        ->assertRedirect(route('product.index'));

    expect(Product::where('name', 'Keyboard')->first()?->user_id)->toBe($user->id);
});

it('updates category without changing product owner', function () {
    $user = User::factory()->create([
        'role' => 'user',
    ]);
    $oldCategory = Category::factory()->create();
    $newCategory = Category::factory()->create();
    $product = Product::factory()->for($user)->for($oldCategory)->create();

    $this
        ->actingAs($user)
        ->put(route('product.update', $product), [
            'name' => 'Mouse Pro',
            'quantity' => 7,
            'price' => 275000,
            'category_id' => $newCategory->id,
        ])
        ->assertRedirect(route('product.index'));

    expect($product->fresh()->user_id)->toBe($user->id)
        ->and($product->fresh()->category_id)->toBe($newCategory->id);
});

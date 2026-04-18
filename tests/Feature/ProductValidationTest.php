<?php

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
        ->assertSessionHasErrors(['name', 'quantity', 'price']);
});

it('requires owner when creating a product', function () {
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
        ->assertSessionHasErrors(['user_id']);
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
        ->assertSessionHasErrors(['name', 'quantity', 'price']);
});

it('allows changing owner while updating a product', function () {
    $user = User::factory()->create([
        'role' => 'user',
    ]);
    $otherUser = User::factory()->create();
    $product = Product::factory()->for($user)->create();

    $response = $this
        ->actingAs($user)
        ->put(route('product.update', $product), [
            'name' => 'Monitor',
            'quantity' => 5,
            'price' => 1500000,
            'user_id' => $otherUser->id,
        ]);

    $response
        ->assertRedirect(route('product.index'));

    expect($product->fresh()->user_id)->toBe($otherUser->id);
});

it('allows admin to choose owner on create and update', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
    ]);
    $owner = User::factory()->create([
        'role' => 'user',
    ]);
    $product = Product::factory()->for($admin)->create();

    $this
        ->actingAs($admin)
        ->post(route('product.store'), [
            'name' => 'Mouse',
            'quantity' => 3,
            'price' => 175000,
            'user_id' => $owner->id,
        ])
        ->assertRedirect(route('product.index'));

    expect(Product::where('name', 'Mouse')->first()?->user_id)->toBe($owner->id);

    $this
        ->actingAs($admin)
        ->put(route('product.update', $product), [
            'name' => 'Mouse Pro',
            'quantity' => 7,
            'price' => 275000,
            'user_id' => $owner->id,
        ])
        ->assertRedirect(route('product.index'));

    expect($product->fresh()->user_id)->toBe($owner->id);
});

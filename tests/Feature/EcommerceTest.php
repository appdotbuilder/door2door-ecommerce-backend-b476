<?php

use App\Models\Category;
use App\Models\Product;

test('welcome page loads', function () {
    $response = $this->get('/');
    $response->assertStatus(200);
});

test('health check endpoint works', function () {
    $response = $this->getJson('/health-check');
    $response->assertStatus(200)
        ->assertJsonStructure([
            'status',
            'timestamp',
        ]);
});

test('can create categories', function () {
    $category = Category::factory()->create([
        'name' => 'Test Category'
    ]);

    $this->assertDatabaseHas('categories', [
        'name' => 'Test Category'
    ]);

    expect($category->name)->toBe('Test Category');
});

test('can create products', function () {
    $category = Category::factory()->create();
    $product = Product::factory()->create([
        'name' => 'Test Product',
        'category_id' => $category->id,
    ]);

    $this->assertDatabaseHas('products', [
        'name' => 'Test Product'
    ]);

    expect($product->name)->toBe('Test Product');
    expect($product->category_id)->toBe($category->id);
});

test('product belongs to category', function () {
    $category = Category::factory()->create();
    $product = Product::factory()->create(['category_id' => $category->id]);

    expect($product->category->id)->toBe($category->id);
    expect($product->category->name)->toBe($category->name);
});

test('category has products', function () {
    $category = Category::factory()->create();
    $product1 = Product::factory()->create(['category_id' => $category->id]);
    $product2 = Product::factory()->create(['category_id' => $category->id]);

    expect($category->products)->toHaveCount(2);
    expect($category->products->pluck('id')->toArray())->toContain($product1->id, $product2->id);
});
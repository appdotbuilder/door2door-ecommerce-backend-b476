<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        $name = fake()->words(random_int(2, 4), true);
        $brands = ['Indomie', 'Unilever', 'Nestle', 'Coca-Cola', 'Danone', 'Indofood', 'Wings', 'ABC', 'Teh Botol', 'Aqua'];
        
        return [
            'name' => ucfirst($name),
            'slug' => \Illuminate\Support\Str::slug($name . '-' . fake()->randomNumber(3)),
            'description' => fake()->paragraph(),
            'price' => fake()->randomFloat(0, 5000, 50000),
            'weight' => fake()->randomFloat(2, 50, 2000),
            'brand' => fake()->randomElement($brands),
            'expiry_date' => fake()->optional()->dateTimeBetween('+1 month', '+2 years'),
            'stock' => fake()->numberBetween(0, 100),
            'images' => [
                fake()->imageUrl(400, 400, 'food'),
                fake()->imageUrl(400, 400, 'food'),
            ],
            'is_active' => true,
            'category_id' => Category::factory(),
        ];
    }
}
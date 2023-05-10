<?php

namespace Database\Factories;

use App\Models\ProductCategory;
use App\Models\ProductInventory;
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
        return [
            'name' => fake()->word,
            'description' => fake()->text,
            'sku' => fake()->word . '-' . fake()->word,
            'price' => fake()->numberBetween(5, 500),
            'product_category_id' => ProductCategory::factory(),
            'product_inventory_id' => ProductInventory::factory(),
            'discount_id' => 1
        ];
    }
}

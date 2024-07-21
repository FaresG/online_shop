<?php

namespace Database\Factories;

use App\Http\Services\StripeService;
use App\Models\ProductCategory;
use App\Models\ProductInventory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

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
        $service = new StripeService;

        $product = $service->createProduct([
            'name' => fake()->word,
            'description' => fake()->text,
            'default_price_data' => [
                'currency' => 'usd',
                'unit_amount_decimal' => fake()->numberBetween(5, 200)
            ]
        ]);

        return [
            'name' => $product->name,
            'description' => $product->description,
            'sku' => fake()->word . '-' . fake()->word,
            'price' => $service->getPrice($product->default_price)->unit_amount_decimal,
            'stripe_id' => $product->id,
            'product_category_id' => ProductCategory::factory(),
            'product_inventory_id' => ProductInventory::factory(),
            'discount_id' => 1
        ];
    }
}

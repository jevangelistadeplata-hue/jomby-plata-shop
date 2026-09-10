<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Define los datos predeterminados del producto.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $costPrice = fake()->randomFloat(2, 100, 5000);

        return [
            'supplier_id' => Supplier::inRandomOrder()->first()?->id ?? Supplier::factory(),
            'category_id' => Category::inRandomOrder()->first()?->id ?? Category::factory(),
            'name' => fake()->unique()->words(3, true),
            'description' => fake()->sentence(12),
            'image' => null,
            'cost_price' => $costPrice,
            'sale_price' => round($costPrice * 1.30, 2),
            'stock' => fake()->numberBetween(5, 100),
            'status' => 'approved',
        ];
    }
}
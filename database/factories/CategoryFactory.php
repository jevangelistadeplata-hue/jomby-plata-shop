<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    protected $model = Category::class;

    /**
     * Define los datos predeterminados de la categoría.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement([
                'Limpieza',
                'Higiene',
                'Oficina',
                'Tecnología',
                'Hogar',
                'Alimentos',
            ]),
            'description' => fake()->sentence(),
            'status' => 'active',
        ];
    }
}
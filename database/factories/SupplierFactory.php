<?php

namespace Database\Factories;

use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Supplier>
 */
class SupplierFactory extends Factory
{
    protected $model = Supplier::class;

    /**
     * Define los datos predeterminados del proveedor.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->supplier(),
            'business_name' => fake()->company(),
            'phone' => fake()->numerify('809-###-####'),
            'address' => fake()->address(),
            'status' => 'approved',
        ];
    }
}
<?php

namespace Database\Factories;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * Contraseña actual utilizada por la fábrica.
     */
    protected static ?string $password;

    /**
     * Define los datos predeterminados del usuario.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'role_id' => Role::where('name', 'Cliente')->value('id'),
        ];
    }

    /**
     * Indica que el correo electrónico del usuario no está verificado.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Indica que el usuario tendrá el rol de Proveedor.
     */
    public function supplier(): static
    {
        return $this->state(fn (array $attributes) => [
            'role_id' => Role::where('name', 'Proveedor')->value('id'),
        ]);
    }

    /**
     * Indica que el usuario tendrá el rol de Administrador.
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role_id' => Role::where('name', 'Administrador')->value('id'),
        ]);
    }

    /**
     * Indica que el usuario tendrá el rol de Cliente.
     */
    public function client(): static
    {
        return $this->state(fn (array $attributes) => [
            'role_id' => Role::where('name', 'Cliente')->value('id'),
        ]);
    }
}
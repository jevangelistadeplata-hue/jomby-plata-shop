<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Primero se crean los roles necesarios para los usuarios.
        $this->call([
            RoleSeeder::class,
        ]);

        
        // Se crea el usuario Administrador para realizar las pruebas del sistema.
        User::factory()->admin()->create([
            'name' => 'Administrador',
            'email' => 'admin@jomby.test',
        ]);

        // Se crean las categorías que utilizarán los productos.
        Category::factory(6)->create();

        // Se crean los proveedores de prueba.
        Supplier::factory(5)->create();

        // Se crean los productos relacionados con proveedores y categorías.
        Product::factory(30)->create();
    }
}
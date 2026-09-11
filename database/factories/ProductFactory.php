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
        $productos = [
            [
                'name' => 'Detergente líquido multiuso 1 L',
                'description' => 'Detergente líquido para limpieza general de superficies.',
                'category' => 'Limpieza',
                'cost_price' => 350,
                'sale_price' => 455,
            ],
            [
                'name' => 'Jabón líquido para manos 500 ml',
                'description' => 'Jabón líquido para higiene y lavado frecuente de manos.',
                'category' => 'Higiene',
                'cost_price' => 180,
                'sale_price' => 234,
            ],
            [
                'name' => 'Papel higiénico 4 rollos',
                'description' => 'Paquete de papel higiénico para uso doméstico y comercial.',
                'category' => 'Higiene',
                'cost_price' => 220,
                'sale_price' => 286,
            ],
            [
                'name' => 'Desinfectante para pisos 1 L',
                'description' => 'Desinfectante líquido para limpieza y desinfección de pisos.',
                'category' => 'Limpieza',
                'cost_price' => 275,
                'sale_price' => 358,
            ],
            [
                'name' => 'Toallas de papel',
                'description' => 'Toallas de papel absorbentes para uso en oficinas y comercios.',
                'category' => 'Higiene',
                'cost_price' => 320,
                'sale_price' => 416,
            ],
            [
                'name' => 'Limpiador de cristales 500 ml',
                'description' => 'Limpiador para cristales, ventanas y superficies de vidrio.',
                'category' => 'Limpieza',
                'cost_price' => 195,
                'sale_price' => 254,
            ],
            [
                'name' => 'Resma de papel 8 ½ x 11',
                'description' => 'Papel blanco para impresión y uso general de oficina.',
                'category' => 'Oficina',
                'cost_price' => 425,
                'sale_price' => 553,
            ],
            [
                'name' => 'Bolígrafo azul caja x12',
                'description' => 'Caja de bolígrafos de tinta azul para uso de oficina.',
                'category' => 'Oficina',
                'cost_price' => 180,
                'sale_price' => 234,
            ],
            [
                'name' => 'Teclado USB',
                'description' => 'Teclado USB para computadoras de escritorio y oficina.',
                'category' => 'Tecnología',
                'cost_price' => 650,
                'sale_price' => 845,
            ],
            [
                'name' => 'Mouse óptico USB',
                'description' => 'Mouse óptico USB para equipos de escritorio y portátiles.',
                'category' => 'Tecnología',
                'cost_price' => 400,
                'sale_price' => 520,
            ],
            [
                'name' => 'Limpiador desengrasante 1 L',
                'description' => 'Producto para remover grasa y suciedad de diferentes superficies.',
                'category' => 'Limpieza',
                'cost_price' => 290,
                'sale_price' => 377,
            ],
            [
                'name' => 'Cloro líquido 1 galón',
                'description' => 'Producto para limpieza y desinfección de superficies.',
                'category' => 'Limpieza',
                'cost_price' => 300,
                'sale_price' => 390,
            ],
            [
                'name' => 'Alcohol líquido 1 L',
                'description' => 'Alcohol para limpieza y desinfección de superficies.',
                'category' => 'Higiene',
                'cost_price' => 350,
                'sale_price' => 455,
            ],
            [
                'name' => 'Guantes de limpieza',
                'description' => 'Guantes reutilizables para labores de limpieza.',
                'category' => 'Limpieza',
                'cost_price' => 150,
                'sale_price' => 195,
            ],
            [
                'name' => 'Esponja para limpieza paquete x3',
                'description' => 'Paquete de esponjas para limpieza general.',
                'category' => 'Limpieza',
                'cost_price' => 120,
                'sale_price' => 156,
            ],
            [
                'name' => 'Carpeta plástica tamaño carta',
                'description' => 'Carpeta plástica para organización y almacenamiento de documentos.',
                'category' => 'Oficina',
                'cost_price' => 95,
                'sale_price' => 124,
            ],
            [
                'name' => 'Marcadores permanentes caja x4',
                'description' => 'Caja de marcadores permanentes para oficina y almacén.',
                'category' => 'Oficina',
                'cost_price' => 210,
                'sale_price' => 273,
            ],
            [
                'name' => 'Memoria USB 64 GB',
                'description' => 'Memoria USB para almacenamiento y transferencia de archivos.',
                'category' => 'Tecnología',
                'cost_price' => 550,
                'sale_price' => 715,
            ],
            [
                'name' => 'Cable USB tipo C',
                'description' => 'Cable USB tipo C para carga y transferencia de datos.',
                'category' => 'Tecnología',
                'cost_price' => 300,
                'sale_price' => 390,
            ],
            [
                'name' => 'Calculadora de escritorio',
                'description' => 'Calculadora electrónica para operaciones de oficina.',
                'category' => 'Oficina',
                'cost_price' => 275,
                'sale_price' => 358,
            ],
            [
                'name' => 'Limpiador de baños 1 L',
                'description' => 'Limpiador especializado para baños y superficies sanitarias.',
                'category' => 'Limpieza',
                'cost_price' => 280,
                'sale_price' => 364,
            ],
            [
                'name' => 'Ambientador en aerosol 400 ml',
                'description' => 'Ambientador para oficinas, comercios y espacios cerrados.',
                'category' => 'Hogar',
                'cost_price' => 240,
                'sale_price' => 312,
            ],
            [
                'name' => 'Servilletas de papel paquete x100',
                'description' => 'Paquete de servilletas de papel para uso comercial y doméstico.',
                'category' => 'Hogar',
                'cost_price' => 160,
                'sale_price' => 208,
            ],
            [
                'name' => 'Bolsas para basura paquete x20',
                'description' => 'Bolsas resistentes para recolección de residuos.',
                'category' => 'Hogar',
                'cost_price' => 250,
                'sale_price' => 325,
            ],
            [
                'name' => 'Archivador tamaño carta',
                'description' => 'Archivador para organización y almacenamiento de documentos.',
                'category' => 'Oficina',
                'cost_price' => 350,
                'sale_price' => 455,
            ],
            [
                'name' => 'Grapadora de escritorio',
                'description' => 'Grapadora metálica para trabajos de oficina.',
                'category' => 'Oficina',
                'cost_price' => 275,
                'sale_price' => 358,
            ],
            [
                'name' => 'Almohadilla para mouse',
                'description' => 'Almohadilla para mejorar el desplazamiento del mouse.',
                'category' => 'Tecnología',
                'cost_price' => 180,
                'sale_price' => 234,
            ],
            [
                'name' => 'Audífonos con conexión USB',
                'description' => 'Audífonos USB para computadora y reuniones virtuales.',
                'category' => 'Tecnología',
                'cost_price' => 700,
                'sale_price' => 910,
            ],
            [
                'name' => 'Café molido paquete 500 g',
                'description' => 'Café molido para consumo en oficinas y hogares.',
                'category' => 'Alimentos',
                'cost_price' => 450,
                'sale_price' => 585,
            ],
            [
                'name' => 'Azúcar blanca paquete 2 lb',
                'description' => 'Azúcar blanca para consumo y preparación de bebidas.',
                'category' => 'Alimentos',
                'cost_price' => 120,
                'sale_price' => 156,
            ],
        ];

        $producto = fake()->randomElement($productos);

        return [
            'supplier_id' => Supplier::inRandomOrder()->first()?->id ?? Supplier::factory(),
            'category_id' => Category::firstOrCreate(['name' => $producto['category']])->id,
            'name' => $producto['name'],
            'description' => $producto['description'],
            'image' => null,
            'cost_price' => $producto['cost_price'],
            'sale_price' => $producto['sale_price'],
            'stock' => fake()->numberBetween(10, 100),
            'status' => 'approved',
        ];
    }
}
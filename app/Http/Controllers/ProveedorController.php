<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProveedorController extends Controller
{
    /**
     * Muestra el dashboard del proveedor.
     */
    public function dashboard(Request $request)
    {
        // Obtiene el proveedor relacionado con el usuario autenticado.
        $supplier = $request->user()->supplier;

        // Verifica que exista un perfil de proveedor asociado.
        if (! $supplier) {
            abort(
                404,
                'No se encontró un perfil de proveedor asociado a este usuario.'
            );
        }

        // Obtiene las cantidades de productos según su estado.
        $stats = [
            'total' => $supplier->products()->count(),

            'pendientes' => $supplier->products()
                ->where('status', 'pending')
                ->count(),

            'aprobados' => $supplier->products()
                ->where('status', 'approved')
                ->count(),

            'inactivos' => $supplier->products()
                ->where('status', 'inactive')
                ->count(),
        ];

        return view('proveedor.dashboard', compact(
            'supplier',
            'stats'
        ));
    }

    /**
     * Muestra los productos pertenecientes al proveedor autenticado.
     */
    public function products(Request $request)
    {
        // Obtiene el proveedor relacionado con el usuario autenticado.
        $supplier = $request->user()->supplier;

        // Verifica que exista un perfil de proveedor asociado.
        if (! $supplier) {
            abort(
                404,
                'No se encontró un perfil de proveedor asociado a este usuario.'
            );
        }

        // Obtiene únicamente los productos de este proveedor.
        $products = $supplier->products()
            ->with('category')
            ->latest()
            ->get();

        return view('proveedor.products.index', compact(
            'supplier',
            'products'
        ));
    }

    /**
     * Muestra el formulario para registrar un producto.
     */
    public function create(Request $request)
    {
        // Obtiene el proveedor relacionado con el usuario autenticado.
        $supplier = $request->user()->supplier;

        // Verifica que exista un perfil de proveedor asociado.
        if (! $supplier) {
            abort(
                404,
                'No se encontró un perfil de proveedor asociado a este usuario.'
            );
        }

        // Obtiene las categorías disponibles para el producto.
        $categories = Category::orderBy('name')->get();

        return view('proveedor.products.create', compact(
            'supplier',
            'categories'
        ));
    }

    /**
     * Guarda un nuevo producto del proveedor autenticado.
     */
    public function store(Request $request)
    {
        // Obtiene el proveedor relacionado con el usuario autenticado.
        $supplier = $request->user()->supplier;

        // Verifica que exista un perfil de proveedor asociado.
        if (! $supplier) {
            abort(
                404,
                'No se encontró un perfil de proveedor asociado a este usuario.'
            );
        }

        // Valida los datos enviados por el formulario.
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'category_id' => [
                'required',
                Rule::exists('categories', 'id'),
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'cost_price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'sale_price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'stock' => [
                'required',
                'integer',
                'min:0',
            ],
        ]);

        // Crea el producto asociado automáticamente al proveedor autenticado.
        Product::create([
            'supplier_id' => $supplier->id,
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'cost_price' => $validated['cost_price'],
            'sale_price' => $validated['sale_price'],
            'stock' => $validated['stock'],

            // Todo producto nuevo queda pendiente de aprobación.
            'status' => 'pending',
        ]);

        return redirect()
            ->route('proveedor.products.index')
            ->with(
                'success',
                'El producto fue registrado correctamente y quedó pendiente de aprobación.'
            );
    }

    /**
     * Muestra el formulario para editar un producto.
     */
    public function edit(Request $request, Product $product)
    {
        // Obtiene el proveedor relacionado con el usuario autenticado.
        $supplier = $request->user()->supplier;

        // Verifica que exista un perfil de proveedor asociado.
        if (! $supplier) {
            abort(
                404,
                'No se encontró un perfil de proveedor asociado a este usuario.'
            );
        }

        // Impide que el proveedor edite productos que no le pertenecen.
        if ($product->supplier_id !== $supplier->id) {
            abort(
                403,
                'No tienes autorización para editar este producto.'
            );
        }

        // Obtiene las categorías disponibles.
        $categories = Category::orderBy('name')->get();

        return view('proveedor.products.edit', compact(
            'supplier',
            'product',
            'categories'
        ));
    }

    /**
     * Actualiza un producto perteneciente al proveedor autenticado.
     */
    public function update(Request $request, Product $product)
    {
        // Obtiene el proveedor relacionado con el usuario autenticado.
        $supplier = $request->user()->supplier;

        // Verifica que exista un perfil de proveedor asociado.
        if (! $supplier) {
            abort(
                404,
                'No se encontró un perfil de proveedor asociado a este usuario.'
            );
        }

        // Impide que el proveedor modifique productos que no le pertenecen.
        if ($product->supplier_id !== $supplier->id) {
            abort(
                403,
                'No tienes autorización para modificar este producto.'
            );
        }

        // Valida los datos enviados por el formulario.
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'category_id' => [
                'required',
                Rule::exists('categories', 'id'),
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'cost_price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'sale_price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'stock' => [
                'required',
                'integer',
                'min:0',
            ],
        ]);

        // Actualiza los datos permitidos del producto.
        $product->update([
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'cost_price' => $validated['cost_price'],
            'sale_price' => $validated['sale_price'],
            'stock' => $validated['stock'],

            // Todo producto modificado por el proveedor vuelve a revisión.
            'status' => 'pending',
        ]);

        return redirect()
            ->route('proveedor.products.index')
            ->with(
                'success',
                'El producto fue actualizado y quedó pendiente de nueva aprobación.'
            );
    }
}






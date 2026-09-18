<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Muestra el listado de productos para el administrador.
     */
    public function index(Request $request)
    {
        // Obtiene los valores enviados desde el formulario de búsqueda y filtro.
        $search = $request->input('search');
        $status = $request->input('status');
        $category = $request->input('category');
        $supplier = $request->input('supplier');

        // Construye la consulta de productos junto con sus relaciones.
        $query = Product::with(['supplier.user', 'category']);

        // Aplica la búsqueda por nombre del producto o empresa proveedora.
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhereHas('supplier', function ($supplierQuery) use ($search) {
                        $supplierQuery->where(
                            'business_name',
                            'like',
                            "%{$search}%"
                        );
                    });
            });
        }

        // Aplica el filtro por estado.
        if ($status) {
            $query->where('status', $status);
        }

        // Aplica el filtro por categoría.
        if ($category) {
            $query->where('category_id', $category);
        }

        // Aplica el filtro por proveedor.
        if ($supplier) {
            $query->where('supplier_id', $supplier);
        }

        // Obtiene los productos más recientes primero.
        $products = $query
            ->latest()
            ->get();

        // Obtiene las categorías para mostrar el filtro.
        $categories = Category::orderBy('name')->get();

        // Obtiene los proveedores para mostrar el filtro.
        $suppliers = Supplier::orderBy('business_name')->get();

        return view('admin.products.index', compact(
            'products',
            'categories',
            'suppliers',
            'search',
            'status',
            'category',
            'supplier'
        ));
    }

    /**
     * Aprueba un producto pendiente.
     */
    public function approve(Product $product)
    {
        // Cambia el estado del producto a aprobado.
        $product->update([
            'status' => 'approved',
        ]);

        return redirect()
            ->route('admin.products.index')
            ->with(
                'success',
                'El producto fue aprobado correctamente.'
            );
    }

    /**
     * Desactiva un producto.
     */
    public function deactivate(Product $product)
    {
        // Cambia el estado del producto a inactivo.
        $product->update([
            'status' => 'inactive',
        ]);

        return redirect()
            ->route('admin.products.index')
            ->with(
                'success',
                'El producto fue desactivado correctamente.'
            );
    }
}

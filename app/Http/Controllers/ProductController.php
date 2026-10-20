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
        $search = $request->input('search');
        $status = $request->input('status');
        $category = $request->input('category');
        $supplier = $request->input('supplier');

        // Carga las relaciones del producto y el estado del proveedor.
        $query = Product::with(['supplier.user', 'category']);

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

        if ($status) {
            $query->where('status', $status);
        }

        if ($category) {
            $query->where('category_id', $category);
        }

        if ($supplier) {
            $query->where('supplier_id', $supplier);
        }

        $products = $query->latest()->get();

        $categories = Category::orderBy('name')->get();
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
     * Aprueba un producto únicamente si su proveedor está aprobado.
     */
    public function approve(Product $product)
    {
        $product->load('supplier');

        if (!$product->supplier || $product->supplier->status !== 'approved') {
            return redirect()
                ->route('admin.products.index')
                ->with(
                    'error',
                    'No se puede aprobar el producto porque su proveedor no está aprobado.'
                );
        }

        if ($product->status !== 'pending') {
            return redirect()
                ->route('admin.products.index')
                ->with(
                    'error',
                    'Solo se pueden aprobar productos pendientes.'
                );
        }

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

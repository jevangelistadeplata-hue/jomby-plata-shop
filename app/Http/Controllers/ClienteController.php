<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Muestra el catálogo de productos disponibles para los clientes.
     */
    public function catalog(Request $request)
    {
        // Obtiene los valores utilizados para la búsqueda y el filtro.
        $search = $request->input('search');
        $category = $request->input('category');

        // Construye la consulta mostrando solamente productos disponibles.
        $query = Product::with('category')
            ->where('status', 'approved')
            ->where('stock', '>', 0);

        // Aplica la búsqueda por nombre del producto.
        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        // Aplica el filtro por categoría.
        if ($category) {
            $query->where('category_id', $category);
        }

        // Obtiene los productos más recientes primero.
        $products = $query
            ->latest()
            ->get();

        // Obtiene las categorías disponibles para el filtro.
        $categories = Category::orderBy('name')->get();

        return view('cliente.catalog', compact(
            'products',
            'categories',
            'search',
            'category'
        ));
    }

    /**
     * Muestra las compras realizadas por el cliente autenticado.
     */
    public function purchases(Request $request)
    {
        // Obtiene únicamente las ventas del cliente autenticado.
        $orders = Order::where('user_id', $request->user()->id)
            ->latest()
            ->get();

        return view('cliente.purchases', compact('orders'));
    }

    /**
     * Muestra el detalle de una compra del cliente autenticado.
     */
    public function purchaseShow(Request $request, Order $order)
    {
        // Impide que un cliente consulte compras de otro usuario.
        if ($order->user_id !== $request->user()->id) {
            abort(
                403,
                'No tienes autorización para consultar esta compra.'
            );
        }

        // Carga los productos incluidos en la compra.
        $order->load('items.product');

        return view('cliente.purchase-show', compact('order'));
    }
}




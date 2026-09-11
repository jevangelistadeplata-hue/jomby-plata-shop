<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    /**
     * Muestra el listado de ventas.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $query = Order::with([
            'user',
            'items.product',
        ]);

        // Permite buscar por número de venta o cliente.
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        // Permite filtrar las ventas por estado.
        if ($status) {
            $query->where('status', $status);
        }

        $orders = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.sales.index', compact(
            'orders',
            'search',
            'status'
        ));
    }
}
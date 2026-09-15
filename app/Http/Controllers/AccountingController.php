<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;

class AccountingController extends Controller
{
    /**
     * Muestra el resumen básico de contabilidad.
     */
    public function index()
    {
        // Calcula el total de ventas registradas.
        $totalSales = Order::sum('total');

        // Calcula el costo total de los productos vendidos.
        $costOfSales = OrderItem::selectRaw(
            'SUM(cost_price * quantity) as total_cost'
        )->value('total_cost') ?? 0;

        // Calcula la utilidad bruta.
        $grossProfit = $totalSales - $costOfSales;

        // Calcula el margen bruto.
        $grossMargin = $totalSales > 0
            ? ($grossProfit / $totalSales) * 100
            : 0;

        return view('admin.accounting.index', compact(
            'totalSales',
            'costOfSales',
            'grossProfit',
            'grossMargin'
        ));
    }
}


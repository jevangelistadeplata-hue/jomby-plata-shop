<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductReturn;

class AccountingController extends Controller
{
    /**
     * Muestra el resumen básico de contabilidad.
     */
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Ventas
        |--------------------------------------------------------------------------
        */

        $orders = Order::with([
            'user',
            'items.product',
        ])
            ->latest()
            ->get();

        // Total de ventas registradas.
        $totalSales = $orders->sum('total');


        /*
        |--------------------------------------------------------------------------
        | Devoluciones completadas
        |--------------------------------------------------------------------------
        */

        $completedReturns = ProductReturn::with([
            'order.user',
            'product',
        ])
            ->where('status', 'completed')
            ->latest()
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Cálculo del valor de las devoluciones
        |--------------------------------------------------------------------------
        */

        $totalReturns = 0;
        $returnedCost = 0;

        foreach ($completedReturns as $return) {

            $orderItem = OrderItem::where('order_id', $return->order_id)
                ->where('product_id', $return->product_id)
                ->first();

            if ($orderItem) {

                // Valor de venta de los productos devueltos.
                $totalReturns +=
                    (float) $orderItem->unit_price * (int) $return->quantity;

                // Costo de los productos devueltos.
                $returnedCost +=
                    (float) $orderItem->cost_price * (int) $return->quantity;
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Ventas netas
        |--------------------------------------------------------------------------
        */

        $netSales = $totalSales - $totalReturns;


        /*
        |--------------------------------------------------------------------------
        | Costo de ventas
        |--------------------------------------------------------------------------
        */

        $costOfSales = OrderItem::selectRaw(
            'SUM(cost_price * quantity) as total_cost'
        )->value('total_cost') ?? 0;

        // Se resta el costo correspondiente a las devoluciones completadas.
        $netCostOfSales = (float) $costOfSales - $returnedCost;


        /*
        |--------------------------------------------------------------------------
        | Utilidad bruta
        |--------------------------------------------------------------------------
        */

        $grossProfit = $netSales - $netCostOfSales;


        /*
        |--------------------------------------------------------------------------
        | Margen bruto
        |--------------------------------------------------------------------------
        */

        $grossMargin = $netSales > 0
            ? ($grossProfit / $netSales) * 100
            : 0;


        /*
        |--------------------------------------------------------------------------
        | Detalle de ventas
        |--------------------------------------------------------------------------
        */

        $salesDetails = $orders->map(function ($order) use ($completedReturns) {

            // Costo original de todos los productos de la venta.
            $cost = $order->items->sum(function ($item) {
                return (float) $item->cost_price * (int) $item->quantity;
            });


            // Devoluciones completadas correspondientes a esta venta.
            $returnsForOrder = $completedReturns->where(
                'order_id',
                $order->id
            );


            $returnAmount = 0;
            $returnedCostForOrder = 0;


            foreach ($returnsForOrder as $return) {

                $item = $order->items->firstWhere(
                    'product_id',
                    $return->product_id
                );

                if ($item) {

                    // Valor de venta de la devolución.
                    $returnAmount +=
                        (float) $item->unit_price * (int) $return->quantity;

                    // Costo de los productos devueltos.
                    $returnedCostForOrder +=
                        (float) $item->cost_price * (int) $return->quantity;
                }
            }


            // Venta neta después de las devoluciones.
            $netTotal = (float) $order->total - $returnAmount;


            // Costo neto después de las devoluciones.
            $netCost = $cost - $returnedCostForOrder;


            // Utilidad real de la venta después de las devoluciones.
            $profit = $netTotal - $netCost;


            return (object) [

                'id' => $order->id,

                'order_number' => $order->order_number,

                'created_at' => $order->created_at,

                'customer' => $order->user?->name
                    ?? 'Cliente no disponible',

                'total' => (float) $order->total,

                'returns' => $returnAmount,

                'net_total' => $netTotal,

                'cost' => $netCost,

                'profit' => $profit,

            ];
        });


        /*
        |--------------------------------------------------------------------------
        | Detalle de devoluciones
        |--------------------------------------------------------------------------
        */

        $returnsDetails = $completedReturns->map(function ($return) {

            $orderItem = OrderItem::where('order_id', $return->order_id)
                ->where('product_id', $return->product_id)
                ->first();


            $amount = 0;
            $cost = 0;


            if ($orderItem) {

                $amount =
                    (float) $orderItem->unit_price * (int) $return->quantity;

                $cost =
                    (float) $orderItem->cost_price * (int) $return->quantity;
            }


            return (object) [

                'id' => $return->id,

                'created_at' => $return->created_at,

                'order_number' => $return->order?->order_number
                    ?? 'N/A',

                'customer' => $return->order?->user?->name
                    ?? 'Cliente no disponible',

                'product' => $return->product?->name
                    ?? 'Producto no disponible',

                'quantity' => $return->quantity,

                'amount' => $amount,

                'cost' => $cost,

                'status' => $return->status,

            ];
        });


        /*
        |--------------------------------------------------------------------------
        | Vista
        |--------------------------------------------------------------------------
        */

        return view('admin.accounting.index', compact(

            'totalSales',

            'totalReturns',

            'netSales',

            'costOfSales',

            'netCostOfSales',

            'returnedCost',

            'grossProfit',

            'grossMargin',

            'salesDetails',

            'returnsDetails'

        ));
    }
}
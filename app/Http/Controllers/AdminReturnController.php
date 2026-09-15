<?php

namespace App\Http\Controllers;

use App\Models\ProductReturn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminReturnController extends Controller
{
    /**
     * Muestra las solicitudes de devolución.
     */
    public function index(Request $request)
    {
        // Obtiene el filtro de estado seleccionado.
        $status = $request->input('status');

        // Construye la consulta con las relaciones necesarias.
        $query = ProductReturn::with([
            'order',
            'user',
            'product',
        ]);

        // Filtra las solicitudes por estado cuando se indique.
        if ($status) {
            $query->where('status', $status);
        }

        // Obtiene las solicitudes más recientes primero.
        $returns = $query
            ->latest()
            ->get();

        return view('admin.returns.index', compact(
            'returns',
            'status'
        ));
    }

    /**
     * Aprueba una solicitud de devolución y restaura el inventario.
     */
    public function approve(ProductReturn $return)
    {
        // Impide procesar nuevamente una devolución ya procesada.
        if ($return->status !== 'pending') {
            return back()->with(
                'error',
                'Esta solicitud de devolución ya fue procesada.'
            );
        }

        DB::transaction(function () use ($return) {

            // Obtiene el producto relacionado con la devolución.
            $product = $return->product;

            // Aumenta el inventario con la cantidad devuelta.
            $product->increment('stock', $return->quantity);

            // Marca la devolución como completada.
            $return->update([
                'status' => 'completed',
                'processed_at' => now(),
            ]);
        });

        return back()->with(
            'success',
            'La devolución fue aprobada, el inventario fue actualizado y la solicitud quedó completada.'
        );
    }

    /**
     * Rechaza una solicitud de devolución.
     */
    public function reject(ProductReturn $return)
    {
        // Impide rechazar una solicitud que ya fue procesada.
        if ($return->status !== 'pending') {
            return back()->with(
                'error',
                'Esta solicitud de devolución ya fue procesada.'
            );
        }

        // Marca la solicitud como rechazada.
        $return->update([
            'status' => 'rejected',
            'processed_at' => now(),
        ]);

        return back()->with(
            'success',
            'La solicitud de devolución fue rechazada correctamente.'
        );
    }
}





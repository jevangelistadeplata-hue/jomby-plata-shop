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
     * Aprueba una solicitud de devolución.
     */
    public function approve(ProductReturn $return)
    {
        // Solo se pueden aprobar solicitudes pendientes.
        if ($return->status !== 'pending') {
            return back()->with(
                'error',
                'Esta solicitud no está pendiente y no puede ser aprobada.'
            );
        }

        // Cambia la solicitud a estado aprobada.
        $return->update([
            'status' => 'approved',
        ]);

        return back()->with(
            'success',
            'La solicitud de devolución fue aprobada correctamente. Ahora debe completarse cuando la devolución se haya realizado.'
        );
    }

    /**
     * Completa una devolución aprobada y restaura el inventario.
     */
    public function complete(ProductReturn $return)
    {
        // Solo se pueden completar devoluciones aprobadas.
        if ($return->status !== 'approved') {
            return back()->with(
                'error',
                'Solo se pueden completar devoluciones que hayan sido aprobadas.'
            );
        }

        DB::transaction(function () use ($return) {

            // Obtiene el producto relacionado con la devolución.
            $product = $return->product;

            // Restaura el inventario con la cantidad devuelta.
            $product->increment('stock', $return->quantity);

            // Marca la devolución como completada.
            $return->update([
                'status' => 'completed',
                'processed_at' => now(),
            ]);
        });

        return back()->with(
            'success',
            'La devolución fue completada, el inventario fue actualizado correctamente y ahora afecta la contabilidad.'
        );
    }

    /**
     * Rechaza una solicitud de devolución.
     */
    public function reject(ProductReturn $return)
    {
        // Solo se pueden rechazar solicitudes pendientes.
        if ($return->status !== 'pending') {
            return back()->with(
                'error',
                'Esta solicitud ya fue procesada y no puede ser rechazada.'
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




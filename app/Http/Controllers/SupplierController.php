<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Muestra el listado de proveedores.
     */
    public function index(Request $request)
    {
        // Obtiene los valores enviados desde el formulario de búsqueda y filtro.
        $search = $request->input('search');

        $status = $request->input('status');

        // Construye la consulta de proveedores junto con el usuario relacionado.
        $query = Supplier::with('user');

        // Aplica la búsqueda por nombre, correo o empresa.
        if ($search) {
            $query->where(function ($q) use ($search) {

                $q->where('business_name', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {

                        $userQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");

                    });

            });
        }

        // Aplica el filtro por estado.
        if ($status) {
            $query->where('status', $status);
        }

        // Obtiene los proveedores más recientes primero.
        $suppliers = $query
            ->latest()
            ->get();

        return view('admin.suppliers.index', compact(
            'suppliers',
            'search',
            'status'
        ));
    }

    /**
     * Aprueba un proveedor.
     */
    public function approve(Supplier $supplier)
    {
        // Cambia el estado del proveedor a aprobado.
        $supplier->update([
            'status' => 'approved',
        ]);

        return redirect()
            ->route('admin.suppliers.index')
            ->with('success', 'El proveedor fue aprobado correctamente.');
    }

    /**
     * Rechaza un proveedor.
     */
    public function reject(Supplier $supplier)
    {
        // Cambia el estado del proveedor a rechazado.
        $supplier->update([
            'status' => 'rejected',
        ]);

        return redirect()
            ->route('admin.suppliers.index')
            ->with('success', 'El proveedor fue rechazado correctamente.');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Muestra el listado de proveedores para el administrador.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $query = Supplier::with('user');

        // Filtrado por empresa, teléfono o datos del usuario asociado.
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('business_name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        // Filtrado por estado de aprobación.
        if ($status) {
            $query->where('status', $status);
        }

        $suppliers = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.suppliers.index', compact(
            'suppliers',
            'search',
            'status'
        ));
    }

    /**
     * Aprueba la solicitud de un proveedor.
     */
    public function approve(Supplier $supplier)
    {
        $supplier->update([
            'status' => 'approved',
        ]);

        return redirect()
            ->back()
            ->with('success', 'El proveedor ha sido aprobado correctamente.');
    }

    /**
     * Rechaza la solicitud de un proveedor.
     */
    public function reject(Supplier $supplier)
    {
        $supplier->update([
            'status' => 'rejected',
        ]);

        return redirect()
            ->back()
            ->with('success', 'El proveedor ha sido rechazado.');
    }
}

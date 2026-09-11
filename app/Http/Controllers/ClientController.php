<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Muestra el listado de clientes.
     */
    public function index(Request $request)
    {
        // Obtiene el texto utilizado para la búsqueda.
        $search = $request->input('search');

        // Construye la consulta mostrando solamente usuarios con rol Cliente.
        $query = User::with('role')
            ->whereHas('role', function ($roleQuery) {
                $roleQuery->where('name', 'Cliente');
            });

        // Aplica la búsqueda por nombre o correo electrónico.
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Obtiene los clientes más recientes primero.
        $clients = $query->latest()->get();

        return view('admin.clients.index', compact(
            'clients',
            'search'
        ));
    }
}
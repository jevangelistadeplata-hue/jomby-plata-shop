<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;

class AdminController extends Controller
{
    /**
     * Muestra el dashboard del administrador.
     */
    public function dashboard()
    {
        // Obtiene los principales datos que se mostrarán en el dashboard.
        $totalUsers = User::count();

        $totalSuppliers = Supplier::count();

        $totalProducts = Product::count();

        // Cuenta solamente los usuarios que tienen el rol Cliente.
        $totalClients = User::whereHas('role', function ($query) {
            $query->where('name', 'Cliente');
        })->count();

        // Obtiene las cantidades que requieren atención del administrador.
        $pendingSuppliers = Supplier::where('status', 'pending')->count();

        $pendingProducts = Product::where('status', 'pending')->count();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalSuppliers',
            'totalProducts',
            'totalClients',
            'pendingSuppliers',
            'pendingProducts'
        ));
    }
}
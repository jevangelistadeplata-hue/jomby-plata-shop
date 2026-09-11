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
        $pendingSuppliers = Supplier::where('status', 'pending')->count();
        $totalProducts = Product::count();
        $pendingProducts = Product::where('status', 'pending')->count();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalSuppliers',
            'pendingSuppliers',
            'totalProducts',
            'pendingProducts'
        ));
    }
}
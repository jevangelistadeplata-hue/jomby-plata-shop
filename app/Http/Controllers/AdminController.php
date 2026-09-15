<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
use Carbon\Carbon;

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

        // Calcula las ventas realizadas durante el día actual.
        $salesToday = Order::whereDate('created_at', today())
            ->sum('total');

        // Calcula las ventas realizadas durante el mes actual.
        $salesMonth = Order::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->sum('total');

        // Calcula el ticket promedio de las ventas registradas.
        $averageTicket = Order::avg('total') ?? 0;

        // Prepara las fechas de los últimos siete días.
        $salesChartLabels = [];
        $salesChartData = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);

            $salesChartLabels[] = $date->translatedFormat('D d');

            $salesChartData[] = Order::whereDate('created_at', $date)
                ->sum('total');
        }

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalSuppliers',
            'totalProducts',
            'totalClients',
            'pendingSuppliers',
            'pendingProducts',
            'salesToday',
            'salesMonth',
            'averageTicket',
            'salesChartLabels',
            'salesChartData'
        ));
    }
}

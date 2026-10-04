<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Muestra el dashboard del administrador.
     */
    public function dashboard(Request $request)
    {
        // Datos generales del dashboard.
        $totalUsers = User::count();

        $totalSuppliers = Supplier::count();

        $totalProducts = Product::count();

        // Cuenta solamente los usuarios que tienen el rol Cliente.
        $totalClients = User::whereHas('role', function ($query) {
            $query->where('name', 'Cliente');
        })->count();

        // Cantidades que requieren atención del administrador.
        $pendingSuppliers = Supplier::where('status', 'pending')->count();

        $pendingProducts = Product::where('status', 'pending')->count();

        // Ventas realizadas durante el día actual.
        $salesToday = Order::whereDate('created_at', today())
            ->sum('total');

        // Ventas realizadas durante el mes actual.
        $salesMonth = Order::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->sum('total');

        // Ticket promedio de las ventas registradas.
        $averageTicket = Order::avg('total') ?? 0;

        /*
         * Filtro del gráfico de ventas.
         *
         * Opciones:
         * 1m     = Último mes
         * 2m     = 2 últimos meses
         * 3m     = 3 últimos meses
         * custom = Rango de fecha personalizado
         */
        $range = $request->input('range', '1m');

        if (!in_array($range, ['1m', '2m', '3m', 'custom'])) {
            $range = '1m';
        }

        $today = Carbon::today();

        if ($range === '2m') {
            $startDate = $today->copy()->subMonths(2);
            $endDate = $today->copy();
        } elseif ($range === '3m') {
            $startDate = $today->copy()->subMonths(3);
            $endDate = $today->copy();
        } elseif ($range === 'custom') {
            $request->validate([
                'date_from' => ['required', 'date'],
                'date_to' => ['required', 'date', 'after_or_equal:date_from'],
            ]);

            $startDate = Carbon::parse($request->input('date_from'));
            $endDate = Carbon::parse($request->input('date_to'));
        } else {
            // Último mes.
            $startDate = $today->copy()->subMonth();
            $endDate = $today->copy();
            $range = '1m';
        }

        // Consulta todas las ventas del período en una sola consulta.
        $salesByDate = Order::query()
            ->whereBetween('created_at', [
                $startDate->copy()->startOfDay(),
                $endDate->copy()->endOfDay(),
            ])
            ->selectRaw('DATE(created_at) as sale_date, SUM(total) as total')
            ->groupBy('sale_date')
            ->orderBy('sale_date')
            ->pluck('total', 'sale_date');

        // Prepara las fechas y valores que utilizará el gráfico.
        $salesChartLabels = [];
        $salesChartData = [];

        $currentDate = $startDate->copy()->startOfDay();
        $lastDate = $endDate->copy()->startOfDay();

        while ($currentDate->lte($lastDate)) {
            $dateKey = $currentDate->toDateString();

            $salesChartLabels[] = $currentDate->format('d/m');

            $salesChartData[] = (float) ($salesByDate[$dateKey] ?? 0);

            $currentDate->addDay();
        }

        // Título dinámico del gráfico.
        if ($range === '2m') {
            $salesChartTitle = 'Ventas — últimos 2 meses';
        } elseif ($range === '3m') {
            $salesChartTitle = 'Ventas — últimos 3 meses';
        } elseif ($range === 'custom') {
            $salesChartTitle = 'Ventas — del '
                . $startDate->format('d/m/Y')
                . ' al '
                . $endDate->format('d/m/Y');
        } else {
            $salesChartTitle = 'Ventas — último mes';
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
            'salesChartData',
            'salesChartTitle',
            'range',
            'startDate',
            'endDate'
        ));
    }
}
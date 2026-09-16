@extends('layouts.app')

@section('title', 'Contabilidad')

@section('content')
    {{-- Encabezado --}}
    <div class="mb-4">
        <h1 class="h3 fw-bold mb-1">
            Contabilidad
        </h1>
        <p class="text-muted mb-0">
            Resumen básico de las operaciones de venta y devolución.
        </p>
    </div>

    {{-- Resumen contable --}}
    <div class="row g-4 mb-4">

        {{-- Ventas totales --}}
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <p class="text-muted mb-2">
                        Ventas totales
                    </p>
                    <h2 class="h4 fw-bold mb-0">
                        RD$ {{ number_format($totalSales, 2) }}
                    </h2>
                </div>
            </div>
        </div>

        {{-- Devoluciones --}}
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <p class="text-muted mb-2">
                        Devoluciones
                    </p>
                    <h2 class="h4 fw-bold mb-0">
                        RD$ {{ number_format($totalReturns, 2) }}
                    </h2>
                </div>
            </div>
        </div>

        {{-- Ventas netas --}}
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <p class="text-muted mb-2">
                        Ventas netas
                    </p>
                    <h2 class="h4 fw-bold mb-0">
                        RD$ {{ number_format($netSales, 2) }}
                    </h2>
                </div>
            </div>
        </div>

        {{-- Costo de ventas --}}
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <p class="text-muted mb-2">
                        Costo de ventas
                    </p>
                    <h2 class="h4 fw-bold mb-0">
                        RD$ {{ number_format($netCostOfSales, 2) }}
                    </h2>
                </div>
            </div>
        </div>

    </div>

    {{-- Utilidad --}}
    <div class="row g-4 mb-5">

        {{-- Utilidad bruta --}}
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <p class="text-muted mb-2">
                        Utilidad bruta
                    </p>
                    <h2 class="h4 fw-bold text-success mb-0">
                        RD$ {{ number_format($grossProfit, 2) }}
                    </h2>
                </div>
            </div>
        </div>

        {{-- Margen bruto --}}
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <p class="text-muted mb-2">
                        Margen bruto
                    </p>
                    <h2 class="h4 fw-bold text-primary mb-0">
                        {{ number_format($grossMargin, 2) }}%
                    </h2>
                </div>
            </div>
        </div>

    </div>

    {{-- Detalle de ventas --}}
    <div class="mb-3">
        <h5 class="fw-bold">
            Detalle de ventas
        </h5>
        <p class="text-muted small mb-0">
            Resumen de las ventas registradas y su utilidad.
        </p>
    </div>

    <div class="card border-0 shadow-sm mb-5">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Fecha</th>
                            <th>Venta</th>
                            <th>Cliente</th>
                            <th class="text-end">Venta</th>
                            <th class="text-end">Devolución</th>
                            <th class="text-end">Venta neta</th>
                            <th class="text-end">Costo</th>
                            <th class="text-end pe-4">Utilidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($salesDetails as $sale)
                            <tr>
                                <td class="ps-4">
                                    {{ $sale->created_at->format('d/m/Y') }}
                                </td>
                                <td>
                                    <span class="fw-semibold">
                                        {{ $sale->order_number }}
                                    </span>
                                </td>
                                <td>
                                    {{ $sale->customer }}
                                </td>
                                <td class="text-end">
                                    RD$ {{ number_format($sale->total, 2) }}
                                </td>
                                <td class="text-end">
                                    RD$ {{ number_format($sale->returns, 2) }}
                                </td>
                                <td class="text-end fw-semibold">
                                    RD$ {{ number_format($sale->net_total, 2) }}
                                </td>
                                <td class="text-end">
                                    RD$ {{ number_format($sale->cost, 2) }}
                                </td>
                                <td class="text-end pe-4 fw-semibold">
                                    RD$ {{ number_format($sale->profit, 2) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">
                                    No hay ventas registradas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Devoluciones aprobadas --}}
    <div class="mb-3">
        <h5 class="fw-bold">
            Devoluciones aprobadas
        </h5>
        <p class="text-muted small mb-0">
            Devoluciones que afectan los resultados contables.
        </p>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Fecha</th>
                            <th>Venta</th>
                            <th>Cliente</th>
                            <th>Producto</th>
                            <th class="text-center">Cantidad</th>
                            <th class="text-end pe-4">Monto</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($returnsDetails as $return)
                            <tr>
                                <td class="ps-4">
                                    {{ $return->created_at->format('d/m/Y') }}
                                </td>
                                <td>
                                    <span class="fw-semibold">
                                        {{ $return->order_number }}
                                    </span>
                                </td>
                                <td>
                                    {{ $return->customer }}
                                </td>
                                <td>
                                    {{ $return->product }}
                                </td>
                                <td class="text-center">
                                    {{ $return->quantity }}
                                </td>
                                <td class="text-end pe-4 fw-semibold text-danger">
                                    RD$ {{ number_format($return->amount, 2) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    No hay devoluciones aprobadas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection


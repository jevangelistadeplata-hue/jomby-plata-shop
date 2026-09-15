@extends('layouts.app')

@section('content')

<div class="container py-4">

    {{-- Encabezado --}}
    <div class="mb-4">

        <h1 class="h3 mb-1">
            Contabilidad
        </h1>

        <p class="text-muted mb-0">
            Resumen básico de las operaciones de venta.
        </p>

    </div>

    {{-- Resumen contable --}}
    <div class="row g-4">

        {{-- Ventas --}}
        <div class="col-md-6 col-xl-3">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <p class="text-muted mb-2">
                        Ventas totales
                    </p>

                    <h2 class="h4 mb-0">
                        RD$ {{ number_format($totalSales, 2) }}
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

                    <h2 class="h4 mb-0">
                        RD$ {{ number_format($costOfSales, 2) }}
                    </h2>

                </div>

            </div>

        </div>

        {{-- Utilidad bruta --}}
        <div class="col-md-6 col-xl-3">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <p class="text-muted mb-2">
                        Utilidad bruta
                    </p>

                    <h2 class="h4 mb-0">
                        RD$ {{ number_format($grossProfit, 2) }}
                    </h2>

                </div>

            </div>

        </div>

        {{-- Margen bruto --}}
        <div class="col-md-6 col-xl-3">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <p class="text-muted mb-2">
                        Margen bruto
                    </p>

                    <h2 class="h4 mb-0">
                        {{ number_format($grossMargin, 2) }}%
                    </h2>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection


@extends('layouts.app')

@section('title', 'Dashboard administrativo')

@section('content')

{{-- Encabezado --}}
<div class="mb-4">
    <h1 class="h3 fw-bold">
        Dashboard administrativo
    </h1>

    <p class="text-muted mb-0">
        Resumen general de Jomby Plata Shop.
    </p>
</div>

{{-- Información general del sistema --}}
<div class="row g-4 mb-4">

    {{-- Usuarios --}}
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <h6 class="text-muted">
                    Usuarios
                </h6>

                <h2 class="fw-bold mb-0">
                    {{ number_format($totalUsers) }}
                </h2>
            </div>
        </div>
    </div>

    {{-- Clientes --}}
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <h6 class="text-muted">
                    Clientes
                </h6>

                <h2 class="fw-bold mb-0">
                    {{ number_format($totalClients) }}
                </h2>
            </div>
        </div>
    </div>

    {{-- Proveedores --}}
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <h6 class="text-muted">
                    Proveedores
                </h6>

                <h2 class="fw-bold mb-0">
                    {{ number_format($totalSuppliers) }}
                </h2>
            </div>
        </div>
    </div>

    {{-- Productos --}}
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <h6 class="text-muted">
                    Productos
                </h6>

                <h2 class="fw-bold mb-0">
                    {{ number_format($totalProducts) }}
                </h2>
            </div>
        </div>
    </div>

</div>

{{-- Información de ventas --}}
<div class="mb-3">
    <h5 class="fw-bold">
        Ventas
    </h5>
</div>

<div class="row g-4 mb-4">

    {{-- Ventas de hoy --}}
    <div class="col-md-6 col-xl-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <h6 class="text-muted">
                    Ventas de hoy
                </h6>

                <h2 class="fw-bold mb-0">
                    RD$ {{ number_format($salesToday, 2) }}
                </h2>
            </div>
        </div>
    </div>

    {{-- Ventas del mes --}}
    <div class="col-md-6 col-xl-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <h6 class="text-muted">
                    Ventas del mes
                </h6>

                <h2 class="fw-bold mb-0">
                    RD$ {{ number_format($salesMonth, 2) }}
                </h2>
            </div>
        </div>
    </div>

    {{-- Ticket promedio --}}
    <div class="col-md-6 col-xl-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <h6 class="text-muted">
                    Ticket promedio
                </h6>

                <h2 class="fw-bold mb-0">
                    RD$ {{ number_format($averageTicket, 2) }}
                </h2>
            </div>
        </div>
    </div>

</div>

{{-- Gráfico de ventas --}}
<div class="row g-4 mb-4">

    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body">

                <h5 class="fw-bold mb-1">
                    Ventas — últimos 7 días
                </h5>

                <p class="text-muted small mb-4">
                    Total de ventas registradas por día.
                </p>

                <div
                    id="salesChartContainer"
                    data-labels="{{ implode('|', $salesChartLabels ?? []) }}"
                    data-values="{{ implode('|', $salesChartData ?? []) }}"
                    style="height: 320px;"
                >
                    <canvas
                        id="salesChart"
                        aria-label="Gráfico de ventas de los últimos 7 días"
                        role="img"
                    ></canvas>
                </div>

            </div>
        </div>
    </div>

</div>

{{-- Información que requiere atención del administrador --}}
<div class="mb-3">
    <h5 class="fw-bold">
        Pendientes de aprobación
    </h5>
</div>

<div class="row g-4">

    {{-- Proveedores pendientes --}}
    <div class="col-md-6 col-xl-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <h6 class="text-muted">
                    Proveedores pendientes
                </h6>

                <h2 class="fw-bold mb-0 text-warning">
                    {{ number_format($pendingSuppliers) }}
                </h2>
            </div>
        </div>
    </div>

    {{-- Productos pendientes --}}
    <div class="col-md-6 col-xl-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <h6 class="text-muted">
                    Productos pendientes
                </h6>

                <h2 class="fw-bold mb-0 text-warning">
                    {{ number_format($pendingProducts) }}
                </h2>
            </div>
        </div>
    </div>

</div>

@endsection

@push('scripts')

{{-- Carga Chart.js para mostrar el gráfico de ventas. --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Obtiene el contenedor del gráfico.
    const salesChartContainer = document.getElementById('salesChartContainer');

    // Obtiene las etiquetas de los últimos siete días.
    const salesChartLabels = salesChartContainer.dataset.labels.split('|');

    // Obtiene los valores de ventas.
    const salesChartData = salesChartContainer.dataset.values
        .split('|')
        .map(Number);

    // Obtiene el elemento donde se mostrará el gráfico.
    const salesChartElement = document.getElementById('salesChart');

    // Crea el gráfico de ventas.
    new Chart(salesChartElement, {
        type: 'bar',

        data: {
            labels: salesChartLabels,

            datasets: [{
                label: 'Ventas (RD$)',
                data: salesChartData,
                backgroundColor: '#6c757d',
                borderRadius: 5
            }]
        },

        options: {
            responsive: true,
            maintainAspectRatio: false,

            plugins: {
                legend: {
                    display: false
                }
            },

            scales: {
                y: {
                    beginAtZero: true,

                    ticks: {
                        callback: function(value) {
                            return 'RD$ ' + value.toLocaleString('es-DO');
                        }
                    }
                },

                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
</script>

@endpush
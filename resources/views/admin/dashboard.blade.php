@extends('layouts.app')

@push('styles')
@vite('resources/css/admin_dashboard.css')
@endpush

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

    <div class="card dashboard-card shadow-sm h-100">

        <div class="card-body d-flex align-items-center gap-3">

            <div class="dashboard-icon icon-blue">
                <i class="bi bi-people"></i>
            </div>

            <div>

                <h6 class="text-muted mb-1">
                    Usuarios
                </h6>

                <h2 class="fw-bold mb-0">
                    {{ number_format($totalUsers) }}
                </h2>

            </div>

        </div>

    </div>

</div>


{{-- Clientes --}}

<div class="col-md-6 col-xl-3">

    <div class="card dashboard-card shadow-sm h-100">

        <div class="card-body d-flex align-items-center gap-3">

            <div class="dashboard-icon icon-green">
                <i class="bi bi-person-check"></i>
            </div>

            <div>

                <h6 class="text-muted mb-1">
                    Clientes
                </h6>

                <h2 class="fw-bold mb-0">
                    {{ number_format($totalClients) }}
                </h2>

            </div>

        </div>

    </div>

</div>


{{-- Proveedores --}}

<div class="col-md-6 col-xl-3">

    <div class="card dashboard-card shadow-sm h-100">

        <div class="card-body d-flex align-items-center gap-3">

            <div class="dashboard-icon icon-purple">
                <i class="bi bi-truck"></i>
            </div>

            <div>

                <h6 class="text-muted mb-1">
                    Proveedores
                </h6>

                <h2 class="fw-bold mb-0">
                    {{ number_format($totalSuppliers) }}
                </h2>

            </div>

        </div>

    </div>

</div>


{{-- Productos --}}

<div class="col-md-6 col-xl-3">

    <div class="card dashboard-card shadow-sm h-100">

        <div class="card-body d-flex align-items-center gap-3">

            <div class="dashboard-icon icon-orange">
                <i class="bi bi-box-seam"></i>
            </div>

            <div>

                <h6 class="text-muted mb-1">
                    Productos
                </h6>

                <h2 class="fw-bold mb-0">
                    {{ number_format($totalProducts) }}
                </h2>

            </div>

        </div>

    </div>

</div>

</div>

{{-- Información de ventas --}}

<div class="mb-3">

<h5 class="section-title">
    Ventas
</h5>

</div>

<div class="row g-4 mb-4">

{{-- Ventas de hoy --}}

<div class="col-md-6 col-xl-4">

    <div class="card dashboard-card shadow-sm h-100">

        <div class="card-body d-flex align-items-center gap-3">

            <div class="dashboard-icon icon-green">
                <i class="bi bi-cash-stack"></i>
            </div>

            <div>

                <h6 class="text-muted mb-1">
                    Ventas de hoy
                </h6>

                <h2 class="fw-bold mb-0">
                    RD$ {{ number_format($salesToday, 2) }}
                </h2>

            </div>

        </div>

    </div>

</div>


{{-- Ventas del mes --}}

<div class="col-md-6 col-xl-4">

    <div class="card dashboard-card shadow-sm h-100">

        <div class="card-body d-flex align-items-center gap-3">

            <div class="dashboard-icon icon-blue">
                <i class="bi bi-graph-up-arrow"></i>
            </div>

            <div>

                <h6 class="text-muted mb-1">
                    Ventas del mes
                </h6>

                <h2 class="fw-bold mb-0">
                    RD$ {{ number_format($salesMonth, 2) }}
                </h2>

            </div>

        </div>

    </div>

</div>


{{-- Ticket promedio --}}

<div class="col-md-6 col-xl-4">

    <div class="card dashboard-card shadow-sm h-100">

        <div class="card-body d-flex align-items-center gap-3">

            <div class="dashboard-icon icon-purple">
                <i class="bi bi-receipt"></i>
            </div>

            <div>

                <h6 class="text-muted mb-1">
                    Ticket promedio
                </h6>

                <h2 class="fw-bold mb-0">
                    RD$ {{ number_format($averageTicket, 2) }}
                </h2>

            </div>

        </div>

    </div>

</div>

</div>

{{-- Gráfico de ventas --}}

<div class="row g-4 mb-4">

<div class="col-12">

    <div class="card chart-card shadow-sm">

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

<h5 class="section-title">
    Pendientes de aprobación
</h5>

</div>

<div class="row g-4">

{{-- Proveedores pendientes --}}

<div class="col-md-6 col-xl-4">

    <div class="card dashboard-card shadow-sm h-100">

        <div class="card-body d-flex align-items-center gap-3">

            <div class="dashboard-icon icon-yellow">
                <i class="bi bi-hourglass-split"></i>
            </div>

            <div>

                <h6 class="text-muted mb-1">
                    Proveedores pendientes
                </h6>

                <h2 class="fw-bold mb-0 text-warning">
                    {{ number_format($pendingSuppliers) }}
                </h2>

            </div>

        </div>

    </div>

</div>


{{-- Productos pendientes --}}

<div class="col-md-6 col-xl-4">

    <div class="card dashboard-card shadow-sm h-100">

        <div class="card-body d-flex align-items-center gap-3">

            <div class="dashboard-icon icon-yellow">
                <i class="bi bi-box"></i>
            </div>

            <div>

                <h6 class="text-muted mb-1">
                    Productos pendientes
                </h6>

                <h2 class="fw-bold mb-0 text-warning">
                    {{ number_format($pendingProducts) }}
                </h2>

            </div>

        </div>

    </div>

</div>

</div>

@endsection

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script> const salesChartContainer = document.getElementById('salesChartContainer'); const salesChartLabels = salesChartContainer.dataset.labels.split('|'); const salesChartData = salesChartContainer.dataset.values .split('|') .map(Number); const salesChartElement = document.getElementById('salesChart'); const chartContext = salesChartElement.getContext('2d'); const gradient = chartContext.createLinearGradient(0, 0, 0, 320); gradient.addColorStop(0, 'rgba(13, 110, 253, 0.85)'); gradient.addColorStop(1, 'rgba(13, 110, 253, 0.25)'); new Chart(salesChartElement, { type: 'bar', data: { labels: salesChartLabels, datasets: [{ label: 'Ventas (RD$)', data: salesChartData, backgroundColor: gradient, borderColor: '#0d6efd', borderWidth: 1, borderRadius: 8, borderSkipped: false }] }, options: { responsive: true, maintainAspectRatio: false, interaction: { intersect: false, mode: 'index' }, plugins: { legend: { display: false }, tooltip: { callbacks: { label: function(context) { return 'RD$ ' + Number(context.raw).toLocaleString('es-DO', { minimumFractionDigits: 2, maximumFractionDigits: 2 }); } } } }, scales: { y: { beginAtZero: true, grid: { color: 'rgba(0, 0, 0, 0.06)' }, ticks: { callback: function(value) { return 'RD$ ' + Number(value).toLocaleString('es-DO'); } } }, x: { grid: { display: false } } } } }); </script>

@endpush
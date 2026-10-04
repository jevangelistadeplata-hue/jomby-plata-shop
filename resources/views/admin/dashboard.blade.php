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

                <div class="d-flex flex-column flex-lg-row justify-content-between gap-3 mb-4">

                    <div>

                        <h5 class="fw-bold mb-1">
                            {{ $salesChartTitle }}
                        </h5>

                        <p class="text-muted small mb-0">
                            Total de ventas registradas por día.
                        </p>

                    </div>


                    {{-- Selector de período --}}

                    <div style="min-width: 220px;">

                        <label
                            for="salesRange"
                            class="form-label small fw-semibold mb-1"
                        >
                            Rango de fecha
                        </label>

                        <select
                            id="salesRange"
                            class="form-select"
                            onchange="changeSalesRange(this.value)"
                        >

                            <option
                                value="1m"
                                {{ $range === '1m' ? 'selected' : '' }}
                            >
                                Último mes
                            </option>

                            <option
                                value="2m"
                                {{ $range === '2m' ? 'selected' : '' }}
                            >
                                2 últimos meses
                            </option>

                            <option
                                value="3m"
                                {{ $range === '3m' ? 'selected' : '' }}
                            >
                                3 últimos meses
                            </option>

                            <option
                                value="custom"
                                {{ $range === 'custom' ? 'selected' : '' }}
                            >
                                Rango de fecha
                            </option>

                        </select>

                    </div>

                </div>


                {{-- Rango de fecha personalizado --}}

                <div
                    id="customDateRange"
                    class="row g-3 mb-4 {{ $range === 'custom' ? '' : 'd-none' }}"
                >

                    <div class="col-md-6">

                        <label
                            for="dateFrom"
                            class="form-label small fw-semibold"
                        >
                            Desde
                        </label>

                        <input
                            type="date"
                            id="dateFrom"
                            class="form-control"
                            value="{{ $range === 'custom' ? $startDate->format('Y-m-d') : '' }}"
                            max="{{ now()->format('Y-m-d') }}"
                            onchange="updateCustomDateRange()"
                        >

                    </div>


                    <div class="col-md-6">

                        <label
                            for="dateTo"
                            class="form-label small fw-semibold"
                        >
                            Hasta
                        </label>

                        <input
                            type="date"
                            id="dateTo"
                            class="form-control"
                            value="{{ $range === 'custom' ? $endDate->format('Y-m-d') : '' }}"
                            max="{{ now()->format('Y-m-d') }}"
                            onchange="updateCustomDateRange()"
                        >

                    </div>

                </div>


                {{-- Contenedor del gráfico --}}

                <div
                    id="salesChartContainer"
                    data-labels="{{ implode('|', $salesChartLabels ?? []) }}"
                    data-values="{{ implode('|', $salesChartData ?? []) }}"
                    style="height: 320px;"
                >

                    <canvas
                        id="salesChart"
                        aria-label="{{ $salesChartTitle }}"
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

<script>

    /*
     * Cambia el período del gráfico.
     */
    function changeSalesRange(range) {

        const url = new URL(window.location.href);

        url.searchParams.set('range', range);

        if (range !== 'custom') {
            url.searchParams.delete('date_from');
            url.searchParams.delete('date_to');

            window.location.href = url.toString();

            return;
        }

        document.getElementById('customDateRange').classList.remove('d-none');

        const dateFrom = document.getElementById('dateFrom');
        const dateTo = document.getElementById('dateTo');

        if (!dateFrom.value || !dateTo.value) {

            const today = new Date();

            const oneMonthAgo = new Date();
            oneMonthAgo.setMonth(today.getMonth() - 1);

            dateFrom.value = formatDate(oneMonthAgo);
            dateTo.value = formatDate(today);
        }
    }


    /*
     * Actualiza automáticamente el gráfico
     * cuando se seleccionan las fechas Desde y Hasta.
     */
    function updateCustomDateRange() {

        const dateFrom = document.getElementById('dateFrom').value;
        const dateTo = document.getElementById('dateTo').value;

        if (!dateFrom || !dateTo) {
            return;
        }

        if (dateFrom > dateTo) {

            alert('La fecha Desde no puede ser posterior a la fecha Hasta.');

            return;
        }

        const url = new URL(window.location.href);

        url.searchParams.set('range', 'custom');
        url.searchParams.set('date_from', dateFrom);
        url.searchParams.set('date_to', dateTo);

        window.location.href = url.toString();
    }


    /*
     * Convierte una fecha al formato YYYY-MM-DD.
     */
    function formatDate(date) {

        const year = date.getFullYear();

        const month = String(date.getMonth() + 1).padStart(2, '0');

        const day = String(date.getDate()).padStart(2, '0');

        return `${year}-${month}-${day}`;
    }


    /*
     * Datos del gráfico enviados desde Laravel.
     */
    const salesChartContainer =
        document.getElementById('salesChartContainer');

    const salesChartLabels =
        salesChartContainer.dataset.labels.split('|');

    const salesChartData =
        salesChartContainer.dataset.values
            .split('|')
            .map(Number);


    /*
     * Inicializa el gráfico.
     */
    const salesChartElement =
        document.getElementById('salesChart');

    const chartContext =
        salesChartElement.getContext('2d');


    /*
     * Degradado de las barras.
     */
    const gradient =
        chartContext.createLinearGradient(0, 0, 0, 320);

    gradient.addColorStop(
        0,
        'rgba(13, 110, 253, 0.85)'
    );

    gradient.addColorStop(
        1,
        'rgba(13, 110, 253, 0.25)'
    );


    /*
     * Gráfico Chart.js.
     */
    new Chart(salesChartElement, {

        type: 'bar',

        data: {

            labels: salesChartLabels,

            datasets: [{

                label: 'Ventas (RD$)',

                data: salesChartData,

                backgroundColor: gradient,

                borderColor: '#0d6efd',

                borderWidth: 1,

                borderRadius: 8,

                borderSkipped: false

            }]

        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            interaction: {

                intersect: false,

                mode: 'index'

            },

            plugins: {

                legend: {

                    display: false

                },

                tooltip: {

                    callbacks: {

                        label: function(context) {

                            return 'RD$ ' +
                                Number(context.raw).toLocaleString(
                                    'es-DO',
                                    {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    }
                                );

                        }

                    }

                }

            },

            scales: {

                y: {

                    beginAtZero: true,

                    grid: {

                        color: 'rgba(0, 0, 0, 0.06)'

                    },

                    ticks: {

                        callback: function(value) {

                            return 'RD$ ' +
                                Number(value).toLocaleString('es-DO');

                        }

                    }

                },

                x: {

                    grid: {

                        display: false

                    },

                    ticks: {

                        autoSkip: true,

                        maxTicksLimit: 15

                    }

                }

            }

        }

    });

</script>

@endpush
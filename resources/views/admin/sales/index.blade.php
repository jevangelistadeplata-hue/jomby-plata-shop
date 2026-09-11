@extends('layouts.app')

@section('title', 'Ventas')

@section('content')

    <div class="mb-4">
        <h1 class="h3 fw-bold">
            Ventas
        </h1>

        <p class="text-muted mb-0">
            Gestión de las ventas realizadas en Jomby Plata Shop.
        </p>
    </div>

    {{-- Búsqueda y filtro --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">

            <form method="GET" action="{{ route('admin.sales.index') }}">

                <div class="row g-3 align-items-end">

                    <div class="col-md-6">

                        <label for="search" class="form-label">
                            Buscar venta
                        </label>

                        <input
                            type="text"
                            name="search"
                            id="search"
                            class="form-control"
                            value="{{ $search }}"
                            placeholder="Número de venta, cliente o correo"
                        >

                    </div>

                    <div class="col-md-4">

                        <label for="status" class="form-label">
                            Estado
                        </label>

                        <select
                            name="status"
                            id="status"
                            class="form-select"
                        >
                            <option value="">
                                Todos los estados
                            </option>

                            <option
                                value="pending"
                                {{ $status === 'pending' ? 'selected' : '' }}
                            >
                                Pendiente
                            </option>

                            <option
                                value="confirmed"
                                {{ $status === 'confirmed' ? 'selected' : '' }}
                            >
                                Confirmada
                            </option>

                            <option
                                value="completed"
                                {{ $status === 'completed' ? 'selected' : '' }}
                            >
                                Completada
                            </option>

                            <option
                                value="cancelled"
                                {{ $status === 'cancelled' ? 'selected' : '' }}
                            >
                                Cancelada
                            </option>
                        </select>

                    </div>

                    <div class="col-md-2 d-grid">

                        <button
                            type="submit"
                            class="btn btn-dark"
                        >
                            Buscar
                        </button>

                    </div>

                </div>

            </form>

        </div>
    </div>

    {{-- Listado de ventas --}}
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <strong>Listado de ventas</strong>
            <span class="badge bg-secondary">{{ $orders->total() ?? $orders->count() }} ventas</span>
        </div>

        <div class="card-body p-0">

            @if ($orders->count())

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">

                            <tr>
                                <th>Venta</th>
                                <th>Cliente</th>
                                <th>Productos</th>
                                <th>Subtotal</th>
                                <th>Impuesto</th>
                                <th>Total</th>
                                <th>Estado</th>
                                <th>Fecha</th>
                            </tr>

                        </thead>

                        <tbody>

                            @foreach ($orders as $order)

                                <tr>

                                    <td>
                                        <strong>
                                            {{ $order->order_number }}
                                        </strong>
                                    </td>

                                    <td>

                                        <div>
                                            {{ $order->user->name ?? 'N/A' }}
                                        </div>

                                        <small class="text-muted">
                                            {{ $order->user->email ?? '' }}
                                        </small>

                                    </td>

                                    <td>
                                        <span class="badge bg-light text-dark border">
                                            {{ $order->items->sum('quantity') }}
                                        </span>
                                    </td>

                                    <td>
                                        RD$ {{ number_format($order->subtotal, 2) }}
                                    </td>

                                    <td>
                                        RD$ {{ number_format($order->tax, 2) }}
                                    </td>

                                    <td>
                                        <strong>
                                            RD$ {{ number_format($order->total, 2) }}
                                        </strong>
                                    </td>

                                    <td>

                                        @if ($order->status === 'pending')

                                            <span class="badge bg-warning text-dark">
                                                Pendiente
                                            </span>

                                        @elseif ($order->status === 'confirmed')

                                            <span class="badge bg-primary">
                                                Confirmada
                                            </span>

                                        @elseif ($order->status === 'completed')

                                            <span class="badge bg-success">
                                                Completada
                                            </span>

                                        @elseif ($order->status === 'cancelled')

                                            <span class="badge bg-danger">
                                                Cancelada
                                            </span>

                                        @endif

                                    </td>

                                    <td>
                                        {{ $order->created_at->format('d/m/Y H:i') }}
                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

                {{-- Enlaces de paginación --}}
                @if (method_exists($orders, 'hasPages') && $orders->hasPages())
                    <div class="p-3 border-top d-flex justify-content-end">
                        {{ $orders->links() }}
                    </div>
                @endif

            @else

                <div class="text-center py-5">

                    <h5 class="fw-bold mb-2">
                        No hay ventas registradas
                    </h5>

                    <p class="text-muted mb-0">
                        Cuando se registren ventas aparecerán en este listado.
                    </p>

                </div>

            @endif

        </div>

    </div>

@endsection
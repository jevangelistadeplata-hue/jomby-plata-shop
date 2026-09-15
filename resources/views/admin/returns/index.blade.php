@extends('layouts.app')

@section('title', 'Devoluciones')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h1 class="h3 fw-bold mb-1">
                Devoluciones
            </h1>

            <p class="text-muted mb-0">
                Revisa las solicitudes de devolución realizadas por los clientes.
            </p>
        </div>

    </div>

    {{-- Filtro por estado. --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <form
                action="{{ route('admin.returns.index') }}"
                method="GET"
                class="row g-3 align-items-end"
            >

                <div class="col-md-4">

                    <label
                        for="status"
                        class="form-label fw-semibold"
                    >
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
                            @selected($status === 'pending')
                        >
                            Pendientes
                        </option>

                        <option
                            value="approved"
                            @selected($status === 'approved')
                        >
                            Aprobadas
                        </option>

                        <option
                            value="rejected"
                            @selected($status === 'rejected')
                        >
                            Rechazadas
                        </option>

                        <option
                            value="completed"
                            @selected($status === 'completed')
                        >
                            Completadas
                        </option>

                    </select>

                </div>

                <div class="col-md-auto">

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Filtrar
                    </button>

                </div>

                <div class="col-md-auto">

                    <a
                        href="{{ route('admin.returns.index') }}"
                        class="btn btn-outline-secondary"
                    >
                        Limpiar
                    </a>

                </div>

            </form>

        </div>

    </div>

    {{-- Listado de devoluciones. --}}
    <div class="card border-0 shadow-sm">

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>

                            <th>
                                Venta
                            </th>

                            <th>
                                Cliente
                            </th>

                            <th>
                                Producto
                            </th>

                            <th class="text-center">
                                Cantidad
                            </th>

                            <th>
                                Motivo
                            </th>

                            <th>
                                Estado
                            </th>

                            <th>
                                Fecha
                            </th>

                            <th class="text-center">
                                Acciones
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse ($returns as $return)

                            <tr>

                                <td>
                                    <strong>
                                        {{ $return->order->order_number ?? 'N/A' }}
                                    </strong>
                                </td>

                                <td>

                                    <div class="fw-semibold">
                                        {{ $return->user->name ?? 'N/A' }}
                                    </div>

                                    <small class="text-muted">
                                        {{ $return->user->email ?? '' }}
                                    </small>

                                </td>

                                <td>
                                    {{ $return->product->name ?? 'N/A' }}
                                </td>

                                <td class="text-center">
                                    <span class="badge bg-light text-dark border">
                                        {{ $return->quantity }}
                                    </span>
                                </td>

                                <td>
                                    <span title="{{ $return->reason }}">
                                        {{ Str::limit($return->reason, 40) }}
                                    </span>
                                </td>

                                <td>

                                    @if ($return->status === 'pending')

                                        <span class="badge bg-warning text-dark">
                                            Pendiente
                                        </span>

                                    @elseif ($return->status === 'approved')

                                        <span class="badge bg-success">
                                            Aprobada
                                        </span>

                                    @elseif ($return->status === 'rejected')

                                        <span class="badge bg-danger">
                                            Rechazada
                                        </span>

                                    @elseif ($return->status === 'completed')

                                        <span class="badge bg-primary">
                                            Completada
                                        </span>

                                    @endif

                                </td>

                                <td>
                                    {{ $return->created_at->format('d/m/Y H:i') }}
                                </td>

                                <td class="text-center">

                                    @if ($return->status === 'pending')

                                        <div class="d-flex justify-content-center gap-2">

                                            {{-- Formulario para aprobar la devolución. --}}
                                            <form
                                                action="{{ route('admin.returns.approve', $return) }}"
                                                method="POST"
                                            >

                                                @csrf
                                                @method('PATCH')

                                                <button
                                                    type="submit"
                                                    class="btn btn-sm btn-success"
                                                    onclick="return confirm('¿Está seguro de aprobar esta solicitud de devolución?')"
                                                >
                                                    Aprobar
                                                </button>

                                            </form>

                                            {{-- Formulario para rechazar la devolución. --}}
                                            <form
                                                action="{{ route('admin.returns.reject', $return) }}"
                                                method="POST"
                                            >

                                                @csrf
                                                @method('PATCH')

                                                <button
                                                    type="submit"
                                                    class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('¿Está seguro de rechazar esta solicitud de devolución?')"
                                                >
                                                    Rechazar
                                                </button>

                                            </form>

                                        </div>

                                    @else

                                        <span class="badge bg-light text-muted border">
                                            Procesada
                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="8"
                                    class="text-center text-muted py-5"
                                >
                                    <h5 class="fw-bold mb-1">
                                        No hay solicitudes de devolución
                                    </h5>

                                    <p class="mb-0">
                                        No se encontraron registros según el filtro seleccionado.
                                    </p>
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            {{-- Paginación --}}
            @if (method_exists($returns, 'hasPages') && $returns->hasPages())
                <div class="p-3 border-top d-flex justify-content-end">
                    {{ $returns->links() }}
                </div>
            @endif

        </div>

    </div>

@endsection
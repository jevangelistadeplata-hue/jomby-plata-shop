@extends('layouts.app')

@section('title', 'Devoluciones')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h1 class="h3 fw-bold mb-1">
                Devoluciones
            </h1>

            <p class="text-muted mb-0">
                Revisa y gestiona las solicitudes de devolución realizadas por los clientes.
            </p>
        </div>

    </div>

    {{-- Mensaje de éxito. --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">

            <i class="bi bi-check-circle me-2"></i>

            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Cerrar"
            ></button>

        </div>
    @endif

    {{-- Mensaje de error. --}}
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">

            <i class="bi bi-exclamation-triangle me-2"></i>

            {{ session('error') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Cerrar"
            ></button>

        </div>
    @endif

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
                        <i class="bi bi-funnel me-1"></i>
                        Filtrar
                    </button>

                </div>

                <div class="col-md-auto">

                    <a
                        href="{{ route('admin.returns.index') }}"
                        class="btn btn-outline-secondary"
                    >
                        <i class="bi bi-x-circle me-1"></i>
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
                                            <i class="bi bi-hourglass-split me-1"></i>
                                            Pendiente
                                        </span>

                                    @elseif ($return->status === 'approved')

                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle me-1"></i>
                                            Aprobada
                                        </span>

                                    @elseif ($return->status === 'rejected')

                                        <span class="badge bg-danger">
                                            <i class="bi bi-x-circle me-1"></i>
                                            Rechazada
                                        </span>

                                    @elseif ($return->status === 'completed')

                                        <span class="badge bg-primary">
                                            <i class="bi bi-check2-all me-1"></i>
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

                                            {{-- Aprobar solicitud. --}}
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
                                                    <i class="bi bi-check-lg me-1"></i>
                                                    Aprobar
                                                </button>

                                            </form>

                                            {{-- Rechazar solicitud. --}}
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
                                                    <i class="bi bi-x-lg me-1"></i>
                                                    Rechazar
                                                </button>

                                            </form>

                                        </div>

                                    @elseif ($return->status === 'approved')

                                        {{-- Completar devolución. --}}
                                        <form
                                            action="{{ route('admin.returns.complete', $return) }}"
                                            method="POST"
                                        >

                                            @csrf
                                            @method('PATCH')

                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-primary"
                                                onclick="return confirm('¿Confirma que la devolución ya fue realizada? Al completarla se restaurará el inventario y afectará la contabilidad.')"
                                            >
                                                <i class="bi bi-check2-all me-1"></i>
                                                Completar
                                            </button>

                                        </form>

                                    @elseif ($return->status === 'completed')

                                        <span class="badge bg-light text-primary border">
                                            <i class="bi bi-check2-all me-1"></i>
                                            Procesada
                                        </span>

                                    @elseif ($return->status === 'rejected')

                                        <span class="badge bg-light text-danger border">
                                            <i class="bi bi-x-circle me-1"></i>
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

                                    <i class="bi bi-inbox fs-1 d-block mb-3"></i>

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

            {{-- Paginación. --}}
            @if (method_exists($returns, 'hasPages') && $returns->hasPages())

                <div class="p-3 border-top d-flex justify-content-end">

                    {{ $returns->links() }}

                </div>

            @endif

        </div>

    </div>

@endsection
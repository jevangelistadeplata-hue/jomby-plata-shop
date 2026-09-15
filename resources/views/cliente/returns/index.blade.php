@extends('layouts.app')

@section('title', 'Mis devoluciones')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h1 class="h3 fw-bold mb-1">
                Mis devoluciones
            </h1>

            <p class="text-muted mb-0">
                Consulta el estado de tus solicitudes de devolución.
            </p>
        </div>

        <a
            href="{{ route('cliente.purchases') }}"
            class="btn btn-outline-primary"
        >
            Ver mis compras
        </a>

    </div>

    {{-- Listado de devoluciones del cliente. --}}
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
                                    {{ $return->product->name ?? 'N/A' }}
                                </td>

                                <td class="text-center">
                                    <span class="badge bg-light text-dark border">
                                        {{ $return->quantity }}
                                    </span>
                                </td>

                                <td>
                                    <span title="{{ $return->reason }}">
                                        {{ Str::limit($return->reason, 45) }}
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

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="6"
                                    class="text-center text-muted py-5"
                                >
                                    <h5 class="fw-bold mb-1">
                                        No tienes solicitudes de devolución
                                    </h5>

                                    <p class="mb-0">
                                        Cuando solicites una devolución sobre alguno de tus pedidos, aparecerá en esta sección.
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
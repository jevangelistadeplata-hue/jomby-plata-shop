@extends('layouts.app')

@section('title', 'Mis compras')

@section('content')

    <div class="mb-4">

        <h1 class="h3 fw-bold mb-1">
            Mis compras
        </h1>

        <p class="text-muted mb-0">
            Consulta las compras que has realizado.
        </p>

    </div>

    @if ($orders->count())

        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead>

                            <tr>

                                <th>Número de venta</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                                <th>Método de pago</th>
                                <th class="text-end">Total</th>

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
                                        {{ $order->created_at->format('d/m/Y H:i') }}
                                    </td>

                                    <td>

                                        @if ($order->status === 'confirmed')

                                            <span class="badge bg-success">
                                                Confirmada
                                            </span>

                                        @elseif ($order->status === 'pending')

                                            <span class="badge bg-warning text-dark">
                                                Pendiente
                                            </span>

                                        @elseif ($order->status === 'completed')

                                            <span class="badge bg-primary">
                                                Completada
                                            </span>

                                        @elseif ($order->status === 'cancelled')

                                            <span class="badge bg-danger">
                                                Cancelada
                                            </span>

                                        @endif

                                    </td>

                                    <td>

                                        @if ($order->payment_method === 'cash')
                                            Efectivo
                                        @elseif ($order->payment_method === 'card')
                                            Tarjeta
                                        @elseif ($order->payment_method === 'transfer')
                                            Transferencia
                                        @endif

                                    </td>

                                    <td class="text-end fw-bold">

                                        RD$
                                        {{ number_format($order->total, 2) }}

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    @else

        <div class="card border-0 shadow-sm">

            <div class="card-body text-center py-5">

                <h5 class="fw-bold">
                    No tienes compras registradas.
                </h5>

                <p class="text-muted mb-4">
                    Cuando realices una compra, aparecerá aquí.
                </p>

                <a
                    href="{{ route('cliente.catalog') }}"
                    class="btn btn-primary"
                >
                    Ver productos
                </a>

            </div>

        </div>

    @endif

@endsection


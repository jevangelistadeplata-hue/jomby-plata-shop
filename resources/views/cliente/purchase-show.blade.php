@extends('layouts.app')

@section('title', 'Detalle de compra')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h1 class="h3 fw-bold mb-1">
            Detalle de compra
        </h1>

        <p class="text-muted mb-0">
            Consulta los productos incluidos en esta compra.
        </p>

    </div>

    <a
        href="{{ route('cliente.purchases') }}"
        class="btn btn-outline-primary"
    >
        Volver a mis compras
    </a>

</div>

{{-- Información general de la compra. --}}
<div class="card border-0 shadow-sm mb-4">

    <div class="card-body">

        <div class="row g-4">

            <div class="col-md-4">

                <p class="text-muted mb-1">
                    Número de venta
                </p>

                <h5 class="fw-bold">
                    {{ $order->order_number }}
                </h5>

            </div>

            <div class="col-md-4">

                <p class="text-muted mb-1">
                    Fecha
                </p>

                <h5 class="fw-bold">
                    {{ $order->created_at->format('d/m/Y H:i') }}
                </h5>

            </div>

            <div class="col-md-4">

                <p class="text-muted mb-1">
                    Estado
                </p>

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

            </div>

            <div class="col-md-4">

                <p class="text-muted mb-1">
                    Método de pago
                </p>

                <h6 class="fw-bold">

                    @if ($order->payment_method === 'cash')
                        Efectivo
                    @elseif ($order->payment_method === 'card')
                        Tarjeta
                    @elseif ($order->payment_method === 'transfer')
                        Transferencia
                    @endif

                </h6>

            </div>

        </div>

    </div>

</div>

{{-- Productos incluidos en la compra. --}}
<div class="card border-0 shadow-sm">

    <div class="card-body">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h5 class="fw-bold mb-0">
                Productos comprados
            </h5>

            @if ($order->status !== 'cancelled')

                <a
                    href="{{ route('cliente.returns.create', $order) }}"
                    class="btn btn-outline-warning"
                >
                    Solicitar devolución
                </a>

            @endif

        </div>

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead>

                    <tr>

                        <th>
                            Producto
                        </th>

                        <th class="text-center">
                            Cantidad
                        </th>

                        <th class="text-end">
                            Precio unitario
                        </th>

                        <th class="text-end">
                            Subtotal
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @foreach ($order->items as $item)

                        <tr>

                            <td>
                                <strong>
                                    {{ $item->product->name }}
                                </strong>
                            </td>

                            <td class="text-center">
                                {{ $item->quantity }}
                            </td>

                            <td class="text-end">
                                RD$
                                {{ number_format($item->unit_price, 2) }}
                            </td>

                            <td class="text-end fw-bold">
                                RD$
                                {{ number_format($item->subtotal, 2) }}
                            </td>

                        </tr>

                    @endforeach

                </tbody>

                <tfoot>

                    <tr>

                        <td
                            colspan="3"
                            class="text-end fw-bold"
                        >
                            Subtotal:
                        </td>

                        <td class="text-end fw-bold">
                            RD$
                            {{ number_format($order->subtotal, 2) }}
                        </td>

                    </tr>

                    <tr>

                        <td
                            colspan="3"
                            class="text-end fw-bold"
                        >
                            Impuestos:
                        </td>

                        <td class="text-end fw-bold">
                            RD$
                            {{ number_format($order->tax, 2) }}
                        </td>

                    </tr>

                    <tr>

                        <td
                            colspan="3"
                            class="text-end fw-bold"
                        >
                            Total:
                        </td>

                        <td class="text-end fw-bold fs-5">
                            RD$
                            {{ number_format($order->total, 2) }}
                        </td>

                    </tr>

                </tfoot>

            </table>

        </div>

    </div>

</div>

@endsection


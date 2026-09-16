@extends('layouts.app')

@section('title', 'Mi carrito')

@section('content')

    @php
        $cartQuantity = collect($cart)->sum('quantity');
    @endphp

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h1 class="h3 fw-bold mb-1">

                <i class="bi bi-cart3 me-2"></i>

                Mi carrito

                <span class="badge rounded-pill bg-danger align-middle">
                    {{ $cartQuantity }}
                </span>

            </h1>

            <p class="text-muted mb-0">
                Revisa los productos que deseas comprar.
            </p>

        </div>

        <a
            href="{{ route('cliente.catalog') }}"
            class="btn btn-outline-primary"
        >
            Seguir comprando
        </a>

    </div>

    @if (count($cart))

        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead>

                            <tr>

                                <th>Producto</th>
                                <th>Precio</th>
                                <th class="text-center">Cantidad</th>
                                <th class="text-end">Subtotal</th>
                                <th class="text-center">Acción</th>

                            </tr>

                        </thead>

                        <tbody>

                            @php
                                $total = 0;
                            @endphp

                            @foreach ($cart as $item)

                                @php
                                    $subtotal = $item['price'] * $item['quantity'];
                                    $total += $subtotal;
                                @endphp

                                <tr>

                                    <td>
                                        <strong>
                                            {{ $item['name'] }}
                                        </strong>
                                    </td>

                                    <td>
                                        RD$
                                        {{ number_format($item['price'], 2) }}
                                    </td>

                                    <td class="text-center">

                                        <div class="d-inline-flex align-items-center gap-2">

                                            {{-- Disminuir cantidad --}}
                                            <form
                                                action="{{ route('cliente.cart.decrease', $item['product_id']) }}"
                                                method="POST"
                                            >

                                                @csrf
                                                @method('PATCH')

                                                <button
                                                    type="submit"
                                                    class="btn btn-outline-secondary btn-sm"
                                                >
                                                    −
                                                </button>

                                            </form>

                                            <span class="fw-bold">
                                                {{ $item['quantity'] }}
                                            </span>

                                            {{-- Aumentar cantidad --}}
                                            <form
                                                action="{{ route('cliente.cart.increase', $item['product_id']) }}"
                                                method="POST"
                                            >

                                                @csrf
                                                @method('PATCH')

                                                <button
                                                    type="submit"
                                                    class="btn btn-outline-primary btn-sm"
                                                >
                                                    +
                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                    <td class="text-end">

                                        <strong>
                                            RD$
                                            {{ number_format($subtotal, 2) }}
                                        </strong>

                                    </td>

                                    <td class="text-center">

                                        {{-- Eliminar producto --}}
                                        <form
                                            action="{{ route('cliente.cart.remove', $item['product_id']) }}"
                                            method="POST"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn btn-outline-danger btn-sm"
                                            >
                                                Eliminar
                                            </button>

                                        </form>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                        <tfoot>

                            <tr>

                                <td
                                    colspan="4"
                                    class="text-end fw-bold"
                                >
                                    Total:
                                </td>

                                <td class="text-end fw-bold">

                                    RD$
                                    {{ number_format($total, 2) }}

                                </td>

                            </tr>

                            <tr>

                                <td colspan="5">

                                    <div class="d-flex justify-content-end mt-3">

                                        {{-- Formulario para finalizar la compra --}}
                                        <form
                                            action="{{ route('cliente.cart.checkout') }}"
                                            method="POST"
                                        >

                                            @csrf

                                            <button
                                                type="submit"
                                                class="btn btn-success"
                                            >
                                                Finalizar compra
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        </tfoot>

                    </table>

                </div>

            </div>

        </div>

    @else

        <div class="card border-0 shadow-sm">

            <div class="card-body text-center py-5">

                <h5 class="fw-bold">
                    Tu carrito está vacío.
                </h5>

                <p class="text-muted mb-4">
                    Agrega productos desde el catálogo para comenzar tu compra.
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








@extends('layouts.app')

@section('title', 'Dashboard del cliente')

@section('content')

    <div class="mb-4">

        <h1 class="h3 fw-bold">
            Dashboard del cliente
        </h1>

        <p class="text-muted mb-0">
            Bienvenido, {{ auth()->user()->name }}.
        </p>

    </div>

    <div class="row g-4">

        {{-- Catálogo de productos --}}
        <div class="col-md-6 col-xl-4">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <h5 class="fw-bold">
                        Catálogo
                    </h5>

                    <p class="text-muted">
                        Consulta los productos disponibles para comprar.
                    </p>

                    <a
                        href="{{ route('cliente.catalog') }}"
                        class="btn btn-primary"
                    >
                        Ver productos
                    </a>

                </div>

            </div>

        </div>

        {{-- Carrito --}}
        <div class="col-md-6 col-xl-4">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <h5 class="fw-bold">
                        Mi carrito
                    </h5>

                    <p class="text-muted">
                        Revisa los productos que deseas comprar.
                    </p>

                    <a
                        href="{{ route('cliente.cart.index') }}"
                        class="btn btn-outline-primary"
                    >
                        Ver carrito
                    </a>

                </div>

            </div>

        </div>

        {{-- Compras --}}
        <div class="col-md-6 col-xl-4">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <h5 class="fw-bold">
                        Mis compras
                    </h5>

                    <p class="text-muted">
                        Consulta tus compras realizadas.
                    </p>

                    <a
                        href="{{ route('cliente.purchases') }}"
                        class="btn btn-outline-primary"
                    >
                        Ver mis compras
                    </a>

                </div>

            </div>

        </div>

    </div>

@endsection




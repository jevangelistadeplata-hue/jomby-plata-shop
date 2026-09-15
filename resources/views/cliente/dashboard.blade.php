@extends('layouts.app')

@section('title', 'Dashboard del cliente')

@section('content')

    <div class="mb-4">

        <h1 class="h3 fw-bold mb-1">
            Dashboard del cliente
        </h1>

        <p class="text-muted mb-0">
            Bienvenido, {{ auth()->user()->name }}.
        </p>

    </div>

    <div class="row g-4">

        {{-- Catálogo. --}}
        <div class="col-md-6 col-lg-3">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body d-flex flex-column">

                    <h5 class="fw-bold mb-2">
                        Catálogo
                    </h5>

                    <p class="text-muted flex-grow-1">
                        Consulta los productos disponibles para comprar.
                    </p>

                    <a
                        href="{{ route('cliente.catalog') }}"
                        class="btn btn-primary w-100 mt-auto"
                    >
                        Ver catálogo
                    </a>

                </div>

            </div>

        </div>

        {{-- Mi carrito. --}}
        <div class="col-md-6 col-lg-3">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body d-flex flex-column">

                    <h5 class="fw-bold mb-2">
                        Mi carrito
                    </h5>

                    <p class="text-muted flex-grow-1">
                        Revisa los productos que deseas comprar.
                    </p>

                    <a
                        href="{{ route('cliente.cart.index') }}"
                        class="btn btn-primary w-100 mt-auto"
                    >
                        Ver carrito
                    </a>

                </div>

            </div>

        </div>

        {{-- Mis compras. --}}
        <div class="col-md-6 col-lg-3">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body d-flex flex-column">

                    <h5 class="fw-bold mb-2">
                        Mis compras
                    </h5>

                    <p class="text-muted flex-grow-1">
                        Consulta tus compras realizadas.
                    </p>

                    <a
                        href="{{ route('cliente.purchases') }}"
                        class="btn btn-primary w-100 mt-auto"
                    >
                        Ver compras
                    </a>

                </div>

            </div>

        </div>

        {{-- Mis devoluciones. --}}
        <div class="col-md-6 col-lg-3">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body d-flex flex-column">

                    <h5 class="fw-bold mb-2">
                        Mis devoluciones
                    </h5>

                    <p class="text-muted flex-grow-1">
                        Consulta el estado de tus solicitudes de devolución.
                    </p>

                    <a
                        href="{{ route('cliente.returns.index') }}"
                        class="btn btn-primary w-100 mt-auto"
                    >
                        Ver devoluciones
                    </a>

                </div>

            </div>

        </div>

    </div>

@endsection




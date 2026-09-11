@extends('layouts.app')

@section('title', 'Dashboard administrativo')

@section('content')
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
        <div class="col-md-6 col-xl-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h6 class="text-muted">
                        Usuarios
                    </h6>
                    <h2 class="fw-bold mb-0">
                        {{ number_format($totalUsers) }}
                    </h2>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h6 class="text-muted">
                        Proveedores
                    </h6>
                    <h2 class="fw-bold mb-0">
                        {{ number_format($totalSuppliers) }}
                    </h2>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h6 class="text-muted">
                        Productos
                    </h6>
                    <h2 class="fw-bold mb-0">
                        {{ number_format($totalProducts) }}
                    </h2>
                </div>
            </div>
        </div>
    </div>

    {{-- Información que requiere atención del administrador --}}
    <div class="mb-3">
        <h5 class="fw-bold">
            Pendientes de aprobación
        </h5>
    </div>

    <div class="row g-4">
        <div class="col-md-6 col-xl-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h6 class="text-muted">
                        Proveedores pendientes
                    </h6>
                    <h2 class="fw-bold mb-0 text-warning">
                        {{ number_format($pendingSuppliers) }}
                    </h2>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h6 class="text-muted">
                        Productos pendientes
                    </h6>
                    <h2 class="fw-bold mb-0 text-warning">
                        {{ number_format($pendingProducts) }}
                    </h2>
                </div>
            </div>
        </div>
    </div>
@endsection
@extends('layouts.app')

@section('title', 'Dashboard del proveedor')

@section('content')

    <div class="mb-4">
        <h1 class="h3 fw-bold">
            Dashboard del proveedor
        </h1>

        <p class="text-muted mb-0">
            Bienvenido, {{ auth()->user()->name }}.
        </p>

        <p class="text-muted mb-0">
            Empresa: <strong>{{ $supplier->business_name }}</strong>
        </p>
    </div>

    <div class="row g-4">

        <!-- Total de productos -->
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h6 class="text-muted">
                        Total de productos
                    </h6>

                    <h2 class="fw-bold mb-0">
                        {{ $stats['total'] }}
                    </h2>
                </div>
            </div>
        </div>

        <!-- Productos pendientes -->
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h6 class="text-muted">
                        Pendientes
                    </h6>

                    <h2 class="fw-bold mb-0">
                        {{ $stats['pendientes'] }}
                    </h2>
                </div>
            </div>
        </div>

        <!-- Productos aprobados -->
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h6 class="text-muted">
                        Aprobados
                    </h6>

                    <h2 class="fw-bold mb-0">
                        {{ $stats['aprobados'] }}
                    </h2>
                </div>
            </div>
        </div>

        <!-- Productos inactivos -->
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h6 class="text-muted">
                        Inactivos
                    </h6>

                    <h2 class="fw-bold mb-0">
                        {{ $stats['inactivos'] }}
                    </h2>
                </div>
            </div>
        </div>

    </div>

    <div class="card border-0 shadow-sm mt-4">
        <div class="card-body">

            <h5 class="fw-bold">
                Estado del proveedor
            </h5>

            <p class="mb-0">
                Estado actual:

                @if ($supplier->status === 'approved')
                    <span class="badge bg-success">
                        Aprobado
                    </span>
                @elseif ($supplier->status === 'pending')
                    <span class="badge bg-warning text-dark">
                        Pendiente de aprobación
                    </span>
                @else
                    <span class="badge bg-danger">
                        Rechazado
                    </span>
                @endif
            </p>

        </div>
    </div>

@endsection



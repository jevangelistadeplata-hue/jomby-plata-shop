@extends('layouts.app')

@section('title', 'Ventas')

@section('content')

    <div class="mb-4">
        <h1 class="h3 fw-bold">
            Ventas
        </h1>

        <p class="text-muted mb-0">
            Gestión de las ventas realizadas en Jomby Plata Shop.
        </p>
    </div>

    {{-- Información inicial del módulo de ventas --}}
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-dark text-white">
            <strong>Listado de ventas</strong>
        </div>

        <div class="card-body">

            <div class="text-center py-4">

                <h5 class="fw-bold mb-2">
                    Módulo de ventas
                </h5>

                <p class="text-muted mb-0">
                    El módulo está preparado para integrar el registro y
                    gestión de las ventas.
                </p>

            </div>

        </div>

    </div>

@endsection
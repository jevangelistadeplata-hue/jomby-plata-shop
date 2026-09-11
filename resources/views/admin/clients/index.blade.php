@extends('layouts.app')

@section('title', 'Clientes')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1">Clientes</h1>
        <p class="text-muted mb-0">
            Gestión de clientes registrados en Jomby Plata Shop.
        </p>
    </div>
</div>

{{-- Formulario de búsqueda --}}
<div class="card shadow-sm mb-4">
    <div class="card-body">

        <form method="GET" action="{{ route('admin.clients.index') }}">

            <div class="row g-3 align-items-end">

                <div class="col-md-10">
                    <label for="search" class="form-label">
                        Buscar cliente
                    </label>

                    <input
                        type="text"
                        name="search"
                        id="search"
                        class="form-control"
                        value="{{ $search }}"
                        placeholder="Buscar por nombre o correo electrónico"
                    >
                </div>

                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        Buscar
                    </button>
                </div>

            </div>

        </form>

    </div>
</div>

{{-- Tabla de clientes --}}
<div class="card shadow-sm">

    <div class="card-header bg-dark text-white">
        <strong>Listado de clientes</strong>
    </div>

    <div class="card-body p-0">

        @if ($clients->count() > 0)

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Correo electrónico</th>
                            <th>Rol</th>
                            <th>Registro</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach ($clients as $client)

                            <tr>
                                <td>{{ $client->id }}</td>

                                <td>
                                    <strong>{{ $client->name }}</strong>
                                </td>

                                <td>
                                    {{ $client->email }}
                                </td>

                                <td>
                                    <span class="badge bg-primary">
                                        {{ $client->role->name }}
                                    </span>
                                </td>

                                <td>
                                    {{ $client->created_at->format('d/m/Y') }}
                                </td>
                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="p-4 text-center">
                <p class="text-muted mb-0">
                    No se encontraron clientes.
                </p>
            </div>

        @endif

    </div>

</div>

@endsection
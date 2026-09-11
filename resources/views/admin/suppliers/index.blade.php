@extends('layouts.app')

@section('title', 'Proveedores')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h1 class="h3 fw-bold mb-1">
                Proveedores
            </h1>

            <p class="text-muted mb-0">
                Administración de proveedores registrados en Jomby Plata Shop.
            </p>

        </div>

    </div>

    {{-- Formulario de búsqueda y filtro --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <form
                method="GET"
                action="{{ route('admin.suppliers.index') }}"
            >

                <div class="row g-3 align-items-end">

                    <div class="col-md-6">

                        <label
                            for="search"
                            class="form-label fw-semibold"
                        >
                            Buscar proveedor
                        </label>

                        <input
                            type="text"
                            name="search"
                            id="search"
                            class="form-control"
                            value="{{ $search }}"
                            placeholder="Nombre, correo o empresa"
                        >

                    </div>

                    <div class="col-md-4">

                        <label
                            for="status"
                            class="form-label fw-semibold"
                        >
                            Filtrar por estado
                        </label>

                        <select
                            name="status"
                            id="status"
                            class="form-select"
                        >

                            <option value="">
                                Todos los estados
                            </option>

                            <option
                                value="pending"
                                {{ $status === 'pending' ? 'selected' : '' }}
                            >
                                Pendiente
                            </option>

                            <option
                                value="approved"
                                {{ $status === 'approved' ? 'selected' : '' }}
                            >
                                Aprobado
                            </option>

                            <option
                                value="rejected"
                                {{ $status === 'rejected' ? 'selected' : '' }}
                            >
                                Rechazado
                            </option>

                        </select>

                    </div>

                    <div class="col-md-2 d-grid">

                        <button
                            type="submit"
                            class="btn btn-dark"
                        >
                            Buscar
                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

    {{-- Listado de proveedores --}}
    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-dark">

                        <tr>

                            <th>ID</th>

                            <th>Proveedor</th>

                            <th>Empresa</th>

                            <th>Teléfono</th>

                            <th>Estado</th>

                            <th>Registro</th>

                            <th>Acciones</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse ($suppliers as $supplier)

                            <tr>

                                <td>
                                    {{ $supplier->id }}
                                </td>

                                <td>

                                    <div class="fw-semibold">
                                        {{ $supplier->user->name }}
                                    </div>

                                    <small class="text-muted">
                                        {{ $supplier->user->email }}
                                    </small>

                                </td>

                                <td>
                                    {{ $supplier->business_name }}
                                </td>

                                <td>
                                    {{ $supplier->phone }}
                                </td>

                                <td>

                                    @if ($supplier->status === 'approved')

                                        <span class="badge bg-success">
                                            Aprobado
                                        </span>

                                    @elseif ($supplier->status === 'pending')

                                        <span class="badge bg-warning text-dark">
                                            Pendiente
                                        </span>

                                    @else

                                        <span class="badge bg-danger">
                                            Rechazado
                                        </span>

                                    @endif

                                </td>

                                <td>
                                    {{ $supplier->created_at->format('d/m/Y') }}
                                </td>

                                <td>

                                    @if ($supplier->status === 'pending')

                                        <div class="d-flex gap-2">

                                            {{-- Formulario para aprobar --}}
                                            <form
                                                method="POST"
                                                action="{{ route('admin.suppliers.approve', $supplier) }}"
                                            >

                                                @csrf
                                                @method('PATCH')

                                                <button
                                                    type="submit"
                                                    class="btn btn-sm btn-success"
                                                >
                                                    Aprobar
                                                </button>

                                            </form>

                                            {{-- Formulario para rechazar --}}
                                            <form
                                                method="POST"
                                                action="{{ route('admin.suppliers.reject', $supplier) }}"
                                            >

                                                @csrf
                                                @method('PATCH')

                                                <button
                                                    type="submit"
                                                    class="btn btn-sm btn-danger"
                                                >
                                                    Rechazar
                                                </button>

                                            </form>

                                        </div>

                                    @else

                                        <span class="text-muted">
                                            Sin acciones
                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="7"
                                    class="text-center py-4"
                                >

                                    <span class="text-muted">
                                        No se encontraron proveedores.
                                    </span>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

@endsection
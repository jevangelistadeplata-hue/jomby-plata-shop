@extends('layouts.app')
@section('title', 'Administrar Productos')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4 gap-4">
    <div>
        <h1 class="h3 fw-bold mb-1">
            Administrar Productos
        </h1>
        <p class="text-muted mb-0">
            Administración de productos registrados en Jomby Plata Shop.
        </p>
    </div>

<div style="min-width: 280px;">
    <label
        for="supplier"
        class="form-label fw-semibold mb-1"
    >
        Filtrar por proveedor
    </label>

    <select
        name="supplier"
        id="supplier"
        class="form-select"
        form="formFiltrosProductos"
    >
        <option value="">Todos los proveedores</option>

        @foreach ($suppliers as $item)
            <option
                value="{{ $item->id }}"
                {{ (string) $supplier === (string) $item->id ? 'selected' : '' }}
            >
                {{ $item->business_name }}
            </option>
        @endforeach
    </select>
</div>

</div>

{{-- Formulario de búsqueda y filtros --}}

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form
            method="GET"
            action="{{ route('admin.products.index') }}"
            id="formFiltrosProductos"
        >
            <div class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label
                        for="search"
                        class="form-label fw-semibold"
                    >
                        Buscar producto
                    </label>

                <input
                    type="text"
                    name="search"
                    id="search"
                    class="form-control"
                    value="{{ $search }}"
                    placeholder="Nombre del producto o proveedor"
                >
            </div>

            <div class="col-md-3">
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
                    <option value="">Todos los estados</option>

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
                        value="inactive"
                        {{ $status === 'inactive' ? 'selected' : '' }}
                    >
                        Inactivo
                    </option>
                </select>
            </div>

            <div class="col-md-3">
                <label
                    for="category"
                    class="form-label fw-semibold"
                >
                    Filtrar por categoría
                </label>

                <select
                    name="category"
                    id="category"
                    class="form-select"
                >
                    <option value="">Todas las categorías</option>

                    @foreach ($categories as $item)
                        <option
                            value="{{ $item->id }}"
                            {{ (string) $category === (string) $item->id ? 'selected' : '' }}
                        >
                            {{ $item->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-1 d-grid">
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

{{-- Listado de productos --}}

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Producto</th>
                        <th>Proveedor</th>
                        <th>Estado del proveedor</th>
                        <th>Categoría</th>
                        <th>Costo</th>
                        <th>Venta</th>
                        <th>Stock</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

            <tbody>
                @forelse ($products as $product)
                    <tr>
                        <td>
                            {{ $product->id }}
                        </td>

                        <td>
                            <div class="fw-semibold">
                                {{ $product->name }}
                            </div>

                            @if ($product->description)
                                <small class="text-muted">
                                    {{ Str::limit($product->description, 45) }}
                                </small>
                            @endif
                        </td>

                        {{-- Nombre del proveedor --}}
                        <td>
                            {{ $product->supplier?->business_name ?? 'Sin proveedor' }}
                        </td>

                        {{-- Estado del proveedor --}}
                        <td>
                            @if ($product->supplier?->status === 'approved')
                                <span class="badge bg-success">
                                    Aprobado
                                </span>
                            @elseif ($product->supplier?->status === 'pending')
                                <span class="badge bg-warning text-dark">
                                    Pendiente
                                </span>
                            @elseif ($product->supplier?->status === 'rejected')
                                <span class="badge bg-danger">
                                    Rechazado
                                </span>
                            @else
                                <span class="badge bg-secondary">
                                    No disponible
                                </span>
                            @endif
                        </td>

                        {{-- Categoría --}}
                        <td>
                            {{ $product->category?->name ?? 'Sin categoría' }}
                        </td>

                        {{-- Costo --}}
                        <td>
                            ${{ number_format($product->cost_price, 2) }}
                        </td>

                        {{-- Precio de venta --}}
                        <td>
                            ${{ number_format($product->sale_price, 2) }}
                        </td>

                        {{-- Existencias --}}
                        <td>
                            {{ number_format($product->stock) }}
                        </td>

                        {{-- Estado del producto --}}
                        <td>
                            @if ($product->status === 'approved')
                                <span class="badge bg-success">
                                    Aprobado
                                </span>
                            @elseif ($product->status === 'pending')
                                <span class="badge bg-warning text-dark">
                                    Pendiente
                                </span>
                            @else
                                <span class="badge bg-secondary">
                                    Inactivo
                                </span>
                            @endif
                        </td>

                        {{-- Acciones --}}
                        <td>
                            @if ($product->status === 'pending')
                                <div class="d-flex gap-2 flex-wrap">

                                    {{-- Aprobar solo si el proveedor está aprobado --}}
                                    @if ($product->supplier?->status === 'approved')
                                        <form
                                            method="POST"
                                            action="{{ route('admin.products.approve', $product) }}"
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
                                    @else
                                        <span
                                            class="text-muted small"
                                            title="El proveedor debe estar aprobado primero."
                                        >
                                            No se puede aprobar
                                        </span>
                                    @endif

                                    {{-- Desactivar producto --}}
                                    <form
                                        method="POST"
                                        action="{{ route('admin.products.deactivate', $product) }}"
                                    >
                                        @csrf
                                        @method('PATCH')

                                        <button
                                            type="submit"
                                            class="btn btn-sm btn-danger"
                                        >
                                            Desactivar
                                        </button>
                                    </form>
                                </div>

                            @elseif ($product->status === 'approved')
                                <form
                                    method="POST"
                                    action="{{ route('admin.products.deactivate', $product) }}"
                                >
                                    @csrf
                                    @method('PATCH')

                                    <button
                                        type="submit"
                                        class="btn btn-sm btn-danger"
                                    >
                                        Desactivar
                                    </button>
                                </form>

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
                            colspan="10"
                            class="text-center py-4"
                        >
                            <span class="text-muted">
                                No se encontraron productos.
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
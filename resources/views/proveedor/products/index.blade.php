@extends('layouts.app')

@section('title', 'Mis productos')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">
                Mis productos
            </h1>

            <p class="text-muted mb-0">
                Productos registrados por {{ $supplier->business_name }}.
            </p>
        </div>

        <a href="{{ route('proveedor.products.create') }}" class="btn btn-primary">
            Registrar producto
        </a>
    </div>

    @if ($products->count())

        <div class="card border-0 shadow-sm">
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">

                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Categoría</th>
                                <th>Precio de costo</th>
                                <th>Precio de venta</th>
                                <th>Stock</th>
                                <th>Estado</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach ($products as $product)

                                <tr>
                                    <td>
                                        <strong>
                                            {{ $product->name }}
                                        </strong>

                                        @if ($product->description)
                                            <br>

                                            <small class="text-muted">
                                                {{ $product->description }}
                                            </small>
                                        @endif
                                    </td>

                                    <td>
                                        {{ $product->category->name ?? 'Sin categoría' }}
                                    </td>

                                    <td>
                                        RD$ {{ number_format($product->cost_price, 2) }}
                                    </td>

                                    <td>
                                        RD$ {{ number_format($product->sale_price, 2) }}
                                    </td>

                                    <td>
                                        {{ $product->stock }}
                                    </td>

                                    <td>

                                        @if ($product->status === 'approved')

                                            <span class="badge bg-success">
                                                Aprobado
                                            </span>

                                        @elseif ($product->status === 'pending')

                                            <span class="badge bg-warning text-dark">
                                                Pendiente
                                            </span>

                                        @elseif ($product->status === 'inactive')

                                            <span class="badge bg-secondary">
                                                Inactivo
                                            </span>

                                        @endif

                                    </td>
                                </tr>

                            @endforeach

                        </tbody>

                    </table>
                </div>

            </div>
        </div>

    @else

        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">

                <h5 class="fw-bold">
                    No tienes productos registrados.
                </h5>

                <p class="text-muted mb-0">
                    Cuando registres productos, aparecerán en esta sección.
                </p>

            </div>
        </div>

    @endif

@endsection



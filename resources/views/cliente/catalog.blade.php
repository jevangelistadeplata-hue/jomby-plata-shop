@extends('layouts.app')

@section('title', 'Catálogo de productos')

@section('content')

    <div class="mb-4">

        <h1 class="h3 fw-bold">
            Catálogo de productos
        </h1>

        <p class="text-muted mb-0">
            Consulta los productos disponibles para comprar.
        </p>

    </div>

    {{-- Formulario de búsqueda y filtro. --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <form
                action="{{ route('cliente.catalog') }}"
                method="GET"
            >

                <div class="row g-3 align-items-end">

                    {{-- Búsqueda --}}
                    <div class="col-md-6">

                        <label
                            for="search"
                            class="form-label"
                        >
                            Buscar producto
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="search"
                            name="search"
                            value="{{ $search }}"
                            placeholder="Escriba el nombre del producto"
                        >

                    </div>

                    {{-- Filtro por categoría --}}
                    <div class="col-md-4">

                        <label
                            for="category"
                            class="form-label"
                        >
                            Categoría
                        </label>

                        <select
                            class="form-select"
                            id="category"
                            name="category"
                        >

                            <option value="">
                                Todas las categorías
                            </option>

                            @foreach ($categories as $item)

                                <option
                                    value="{{ $item->id }}"
                                    {{ $category == $item->id ? 'selected' : '' }}
                                >
                                    {{ $item->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                    {{-- Botón buscar --}}
                    <div class="col-md-2">

                        <button
                            type="submit"
                            class="btn btn-primary w-100"
                        >
                            Buscar
                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

    {{-- Resultados del catálogo. --}}
    @if ($products->count())

        <div class="row g-4">

            @foreach ($products as $product)

                <div class="col-md-6 col-lg-4 col-xl-3">

                    <div class="card border-0 shadow-sm h-100">

                        <div class="card-body d-flex flex-column">

                            <h5 class="fw-bold">
                                {{ $product->name }}
                            </h5>

                            <p class="text-muted small mb-2">
                                {{ $product->category->name ?? 'Sin categoría' }}
                            </p>

                            @if ($product->description)

                                <p class="text-muted">
                                    {{ $product->description }}
                                </p>

                            @endif

                            <div class="mt-auto">

                                <p class="mb-1">

                                    <strong>
                                        Precio:
                                    </strong>

                                    RD$
                                    {{ number_format($product->sale_price, 2) }}

                                </p>

                                <p class="mb-3">

                                    <strong>
                                        Stock:
                                    </strong>

                                    {{ $product->stock }}

                                </p>

                                {{-- Formulario para agregar el producto al carrito. --}}
                                <form
                                    action="{{ route('cliente.cart.add', $product) }}"
                                    method="POST"
                                >

                                    @csrf

                                    <button
                                        type="submit"
                                        class="btn btn-primary w-100"
                                    >
                                        Agregar al carrito
                                    </button>

                                </form>

                            </div>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    @else

        <div class="card border-0 shadow-sm">

            <div class="card-body text-center py-5">

                <h5 class="fw-bold">
                    No se encontraron productos.
                </h5>

                <p class="text-muted mb-0">
                    No existen productos disponibles con los criterios seleccionados.
                </p>

            </div>

        </div>

    @endif

@endsection


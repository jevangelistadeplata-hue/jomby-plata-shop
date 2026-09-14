@extends('layouts.app')

@section('title', 'Registrar producto')

@section('content')

<div class="mb-4">

    <h1 class="h3 fw-bold">
        Registrar producto
    </h1>

    <p class="text-muted mb-0">
        Registra un nuevo producto para
        <strong>{{ $supplier->business_name }}</strong>.
    </p>

</div>

{{-- Muestra un aviso general cuando existen errores de validación. --}}
@if ($errors->any())

    <div class="alert alert-danger">
        <strong>Por favor, corrige los siguientes errores:</strong>

        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>

@endif

<div class="card border-0 shadow-sm">

    <div class="card-body">

        <form action="{{ route('proveedor.products.store') }}" method="POST">

            @csrf

            <div class="row g-3">

                {{-- Nombre --}}
                <div class="col-md-6">

                    <label for="name" class="form-label">
                        Nombre del producto
                    </label>

                    <input
                        type="text"
                        class="form-control @error('name') is-invalid @enderror"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Ej. Detergente líquido"
                    >

                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                {{-- Categoría --}}
                <div class="col-md-6">

                    <label for="category_id" class="form-label">
                        Categoría
                    </label>

                    <select
                        class="form-select @error('category_id') is-invalid @enderror"
                        id="category_id"
                        name="category_id"
                    >

                        <option value="">
                            Seleccione una categoría
                        </option>

                        @foreach ($categories as $category)

                            <option
                                value="{{ $category->id }}"
                                {{ old('category_id') == $category->id ? 'selected' : '' }}
                            >
                                {{ $category->name }}
                            </option>

                        @endforeach

                    </select>

                    @error('category_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                {{-- Descripción --}}
                <div class="col-12">

                    <label for="description" class="form-label">
                        Descripción
                    </label>

                    <textarea
                        class="form-control @error('description') is-invalid @enderror"
                        id="description"
                        name="description"
                        rows="4"
                        placeholder="Descripción del producto"
                    >{{ old('description') }}</textarea>

                    @error('description')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                {{-- Precio de costo --}}
                <div class="col-md-4">

                    <label for="cost_price" class="form-label">
                        Precio de costo
                    </label>

                    <div class="input-group">

                        <span class="input-group-text">
                            RD$
                        </span>

                        <input
                            type="number"
                            class="form-control @error('cost_price') is-invalid @enderror"
                            id="cost_price"
                            name="cost_price"
                            value="{{ old('cost_price') }}"
                            min="0"
                            step="0.01"
                            placeholder="0.00"
                        >

                    </div>

                    @error('cost_price')
                        <div class="text-danger small mt-1">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                {{-- Precio de venta --}}
                <div class="col-md-4">

                    <label for="sale_price" class="form-label">
                        Precio de venta
                    </label>

                    <div class="input-group">

                        <span class="input-group-text">
                            RD$
                        </span>

                        <input
                            type="number"
                            class="form-control @error('sale_price') is-invalid @enderror"
                            id="sale_price"
                            name="sale_price"
                            value="{{ old('sale_price') }}"
                            min="0"
                            step="0.01"
                            placeholder="0.00"
                        >

                    </div>

                    @error('sale_price')
                        <div class="text-danger small mt-1">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                {{-- Stock --}}
                <div class="col-md-4">

                    <label for="stock" class="form-label">
                        Stock inicial
                    </label>

                    <input
                        type="number"
                        class="form-control @error('stock') is-invalid @enderror"
                        id="stock"
                        name="stock"
                        value="{{ old('stock', 0) }}"
                        min="0"
                        step="1"
                    >

                    @error('stock')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

            </div>

            <hr class="my-4">

            <div class="d-flex justify-content-between">

                <a
                    href="{{ route('proveedor.products.index') }}"
                    class="btn btn-outline-secondary"
                >
                    Cancelar
                </a>

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Registrar producto
                </button>

            </div>

        </form>

    </div>

</div>

@endsection



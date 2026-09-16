@extends('layouts.app')

@section('title', 'Inicio')

@section('content')

<style>
    .category-image {
        overflow: hidden;
        border-radius: 0.375rem;
    }

    .category-image img {
        transition: transform 0.5s ease;
    }

    .category-image:hover img {
        transform: scale(1.12);
    }

    .category-name {
        color: inherit;
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .category-name:hover {
        color: var(--bs-primary);
        text-decoration: underline;
    }
</style>

<div class="text-center mb-5">

<h1 class="display-5 fw-bold">
    CATÁLOGO EMPRESARIAL
</h1>

<p class="lead text-muted mb-2">
    Productos y soluciones para las necesidades de su empresa.
</p>

<a href="{{ route('catalog') }}" class="btn btn-primary mt-3">
    Ver todos los productos
</a>

</div>

<div class="text-center mb-4">

<h2 class="fw-bold">
    Categorías de productos
</h2>

<p class="text-muted">
    Explore nuestras categorías y encuentre los productos que necesita.
</p>

</div>

<div class="row g-4">

@forelse ($categories as $category)

    <div class="col-md-6 col-lg-4">

        <div class="card h-100 shadow-sm border-0">

            <div class="card-body text-center p-4">

                <div class="mb-3 category-image">

                    @if ($category->image)

                        <img
                            src="{{ asset('storage/' . $category->image) }}"
                            alt="{{ $category->name }}"
                            class="img-fluid"
                            style="width: 100%; height: 220px; object-fit: cover;"
                        >

                    @else

                        <div class="bg-light rounded p-5">

                            <span class="text-muted">
                                Imagen de {{ $category->name }}
                            </span>

                        </div>

                    @endif

                </div>

                <h3 class="h5 fw-bold">

                    <a
                        href="{{ route('catalog', ['category' => $category->id]) }}"
                        class="category-name"
                    >
                        {{ $category->name }}
                    </a>

                </h3>

                @if ($category->description)

                    <p class="text-muted mb-0">
                        {{ $category->description }}
                    </p>

                @endif

            </div>

        </div>

    </div>

@empty

    <div class="col-12">

        <div class="alert alert-info text-center">
            No hay categorías disponibles en este momento.
        </div>

    </div>

@endforelse

</div>

@endsection

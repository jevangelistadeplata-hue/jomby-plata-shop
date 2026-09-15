@extends('layouts.app')

@section('title', 'Solicitar devolución')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h1 class="h3 fw-bold mb-1">
                Solicitar devolución
            </h1>

            <p class="text-muted mb-0">
                Solicita la devolución de un producto incluido en esta compra.
            </p>

        </div>

        <a
            href="{{ route('cliente.purchases.show', $order) }}"
            class="btn btn-outline-primary"
        >
            Volver a la compra
        </a>

    </div>

    {{-- Información de la compra. --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <p class="text-muted mb-1">
                Número de venta
            </p>

            <h5 class="fw-bold mb-0">
                {{ $order->order_number }}
            </h5>

        </div>

    </div>

    {{-- Formulario de devolución. --}}
    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <form
                action="{{ route('cliente.returns.store', $order) }}"
                method="POST"
            >

                @csrf

                {{-- Producto. --}}
                <div class="mb-3">

                    <label
                        for="product_id"
                        class="form-label fw-semibold"
                    >
                        Producto
                    </label>

                    <select
                        name="product_id"
                        id="product_id"
                        class="form-select @error('product_id') is-invalid @enderror"
                        required
                    >

                        <option value="">
                            Seleccione un producto
                        </option>

                        @foreach ($order->items as $item)

                            <option
                                value="{{ $item->product_id }}"
                                data-max-quantity="{{ $item->quantity }}"
                                @selected(old('product_id') == $item->product_id)
                            >
                                {{ $item->product->name }}
                                — Compradas: {{ $item->quantity }}
                            </option>

                        @endforeach

                    </select>

                    @error('product_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                {{-- Cantidad. --}}
                <div class="mb-3">

                    <label
                        for="quantity"
                        class="form-label fw-semibold"
                    >
                        Cantidad a devolver
                    </label>

                    <input
                        type="number"
                        name="quantity"
                        id="quantity"
                        class="form-control @error('quantity') is-invalid @enderror"
                        value="{{ old('quantity', 1) }}"
                        min="1"
                        required
                    >

                    <div class="form-text">
                        La cantidad no puede superar las unidades compradas.
                    </div>

                    @error('quantity')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                {{-- Motivo. --}}
                <div class="mb-4">

                    <label
                        for="reason"
                        class="form-label fw-semibold"
                    >
                        Motivo de la devolución
                    </label>

                    <textarea
                        name="reason"
                        id="reason"
                        rows="5"
                        class="form-control @error('reason') is-invalid @enderror"
                        placeholder="Explique brevemente el motivo de la devolución."
                        required
                    >{{ old('reason') }}</textarea>

                    @error('reason')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                {{-- Botón de envío. --}}
                <div class="d-flex justify-content-end gap-2">

                    <a
                        href="{{ route('cliente.purchases.show', $order) }}"
                        class="btn btn-outline-secondary"
                    >
                        Cancelar
                    </a>

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Solicitar devolución
                    </button>

                </div>

            </form>

        </div>

    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const productSelect = document.getElementById('product_id');
            const quantityInput = document.getElementById('quantity');

            function updateMaxQuantity() {
                const selectedOption = productSelect.options[productSelect.selectedIndex];
                const maxQuantity = selectedOption ? selectedOption.getAttribute('data-max-quantity') : null;

                if (maxQuantity) {
                    quantityInput.setAttribute('max', maxQuantity);
                    if (parseInt(quantityInput.value) > parseInt(maxQuantity)) {
                        quantityInput.value = maxQuantity;
                    }
                } else {
                    quantityInput.removeAttribute('max');
                }
            }

            productSelect.addEventListener('change', updateMaxQuantity);
            updateMaxQuantity();
        });
    </script>
@endpush

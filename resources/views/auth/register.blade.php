@extends('layouts.app')

@section('title', 'Registrarse')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7">

            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white text-center">
                    <h4 class="mb-0">Crear cuenta</h4>
                </div>

                <div class="card-body p-4">

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">
                                Nombre completo
                            </label>

                            <input
                                type="text"
                                class="form-control @error('name') is-invalid @enderror"
                                id="name"
                                name="name"
                                value="{{ old('name') }}"
                                required
                                autofocus
                            >

                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">
                                Correo electrónico
                            </label>

                            <input
                                type="email"
                                class="form-control @error('email') is-invalid @enderror"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                autocomplete="username"
                                required
                            >

                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">
                                Contraseña
                            </label>

                            <input
                                type="password"
                                class="form-control @error('password') is-invalid @enderror"
                                id="password"
                                name="password"
                                autocomplete="new-password"
                                required
                            >

                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                            <div class="form-text">
                                La contraseña debe tener al menos 8 caracteres.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">
                                Confirmar contraseña
                            </label>

                            <input
                                type="password"
                                class="form-control"
                                id="password_confirmation"
                                name="password_confirmation"
                                autocomplete="new-password"
                                required
                            >
                        </div>

                        <div class="mb-4">
                            <label for="role" class="form-label">
                                Tipo de cuenta
                            </label>

                            <select
                                class="form-select @error('role') is-invalid @enderror"
                                id="role"
                                name="role"
                                required
                            >
                                <option value="">Seleccione una opción</option>
                                <option
                                    value="Cliente"
                                    {{ old('role') === 'Cliente' ? 'selected' : '' }}
                                >
                                    Cliente
                                </option>
                                <option
                                    value="Proveedor"
                                    {{ old('role') === 'Proveedor' ? 'selected' : '' }}
                                >
                                    Proveedor
                                </option>
                            </select>

                            @error('role')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div id="datosProveedor" class="border rounded p-3 mb-4 bg-light d-none">

                            <h5 class="mb-3">
                                Información del proveedor
                            </h5>

                            <div class="mb-3">
                                <label for="business_name" class="form-label">
                                    Nombre de la empresa
                                </label>

                                <input
                                    type="text"
                                    class="form-control @error('business_name') is-invalid @enderror"
                                    id="business_name"
                                    name="business_name"
                                    value="{{ old('business_name') }}"
                                >

                                @error('business_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label">
                                    Teléfono
                                </label>

                                <input
                                    type="text"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    id="phone"
                                    name="phone"
                                    value="{{ old('phone') }}"
                                    maxlength="20"
                                >

                                @error('phone')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-0">
                                <label for="address" class="form-label">
                                    Dirección
                                </label>

                                <textarea
                                    class="form-control @error('address') is-invalid @enderror"
                                    id="address"
                                    name="address"
                                    rows="3"
                                >{{ old('address') }}</textarea>

                                @error('address')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                Crear cuenta
                            </button>
                        </div>

                    </form>

                    <hr class="my-4">

                    <div class="text-center">
                        <p class="mb-2">
                            ¿Ya tienes una cuenta?
                        </p>

                        <a
                            href="{{ route('login') }}"
                            class="btn btn-outline-dark"
                        >
                            Iniciar sesión
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const role = document.getElementById('role');
        const datosProveedor = document.getElementById('datosProveedor');

        function mostrarDatosProveedor() {
            if (role.value === 'Proveedor') {
                datosProveedor.classList.remove('d-none');
            } else {
                datosProveedor.classList.add('d-none');
            }
        }

        role.addEventListener('change', mostrarDatosProveedor);

        mostrarDatosProveedor();
    });
</script>
@endpush
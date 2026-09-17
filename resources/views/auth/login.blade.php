@extends('layouts.app')

@section('title', 'Iniciar sesión')

@section('content')

    <div
        class="login-background"
        style="--bg-image: url('{{ asset('images/login/login_background.jpg') }}');"
    >

        <div class="login-form-container">

            <div class="login-card">

                <div class="login-card-header">
                    <h4>Iniciar sesión</h4>
                </div>

                <div class="login-card-body">

                    <form method="POST" action="{{ route('login.store') }}">
                        @csrf

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
                                autofocus
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
                                autocomplete="current-password"
                                required
                            >

                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-check mb-4">
                            <input
                                type="checkbox"
                                class="form-check-input"
                                id="remember"
                                name="remember"
                                value="1"
                                {{ old('remember') ? 'checked' : '' }}
                            >

                            <label class="form-check-label" for="remember">
                                Recordarme
                            </label>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                Iniciar sesión
                            </button>
                        </div>
                    </form>

                    <hr class="my-4">

                    <div class="text-center">
                        <p class="mb-2">
                            ¿No tienes una cuenta?
                        </p>

                        <a
                            href="{{ route('register') }}"
                            class="btn btn-outline-dark"
                        >
                            Registrarse
                        </a>
                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection
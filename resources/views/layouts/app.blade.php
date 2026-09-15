<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Jomby Plata Shop')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')

</head>

<body class="d-flex flex-column min-vh-100">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">

        <div class="container">

            {{-- Nombre de la aplicación --}}
            <a class="navbar-brand fw-bold" href="{{ url('/') }}">
                Jomby Plata Shop
            </a>

            {{-- Botón para menú en dispositivos pequeños --}}
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#menuPrincipal"
                aria-controls="menuPrincipal"
                aria-expanded="false"
                aria-label="Mostrar navegación"
            >
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="menuPrincipal">

                <ul class="navbar-nav ms-auto align-items-lg-center">

                    {{-- Inicio --}}
                    <li class="nav-item">

                        <a
                            class="nav-link {{ request()->is('/') ? 'active' : '' }}"
                            href="{{ url('/') }}"
                        >
                            Inicio
                        </a>

                    </li>

                    @auth

                        {{-- Opciones exclusivas del administrador --}}
                        @if (auth()->user()->isAdmin())

                            {{-- Dashboard --}}
                            <li class="nav-item">

                                <a
                                    class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                                    href="{{ route('admin.dashboard') }}"
                                >
                                    Dashboard
                                </a>

                            </li>

                            {{-- Productos --}}
                            <li class="nav-item">

                                <a
                                    class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}"
                                    href="{{ route('admin.products.index') }}"
                                >
                                    Productos
                                </a>

                            </li>

                            {{-- Proveedores --}}
                            <li class="nav-item">

                                <a
                                    class="nav-link {{ request()->routeIs('admin.suppliers.*') ? 'active' : '' }}"
                                    href="{{ route('admin.suppliers.index') }}"
                                >
                                    Proveedores
                                </a>

                            </li>

                            {{-- Clientes --}}
                            <li class="nav-item">

                                <a
                                    class="nav-link {{ request()->routeIs('admin.clients.*') ? 'active' : '' }}"
                                    href="{{ route('admin.clients.index') }}"
                                >
                                    Clientes
                                </a>

                            </li>

                            {{-- Ventas --}}
                            <li class="nav-item">

                                <a
                                    class="nav-link {{ request()->routeIs('admin.sales.*') ? 'active' : '' }}"
                                    href="{{ route('admin.sales.index') }}"
                                >
                                    Ventas
                                </a>

                            </li>

                            {{-- Contabilidad --}}
                            <li class="nav-item">

                                <a
                                    class="nav-link {{ request()->routeIs('admin.accounting.index') ? 'active' : '' }}" 
                                    href="{{ route('admin.accounting.index') }}"                             
                                >
                                    Contabilidad
                                </a>

                            </li>

                        @endif

                        {{-- Opciones exclusivas del proveedor --}}
                        @if (auth()->user()->isSupplier())

                            {{-- Dashboard del proveedor --}}
                            <li class="nav-item">

                                <a
                                    class="nav-link {{ request()->routeIs('proveedor.dashboard') ? 'active' : '' }}"
                                    href="{{ route('proveedor.dashboard') }}"
                                >
                                    Dashboard
                                </a>

                            </li>

                            {{-- Mis productos --}}
                            <li class="nav-item">

                                <a
                                    class="nav-link {{ request()->routeIs('proveedor.products.index') ? 'active' : '' }}"
                                    href="{{ route('proveedor.products.index') }}"
                                >
                                    Mis productos
                                </a>

                            </li>

                            {{-- Registrar producto --}}
                            <li class="nav-item">

                                <a
                                    class="nav-link {{ request()->routeIs('proveedor.products.create') ? 'active' : '' }}"
                                    href="{{ route('proveedor.products.create') }}"
                                >
                                    Registrar producto
                                </a>

                            </li>

                        @endif

                        {{-- Opciones exclusivas del cliente --}}
                        @if (auth()->user()->isClient())

                            {{-- Dashboard del cliente --}}
                            <li class="nav-item">

                                <a
                                    class="nav-link {{ request()->routeIs('cliente.dashboard') ? 'active' : '' }}"
                                    href="{{ route('cliente.dashboard') }}"
                                >
                                    Dashboard
                                </a>

                            </li>

                            {{-- Productos --}}
                            <li class="nav-item">

                                <a
                                    class="nav-link {{ request()->routeIs('cliente.catalog') ? 'active' : '' }}"
                                    href="{{ route('cliente.catalog') }}"
                                >
                                    Productos
                                </a>

                            </li>

                            {{-- Carrito --}}
                            <li class="nav-item">

                                <a
                                    class="nav-link {{ request()->routeIs('cliente.cart.index') ? 'active' : '' }}"
                                    href="{{ route('cliente.cart.index') }}"
                                >
                                    Mi carrito
                                </a>

                            </li>

                            {{-- Compras --}}
                            <li class="nav-item">

                                <a
                                    class="nav-link {{ request()->routeIs('cliente.purchases') ? 'active' : '' }}"
                                    href="{{ route('cliente.purchases') }}" 
                                >
                                    Mis compras
                                </a>

                            </li>

                        @endif

                    @endauth

                    {{-- Opciones para usuarios no autenticados --}}
                    @guest

                        {{-- Iniciar sesión --}}
                        <li class="nav-item">

                            <a
                                class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}"
                                href="{{ route('login') }}"
                            >
                                Iniciar sesión
                            </a>

                        </li>

                        {{-- Registrarse --}}
                        <li class="nav-item">

                            <a
                                class="nav-link {{ request()->routeIs('register') ? 'active' : '' }}"
                                href="{{ route('register') }}"
                            >
                                Registrarse
                            </a>

                        </li>

                    @else

                        {{-- Nombre del usuario autenticado --}}
                        <li class="nav-item ms-lg-2">

                            <span class="nav-link text-light fw-medium">
                                Hola, {{ auth()->user()->name }}
                            </span>

                        </li>

                        {{-- Cerrar sesión --}}
                        <li class="nav-item">

                            <form
                                method="POST"
                                action="{{ route('logout') }}"
                                class="d-inline"
                            >

                                @csrf

                                <button
                                    type="submit"
                                    class="nav-link btn btn-link text-decoration-none border-0 py-0"
                                >
                                    Cerrar sesión
                                </button>

                            </form>

                        </li>

                    @endguest

                </ul>

            </div>

        </div>

    </nav>

    <main class="container py-4 flex-grow-1">

        {{-- Mensaje de éxito --}}
        @if (session('success'))

            <div
                class="alert alert-success alert-dismissible fade show"
                role="alert"
            >

                {{ session('success') }}

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Cerrar"
                ></button>

            </div>

        @endif

        {{-- Mensaje de error --}}
        @if (session('error'))

            <div
                class="alert alert-danger alert-dismissible fade show"
                role="alert"
            >

                {{ session('error') }}

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Cerrar"
                ></button>

            </div>

        @endif

        @yield('content')

    </main>

    {{-- Pie de página --}}
    <footer class="bg-dark text-white text-center py-3 mt-auto">

        <div class="container">

            <small>
                Jomby Plata Shop © {{ date('Y') }} - Proyecto académico INFOTEP
            </small>

        </div>

    </footer>

    @stack('scripts')

</body>

</html>





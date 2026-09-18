<!DOCTYPE html>
<html lang="es" class="h-100">

<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >
    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >
    <title>
        @yield('title', 'Jomby Plata Shop')
    </title>
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700&display=swap"
        rel="stylesheet"
    >
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>

<body class="d-flex flex-column min-vh-100">

    {{-- =========================================================
         ENCABEZADO PRINCIPAL
         ========================================================= --}}
    <header class="jomby-header">

        {{-- =====================================================
             BARRA SUPERIOR
             Logo + nombre de la tienda + usuario
             ===================================================== --}}
        <div class="jomby-topbar">
            <div class="container">
                <div class="jomby-topbar-content">

                    {{-- =================================================
                         LOGO + NOMBRE DE LA TIENDA
                         ================================================= --}}
                    <a
                        href="{{ url('/') }}"
                        class="jomby-brand"
                    >
                        <img
                            src="{{ asset('images/logo/logo.png') }}"
                            alt="Jomby Plata Shop"
                            class="logo-jomby"
                            fetchpriority="high"
                            decoding="async"
                        >
                        <span class="jomby-store-name">
                            Jomby Plata Shop
                        </span>
                    </a>

                    {{-- =================================================
                         INFORMACIÓN DEL USUARIO
                         ================================================= --}}
                    <div class="jomby-user-area">
                        @auth
                            <div class="jomby-user">
                                {{-- Información del usuario --}}
                                <div class="jomby-user-info">
                                    <i
                                        class="bi bi-person-circle jomby-user-icon"
                                    ></i>
                                    <div class="jomby-user-details">
                                        <div class="jomby-welcome">
                                            Bienvenido(a)
                                            {{ auth()->user()->name }}
                                        </div>
                                        <div class="jomby-last-login">
                                            Última conexión:
                                            @if (session('last_login_at'))
                                                {{ session('last_login_at') }}
                                            @else
                                                Primera conexión
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{-- Cerrar sesión --}}
                                <form
                                    method="POST"
                                    action="{{ route('logout') }}"
                                    class="m-0"
                                >
                                    @csrf
                                    <button
                                        type="submit"
                                        class="jomby-logout"
                                    >
                                        <i class="bi bi-box-arrow-right"></i>
                                        Cerrar sesión
                                    </button>
                                </form>
                            </div>
                        @else
                            {{-- Iniciar sesión --}}
                            <a
                                href="{{ route('login') }}"
                                class="jomby-user-link"
                            >
                                <i class="bi bi-box-arrow-in-right me-1"></i>
                                Iniciar sesión
                            </a>

                            {{-- Registrarse --}}
                            <a
                                href="{{ route('register') }}"
                                class="jomby-user-link ms-3"
                            >
                                <i class="bi bi-person-plus me-1"></i>
                                Registrarse
                            </a>
                        @endauth
                    </div>

                </div>
            </div>
        </div>

        {{-- =====================================================
             BARRA DE NAVEGACIÓN
             ===================================================== --}}
        <nav class="jomby-menubar">
            <div class="container">

                {{-- =================================================
                     BOTÓN MENÚ MÓVIL
                     ================================================= --}}
                <button
                    class="navbar-toggler jomby-toggler d-lg-none"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#menuPrincipal"
                    aria-controls="menuPrincipal"
                    aria-expanded="false"
                    aria-label="Mostrar navegación"
                >
                    <span class="navbar-toggler-icon"></span>
                </button>

                {{-- =================================================
                     MENÚ PRINCIPAL
                     ================================================= --}}
                <div
                    class="collapse d-lg-block"
                    id="menuPrincipal"
                >
                    <ul class="navbar-nav flex-lg-row align-items-lg-center">

                        {{-- =================================================
                             USUARIOS NO AUTENTICADOS
                             ================================================= --}}
                        @guest
                            {{-- Inicio --}}
                            <li class="nav-item">
                                <a
                                    class="nav-link {{ request()->is('/') ? 'active' : '' }}"
                                    href="{{ url('/') }}"
                                >
                                    Inicio
                                </a>
                            </li>
                        @endguest

                        {{-- =================================================
                             USUARIOS AUTENTICADOS
                             ================================================= --}}
                        @auth

                            {{-- =================================================
                                 ADMINISTRADOR / CONTADOR
                                 ================================================= --}}
                            @if (auth()->user()->isAdmin())
                                {{-- Inicio --}}
                                <li class="nav-item">
                                    <a
                                        class="nav-link {{ request()->is('/') ? 'active' : '' }}"
                                        href="{{ url('/') }}"
                                    >
                                        Inicio
                                    </a>
                                </li>

                                {{-- Dashboard --}}
                                <li class="nav-item">
                                    <a
                                        class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                                        href="{{ route('admin.dashboard') }}"
                                    >
                                        Dashboard
                                    </a>
                                </li>

                                {{-- Administrar Productos --}}
                                <li class="nav-item">
                                    <a
                                        class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}"
                                        href="{{ route('admin.products.index') }}"
                                    >
                                        Administrar Productos
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

                                {{-- Devoluciones --}}
                                <li class="nav-item">
                                    <a
                                        class="nav-link {{ request()->routeIs('admin.returns.index') ? 'active' : '' }}"
                                        href="{{ route('admin.returns.index') }}"
                                    >
                                        Devoluciones
                                    </a>
                                </li>
                            @endif

                            {{-- =================================================
                                 PROVEEDOR
                                 ================================================= --}}
                            @if (auth()->user()->isSupplier())
                                {{-- Dashboard --}}
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

                            {{-- =================================================
                                 CLIENTE
                                 ================================================= --}}
                            @if (auth()->user()->isClient())
                                {{-- Productos --}}
                                <li class="nav-item">
                                    <a
                                        class="nav-link {{ request()->routeIs('cliente.catalog') ? 'active' : '' }}"
                                        href="{{ route('cliente.catalog') }}"
                                    >
                                        Productos
                                    </a>
                                </li>

                                {{-- =================================================
                                     CARRITO
                                     ================================================= --}}
                                @php
                                    $cartQuantity = auth()->user()
                                        ->cartItems()
                                        ->sum('quantity');
                                @endphp

                                <li class="nav-item">
                                    <a
                                        class="nav-link {{ request()->routeIs('cliente.cart.index') ? 'active' : '' }}"
                                        href="{{ route('cliente.cart.index') }}"
                                    >
                                        <i class="bi bi-cart3 me-1"></i>
                                        Mi carrito
                                        <span
                                            class="badge rounded-pill bg-danger ms-1"
                                        >
                                            {{ $cartQuantity }}
                                        </span>
                                    </a>
                                </li>

                                {{-- Mis compras --}}
                                <li class="nav-item">
                                    <a
                                        class="nav-link {{ request()->routeIs('cliente.purchases*') ? 'active' : '' }}"
                                        href="{{ route('cliente.purchases') }}"
                                    >
                                        Mis compras
                                    </a>
                                </li>

                                {{-- Mis devoluciones --}}
                                <li class="nav-item">
                                    <a
                                        class="nav-link {{ request()->routeIs('cliente.returns.*') ? 'active' : '' }}"
                                        href="{{ route('cliente.returns.index') }}"
                                    >
                                        Mis devoluciones
                                    </a>
                                </li>
                            @endif

                        @endauth

                    </ul>
                </div>

            </div>
        </nav>

    </header>

    {{-- =========================================================
         CONTENIDO PRINCIPAL
         ========================================================= --}}
    <main class="container py-4 flex-grow-1">

        {{-- =====================================================
             MENSAJE DE ÉXITO
             ===================================================== --}}
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

        {{-- =====================================================
             MENSAJE DE ERROR
             ===================================================== --}}
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

    {{-- =========================================================
         PIE DE PÁGINA
         ========================================================= --}}
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
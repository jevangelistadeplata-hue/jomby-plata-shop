<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

/*
|--------------------------------------------------------------------------
| Rutas de autenticación
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    // Muestra el formulario de inicio de sesión.
    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    // Procesa el inicio de sesión.
    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('throttle:5,1')
        ->name('login.store');

    // Muestra el formulario de registro.
    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('register');

    // Procesa el registro de un nuevo usuario.
    Route::post('/register', [AuthController::class, 'register'])
        ->name('register.store');
});

/*
|--------------------------------------------------------------------------
| Rutas del usuario autenticado
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Cierra la sesión del usuario autenticado.
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');
});

/*
|--------------------------------------------------------------------------
| Rutas del administrador
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->group(function () {

        // Muestra el dashboard administrativo.
        Route::get('/dashboard', [AdminController::class, 'dashboard'])
            ->name('admin.dashboard');

        /*
        |--------------------------------------------------------------------------
        | Proveedores
        |--------------------------------------------------------------------------
        */

        // Muestra el listado de proveedores.
        Route::get('/proveedores', [SupplierController::class, 'index'])
            ->name('admin.suppliers.index');

        // Aprueba un proveedor.
        Route::patch('/proveedores/{supplier}/aprobar', [SupplierController::class, 'approve'])
            ->name('admin.suppliers.approve');

        // Rechaza un proveedor.
        Route::patch('/proveedores/{supplier}/rechazar', [SupplierController::class, 'reject'])
            ->name('admin.suppliers.reject');

        /*
        |--------------------------------------------------------------------------
        | Productos
        |--------------------------------------------------------------------------
        */

        // Muestra el listado de productos.
        Route::get('/productos', [ProductController::class, 'index'])
            ->name('admin.products.index');

        // Aprueba un producto.
        Route::patch('/productos/{product}/aprobar', [ProductController::class, 'approve'])
            ->name('admin.products.approve');

        // Desactiva un producto.
        Route::patch('/productos/{product}/desactivar', [ProductController::class, 'deactivate'])
            ->name('admin.products.deactivate');
    });
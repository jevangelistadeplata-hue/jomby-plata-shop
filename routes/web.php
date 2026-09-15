<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AccountingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\SaleController;
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
    ->as('admin.')
    ->group(function () {

        // Muestra el dashboard administrativo.
        Route::get('/dashboard', [AdminController::class, 'dashboard'])
            ->name('dashboard');

        /*
        |--------------------------------------------------------------------------
        | Proveedores
        |--------------------------------------------------------------------------
        */

        // Muestra el listado de proveedores.
        Route::get('/proveedores', [SupplierController::class, 'index'])
            ->name('suppliers.index');

        // Aprueba un proveedor.
        Route::patch('/proveedores/{supplier}/aprobar', [SupplierController::class, 'approve'])
            ->name('suppliers.approve');

        // Rechaza un proveedor.
        Route::patch('/proveedores/{supplier}/rechazar', [SupplierController::class, 'reject'])
            ->name('suppliers.reject');

        /*
        |--------------------------------------------------------------------------
        | Productos
        |--------------------------------------------------------------------------
        */

        // Muestra el listado de productos.
        Route::get('/productos', [ProductController::class, 'index'])
            ->name('products.index');

        // Aprueba un producto.
        Route::patch('/productos/{product}/aprobar', [ProductController::class, 'approve'])
            ->name('products.approve');

        // Desactiva un producto.
        Route::patch('/productos/{product}/desactivar', [ProductController::class, 'deactivate'])
            ->name('products.deactivate');

        /*
        |--------------------------------------------------------------------------
        | Clientes
        |--------------------------------------------------------------------------
        */

        // Muestra el listado de clientes.
        Route::get('/clientes', [ClientController::class, 'index'])
            ->name('clients.index');

        /*
        |--------------------------------------------------------------------------
        | Ventas
        |--------------------------------------------------------------------------
        */

        // Muestra el listado de ventas.
        Route::get('/ventas', [SaleController::class, 'index'])
            ->name('sales.index');
        
        // Muestra el resumen básico de contabilidad.
        Route::get('/contabilidad', [AccountingController::class, 'index'])
            ->name('accounting.index');  
    });

/*
|--------------------------------------------------------------------------
| Rutas del proveedor
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:Proveedor'])
    ->prefix('proveedor')
    ->as('proveedor.')
    ->group(function () {

        // Muestra el dashboard del proveedor.
        Route::get('/dashboard', [ProveedorController::class, 'dashboard'])
            ->name('dashboard');

        // Muestra los productos del proveedor.
        Route::get('/productos', [ProveedorController::class, 'products'])
            ->name('products.index');

        // Muestra el formulario para registrar un producto.
        Route::get('/productos/crear', [ProveedorController::class, 'create'])
            ->name('products.create');

        // Guarda un nuevo producto.
        Route::post('/productos', [ProveedorController::class, 'store'])
            ->name('products.store');

        // Muestra el formulario para editar un producto.
        Route::get('/productos/{product}/editar', [ProveedorController::class, 'edit'])
            ->name('products.edit');

        // Actualiza un producto existente.
        Route::put('/productos/{product}', [ProveedorController::class, 'update'])
            ->name('products.update');
    });

/*
|--------------------------------------------------------------------------
| Rutas del cliente
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:Cliente'])
    ->prefix('cliente')
    ->as('cliente.')
    ->group(function () {

        // Muestra el dashboard del cliente.
        Route::get('/dashboard', function () {
            return view('cliente.dashboard');
        })->name('dashboard');

        // Muestra el catálogo de productos disponibles.
        Route::get('/productos', [ClienteController::class, 'catalog'])
            ->name('catalog');

        // Muestra el carrito del cliente.
        Route::get('/carrito', [CartController::class, 'index'])
            ->name('cart.index');
        
       // Muestra las compras realizadas por el cliente.
        Route::get('/compras', [ClienteController::class, 'purchases'])
            ->name('purchases');   
        
       // Muestra el detalle de una compra del cliente.
        Route::get('/compras/{order}', [ClienteController::class, 'purchaseShow'])
            ->name('purchases.show');   

        // Agrega un producto al carrito.
        Route::post('/carrito/agregar/{product}', [CartController::class, 'add'])
            ->name('cart.add');

       // Aumenta la cantidad de un producto del carrito.
        Route::patch('/carrito/aumentar/{product}', [CartController::class, 'increase'])
            ->name('cart.increase');

       // Disminuye la cantidad de un producto del carrito.
        Route::patch('/carrito/disminuir/{product}', [CartController::class, 'decrease'])
            ->name('cart.decrease'); 

         // Elimina un producto del carrito.
        Route::delete('/carrito/eliminar/{product}', [CartController::class, 'remove'])
            ->name('cart.remove');
        
       // Finaliza la compra del cliente.
        Route::post('/carrito/finalizar', [CartController::class, 'checkout'])
            ->name('cart.checkout');     
            
    });




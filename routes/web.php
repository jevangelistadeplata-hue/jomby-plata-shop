<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
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
    });
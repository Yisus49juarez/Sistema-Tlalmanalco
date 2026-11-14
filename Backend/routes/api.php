<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\HomeController;
use Illuminate\Support\Facades\Route;

// Vista 1.1: Pantalla de Inicio (Pública)
Route::get('/inicio', [HomeController::class, 'index']);

// Vista 1.2 y 1.3: Registro e Inicio de Sesión
Route::prefix('auth')->group(function () {
    Route::post('/register', [RegisterController::class, 'store']);
    Route::post('/login', [LoginController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', [LoginController::class, 'me']);
        Route::post('/logout', [LoginController::class, 'logout']);
    });
});





// Rutas protegidas por Rol
Route::middleware('auth:sanctum')->prefix('panel')->group(function () {
    Route::middleware('role:Administrador')
        ->prefix('admin')
        ->group(base_path('routes/api/admin.php'));

    Route::middleware('role:Staff')
        ->prefix('staff')
        ->group(base_path('routes/api/staff.php'));

    Route::middleware('role:Turista')
        ->prefix('turista')
        ->group(base_path('routes/api/turista.php'));
});
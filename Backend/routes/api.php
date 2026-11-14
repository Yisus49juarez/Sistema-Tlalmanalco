<?php
<<<<<<< HEAD

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// 1. Rutas PÚBLICAS (No requieren token para entrar)
Route::post('/registro', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// 2. Rutas PROTEGIDAS (El middleware exige un token válido)
Route::middleware('auth:sanctum')->group(function () {
    
    // Cualquier ruta que pongas aquí adentro estará blindada.
    // Ejemplo para más adelante:
    // Route::post('/logout', [AuthController::class, 'logout']);
    
=======

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
>>>>>>> main
});
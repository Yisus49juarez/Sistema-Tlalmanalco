<?php

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
    
});
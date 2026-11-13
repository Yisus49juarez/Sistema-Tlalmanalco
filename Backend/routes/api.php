<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\HomeController;
use Illuminate\Http\Request;
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

// Rutas protegidas por Rol (Validación real mediante RoleMiddleware)
Route::middleware('auth:sanctum')->prefix('panel')->group(function () {

    Route::get('/admin', function (Request $request) {
        return response()->json([
            'status'   => 'ok',
            'rol'      => $request->user()->rol->nombre,
            'usuario'  => $request->user()->nombre_completo,
            'email'    => $request->user()->email,
            'permisos' => [
                'Dashboard de métricas financieras y afluencia',
                'Gestión y asignación de roles (Administrador, Staff, Turista)',
                'Asignación de tareas logísticas al Staff',
                'Gestión de publicaciones, eventos y catálogo de souvenirs',
            ],
        ]);
    })->middleware('role:Administrador');

    Route::get('/staff', function (Request $request) {
        return response()->json([
            'status'   => 'ok',
            'rol'      => $request->user()->rol->nombre,
            'usuario'  => $request->user()->nombre_completo,
            'email'    => $request->user()->email,
            'permisos' => [
                'CRUD de eventos y control logístico de recintos',
                'Escaneo y validación de códigos QR en puerta',
                'Gestión de inventario y preparación de pedidos de souvenirs',
                'Publicación de avisos rápidos y chat de soporte',
            ],
        ]);
    })->middleware('role:Staff');

    Route::get('/turista', function (Request $request) {
        return response()->json([
            'status'   => 'ok',
            'rol'      => $request->user()->rol->nombre,
            'usuario'  => $request->user()->nombre_completo,
            'email'    => $request->user()->email,
            'permisos' => [
                'Exploración de cartelera y adquisición de boletos con pase QR',
                'Compra de artesanías y recuerdos en la tienda virtual',
                'Chat directo de soporte con Staff y Administración',
                'Consulta de historial de compras y descarga de boletos',
            ],
        ]);
    })->middleware('role:Turista');
});
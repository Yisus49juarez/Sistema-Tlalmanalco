<?php

use App\Http\Controllers\Api\Admin\DashboardController;
use App\Http\Controllers\Api\Admin\GestionRolController;
use App\Http\Controllers\Api\Admin\PublicacionController;
use App\Http\Controllers\Api\Admin\TareaLogisticaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Tu ruta actual /api/panel/admin (queda intacta)
Route::get('/', function (Request $request) {
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
});

// Vista 2.1: Dashboard de Métricas
Route::get('/dashboard', [DashboardController::class, 'index']);


// Vista 2.2: Gestión de Roles
Route::get('/usuarios', [GestionRolController::class, 'index']);
Route::patch('/usuarios/{usuario}/rol', [GestionRolController::class, 'update']);


// Vista 2.3: Asignación de Tareas (Logística)
Route::get('/tareas', [TareaLogisticaController::class, 'index']);
Route::post('/tareas', [TareaLogisticaController::class, 'store']);
Route::patch('/tareas/{tarea}', [TareaLogisticaController::class, 'update']);
Route::delete('/tareas/{tarea}', [TareaLogisticaController::class, 'destroy']);


// Vista 2.4: Gestión de Publicaciones
Route::get('/publicaciones', [PublicacionController::class, 'index']);
Route::post('/publicaciones', [PublicacionController::class, 'store']);
Route::patch('/publicaciones/{publicacion}', [PublicacionController::class, 'update']);
Route::delete('/publicaciones/{publicacion}', [PublicacionController::class, 'destroy']);
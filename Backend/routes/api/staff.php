<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request) {
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
});
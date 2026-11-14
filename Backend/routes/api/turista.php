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
            'Exploración de cartelera y adquisición de boletos con pase QR',
            'Compra de artesanías y recuerdos en la tienda virtual',
            'Chat directo de soporte con Staff y Administración',
            'Consulta de historial de compras y descarga de boletos',
        ],
    ]);
});
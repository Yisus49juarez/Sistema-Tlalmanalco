<?php
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json(['mensaje' => 'El motor del Backend está funcionando correctamente.']);
});
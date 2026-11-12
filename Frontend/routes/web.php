<?php

use Illuminate\Support\Facades\Route;

// Vistas Públicas (Módulo 1)
Route::get('/', fn () => view('public.inicio'))->name('inicio');
Route::get('/registro', fn () => view('public.registro'))->name('registro');
Route::get('/login', fn () => view('public.login'))->name('login');

// 1. Vista exclusiva del Administrador
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

// 2. Vista exclusiva del Staff
Route::get('/staff/eventos', function () {
    return view('staff.panel');
})->name('staff.eventos');

// 3. Vista exclusiva del Turista
Route::get('/cartelera', function () {
    return view('turista.cartelera');
})->name('turista.cartelera');
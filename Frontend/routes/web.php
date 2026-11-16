<?php

use Illuminate\Support\Facades\Route;

// Vistas Públicas (Módulo 1)
Route::get('/', fn () => view('public.inicio'))->name('inicio');
Route::get('/registro', fn () => view('public.registro'))->name('registro');
Route::get('/login', fn () => view('public.login'))->name('login');

// Vistas del Panel Administrador (Módulo 2)
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', fn () => view('admin.dashboard'))->name('admin.dashboard');
    Route::get('/usuarios', fn () => view('admin.usuarios'))->name('admin.usuarios');
    Route::get('/tareas', fn () => view('admin.tareas'))->name('admin.tareas');
    Route::get('/publicaciones', fn () => view('admin.publicaciones'))->name('admin.publicaciones');
});

// Vista exclusiva del Staff
Route::get('/staff/eventos', fn () => view('staff.panel'))->name('staff.eventos');

// Vista exclusiva del Turista
Route::get('/cartelera', fn () => view('turista.cartelera'))->name('turista.cartelera');
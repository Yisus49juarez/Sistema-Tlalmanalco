<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePublicacionRequest;
use App\Http\Requests\Admin\UpdatePublicacionRequest;
use App\Models\Publicacion;
use Illuminate\Http\JsonResponse;

class PublicacionController extends Controller
{
    public function index(): JsonResponse
    {
        $publicaciones = Publicacion::with([
            'autor:id,nombre_completo',
            'evento:id,titulo',
        ])->orderBy('id', 'desc')->get();

        return response()->json([
            'status' => 'ok',
            'data'   => $publicaciones,
        ]);
    }


    
    public function store(StorePublicacionRequest $request): JsonResponse
    {
        $datos = $request->validated();

        $publicacion = Publicacion::create([
            'user_id'   => $request->user()->id,
            'evento_id' => $datos['evento_id'] ?? null,
            'titulo'    => $datos['titulo'],
            'contenido' => $datos['contenido'],
            'tipo'      => $datos['tipo'] ?? 'Noticia',
        ]);

        return response()->json([
            'status'  => 'ok',
            'mensaje' => 'Publicación creada exitosamente.',
            'data'    => $publicacion->load(['autor:id,nombre_completo', 'evento:id,titulo']),
        ], 201);
    }



    public function update(UpdatePublicacionRequest $request, Publicacion $publicacion): JsonResponse
    {
        $publicacion->update($request->validated());

        return response()->json([
            'status'  => 'ok',
            'mensaje' => 'Publicación actualizada correctamente.',
            'data'    => $publicacion->load(['autor:id,nombre_completo', 'evento:id,titulo']),
        ]);
    }



    public function destroy(Publicacion $publicacion): JsonResponse
    {
        $publicacion->delete();

        return response()->json([
            'status'  => 'ok',
            'mensaje' => 'Publicación eliminada correctamente.',
        ]);
    }
}
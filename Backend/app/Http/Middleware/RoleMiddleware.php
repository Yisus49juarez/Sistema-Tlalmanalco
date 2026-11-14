<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$rolesPermitidos): Response
    {
        $usuario = $request->user()?->loadMissing('rol');

        if (! $usuario || ! $usuario->rol) {
            return response()->json([
                'mensaje' => 'No autenticado o sin rol asignado.',
            ], 401);
        }

        if (! in_array($usuario->rol->nombre, $rolesPermitidos, true)) {
            return response()->json([
                'mensaje' => 'No tienes permisos para acceder a este recurso.',
                'rol_actual' => $usuario->rol->nombre,
            ], 403);
        }

        return $next($request);
    }
}
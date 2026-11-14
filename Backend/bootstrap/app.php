<?php

use App\Http\Middleware\RoleMiddleware;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => RoleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {

        // 1. Forzar que toda ruta api/* devuelva JSON siempre (nunca HTML)
        $exceptions->shouldRenderJsonWhen(function (Request $request, Throwable $e) {
            return $request->is('api/*') || $request->expectsJson();
        });

        // 2. Error 422 / 400: Fallo de validación en FormRequests o Actions
        $exceptions->render(function (ValidationException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'status'  => 'error',
                    'codigo'  => 422,
                    'mensaje' => 'Los datos enviados no son válidos.',
                    'errores' => $e->errors(),
                ], 422);
            }
        });

        // 3. Error 400: Petición mal formada (JSON inválido o parámetros erróneos)
        $exceptions->render(function (BadRequestHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'status'  => 'error',
                    'codigo'  => 400,
                    'mensaje' => $e->getMessage() ?: 'La petición es inválida (Bad Request).',
                ], 400);
            }
        });

        // 4. Error 401: Token faltante, inválido o expirado (Sanctum)
        $exceptions->render(function (AuthenticationException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'status'  => 'error',
                    'codigo'  => 401,
                    'mensaje' => 'No autenticado. Por favor inicia sesión e incluye tu Bearer Token.',
                ], 401);
            }
        });

        // 5. Error 403: Sin permisos suficientes
        $exceptions->render(function (AccessDeniedHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'status'  => 'error',
                    'codigo'  => 403,
                    'mensaje' => 'No tienes permisos para realizar esta acción.',
                ], 403);
            }
        });

        // 6. Error 404: Registro de BD no encontrado (ej. /usuarios/999/rol) o URL inexistente
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                $esModelo = $e->getPrevious() instanceof ModelNotFoundException;

                return response()->json([
                    'status'  => 'error',
                    'codigo'  => 404,
                    'mensaje' => $esModelo
                        ? 'El registro solicitado no existe en la base de datos.'
                        : 'El endpoint solicitado no existe.',
                ], 404);
            }
        });

        // 7. Error 405: Método HTTP incorrecto (ej. hacer GET a una ruta POST)
        $exceptions->render(function (MethodNotAllowedHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'status'  => 'error',
                    'codigo'  => 405,
                    'mensaje' => 'Método HTTP no permitido para esta ruta.',
                ], 405);
            }
        });

        // 8. Error 500: Fallo de consulta SQL o llave foránea en Base de Datos
        $exceptions->render(function (QueryException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'status'  => 'error',
                    'codigo'  => 500,
                    'mensaje' => 'Error al procesar la operación en la base de datos.',
                    'detalle' => config('app.debug') ? $e->getMessage() : null,
                ], 500);
            }
        });

        // 9. Error 500 Genérico: Cualquier otro fallo inesperado del servidor
        $exceptions->render(function (Throwable $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'status'  => 'error',
                    'codigo'  => 500,
                    'mensaje' => 'Ocurrió un error interno en el servidor.',
                    'detalle' => config('app.debug') ? $e->getMessage() : null,
                ], 500);
            }
        });

    })->create();
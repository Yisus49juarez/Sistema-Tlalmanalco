<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function __construct(
        private readonly AuthService $authService
    ) {}

    public function login(LoginRequest $request): JsonResponse
    {
        $resultado = $this->authService->login($request->validated());

        return response()->json([
            'status'  => 'ok',
            'mensaje' => 'Inicio de sesión exitoso.',
            'data'    => $resultado,
        ]);
    }

    public function me(Request $request): JsonResponse
    {
        $usuario = $request->user()->load('rol');

        return response()->json([
            'status' => 'ok',
            'data'   => [
                'usuario' => $usuario,
                'rol'     => $usuario->rol->nombre,
            ],
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $this->authService->logout($request->user());

        return response()->json([
            'status'  => 'ok',
            'mensaje' => 'Sesión cerrada correctamente.',
        ]);
    }
}
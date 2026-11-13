<?php

namespace App\Services;

use App\Models\Rol;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function login(array $credenciales): array
    {
        $usuario = User::with('rol')
            ->where('email', $credenciales['email'])
            ->first();

        if (! $usuario || ! Hash::check($credenciales['password'], $usuario->password)) {
            throw ValidationException::withMessages([
                'email' => ['Las credenciales proporcionadas son incorrectas.'],
            ]);
        }

        $usuario->tokens()->delete();

        $token = $usuario->createToken('auth_token')->plainTextToken;

        return [
            'usuario'     => $usuario,
            'rol'         => $usuario->rol->nombre,
            'redirect_to' => $this->obtenerRutaPorRol($usuario->rol_id),
            'token'       => $token,
        ];
    }

    public function logout(User $usuario): void
    {
        $usuario->currentAccessToken()?->delete();
    }

    private function obtenerRutaPorRol(int $rolId): string
    {
        return match ($rolId) {
            Rol::ID_ADMINISTRADOR => '/admin/dashboard',
            Rol::ID_STAFF => '/staff/eventos',
            default => '/cartelera',
        };
    }
}
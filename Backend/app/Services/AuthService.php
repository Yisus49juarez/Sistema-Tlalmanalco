<?php

namespace App\Services;

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

        // Revocar tokens previos para mantener sesión limpia
        $usuario->tokens()->delete();

        $token = $usuario->createToken('auth_token')->plainTextToken;
        $nombreRol = $usuario->rol->nombre;

        return [
            'usuario'      => $usuario,
            'rol'          => $nombreRol,
            'redirect_to'  => $this->obtenerRutaPorRol($nombreRol),
            'token'        => $token,
        ];
    }

    public function logout(User $usuario): void
    {
        $usuario->currentAccessToken()?->delete();
    }

    private function obtenerRutaPorRol(string $rol): string
    {
        return match ($rol) {
            'Administrador' => '/admin/dashboard',
            'Staff'         => '/staff/eventos',
            default         => '/cartelera',
        };
    }
}
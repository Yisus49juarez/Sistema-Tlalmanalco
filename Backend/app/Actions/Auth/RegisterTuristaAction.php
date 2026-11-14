<?php

namespace App\Actions\Auth;

use App\Models\Rol;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterTuristaAction
{
    public function execute(array $datosValidados): array
    {
        return DB::transaction(function () use ($datosValidados) {
            $usuario = User::create([
                'rol_id'          => Rol::ID_TURISTA,
                'nombre_completo' => $datosValidados['nombre_completo'],
                'email'           => $datosValidados['email'],
                'password'        => Hash::make($datosValidados['password']),
            ]);

            $usuario->load('rol');
            $token = $usuario->createToken('auth_token')->plainTextToken;

            return [
                'usuario'     => $usuario,
                'rol'         => $usuario->rol->nombre,
                'redirect_to' => '/cartelera',
                'token'       => $token,
            ];
        });
    }
}
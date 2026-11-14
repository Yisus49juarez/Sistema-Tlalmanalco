<?php

namespace App\Actions\Admin;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AsignarRolUsuarioAction
{
    public function execute(User $adminActual, User $usuarioObjetivo, int $nuevoRolId): User
    {
        if ($adminActual->id === $usuarioObjetivo->id && $nuevoRolId !== $adminActual->rol_id) {
            throw ValidationException::withMessages([
                'rol_id' => ['Por seguridad, no puedes revocar tu propio rol de Administrador.'],
            ]);
        }

        return DB::transaction(function () use ($usuarioObjetivo, $nuevoRolId) {
            $usuarioObjetivo->update(['rol_id' => $nuevoRolId]);
            $usuarioObjetivo->tokens()->delete();

            return $usuarioObjetivo->load('rol');
        });
    }
}
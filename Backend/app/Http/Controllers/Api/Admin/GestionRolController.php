<?php

namespace App\Http\Controllers\Api\Admin;

use App\Actions\Admin\AsignarRolUsuarioAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateUserRolRequest;
use App\Models\Rol;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class GestionRolController extends Controller
{
    public function __construct(
        private readonly AsignarRolUsuarioAction $asignarRolUsuarioAction
    ) {}

    public function index(): JsonResponse
    {
        return response()->json([
            'status' => 'ok',
            'data'   => [
                'usuarios' => User::with('rol:id,nombre')
                    ->select('id', 'rol_id', 'nombre_completo', 'email', 'created_at')
                    ->orderBy('id', 'desc')
                    ->get(),
                'roles_disponibles' => Rol::select('id', 'nombre')->orderBy('id')->get(),
            ],
        ]);
    }



    
    public function update(UpdateUserRolRequest $request, User $usuario): JsonResponse
    {
        $actualizado = $this->asignarRolUsuarioAction->execute(
            $request->user(),
            $usuario,
            (int) $request->validated()['rol_id']
        );

        return response()->json([
            'status'  => 'ok',
            'mensaje' => 'Rol asignado correctamente.',
            'data'    => $actualizado,
        ]);
    }
}
<?php

namespace App\Actions\Admin;

use App\Models\Rol;
use App\Models\TareaLogistica;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class AsignarTareaLogisticaAction
{
    public function execute(User $admin, array $datos): TareaLogistica
    {
        $miembroStaff = User::findOrFail($datos['staff_id']);

        if (! in_array($miembroStaff->rol_id, [Rol::ID_STAFF, Rol::ID_ADMINISTRADOR], true)) {
            throw ValidationException::withMessages([
                'staff_id' => ['Solo puedes asignar tareas logísticas a usuarios con rol de Staff o Administrador.'],
            ]);
        }

        $tarea = TareaLogistica::create([
            'evento_id'    => $datos['evento_id'] ?? null,
            'staff_id'     => $datos['staff_id'],
            'asignado_por' => $admin->id,
            'titulo'       => $datos['titulo'],
            'descripcion'  => $datos['descripcion'] ?? null,
            'estatus'      => 'Pendiente',
        ]);

        return $tarea->load([
            'staff:id,nombre_completo,email',
            'evento:id,titulo,fecha_hora',
            'administrador:id,nombre_completo',
        ]);
    }
}
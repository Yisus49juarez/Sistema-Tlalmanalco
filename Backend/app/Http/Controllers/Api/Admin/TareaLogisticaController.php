<?php

namespace App\Http\Controllers\Api\Admin;

use App\Actions\Admin\AsignarTareaLogisticaAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTareaLogisticaRequest;
use App\Http\Requests\Admin\UpdateTareaLogisticaRequest;
use App\Models\Rol;
use App\Models\TareaLogistica;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class TareaLogisticaController extends Controller
{
    public function __construct(
        private readonly AsignarTareaLogisticaAction $asignarTareaAction
    ) {}



    
    public function index(): JsonResponse
    {
        $tareas = TareaLogistica::with([
            'staff:id,nombre_completo,email',
            'evento:id,titulo,fecha_hora,lugar',
            'administrador:id,nombre_completo',
        ])->orderBy('id', 'desc')->get();

        $personalStaff = User::where('rol_id', Rol::ID_STAFF)
            ->select('id', 'nombre_completo', 'email')
            ->get();

        return response()->json([
            'status' => 'ok',
            'data'   => [
                'tareas'           => $tareas,
                'staff_disponible' => $personalStaff,
            ],
        ]);
    }



    public function store(StoreTareaLogisticaRequest $request): JsonResponse
    {
        $tarea = $this->asignarTareaAction->execute($request->user(), $request->validated());

        return response()->json([
            'status'  => 'ok',
            'mensaje' => 'Tarea logística asignada exitosamente.',
            'data'    => $tarea,
        ], 201);
    }






    public function update(UpdateTareaLogisticaRequest $request, TareaLogistica $tarea): JsonResponse
    {
        $tarea->update($request->validated());

        return response()->json([
            'status'  => 'ok',
            'mensaje' => 'Tarea logística actualizada correctamente.',
            'data'    => $tarea->load(['staff:id,nombre_completo', 'evento:id,titulo']),
        ]);
    }






    public function destroy(TareaLogistica $tarea): JsonResponse
    {
        $tarea->delete();

        return response()->json([
            'status'  => 'ok',
            'mensaje' => 'Tarea logística eliminada.',
        ]);
    }
}
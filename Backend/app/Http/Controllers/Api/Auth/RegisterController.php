<?php

namespace App\Http\Controllers\Api\Auth;

use App\Actions\Auth\RegisterTuristaAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterUserRequest;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    public function __construct(
        private readonly RegisterTuristaAction $registerTuristaAction
    ) {}

    public function store(RegisterUserRequest $request): JsonResponse
    {
        $resultado = $this->registerTuristaAction->execute($request->validated());

        return response()->json([
            'status'  => 'ok',
            'mensaje' => 'Cuenta de turista creada exitosamente.',
            'data'    => $resultado,
        ], 201);
    }
}
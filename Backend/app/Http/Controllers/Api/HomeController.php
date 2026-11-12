<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\HomePortalService;
use Illuminate\Http\JsonResponse;

class HomeController extends Controller
{
    public function __construct(
        private readonly HomePortalService $homePortalService
    ) {}

    public function index(): JsonResponse
    {
        return response()->json([
            'status' => 'ok',
            'data'   => $this->homePortalService->obtenerDatosInicio(),
        ]);
    }
}
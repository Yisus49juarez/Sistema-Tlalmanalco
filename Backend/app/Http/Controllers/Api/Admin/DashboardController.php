<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Services\MetricsAnalyticsService;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    public function __construct(
        private readonly MetricsAnalyticsService $metricsAnalyticsService
    ) {}

    public function index(): JsonResponse
    {
        return response()->json([
            'status' => 'ok',
            'data'   => $this->metricsAnalyticsService->obtenerResumenDashboard(),
        ]);
    }
}
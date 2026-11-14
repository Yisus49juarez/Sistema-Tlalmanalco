<?php

namespace App\Services;

use App\Models\Evento;
use App\Models\Pedido;
use App\Models\Publicacion;
use App\Models\TareaLogistica;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class MetricsAnalyticsService
{
    public function obtenerResumenDashboard(): array
    {
        $ingresosTienda = (float) Pedido::whereIn('estatus', ['Pagado', 'Entregado'])
            ->sum('total_pago');

        $ingresosBoletos = (float) Ticket::join('eventos', 'tickets.evento_id', '=', 'eventos.id')
            ->sum('eventos.precio');

        $eventosPorEstatus = Evento::select('estatus', DB::raw('COUNT(*) as total'))
            ->groupBy('estatus')
            ->pluck('total', 'estatus');

        $pedidosPorEstatus = Pedido::select('estatus', DB::raw('COUNT(*) as total'))
            ->groupBy('estatus')
            ->pluck('total', 'estatus');

        $tareasPorEstatus = TareaLogistica::select('estatus', DB::raw('COUNT(*) as total'))
            ->groupBy('estatus')
            ->pluck('total', 'estatus');

        $usuariosPorRol = User::join('roles', 'usuarios.rol_id', '=', 'roles.id')
            ->select('roles.nombre as rol', DB::raw('COUNT(usuarios.id) as total'))
            ->groupBy('roles.nombre')
            ->pluck('total', 'rol');

        return [
            'finanzas' => [
                'ingresos_tienda'  => round($ingresosTienda, 2),
                'ingresos_boletos' => round($ingresosBoletos, 2),
                'ingresos_totales' => round($ingresosTienda + $ingresosBoletos, 2),
            ],
            'eventos' => [
                'total'              => Evento::count(),
                'por_estatus'        => $eventosPorEstatus,
                'boletos_emitidos'   => Ticket::count(),
                'boletos_escaneados' => Ticket::where('estatus_acceso', 'Escaneado')->count(),
            ],
            'tienda' => [
                'total_pedidos'       => Pedido::count(),
                'pedidos_por_estatus' => $pedidosPorEstatus,
            ],
            'logistica' => [
                'total_tareas'        => TareaLogistica::count(),
                'tareas_por_estatus'  => $tareasPorEstatus,
                'total_publicaciones' => Publicacion::count(),
            ],
            'usuarios' => [
                'total'   => User::count(),
                'por_rol' => $usuariosPorRol,
            ],
        ];
    }
}
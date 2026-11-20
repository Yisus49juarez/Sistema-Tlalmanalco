<?php

namespace App\Services;

use App\Models\Evento;

class HomePortalService
{
    public function obtenerDatosInicio(): array
    {
        $proximosEventos = Evento::where('estatus', 'Activo')
            ->where('fecha_hora', '>=', now())
            ->orderBy('fecha_hora', 'asc')
            ->take(6)
            ->get();

        return [
            'municipio'  => 'Tlalmanalco, Estado de México',
            'proximos_eventos'   => $proximosEventos,
        ];
    }
}
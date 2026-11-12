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

        $lugaresDestacados = [
            [
                'nombre'      => 'Capilla Abierta y Ex Convento de San Luis Obispo',
                'ubicacion'   => 'Tlalmanalco Centro',
                'descripcion' => 'Patrimonio arquitectónico del siglo XVI famoso por sus relieves en piedra de arte tequitqui.',
            ],
            [
                'nombre'      => 'Parque Ecoturístico Dos Aguas',
                'ubicacion'   => 'San Rafael, Tlalmanalco',
                'descripcion' => 'Reserva natural al pie del Iztaccíhuatl con cascadas, senderismo y avistamiento de luciérnagas.',
            ],
            [
                'nombre'      => 'Museo Comunitario Nonohualca',
                'ubicacion'   => 'Centro Histórico de Tlalmanalco',
                'descripcion' => 'Acervo arqueológico e histórico de los pueblos originarios de la región chalca-amecameca.',
            ],
        ];

        return [
            'municipio'          => 'Tlalmanalco, Estado de México',
            'lugares_turisticos' => $lugaresDestacados,
            'proximos_eventos'   => $proximosEventos,
        ];
    }
}
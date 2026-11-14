<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    protected $table = 'eventos';

    protected $fillable = [
        'titulo',
        'descripcion',
        'lugar',
        'fecha_hora',
        'aforo_maximo',
        'precio',
        'estatus',
    ];

    protected function casts(): array
    {
        return [
            'fecha_hora' => 'datetime',
            'aforo_maximo' => 'integer',
            'precio' => 'decimal:2',
        ];
    }
}
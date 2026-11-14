<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TareaLogistica extends Model
{
    protected $table = 'tareas_logisticas';

    protected $fillable = [
        'evento_id',
        'staff_id',
        'asignado_por',
        'titulo',
        'descripcion',
        'estatus',
    ];

    public function evento(): BelongsTo
    {
        return $this->belongsTo(Evento::class, 'evento_id');
    }

    public function staff(): BelongsTo
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    public function administrador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'asignado_por');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rol extends Model
{
    protected $table = 'roles';

    // IDs normalizados (PK del catálogo roles)
    public const ID_ADMINISTRADOR = 1;
    public const ID_STAFF = 2;
    public const ID_TURISTA = 3;

    // Nombres estandarizados
    public const NOMBRE_ADMINISTRADOR = 'Administrador';
    public const NOMBRE_STAFF = 'Staff';
    public const NOMBRE_TURISTA = 'Turista';

    protected $fillable = [
        'nombre',
    ];

    public function usuarios(): HasMany
    {
        return $this->hasMany(User::class, 'rol_id');
    }
}
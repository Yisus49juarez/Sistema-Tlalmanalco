<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

<<<<<<< HEAD
    protected $fillable = [
        'nombre_completo',
        'email',
        'password',
        'rol_id',
=======
    protected $table = 'usuarios';

    protected $fillable = [
        'rol_id',
        'nombre_completo',
        'email',
        'password',
>>>>>>> main
    ];

    protected $hidden = [
        'password',
<<<<<<< HEAD
        'remember_token',
=======
>>>>>>> main
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
<<<<<<< HEAD
=======

    public function rol(): BelongsTo
    {
        return $this->belongsTo(Rol::class, 'rol_id');
    }

    public function tieneRol(string $nombreRol): bool
    {
        return $this->rol && strcasecmp($this->rol->nombre, $nombreRol) === 0;
    }
>>>>>>> main
}
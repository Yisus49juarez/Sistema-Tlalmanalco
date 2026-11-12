<?php

namespace Database\Seeders;

use App\Models\Evento;
use App\Models\Rol;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Crear Roles oficiales
        $rolAdmin   = Rol::firstOrCreate(['nombre' => 'Administrador']);
        $rolStaff   = Rol::firstOrCreate(['nombre' => 'Staff']);
        $rolTurista = Rol::firstOrCreate(['nombre' => 'Turista']);

        // 2. Crear Usuarios base por cada rol
        User::updateOrCreate(
            ['email' => 'admin@tlalmanalco.gob.mx'],
            [
                'rol_id' => $rolAdmin->id,
                'nombre_completo' => 'Administrador General',
                'password' => Hash::make('password123'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'staff@tlalmanalco.gob.mx'],
            [
                'rol_id' => $rolStaff->id,
                'nombre_completo' => 'Operador Staff Cultural',
                'password' => Hash::make('password123'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'turista@ejemplo.com'],
            [
                'rol_id' => $rolTurista->id,
                'nombre_completo' => 'Visitante de Prueba',
                'password' => Hash::make('password123'),
            ]
        );

        // 3. Eventos iniciales para la Pantalla de Inicio (Vista 1.1)
        Evento::firstOrCreate(
            ['titulo' => 'Recorrido Histórico: Capilla Abierta y Ex Convento de San Luis Obispo'],
            [
                'descripcion' => 'Visita guiada por el conjunto conventual franciscano del siglo XVI y su joya del arte tequitqui.',
                'lugar' => 'Centro Histórico de Tlalmanalco',
                'fecha_hora' => now()->addDays(7)->setTime(11, 0),
                'aforo_maximo' => 80,
                'precio' => 0.00,
                'estatus' => 'Activo',
            ]
        );

        Evento::firstOrCreate(
            ['titulo' => 'Avistamiento Nocturno de Luciérnagas'],
            [
                'descripcion' => 'Recorrido ecoturístico guiado por los senderos boscosos de San Juan Atzacualoya.',
                'lugar' => 'Parque Ecoturístico Dos Aguas, Tlalmanalco',
                'fecha_hora' => now()->addDays(14)->setTime(19, 30),
                'aforo_maximo' => 50,
                'precio' => 150.00,
                'estatus' => 'Activo',
            ]
        );
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // 1. Validar que el frontend envíe todo correctamente
        $request->validate([
            'name' => 'required|string|max:255',
            'apellido' => 'nullable|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6',
        ]);

        // 2. Crear al usuario en la base de datos
        $user = User::create([
            'name' => $request->name,
            'apellido' => $request->apellido,
            'rol' => $request->rol ?? 'turista', // Si no envían rol, será turista
            'email' => $request->email,
            'password' => Hash::make($request->password), // ¡Secreto e indescifrable!
        ]);

        // 3. Responderle al frontend que todo salió bien
        return response()->json([
            'mensaje' => 'Usuario registrado exitosamente',
            'usuario' => $user
        ], 201);
    }
}
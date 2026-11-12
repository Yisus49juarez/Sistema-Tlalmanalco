<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // Función para REGISTRAR
public function register(Request $request)
    {
        // 1. Ya no pedimos ni validamos el rol_id que viene de fuera
        $request->validate([
            'nombre_completo' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8'
        ]);

        // 2. Insertar en la base de datos forzando el rol 3
        $user = User::create([
            'nombre_completo' => $request->nombre_completo,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol_id' => 3, // <-- Todo usuario nuevo será rol 3 (Turista/Usuario)
        ]);

        // 3. Generar el token de seguridad
        $token = $user->createToken('auth_token')->plainTextToken;

        // 4. Retornar respuesta
        return response()->json([
            'message' => 'Usuario registrado exitosamente',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ], 201);
            }



            
    // Función para INICIAR SESIÓN
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Buscar al usuario por correo
        $user = User::where('email', $request->email)->first();

        // Verificar que exista y la contraseña coincida
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['El correo o la contraseña son incorrectos.'],
            ]);
        }

        // Generar nuevo token
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Inicio de sesión exitoso',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ]);
    }
}
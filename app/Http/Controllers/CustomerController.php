<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CustomerController extends Controller
{
    /*public function login(Request $request)
    {

        try {
            // Validar la solicitud
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|string',
            ]);

            // Intentar autenticar al usuario utilizando las credenciales proporcionadas
            if (Auth::attempt($request->only('email', 'password'))) {
                // Autenticación exitosa, obtener el usuario autenticado
                $user = Auth::user();

                // Generar token de acceso
                $token = $user->createToken('auth_token')->plainTextToken;
                unset($user['id'], $user['created_at'], $user['updated_at']);

                // Devolver el token y la información del usuario como respuesta
                return response()->json(['user' => $user, 'token' => $token], 200);
            } else {
                // Si las credenciales son inválidas, devolver un error de autenticación
                return response()->json(['error' => 'Invalid credentials'], 401);
            }
        } catch (\Exception $e) {
            // Capturar cualquier excepción y devolver una respuesta de error
            return response()->json(['error' => 'Failed to log in: ' . $e->getMessage()], 500);
        }
    }*/
}

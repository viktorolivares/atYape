<?php

namespace App\Http\Controllers\Api;

use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');


        if (Auth::attempt($credentials)) {

            $user = Auth::user();

            if ($user->state === 'active') {
                return response()->json([
                    'success' => true,
                    'authUser' => $user,
                ]);
            } else {

                throw ValidationException::withMessages([
                    'credentials' => ['El estado de tu cuenta no está activo.'],
                ]);
            }

        } else {

            $errors = [];

            if (!$request->has('email')) {
                $errors['email'] = ['El campo de correo electrónico es requerido.'];
            }

            if (!$request->has('password')) {
                $errors['password'] = ['El campo de contraseña es requerido.'];
            }

            throw ValidationException::withMessages([
                'credentials' => ['Las credenciales proporcionadas son incorrectas.'],
            ]);


        }

    }

    public function logout()
    {
        Auth::logout();

        return response()->json(['message' => 'Logged out']);
    }
}

<?php

namespace App\Http\Controllers\Api;

use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            $user = Auth::user();

            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                'message' => 'Authentication successful',
                'token' => $token], 200);

        } else {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    }

    public function logout()
    {
        Auth::guard('web')->logout();

        return response()->json(['message' => 'Logged out successfully'], 200);
    }
}

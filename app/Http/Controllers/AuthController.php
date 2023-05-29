<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\ValidationException;
use App\Http\Services\ActivityLogService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $activityLogService;

    public function __construct(ActivityLogService $activityLogService)
    {
        $this->activityLogService = $activityLogService;
    }

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

                $logData = [
                    'user_id' => Auth::id(),
                    'model' => 'Auth',
                    'action' => 'Login',
                    'ip' => $request->ip(),
                    'data' => [
                        'login' => [
                            'email' => $request->email
                        ]
                    ],
                ];

                $this->activityLogService->createLog(
                    $logData['user_id'],
                    $logData['model'],
                    $logData['action'],
                    $logData['ip'],
                    $logData['data']
                );

                return response()->json([
                    'success' => true,
                    'authUser' => $user,
                ], Response::HTTP_OK);
                
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

    public function logout(Request $request)
    {

        $user = Auth::user();

        $logData = [
            'user_id' => Auth::id(),
            'model' => 'Auth',
            'action' => 'Logout',
            'ip' => $request->ip(),
            'data' => [
                'logout' => [
                    'email' => $user->email
                ]
            ],
        ];

        $this->activityLogService->createLog(
            $logData['user_id'],
            $logData['model'],
            $logData['action'],
            $logData['ip'],
            $logData['data']
        );

        Auth::logout();

        return response()->json(Response::HTTP_NO_CONTENT);

    }

}

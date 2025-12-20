<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required']
        );

        $user = $this->authService->authenticate(
            $request->username,
            $request->password
        );

        if ($user) {
            $token = $user->createToken('api_token')->plainTextToken;

            return response()->json([
                'message' => 'Login Berhasil',
                'user' => new UserResource($user),
                'access_token' => $token,
                'token_type' => 'Bearer',
            ], 200);
        }

        return response()->json([
            'message' => 'Username atau Password Salah',
        ], 401);
    }
}

<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Services\AuthService;

class AuthController
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $result = $this->authService->login($request->only('username', 'password'));

        if (!$result['success']) {
            return response()->json(['message' => $result['message']], 401);
        }

        return response()->json($result['data']);
    }

    public function logout()
    {
        $result = $this->authService->logout();
        return response()->json($result);
    }
}

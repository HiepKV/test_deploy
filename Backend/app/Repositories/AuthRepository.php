<?php

namespace App\Repositories;

use App\Repositories\Contracts\AuthRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class AuthRepository implements AuthRepositoryInterface
{
    /**
     * Đăng nhập và trả về JWT token nếu thành công
     */
    public function login(array $credentials)
    {
        if (!$token = Auth::guard('api')->attempt($credentials)) {
            return "Wrong username or password";
        }

        return $token;
    }

    public function logout()
    {
        Auth::guard('api')->logout();
        return true;
    }
}

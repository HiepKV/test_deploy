<?php

namespace App\Services;

use App\Repositories\Contracts\AuthRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    protected $authRepo;

    public function __construct(AuthRepositoryInterface $authRepo)
    {
        $this->authRepo = $authRepo;
    }
    public function login(array $credentials)
    {
        $token = $this->authRepo->login($credentials);

        if (!$token) {
            return [
                'success' => false,
                'message' => 'Sai tài khoản hoặc mật khẩu',
            ];
        }

        return [
            'success' => true,
            'data' => [
                'access_token' => $token,
                'token_type'   => 'bearer',
            ]
        ];
    }


    public function logout()
    {
        $this->authRepo->logout();

        return [
            'success' => true,
            'message' => 'Đăng xuất thành công',
        ];
    }
}

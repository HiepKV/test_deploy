<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Http\Request;

class UserService extends BaseService
{
    protected UserRepositoryInterface $userRepository;
    public function __construct(
        UserRepositoryInterface $userRepository,
    )
    {
        $this->userRepository = $userRepository;
    }

    public function getUsers(Request $request): \Illuminate\Database\Eloquent\Collection
    {
        return $this->userRepository->getUsers($request->all());
    }

    public function getUser(int $userId): mixed
    {
        return $this->userRepository->find($userId);
    }

    public function isValidUser(User $user): bool
    {
        return $user->hasVerifiedEmail();
    }
}

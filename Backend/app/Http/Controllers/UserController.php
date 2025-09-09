<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(
        UserService $userService,
    )
    {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        $users = $this->userService->getUsers($request);

        dd($users->toArray());
    }

    /**
     * @throws \Exception
     */
    public function show(int $userId)
    {
        $user = $this->userService->getUser($userId);

        if (!$this->userService->isValidUser($user)) {
            abort(403);
        }

        dd($user->toArray());
    }

}

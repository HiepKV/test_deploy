<?php

namespace App\Repositories\Contracts;

interface UserRepositoryInterface
{
    public function getUsers($filters = []);
}

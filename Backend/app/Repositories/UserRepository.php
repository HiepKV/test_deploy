<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;

/**
 * Class BuildingInvitedMemberRepository
 *
 * @package App\Repositories
 */
class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * Model
     *
     * @return string
     */
    public function model(): string
    {
        return User::class;
    }

    public function getUsers($filters = []): \Illuminate\Database\Eloquent\Collection
    {
        $query = $this->model->newQuery();

        if (!empty($filters['verified'])) {
            $query->verifiedEmail();
        }

        return $query->get();
    }
}

<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Eloquent\BaseRepository as BasePrettusRepository;

/**
 * Class BaseRepository
 *
 * @package App\Repositories
 */
class BaseRepository extends BasePrettusRepository implements RepositoryInterface
{
    /**
     * Model
     *
     * @return string
     */
    public function model()
    {}
}

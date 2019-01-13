<?php

namespace App\Repositories;

use App\Models\Role;
use App\Models\User;
use App\Repositories\Criteria\UserCriteria;
use App\Support\Repositories\RepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class RoleRepository extends BaseRepository implements RepositoryInterface
{
    public function model() : string
    {
        return Role::class;
    }

    /**
     * @return Collection
     * @throws \App\Exceptions\RepositoryException
     */
    public function getAll() : Collection
    {
        return $this->with(['permissions'])->all();
    }

    /**
     * @param User $user
     * @return Role|null
     * @throws \App\Exceptions\RepositoryException
     */
    public function getOneByUser(User $user) : ?Role
    {
        $this->pushCriteria(new UserCriteria($user, 'users'));
        return $this->first();
    }
}

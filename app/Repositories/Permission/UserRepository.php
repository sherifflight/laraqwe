<?php

namespace App\Repositories\Permission;

use App\Models\User;
use App\Repositories\Criteria\Permission\UserPermissionCriteria;
use App\Support\Repositories\PermissionRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class UserRepository extends \App\Repositories\UserRepository implements PermissionRepositoryInterface
{
    /**
     * @param User $user
     * @param string|null $context
     * @return Collection
     * @throws \App\Exceptions\RepositoryException
     */
    public function getForUser(User $user, string $context = null) : Collection
    {
        $this->pushCriteria(new UserPermissionCriteria($user, $context));
        return $this->with([])->all();
    }

    /**
     * @param $id
     * @param User $user
     * @param string|null $context
     * @return User|null
     * @throws \App\Exceptions\RepositoryException
     */
    public function findForUser($id, User $user, string $context = null) : ?User
    {
        $this->pushCriteria(new UserPermissionCriteria($user, $context));
        return $this->with([])->find($id);
    }
}

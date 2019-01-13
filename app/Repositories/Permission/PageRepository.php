<?php

namespace App\Repositories\Permission;

use App\Models\Page;
use App\Models\User;
use App\Repositories\Criteria\Permission\PagePermissionCriteria;
use App\Support\Repositories\PermissionRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class PageRepository extends \App\Repositories\PageRepository implements PermissionRepositoryInterface
{
    /**
     * @param User $user
     * @param string|null $context
     * @return Collection
     * @throws \App\Exceptions\RepositoryException
     */
    public function getForUser(User $user, string $context = null) : Collection
    {
        $this->pushCriteria(new PagePermissionCriteria($user, $context));
        return $this->with([])->all();
    }

    /**
     * @param $id
     * @param User $user
     * @param string|null $context
     * @return User|null
     * @throws \App\Exceptions\RepositoryException
     */
    public function findForUser($id, User $user, string $context = null) : ?Page
    {
        $this->pushCriteria(new PagePermissionCriteria($user, $context));
        return $this->with([])->find($id);
    }
}

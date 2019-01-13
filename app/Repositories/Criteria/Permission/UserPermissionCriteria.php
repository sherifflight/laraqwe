<?php

namespace App\Repositories\Criteria\Permission;

use App\Models\Permission;
use App\Models\Role;
use App\Support\Criteria\CriteriaInterface;
use App\Support\Repositories\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

class UserPermissionCriteria extends BasePermissionCriteria implements CriteriaInterface
{
    /**
     * @param Model $model
     * @param RepositoryInterface $repository
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        if (in_array(Permission::VIEW_USERS, $this->permissions, true)) {
            return $model;
        }

        if (in_array(Permission::VIEW_USERS_LOWER, $this->permissions, true)) {
            return $model->whereHas('roles', function ($query) {
                /** @var $query Builder */
                return $query->whereIn(
                    'name',
                    $this->accessManager->getLowerRoles()
                );
            });
        }

        return $this->empty($model);
    }
}

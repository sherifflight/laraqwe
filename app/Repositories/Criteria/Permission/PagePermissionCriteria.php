<?php

namespace App\Repositories\Criteria\Permission;

use App\Models\Permission;
use App\Support\Criteria\CriteriaInterface;
use App\Support\Repositories\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

class PagePermissionCriteria extends BasePermissionCriteria implements CriteriaInterface
{
    /**
     * @param Model $model
     * @param RepositoryInterface $repository
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        if (in_array(Permission::VIEW_PAGES, $this->permissions, true)) {
            return $model;
        }

        if (in_array(Permission::VIEW_PAGES_LOWER, $this->permissions, true)) {
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

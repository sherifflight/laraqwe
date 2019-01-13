<?php

namespace App\Repositories\Criteria\Permission;

use App\Models\User;
use App\Services\Permission\ScopesAccessManager;
use Illuminate\Database\Query\Builder;

abstract class BasePermissionCriteria
{
    /** @var User */
    protected $user;

    /** @var ScopesAccessManager */
    protected $accessManager;

    /** @var array */
    protected $permissions;

    /** @var string|null */
    protected $context;

    public function __construct(User $user, string $context = null)
    {
        $this->user = $user;
        $this->accessManager = app(ScopesAccessManager::class);
        $this->accessManager->setUser($user);
        $this->permissions = $this->accessManager->getPermissions();
        $this->context = $context;
    }

    protected function empty($model)
    {
        /** @var $model Builder */
        return $model->whereNull('id');
    }
}

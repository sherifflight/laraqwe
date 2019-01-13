<?php

namespace App\Services\Permission;

use App\Models\User;
use Exception;

abstract class BaseAccessManager
{
    /** @var User|null */
    protected $user = null;

    /** @var array|null */
    protected $permissions = null;

    /**
     * @return User|null
     */
    public function getUser() : ?User
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return $this
     */
    public function setUser(User $user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return array
     */
    public function getPermissions() : array
    {
        if ($this->permissions === null) {
            $this->permissions = $this->user->getAllPermissions()->pluck('name')->toArray();
        }
        return $this->permissions;
    }

    /**
     * @param array $permissions
     * @return bool
     */
    protected function canAnyOf(...$permissions) : bool
    {
        return ! empty(array_intersect($permissions, $this->getPermissions()));

        //        return $this->user->hasAnyPermission($permissions);

//        foreach ($permissions as $permission) {
//            if ($this->user->hasAnyPermission($permission) === true) {
//                return true;
//            }
//        }
//
//        return false;
    }

    public function __call($name, $arguments)
    {
        if (! method_exists($this, $name)) {
            throw new Exception($name . ' has no method.');
        }
    }
}

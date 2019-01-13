<?php

namespace App\Services\Permission;

use App\Repositories\RoleRepository;

class ScopesAccessManager extends BaseAccessManager
{
    /**
     * @return array
     * @throws \App\Exceptions\RepositoryException
     */
    public function getLowerRoles() : array
    {
        $roleRepository = new RoleRepository;

        $role = $roleRepository->getOneByUser($this->getUser());

        if ($role === null) {
            return [];
        }

        $levels = $roleRepository->getOrderedLevels();

        $roleLevel = $levels->search($role->name);

        $slice = $levels->slice($roleLevel);

        return $slice->all();
    }
}

<?php

namespace App\Services\Permission;

use App\Models\Permission;
use App\Repositories\Permission\UserRepository;
use Exception;

class ModifyAccessManager extends BaseAccessManager
{
    /**
     * @param string $entity
     * @param int|string $id
     * @return bool
     */
    public function canModify(string $entity, $id = null) : bool
    {
        $entity = ucfirst(str_replace('\'', '', $entity));

        try {
            return $this->{'canModify' . $entity}($id);
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * @param $id
     * @return bool
     * @throws \App\Exceptions\RepositoryException
     */
    public function canModifyUsers($id) : bool
    {
        if (in_array(Permission::MODIFY_USERS, $this->getPermissions(), true)) {
            return true;
        }

        if (
            in_array(Permission::MODIFY_USERS_LOWER, $this->getPermissions(), true)
        ) {
            if ($id !== null) {
                return ((new UserRepository)->findForUser($id, $this->getUser()) !== null);
            }

            return true;
        }

        return false;
    }

    /**
     * @param $id
     * @return bool
     * @throws \App\Exceptions\RepositoryException
     */
    public function canModifyPages($id) : bool
    {
        if (in_array(Permission::MODIFY_PAGES, $this->getPermissions(), true)) {
            return true;
        }

        if (
            in_array(Permission::MODIFY_PAGES_LOWER, $this->getPermissions(), true)
        ) {
            if ($id !== null) {
                return ((new UserRepository)->findForUser($id, $this->getUser()) !== null);
            }

            return true;
        }

        return false;
    }
}

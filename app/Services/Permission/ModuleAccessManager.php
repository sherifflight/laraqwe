<?php

namespace App\Services\Permission;

use App\Models\Permission;
use Exception;

class ModuleAccessManager extends BaseAccessManager
{
    /**
     * @param string $module
     * @return bool
     */
    public function hasAccessTo(string $module) : bool
    {
        $module = studly_case(str_replace('\'', '', $module));

        try {
            return $this->{'hasAccessTo' . $module}();
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * @return bool
     */
    public function hasAccessToUsers() : bool
    {
        return $this->canAnyOf(
            Permission::VIEW_USERS
        );
    }

    /**
     * @return bool
     */
    public function hasAccessToPages() : bool
    {
        return $this->canAnyOf(
            Permission::VIEW_PAGES
        );
    }
}

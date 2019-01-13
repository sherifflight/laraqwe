<?php

if (! function_exists('canview')) {

    /**
     * @param string $module
     * @param \App\Models\User|null $user
     * @return bool
     */
    function canview(string $module, \App\Models\User $user = null) : bool
    {
        $moduleAccessManager = app(\App\Services\Permission\ModuleAccessManager::class);

        if ($user === null) {
            $user = auth('dashboard')->user();
        }

        $hasAccess = $moduleAccessManager
            ->setUser($user)
            ->hasAccessTo($module);

        return $hasAccess;
    }
}

if (! function_exists('get_latest_commit')) {

    /**
     * Returns last commit in case git repo is included into application directory
     *
     * @return string|null
     */
    function get_latest_commit() : ?string
    {
        try {
            if (is_dir(base_path('.git'))) {
                exec('git rev-parse --verify HEAD 2> /dev/null', $output);
                return $output[0];
            }
            return null;
        } catch (\Exception $e) {
            return null;
        }
    }
}

if (! function_exists('canedit')) {

    /**
     * @param string $entity
     * @param null $id
     * @param \App\Models\User|null $user
     * @return bool
     */
    function canedit(string $entity, $id = null, \App\Models\User $user = null) : bool
    {
        $moduleAccessManager = app(\App\Services\Permission\ModifyAccessManager::class);

        if ($user === null) {
            $user = auth('dashboard')->user();
        }

        $hasAccess = $moduleAccessManager
            ->setUser($user)
            ->canModify($entity, $id);

        return $hasAccess;
    }
}

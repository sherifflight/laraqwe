<?php

namespace App\Models\Presenters;

/**
 * Trait PermissionPresenter
 * @package App\Models\Presenters
 */
trait PermissionPresenter
{
    public function getTitleAttribute()
    {
        return trans("permissions.{$this->name}");
    }
}

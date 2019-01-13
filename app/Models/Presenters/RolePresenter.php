<?php

namespace App\Models\Presenters;

/**
 * Trait RolePresenter
 * @package App\Models\Presenters
 */
trait RolePresenter
{
    public function getTitleAttribute()
    {
        return trans("roles.{$this->name}");
    }
}

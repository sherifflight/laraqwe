<?php

namespace App\Models\Presenters;

use Hash;

/**
 * Trait UserPresenter
 * @package App\Models\Presenters
 */
trait UserPresenter
{
//    public function getFullNameAttribute()
//    {
//        return implode(' ', [
//            $this->first_name,
//            $this->middle_name,
//            $this->last_name
//        ]);
//    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = ($value !== null ? Hash::make($value) : null);
    }
}

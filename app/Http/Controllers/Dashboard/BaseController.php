<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Support\ResponseTrait;

abstract class BaseController extends Controller
{
    use ResponseTrait;

    /**
     * @return User|null
     */
    protected function getUser() : ?User
    {
        return auth('dashboard')->user();
    }
}

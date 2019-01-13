<?php

namespace App\Support\Repositories;

use App\Models\User;

interface PermissionRepositoryInterface
{
    public function getForUser(User $user, string $context = null);

    public function findForUser($id, User $user, string $context = null);
}

<?php

namespace App\Repositories;

use App\Models\User;
use App\Support\Repositories\RepositoryInterface;
use Exception;

class UserRepository extends BaseRepository implements RepositoryInterface
{
    public function model() : string
    {
        return User::class;
    }

    /**
     * @param string $email
     * @param string $password
     * @param string $name
     * @return User|null
     * @throws \App\Exceptions\RepositoryException
     */
    public function createBulky(
        string $email,
        string $password,
        string $name
    ) : ?User {
        return $this->create([
            'name' => $name,
            'email' => $email,
            'password' => $password
        ]);
    }

    /**
     * @param User $user
     * @param string $email
     * @param string|null $password
     * @param string $name
     * @return User|null
     * @throws \App\Exceptions\RepositoryException
     */
    public function updateBulky(
        User $user,
        string $email,
        string $password = null,
        string $name
    ) : ?User {
        $data = [
            'name' => $name,
            'email' => $email
        ];
        if ($password !== null) {
            $data['password'] = $password;
        }

        return $this->update($data, $user->id);
    }

    /**
     * @param User $user
     * @param int|null $roleId
     * @return bool
     */
    public function setRole(User $user, int $roleId = null) : bool
    {
        if ($roleId !== null) {
            try {
                $user->roles()->sync([$roleId]);
            } catch (Exception $e) {
                return false;
            }
        }
        return true;
    }
}

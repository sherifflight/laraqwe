<?php

namespace App\Repositories;

use App\Models\Request;
use App\Support\Repositories\RepositoryInterface;

/**
 * Class RequestRepository
 * @package App\Repositories
 */
class RequestRepository extends BaseRepository implements RepositoryInterface
{
    public function model() : string
    {
        return Request::class;
    }

    /**
     * @param string $event_name
     * @param string $name
     * @param string $surname
     * @param string $email
     * @param string $phone
     * @param string $education_level
     * @return Request|null
     * @throws \App\Exceptions\RepositoryException
     */
    public function createBulky(
        string $event_name,
        string $name,
        string $surname,
        string $email,
        string $phone,
        string $education_level
    ) : ?Request {
        return $this->create([
            'event_name' => $event_name,
            'name' => $name,
            'surname' => $surname,
            'email' => $email,
            'phone' => $phone,
            'education_level' => $education_level
        ]);
    }

    /**
     * @param Request $request
     * @param string $event_name
     * @param string $name
     * @param string $surname
     * @param string $email
     * @param string $phone
     * @param string $education_level
     * @return Request|null
     * @throws \App\Exceptions\RepositoryException
     */
    public function updateBulky(
        Request $request,
        string $event_name,
        string $name,
        string $surname,
        string $email,
        string $phone,
        string $education_level
    ) : ?Request {
        $data = [
            'event_name' => $event_name,
            'name' => $name,
            'surname' => $surname,
            'email' => $email,
            'phone' => $phone,
            'education_level' => $education_level
        ];

        return $this->update($data, $request->id);
    }
}

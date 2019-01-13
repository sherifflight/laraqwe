<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\Dashboard\Users\StoreRequest;
use App\Http\Requests\Dashboard\Users\UpdateRequest;
use App\Repositories\Permission\UserRepository;
use App\Repositories\RoleRepository;

class PagesController extends BaseController
{
    /**
     * @param UserRepository $userRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\RepositoryException
     */
    public function index(PageRepository $pageRepository)
    {
        $users = $pageRepository->getForUser($this->getUser());

        return view('dashboard.pages.index', [
            'items' => $users
        ]);
    }

    /**
     * @param int $id
     * @param UserRepository $userRepository
     * @param RoleRepository $roleRepository
     * @return UsersController|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * @throws \App\Exceptions\RepositoryException
     */
    public function edit(int $id, UserRepository $userRepository, RoleRepository $roleRepository)
    {
        $user = $userRepository->findForUser($id, $this->getUser());

        if ($user === null) {
            return $this->error('Не удалось найти пользователя.');
        }

        return view('dashboard.users.edit', [
            'item'    => $user,
        ]);
    }

    /**
     * @param int $id
     * @param UpdateRequest $updateRequest
     * @param UserRepository $userRepository
     * @return UsersController|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\RepositoryException
     */
    public function update(
        int $id, UpdateRequest $updateRequest, UserRepository $userRepository
    ) {
        $user = $userRepository->findForUser($id, $this->getUser());

        if ($user === null) {
            return $this->error('Не удалось найти пользователя.');
        }

        $user = $userRepository->updateBulky(
            $user,
            $updateRequest->input('email'),
            $updateRequest->input('password'),
            $updateRequest->input('name')
        );

        if ($user === null) {
            return $this->error('Не удалось обновить пользователя.');
        }

        return $this->success('Администратор был успешно обновлен.');
    }
}

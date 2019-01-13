<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\Dashboard\Users\StoreRequest;
use App\Http\Requests\Dashboard\Users\UpdateRequest;
use App\Repositories\Permission\UserRepository;
use App\Repositories\RoleRepository;

class UsersController extends BaseController
{
    /**
     * @param UserRepository $userRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\RepositoryException
     */
    public function index(UserRepository $userRepository)
    {
        $users = $userRepository->getForUser($this->getUser());

        return view('dashboard.users.index', [
            'items' => $users
        ]);
    }

    /**
     * @param RoleRepository $roleRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\RepositoryException
     */
    public function create(RoleRepository $roleRepository)
    {
        $roles = $roleRepository->all();

        return view('dashboard.users.create', [
            'roles' => $roles
        ]);
    }

    /**
     * @param StoreRequest $request
     * @param UserRepository $userRepo
     * @return UsersController|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\RepositoryException
     */
    public function store(StoreRequest $request, UserRepository $userRepo)
    {
        $user = $userRepo->createBulky(
            $request->input('email'),
            $request->input('password'),
            $request->input('name')
        );

        if ($user === null) {
            return $this->error('Не удалось добавить пользователя.');
        }

        return $this->success(
            'Пользователь был успешно добавлен.',
            route('dashboard.users.edit', $user->id)
        );
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

        $roles = $roleRepository->all();

        return view('dashboard.users.edit', [
            'item'    => $user,
            'roles'   => $roles
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

        $userRepository->setRole($user, $updateRequest->input('role'));

        return $this->success('Пользователь был успешно обновлен.');
    }

    /**
     * @param int $id
     * @param UserRepository $userRepository
     * @return UsersController|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\RepositoryException
     */
    public function delete(int $id, UserRepository $userRepository)
    {
        $user = $userRepository->findForUser($id, $this->getUser());

        if ($user === null) {
            return $this->error('Не удалось найти пользователя.');
        }

        if ($this->getUser()->id === $id) {
            return $this->error('Нельзя удалить самого себя.');
        }

        $userRepository->delete($user->id);

        return $this->success('Пользователь успешно удален.');
    }
}

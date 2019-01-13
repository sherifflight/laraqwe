<?php

namespace App\Http\Requests\Dashboard\Users;

use App\Http\Requests\Dashboard\BaseRequest;
use App\Repositories\RoleRepository;
use Illuminate\Validation\Rule;

abstract class StoreUpdateRequest extends BaseRequest
{
    /**
     * @return array
     * @throws \App\Exceptions\RepositoryException
     */
    public function rules()
    {
        $roleRepo = app(RoleRepository::class);

        $roles = $roleRepo->all();

        $routeIdParam = $this->route('id');

        return [
            'name' => 'required',
            'email'      => [
                'required',
                'email',
                (
                    $routeIdParam !== null
                    ? Rule::unique('users', 'email')->ignore($routeIdParam)
                    : Rule::unique('users', 'email')
                )
            ],
            'role'       => Rule::in($roles->pluck('id')->all()),
            'password'   => ($routeIdParam === null ? 'required|' : '') . 'confirmed'
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Необходимо указать имя.',
            'email.required' => 'Необходимо указать email.',
            'email.email' => 'Введённый email имеет неверный формат.',
            'email.unique' => 'Пользователь с указанным email-ом уже существует.',
            'role.in' => 'Вы не можете создавать пользователей выбранной роли.',
            'password.required' => 'Необходимо задать пароль.',
            'password.confirmed' => 'Неверное подтверждение пароля.'
        ];
    }
}

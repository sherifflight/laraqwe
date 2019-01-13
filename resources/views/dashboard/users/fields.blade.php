@php /** @var \App\Models\User $item */ @endphp
<div class="row">
    <div class="col-md-7">
        <div class="card card-default">
            <div class="card-header">
                <div class="card-title">Данные для входа</div>
            </div>
            <div class="card-block">
                @include('dashboard.layouts.partials.forms.email', [
                    'title' => 'Email',
                    'name' => 'email',
                    'required' => true,
                    'value' => old('email', isset($item) ? $item->email : ''),
                    'placeholder' => 'Введите email пользователя.'
                ])

                <div class="row">
                    <div class="col-md-6">
                        @include('dashboard.layouts.partials.forms.password', [
                            'title' => 'Пароль',
                            'name' => 'password',
                            'required' => ! isset($item),
                            'placeholder' => 'Введите пароль'
                        ])
                    </div>
                    <div class="col-md-6">
                        @include('dashboard.layouts.partials.forms.password', [
                            'title' => 'Подтверждение пароля',
                            'name' => 'password_confirmation',
                            'required' => ! isset($item),
                            'placeholder' => 'Повторите введённый пароль'
                        ])
                    </div>
                </div>
            </div>
        </div>
        <div class="card card-default">
            <div class="card-header">
                <div class="card-title">Управление доступом</div>
            </div>
            <div class="card-block">

                @include('dashboard.layouts.partials.forms.select-simple', [
                    'title' => 'Роль',
                    'placeholder' => 'Роль пользователя',
                    'name' => 'role',
                    'required' => true,
                    'options' => $roles->pluck('title', 'id')->toArray(),
                    'selected' => old('role', isset($item) ? $item->roles->pluck('id')->first() : 0),
                    'id' => 'rolesSelect'
                ])
                <div class="m-b-15 p-l-12 p-r-12">
                    <div class="m-b-6">Права: </div>
                    @foreach($roles as $role)
                        @php /** @var \App\Models\Role $role **/ @endphp
                        <div id="{{ 'permissionBlock' . $role->id }}" style="display: none;">
                            @foreach($role->permissions as $permission)
                                <span class="label inline-block">{{ trans('permissions.' . $permission->name) }}</span>
                            @endforeach
                        </div>
                    @endforeach
                    <hr class="m-t-15 m-b-0" />
                </div>

            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="card card-default">
            <div class="card-header">
                <div class="card-title">Персональные данные</div>
            </div>
            <div class="card-block">
                @include('dashboard.layouts.partials.forms.text', [
                    'title' => 'Имя',
                    'placeholder' => 'Введите имя',
                    'name' => 'name',
                    'required' => true,
                    'value' => old('name', isset($item) ? $item->name : ''),
                ])
            </div>
        </div>
    </div>
</div>

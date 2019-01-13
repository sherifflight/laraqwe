@extends('dashboard.layouts.pages.index')

@section('title', 'Список пользователей')

@php
    /** @var \App\Models\User $user */
    $user = auth('dashboard')->user();
@endphp

@section('card-header')
    <div class="pull-left">
        @include('dashboard.layouts.partials.datatable-search-input')
    </div>
    @if(canedit('users', null, $user))
        @include('dashboard.layouts.partials.create-new-button', [
            'link' => route('dashboard.users.create')
        ])
    @endif
    <div class="clearfix"></div>
@stop

@section('card-block')
    @if(count($items) > 0)
        <table data-sort-column="0" data-sort-order="asc" class="datatable table table-hover no-footer" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Имя</th>
                    <th>Email</th>
                    <th>Дата создания</th>
                    <th></th>
                </tr>
                </thead>
            <tbody>

            @foreach($items as $item)
                @php
                    /** @var \App\Models\User $item */
                @endphp
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->created_at }}</td>
                    <td>
                        @if(canedit('users', $item->id, $user))
                            @if($user->id !== $item->id)
                                @include('dashboard.layouts.partials.button-list-delete-big', [
                                    'link' => route('dashboard.users.delete', $item->id)
                                ])
                            @endif
                            @include('dashboard.layouts.partials.button-list-edit-big', [
                                'link' => route('dashboard.users.edit', $item->id)
                            ])
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <span class="hint-text m-l-5">Пока нет пользователей</span>
    @endif
@stop

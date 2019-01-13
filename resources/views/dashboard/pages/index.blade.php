@extends('dashboard.layouts.pages.index')

@section('title', 'Список страниц')

@php
    /** @var \App\Models\User $user */
    $user = auth('dashboard')->user();
@endphp

@section('card-header')
    <div class="pull-left">
        @include('dashboard.layouts.partials.datatable-search-input')
    </div>
    <div class="clearfix"></div>
@stop

@section('card-block')
    @if(count($items) > 0)
        <table data-sort-column="0" data-sort-order="asc" class="datatable table table-hover no-footer" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Индекс</th>
                    <th>Название</th>
                    <th>Дата создания</th>
                    <th></th>
                </tr>
                </thead>
            <tbody>

            @foreach($items as $item)
                @php
                    /** @var \App\Models\Page $item */
                @endphp
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->page_name }}</td>
                    <td>{{ $item->title }}</td>
                    <td>{{ $item->created_at }}</td>
                    <td>
                        @if(canedit('pages', $item->id, $user))
                            @include('dashboard.layouts.partials.button-list-edit-big', [
                                'link' => route('dashboard.pages.edit', $item->id)
                            ])
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <span class="hint-text m-l-5">Пока нет страниц</span>
    @endif
@stop

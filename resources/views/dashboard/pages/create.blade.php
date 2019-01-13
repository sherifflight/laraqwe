@extends('dashboard.layouts.pages.createdit')

@section('breadcrumb')
    @include('dashboard.layouts.partials.breadcrumb', ['links' => [
        'Список пользователей' => route('dashboard.users.index')
    ]])
@stop

@section('title', 'Новый пользователь')

@section('fields')
    @include('dashboard.users.fields')
@stop

@section('back-link')
    {{ route('dashboard.users.index') }}
@stop

@push('scripts')
    @include('dashboard.users.scripts')
@endpush

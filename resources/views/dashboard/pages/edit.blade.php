@extends('dashboard.layouts.pages.createdit')

@section('breadcrumb')
    @include('dashboard.layouts.partials.breadcrumb', ['links' => [
        'Список страниц' => route('dashboard.pages.index')
    ]])
@stop

@php /** @var \App\Models\Page $item **/ @endphp
@section('title', 'Изменение страницы с id ' . $item->id)

@section('fields')
    @include('dashboard.pages.fields')
@stop

@section('back-link')
    {{ route('dashboard.pages.index') }}
@stop

@push('scripts')
    @include('dashboard.pages.scripts')
@endpush

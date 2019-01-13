@extends('dashboard.layouts.default')

@section('content')
    <div class="card card-default">
        <div class="card-header">

            @yield('card-header')

            <div class="clearfix"></div>
        </div>
        <div class="card-block">

            @yield('card-block')

        </div>
    </div>
@stop

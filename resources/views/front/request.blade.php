<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Requests</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" media="screen" />

</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">
    <div class="container">
        <a class="navbar-brand" href="#">Eugene Dyakonov</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/') }}">Home
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('front.request.create') }}">Send request</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard.login') }}">Dashboard</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <div class="row">
        <div class="col-lg-12 text-center">
            <h1 class="mt-5">

            </h1>

            @if(Session::has('success'))
                <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('success') }}</p>
            @endif
            @if(Session::has('error'))
                <p class="alert {{ Session::get('alert-class', 'alert-danger') }}">{{ Session::get('error') }}</p>
            @endif

            <div>
                <div class="card col-lg-7">
                    <div class="card-body">
                        <h5 class="card-title">Форма заявки</h5>
                        <form action="{{ route('front.request.store') }}" href="{{ route('front.request.store') }}" method="post">

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <label for="eventSelect">Событие</label>
                                <select class="form-control" name="event_name" id="eventSelect" required>
                                    <option>Событие 1</option>
                                    <option>Событие 2</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="name">Имя</label>
                                <input type="text" name="name" class="form-control" id="name" placeholder="Enter name" required>
                            </div>

                            <div class="form-group">
                                <label for="surname">Фамилия</label>
                                <input type="text" name="surname" class="form-control" id="surname" placeholder="Enter surname" required>
                            </div>

                            <div class="form-group">
                                <label for="phone">Телефон</label>
                                <input type="text" minlength="18" maxlength="18" pattern="[\+]\d{1}\s[\(]\d{3}[\)]\s\d{3}[\-]\d{2}[\-]\d{2}" name="phone" class="form-control" id="phone" placeholder="+7 (123) 456-78-91" required>
                            </div>

                            <div class="form-group">
                                <label for="email">Почта</label>
                                <input type="text" name="email" pattern="\S+@[a-z]+.[a-z]+" class="form-control" id="email" placeholder="Enter email" required>
                            </div>

                            <div class="form-group">
                                <label for="educationLevelSelect">Уровень образования</label>
                                <select class="form-control" name="education_level" id="educationLevelSelect" required>
                                    <option>Bachelor</option>
                                    <option>Master</option>
                                    <option>PhD</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Send</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

</body>
</html>

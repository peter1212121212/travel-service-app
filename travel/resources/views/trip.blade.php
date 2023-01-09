@extends('layouts.main')

<!--PASEK NAWIGACYJNY-->
@section('login')
@if(Session::has('login_id'))
<div class="col-md-3 text-end">
    <div class="my-2">Witaj, {{$user->name}} {{$user->surname}}</div>
    <a href="account" class="btn btn-outline-primary me-2">Konto</a>
    <a href="logout" class="btn btn-primary">Wyloguj</a>
</div>
@else
<div class="col-md-3 text-end">
    <a href="login" class="btn btn-outline-primary me-2">Logowanie</a>
    <a href="register" class="btn btn-primary">Rejestracja</a>
</div>
@endif
@endsection

@section('content')
<!--SLIDER-->
<div class="container-fluid">
    <div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ asset('assets/'.$trip->path_photo_1) }}" class="img-fluid w-100" alt="Trip_main_photo" loading="lazy">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('assets/'.$trip->path_photo_2) }}" class="img-fluid w-100" alt="Trip_second_photo" loading="lazy">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('assets/'.$trip->path_photo_3) }}" class="img-fluid w-100" alt="Trip_third_photo" loading="lazy">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>
<!--OPIS-->
<div class="container">
    <div class="row">
        <div class="col-6 text-center my-4">
            <div class="d-flex flex-column justify-content-center align-items-center h-100">
                <h1 class="fw-bold">{{$trip->hotel_name}}</h1>
                <h2 class="text-muted">{{$trip->country}}</h2>
            </div>
        </div>
        <div class="col-6">
            <div class="d-flex flex-column justify-content-center align-items-center text-center mt-4">
                <div class="d-flex flex-row justify-content-center align-items-center">
                    <h2 class="text-primary m-2">{{$trip->price}} PLN</h2>
                    @if(Session::has('login_id'))
                    <a href="order-{{$trip->id}}" class="btn btn-sm btn-primary">
                        <h3>Zamów teraz</h3>
                    </a>
                    @else
                    <a href="login" class="btn btn-sm btn-primary">
                        <h3>Zaloguj się aby zamówić</h3>
                    </a>
                    @endif
                </div>
                <p class="text-muted my-4"><span class="text-danger">UWAGA! </span>Wycieczka z ceną dotyczą jednej osoby, jeśli chcesz zamówić wycieczkę dla kilku osób dodaj zamówienie kilka razy</p>
                <div class="text-muted my-4">{{$trip->date_start}} - {{$trip->date_end}}</div>
                <div>
                    <p class="card-text">{{$trip->food}}</p>
                    <p class="card-text">{{$trip->transport}}</p>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="display-6 text-center py-4">
                {{$trip->description}}
            </div>
            <div class="text-center">
                @if(Session::has('login_id'))
                <a href="order-{{$trip->id}}" class="btn btn-sm btn-primary">
                    <h1>Zamów teraz</h1>
                </a>
                @else
                <a href="login" class="btn btn-sm btn-primary">
                    <h1>Zaloguj się aby zamówić</h1>
                </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
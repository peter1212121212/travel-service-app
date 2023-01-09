@extends('layouts.main')

<!--PASEK NAWIGACYJNY-->
@section('login')
@if(Session::has('login_id'))
<div class="col-md-3 text-center text-md-end">
    <div class="my-2">Witaj, {{$user->name}} {{$user->surname}}</div>
    <a href="logout" class="btn btn-primary">Wyloguj</a>
</div>
@endif
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 col-md-6 offset-md-3">
            <form class="form text-center w-100" action="{{route('account-edit-user')}}" method="POST">
                <!--TOKEN-->
                @csrf
                <h1 class="h3 mb-3 fw-normal">Edytuj dane konta</h1>

                <div class="form-floating my-3">
                    <input type="text" class="form-control" id="floating_name" value="{{$user->name}}" name="name">
                    <label for="floating_name">Imię</label>
                    <span class="text-danger">@error('name') {{$message}} @enderror</span>
                </div>

                <div class="form-floating my-3">
                    <input type="text" class="form-control" id="floating_surname" value="{{$user->surname}}" name="surname">
                    <label for="floating_surname">Nazwisko</label>
                    <span class="text-danger">@error('surname') {{$message}} @enderror</span>
                </div>

                <div class="form-floating my-3">
                    <input type="email" class="form-control" id="floating_email" value="{{$user->email}}" name="email">
                    <label for="floating_email">Email</label>
                    <span class="text-danger">@error('email') {{$message}} @enderror</span>
                </div>

                <div class="form-floating my-3">
                    <input type="password" class="form-control" id="floating_password" name="password">
                    <label for="floating_password">Hasło</label>
                    <span class="text-danger">@error('password') {{$message}} @enderror</span>
                </div>

                <button class="w-100 btn btn-lg btn-primary my-3" type="submit">Zapisz</button>
            </form>
        </div>
    </div>
</div>
@endsection
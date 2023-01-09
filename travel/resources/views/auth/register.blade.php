@extends('layouts.main')

<!--PASEK NAWIGACYJNY-->
@section('login')
<div class="col-md-3 text-end">
    <a href="login" class="btn btn-outline-primary">Logowanie</a>
</div>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 col-md-6 offset-md-3">
            <form class="form text-center w-100" action="{{route('register-user')}}" method="POST">
                <!--TOKEN-->
                @csrf
                <h1 class="h3 mb-3 fw-normal">Rejestracja</h1>

                <!--ALERTY-->
                @if(Session::has('success'))
                    <div class="alert alert-success">{{Session::get('success')}}</div>
                @endif

                @if(Session::has('fail'))
                    <div class="alert alert-danger">{{Session::get('fail')}}</div>
                @endif

                <div class="form-floating my-3">
                    <input type="text" class="form-control" id="floating_name" value="{{old('name')}}" name="name" required>
                    <label for="floating_name">Imię</label>
                    <span class="text-danger">@error('name') {{$message}} @enderror</span>
                </div>

                <div class="form-floating my-3">
                    <input type="text" class="form-control" id="floating_surname" value="{{old('surname')}}" name="surname" required>
                    <label for="floating_surname">Nazwisko</label>
                    <span class="text-danger">@error('surname') {{$message}} @enderror</span>
                </div>

                <div class="form-floating my-3">
                    <input type="email" class="form-control" id="floating_email" value="{{old('email')}}" name="email" required>
                    <label for="floating_email">Email</label>
                    <span class="text-danger">@error('email') {{$message}} @enderror</span>
                </div>

                <div class="form-floating my-3">
                    <input type="password" class="form-control" id="floating_password" name="password" required>
                    <label for="floating_password">Hasło</label>
                    <span class="text-danger">@error('password') {{$message}} @enderror</span>
                </div>

                <button class="w-100 btn btn-lg btn-primary my-3" type="submit">Zarejestruj</button>
                <a href="login">Masz konto? Logowanie!</a>
            </form>
        </div>
    </div>
</div>
@endsection
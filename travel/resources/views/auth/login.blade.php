@extends('layouts.main')

<!--PASEK NAWIGACYJNY-->
@section('login')
<div class="col-md-3 text-end">
    <a href="register" class="btn btn-primary">Rejestracja</a>
</div>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 col-md-6 offset-md-3">
            <form class="form text-center w-100" action="{{route('login-user')}}" method="POST">
                <!--TOKEN-->
                @csrf
                <h1 class="h3 mb-3 fw-normal">Logowanie</h1>

                <!--ALERTY-->
                @if(Session::has('success'))
                    <div class="alert alert-success">{{Session::get('success')}}</div>
                @endif

                @if(Session::has('fail'))
                    <div class="alert alert-danger">{{Session::get('fail')}}</div>
                @endif

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

                <button class="w-100 btn btn-lg btn-primary my-3" type="submit">Zaloguj</button>
                <a href="login">Nie masz konta? Rejestracja!</a>
            </form>
        </div>
    </div>
</div>
@endsection
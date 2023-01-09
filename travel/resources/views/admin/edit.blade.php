@extends('layouts.main')

<!--PASEK NAWIGACYJNY-->
@section('login')
@if(Session::has('login_id'))
<div class="col-md-3 text-end">
    <div class="my-2">Witaj, {{$user->name}} {{$user->surname}}</div>
    <a href="account" class="btn btn-outline-primary me-2">Konto</a>
    <a href="logout" class="btn btn-primary">Wyloguj</a>
</div>
@endif
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 col-md-6 offset-md-3">
            <form class="form text-center w-100" action="{{route('edit-trip')}}" method="POST" enctype="multipart/form-data">
                <!--TOKEN-->
                @csrf
                <h1 class="h3 mb-3 fw-normal">Edytuj wycieczkę</h1>

                <!--ALERTY-->
                @if(Session::has('success'))
                    <div class="alert alert-success">{{Session::get('success')}}</div>
                @endif

                @if(Session::has('fail'))
                    <div class="alert alert-danger">{{Session::get('fail')}}</div>
                @endif
                <!--ID-->
                <input type="hidden" value="{{$trip->id}}" name="id">

                <div class="form-floating my-3">
                    <input type="text" class="form-control" id="floating_hotel" value="{{$trip->hotel_name}}" name="hotel" required>
                    <label for="floating_hotel">Nazwa hotelu</label>
                    <span class="text-danger">@error('hotel') {{$message}} @enderror</span>
                </div>

                <div class="form-floating my-3">
                    <input type="text" class="form-control" id="floating_price" value="{{$trip->price}}" name="price" required>
                    <label for="floating_price">Cena</label>
                    <span class="text-danger">@error('price') {{$message}} @enderror</span>
                </div>

                <div class="form-floating my-3">
                    <input type="text" class="form-control" id="floating_country" value="{{$trip->country}}" name="country" required>
                    <label for="floating_country">Kraj</label>
                    <span class="text-danger">@error('country') {{$message}} @enderror</span>
                </div>

                <div class="form-floating my-3">
                    <input type="text" class="form-control" id="floating_food" value="{{$trip->food}}" name="food" required>
                    <label for="floating_food">Wyżywienie</label>
                    <span class="text-danger">@error('food') {{$message}} @enderror</span>
                </div>

                <div class="form-floating my-3">
                    <input type="text" class="form-control" id="floating_transport" value="{{$trip->transport}}" name="transport" required>
                    <label for="floating_transport">Transport</label>
                    <span class="text-danger">@error('transport') {{$message}} @enderror</span>
                </div>

                <div class="form-floating my-3">
                    <textarea name="description" class="form-control" id="floating_description" oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"' rows="5" style="height: auto;" required>{{$trip->description}}</textarea>
                    <label for="floating_description">Opis</label>
                    <span class="text-danger">@error('description') {{$message}} @enderror</span>
                </div>

                <div class="form-floating my-3">
                    <input type="date" class="form-control" id="floating_date_start" value="{{$trip->date_start}}" name="date_start" required>
                    <label for="floating_date_start">Data od</label>
                    <span class="text-danger">@error('date_start') {{$message}} @enderror</span>
                </div>

                <div class="form-floating my-3">
                    <input type="date" class="form-control" id="floating_date_end" value="{{$trip->date_end}}" name="date_end" required>
                    <label for="floating_date_end">Data do</label>
                    <span class="text-danger">@error('date_end') {{$message}} @enderror</span>
                </div>

                <div class="form-floating my-3">
                    <input type="file" class="form-control" id="floating_photo_1" name="photo_1" accept="image/png, image/jpeg, image/jpg">
                    <label for="floating_photo_1">Zdjęcie główne</label>
                    <span class="text-danger">@error('photo_1') {{$message}} @enderror</span>
                </div>

                <div class="form-floating my-3">
                    <input type="file" class="form-control" id="floating_photo_2" name="photo_2" accept="image/png, image/jpeg, image/jpg">
                    <label for="floating_photo_2">Zdjęcie 2</label>
                    <span class="text-danger">@error('photo_2') {{$message}} @enderror</span>
                </div>

                <div class="form-floating my-3">
                    <input type="file" class="form-control" id="floating_photo_3" name="photo_3" accept="image/png, image/jpeg, image/jpg">
                    <label for="floating_photo_3">Zdjęcie 3</label>
                    <span class="text-danger">@error('photo_3') {{$message}} @enderror</span>
                </div>

                <button class="w-100 btn btn-lg btn-primary my-3" type="submit">Zapisz</button>
            </form>
        </div>
    </div>
</div>
@endsection
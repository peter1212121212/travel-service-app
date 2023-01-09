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
        <!--ALERTY-->
        @if(Session::has('success'))
        <div class="alert alert-success">{{Session::get('success')}}</div>
        @endif

        @if(Session::has('fail'))
        <div class="alert alert-danger">{{Session::get('fail')}}</div>
        @endif
        <!--ZAKŁADKA PO LEWEJ-->
        <div class="col-5">
            @if ($orders == False)
            <div class="list-group text-break">
                <a href="account" class="list-group-item list-group-item-action active" aria-current="true">Konto</a>
                <a href="account-orders" class="list-group-item list-group-item-action">Zamówienia</a>
            </div>
            @else
            <div class="list-group text-break">
                <a href="account" class="list-group-item list-group-item-action">Konto</a>
                <a href="account-orders" class="list-group-item list-group-item-action active" aria-current="true">Zamówienia</a>
            </div>
            @endif
        </div>
        <!--ZAKŁADKA PO PRAWEJ (ZAWARTOŚĆ)-->
        <div class="col-7">
            @if ($orders == False)
            <!--EDYCJA KONTA-->
            <ol class="list-group list-group text-break">
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <div class="fw-bold">Imię</div>
                        {{$user->name}}
                    </div>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <div class="fw-bold">Nazwisko</div>
                        {{$user->surname}}
                    </div>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <div class="fw-bold">Email</div>
                        {{$user->email}}
                    </div>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <div class="fw-bold">Hasło</div>
                        ********
                    </div>
                </li>
            </ol>
            <div class="text-center">
                <a href="account-edit" class="btn btn-primary m-2">Edytuj konto</a>
                <a href="account-delete" class="btn btn-danger m-2">Usuń konto</a>
            </div>
            @else
            <!--LISTA ZAMÓWIEŃ-->
            <ol class="list-group list-group text-break">
                @foreach ($orders_list as $order)
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <div class="fw-bold">{{$trips[intval($order->trip_id)-1]->hotel_name}}, {{$trips[intval($order->trip_id)-1]->country}}</div>
                        <div><a href="trip-{{$order->trip_id}}" class="btn btn-sm btn-outline-primary">Szczegóły</a></div>
                        @if ($order->status == 'Opłacono')
                        {{$order->status}}
                        @else
                        <span class="text-danger">{{$order->status}}</span>
                        @endif
                    </div>
                    <span class="badge bg-primary rounded-pill">{{$trips[intval($order->trip_id)-1]->price}} PLN</span>
                </li>
                @endforeach
            </ol>
            @endif
        </div>
    </div>
</div>
@endsection
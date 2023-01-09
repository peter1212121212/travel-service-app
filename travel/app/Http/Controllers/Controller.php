<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\User;
use App\Models\Trip;
use App\Models\Order;
use Illuminate\Support\Facades\Session;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /*FUNKCJA DO POBRANIA DANYCH UŻYTKOWNIKA Z BAZY DANYCH*/
    public function get_user(){
        if(Session::has('login_id')){                                                   //Jeśli zmeinna sesyjna istnieje
            $user = User::where('id', '=', Session::get('login_id'))->first();          //To pobierz dane zalogowanego użytkownika bo zmienna sesyjna posiada tylko id
        }else{                                                                          //W przeciwnym wypadku
            $user='';                                                                   //Ustwa pustego stringa aby laravel nie wyrzucał błedu o braku przekazania zmiennej
        }
        return $user;                                                                   //Zwróć zmienną
    }

    /*WIDOK GŁÓWNY*/
    public function index(){
        $user = $this->get_user();                                                                  //Pobierz dane zalogowanego użytkownika
        $trips_abroad = Trip::where('country', '!=', 'Polska')->inRandomOrder()->take(6)->get();    //Pobierz wycieczki zagraniczne
        $trips_poland = Trip::where('country', '=', 'Polska')->inRandomOrder()->take(6)->get();     //Pobierz wycieczki polskie

        return view('index',[       //Zwróć widok z parametrami
            'user'=>$user,
            'trips_abroad'=>$trips_abroad,
            'trips_poland'=>$trips_poland,
        ]);
    }

    /*WIDOK WYCIECZEK ZAGRANICA*/
    public function trips_abroad(){
        $user = $this->get_user();                                                  //Pobierz dane zalogowanego użytkownika
        $trips = Trip::where('country', '!=', 'Polska')->inRandomOrder()->get();    //Pobierz wszystkie wycieczki zagranica

        return view('trips',[                                                       //Zwróć widok z parametrami
            'user'=>$user,
            'trips'=>$trips,
            'header'=>'Wycieczki zagraniczne'
        ]);
    }

    /*WIDOK WYCIECZEK POLSKA*/
    public function trips_poland(){
        $user = $this->get_user();                                                  //Pobierz dane zalogowanego użytkownika
        $trips = Trip::where('country', '=', 'Polska')->inRandomOrder()->get();     //Pobierz wszystkie wycieczki polska

        return view('trips',[                                                       //Zwróć widok z parametrami
            'user'=>$user,
            'trips'=>$trips,
            'header'=>'Wycieczki krajowe'
        ]);
    }

    /*WIDOK WSZYSTKICH WYCIECZEK*/
    public function trips(){
        $user = $this->get_user();              //Pobierz dane zalogowanego użytkownika
        $trips = Trip::inRandomOrder()->get();  //Pobierz wszystkie wycieczki

        return view('trips',[                   //Zwróć widok z parametrami
            'user'=>$user,
            'trips'=>$trips,
            'header'=>'Wszystkie wycieczki'
        ]);
    }

    /*WIDOK GŁÓWNY PANELU ADMINA*/
    public function admin(){
        $user = $this->get_user();  //Pobierz dane zalogowanego użytkownika
        $trips = Trip::get();       //Pobierz wszystkie wycieczki
        $orders = Order::get();     //Pobierz wszystkie zamówienia
        $users = User::get();       //Pobierz wszystkich użytkowników

        return view('admin.admin',[ //Zwróć widok z parametrami
            'user'=>$user,
            'trips'=>$trips,
            'orders_list'=>$orders,
            'users'=>$users
        ]);
    }
    /*ZMIANA STATUSU ZAMÓWIONEJ WYCIECZKI FUNKCJONALNOŚĆ*/
    public function order_status($status,$id){  //Przyjmowany argument id pochodzi z ścieżki
        Order::where('id', '=', $id)->update([  //Aktualizacja statusu w bazie danych
            'status' => $status,
        ]);
        return redirect('admin')->with('success', 'Edycja wycieczki zakońcona powodzeniem!');   //zwróć ścieżkę z komunikatem
    }
}

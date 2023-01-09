<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Trip;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    /*LOGOWANIE WIDOK*/
    public function login(){
        return view('auth.login');
    }

    /*LOGOWANIE FUNKCJONALNOŚĆ*/
    public function login_user(Request $request){   //Request - przyjęcie danych z formularza
        $request->validate([                        //walidacja
            'email' => 'required',                  //sprawdzenie czy login został podany
            'password' => 'required|min:8'          //sprawdzenie czy hasło zostało podane oraz czy posiada minimalną liczbę znaków
        ]);

        $user = User::where('email', '=',$request->email)->first();             //jeśli wszystko się zgadza znajdź dane w bazie

        if($user){                                                              //jeśli użytkownik istnieje
            if(Hash::check($request->password, $user->password)){               //sprawdź czy hasła pasują
                $request->session()->put('login_id',$user->id);                 //ustaw zmienną sesyjną
                if ($user->admin==true){                                        //jeśli użytkownik jest adminem
                    $request->session()->put('admin',$user->admin);             //ustaw dodatkową zmienną sesyjną
                }
                return redirect('/');                                           //jeśli wszystko ok to zwróć widok
            }else{
                return back()->with('fail', 'Hasła nie pasują do siebie!');     //jeśli hasła do siebie nie pasują zwróć komunikat
            }
        }else{
            return back()->with('fail', 'Nie ma takiego użytkownika!');         //jeśli nie ma użytkownika zwróć komunikat
        }
    }

    /*REJESTRACJA WIDOK*/
    public function register(){
        return view('auth.register');
    }

    /*REJESTRACJA FUNKCJONALOŚĆ*/
    public function register_user(Request $request){    //Request - przyjęcie danych z formularza
        $request->validate([                            //walidacja
            'name' => 'required',                       //sprawdzenie czy imię jest podane
            'surname' => 'required',                    //sprawdzenie czy nazwisko jest podane
            'email' => 'required|email|unique:users',   //sprawdzenie czy email jest podany, czy format to email oraz czy jest unikalny
            'password' => 'required|min:8'              //sprawdzenie czy hasło jest podane oraz czy posiada minimalna liczbe znaków
        ]);

        $user = new User();                                 //utwórz nowy obiekt korzystając z klasy User (model)
        $user->name = $request->name;                       //zapisz imię
        $user->surname = $request->surname;                 //zapisz nazwisko
        $user->email = $request->email;                     //zapisz email
        $user->password = Hash::make($request->password);   //zapisz zaszyfrowane hasło korzystając z wbudowanej (w Laravel) metody make z klasy Hash
        $user->admin = false;                               //zapisz brak admina
        $res = $user->save();                               //ZAPISZ REKORD W BAZIE DANYCH

        if ($res) {
            return redirect('login')->with('success', 'Zarejestrowałeś się z powodzeniem!');    //jeśli wszystko jest ok wróć z komunikatem
        } else {
            return back()->with('fail', 'Coś poszło nie tak!');                                 //jeśli coś poszło nie tak wróć z komunikatem
        }
    }

    /*WYLOGOWANIE FUNKCJONALNOŚĆ*/
    public function logout(){
        if (Session::has('login_id')){  //sprawdź czy zmienna sesyjna jest ustawiona
            Session::pull('login_id');  //jeśli tak to usuń zmienną sesyjną
            Session::pull('admin');
            return redirect('/');       //zwróć ścieżkę
        }
    }
    
    /*KONTO PODGLĄD WIDOK*/
    public function account(){
        $user = $this->get_user();  //Pobierz dane zalogowanego użytkownika

        return view('account.account',[
            'user'=>$user,
            'orders'=>False
        ]);
    }

    /*KONTO EDYCJA WIDOK*/
    public function account_edit(){
        $user = $this->get_user();  //Pobierz dane zalogowanego użytkownika

        return view('account.edit',[
            'user'=>$user,
        ]);
    }

    /*KONTO EDYCJA FUNKCJONALNOŚĆ*/
    public function account_edit_user(Request $request){                //Request - przyjęcie danych z formularza
        $user = $this->get_user();                                      //Pobierz dane zalogowanego użytkownika
        $request->validate([                                            //walidacja
            'name' => 'required',                                       //sprawdzenie czy imię jest podane
            'surname' => 'required',                                    //sprawdzenie czy nazwisko jest podane
            'email' => 'required|email|unique:users,email,'.$user->id,  //sprawdzenie czy email jest podany, czy format to email oraz czy jest unikalny
            'password' => 'nullable|min:8'                              //sprawdzenie czy hasło jest podane oraz czy posiada minimalna liczbe znaków
        ]);

        User::where('id', '=', $user->id)->update([                     //aktualizacja bazy
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
        ]);

        if ($request->password != null){                                //gdy jest podane hasło
            User::where('id', '=', $user->id)->update([                 //aktualizacja bazy
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect('account')->with('success', 'Edycja konta zakońcona powodzeniem!');
    }

    /*KONTO USUWANIE FUNKCJONALNOŚĆ*/
    public function account_delete(){
        $user = $this->get_user();                                              //Pobierz dane zalogowanego użytkownika

        if (Session::has('login_id')){                                          //sprawdź czy zmienna sesyjna jest ustawiona - NAJPIERW WYLOGOWANIE
            Session::pull('login_id');                                          //jeśli tak to usuń zmienną sesyjną
            Session::pull('admin');
        }
        User::where('id', '=', $user->id)->delete();                            //usunięcie konta
        return redirect('/')->with('success', 'Usunąłeś konto z powodzeniem!'); //zwróć ścieżkę z komunikatem
    }

    /*KONTO ZAMÓWIENIA WIDOK*/
    public function account_order(){
        $user = $this->get_user();                                  //Pobierz dane zalogowanego użytkownika
        $orders = Order::where('user_id', '=', $user->id)->get();   //Pobierz dane zamówień zalogowanego użytkownika
        $trips = Trip::get();                                       //Pobierz wszystkie wycieczki

        return view('account.account',[                                     //zwróć widok z parametrami
            'user'=>$user,
            'orders'=>True,
            'orders_list'=>$orders,
            'trips'=>$trips
        ]);
    }

    /*KONTO ZAMÓWIENIA FUNKCJONALNOŚĆ*/
    public function account_order_user($trip_id){   //Przyjmowany argument id pochodzi z ścieżki
        $user = $this->get_user();                  //Pobierz dane zalogowanego użytkownika

        $order = new Order();                       //utwórz nowy obiekt korzystając z klasy Order (model)
        $order->user_id = $user->id;                //zapisz id użytkownika
        $order->trip_id = $trip_id;                 //zapisz id wycieczki
        $order->status = 'Brak opłaty';             //zapisz domyślny status wycieczki
        $res = $order->save();                      //zapisz rekord w bazie danych

        if ($res) {                                 //zwróć ścieżkę z komunikatem
            return redirect('account-orders')->with('success', 'Zamówiłeś wycieczkę z powodzeniem, opłać wakacje w naszym punkcie stacjonarnym!');
        } else {
            return back()->with('fail', 'Coś poszło nie tak!');
        }
    }
}

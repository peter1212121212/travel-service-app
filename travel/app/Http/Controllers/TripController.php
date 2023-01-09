<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use Illuminate\Http\Request;

class TripController extends Controller
{
    /*FUNKCJA DO PODMIANY ZDJĘĆ*/
    public function update_photo($photo, $request){
        if ($photo != null){
            $trip = Trip::where('id', '=', $request->id)->first();              //Pobierz dane o wycieczce z bazy danych
            unlink(public_path().'\assets\\'.$trip->path_photo_1);              //usuń stare zdjęcie 1
            $photo_name_1 = time().'.'.$photo->getClientOriginalName();         //zapisanie nazwy pliku w zmiennej
            $photo->move(public_path('/assets'), $photo_name_1);                //przeniesienie zdjęcia do folderu public/assets
            Trip::where('id', '=', $request->id)->update([                      //aktualizacja bazy
                'path_photo_1' => $photo_name_1,
            ]);
        }
    }
    
    /*WYCIECZKA WIDOK - PODGLĄD*/
    public function trip($id){                          //Przyjmowany argument id pochodzi z ścieżki
        $user = $this->get_user();                      //Pobierz dane zalogowanego użytkownika
        $trip = Trip::where('id', '=', $id)->first();   //Pobierz wycieczkę o id podanym w ścieżce
        
        if ($trip == null){                             //jeśli nie ma w bazie
            return redirect('/');                       //to zwróć ścieżkę strony głównej
        }

        return view('trip',[                            //Zwróć widok z parametrami
            'user' => $user,
            'trip'=> $trip
        ]);
    }

    /*TWORZENIE NOWEJ WYCIECZKI WIDOK*/
    public function create(){
        $user = $this->get_user();  //Pobierz dane zalogowanego użytkownika

        return view('admin.create',[       //Zwróć widok z parametrami
            'user'=>$user,
        ]);
    }

    /*TWORZENIE NOWEJ WYCIECZKI FUNKCJONALNOŚĆ*/
    public function create_trip(Request $request){                          //Request - przyjęcie danych z formularza
        $request->validate([                                                //walidacja                 
            'hotel' => 'required',                                          //sprawdzenie czy nazwa hotelu jest podana
            'price' => 'required|min:0|regex:/^\d*(\.\d{1,2})?$/',          //sprawdzenie czy cena jest podana, czy jest większa od 0 oraz czy cena zawiera kropkę, a nie przecinek
            'country' => 'required',                                        //sprawdzenie czy kraj jest podany
            'food' => 'required',                                           //sprawdzenie czy wyżywienie jest podane
            'transport' => 'required',                                      //sprawdzenie czy transport jest podany
            'description' => 'required',                                    //sprawdzenie czy opis jest podany
            'date_start' => 'required|date|after:today',                    //sprawdzenie czy data rozpoczęcia jest podana, czy data jest datą oraz czy jest to data większa od dzisiaj(minimum jutro)
            'date_end' => 'required|date|after:date_start',                 //sprawdzenie czy data zakończenia jest podana, czy data jest datą oraz czy jest to data większa od datey rozpoczęcia
            'photo_1' => 'required|image|mimes:jpg,png,jpeg|max:2048',      //sprawdzenie czy zdjęcie jest podane, czy plik to zdjęcie, czy posiada odpowiedni format oraz czy rozmiar nie jest za duży
            'photo_2' => 'required|image|mimes:jpg,png,jpeg|max:2048',      //sprawdzenie czy zdjęcie jest podane, czy plik to zdjęcie, czy posiada odpowiedni format oraz czy rozmiar nie jest za duży
            'photo_3' => 'required|image|mimes:jpg,png,jpeg|max:2048',      //sprawdzenie czy zdjęcie jest podane, czy plik to zdjęcie, czy posiada odpowiedni format oraz czy rozmiar nie jest za duży
        ]);

        $photo_1 = request()->file('photo_1');                              //zapisanie zdjęcia w zmiennej
        $photo_name_1 = time().'.'.$photo_1->getClientOriginalName();       //zapisanie nazwy pliku w zmiennej
        $photo_1->move(public_path('/assets'), $photo_name_1);              //przeniesienie zdjęcia do folderu public/assets

        $photo_2 = request()->file('photo_2');                              //zapisanie zdjęcia w zmiennej
        $photo_name_2 = time().'.'.$photo_2->getClientOriginalName();       //zapisanie nazwy pliku w zmiennej
        $photo_2->move(public_path('/assets'), $photo_name_2);

        $photo_3 = request()->file('photo_3');                              //zapisanie zdjęcia w zmiennej
        $photo_name_3 = time().'.'.$photo_3->getClientOriginalName();       //zapisanie nazwy pliku w zmiennej
        $photo_3->move(public_path('/assets'), $photo_name_3);              //przeniesienie zdjęcia do folderu public/assets



        $trip = new Trip();                             //utwórz nowy obiekt korzystając z klasy Trip (model)
        $trip->hotel_name = $request->hotel;            //zapisz nazwę hotelu
        $trip->price = $request->price;                 //zapisz cenę
        $trip->country = $request->country;             //zapisz kraj
        $trip->food = $request->food;                   //zapisz wyżywienie
        $trip->transport = $request->transport;         //zapisz transport
        $trip->description = $request->description;     //zapisz opis
        $trip->path_photo_1 = $photo_name_1;            //zapisz ścieżkę zdjęcia 1
        $trip->path_photo_2 = $photo_name_2;            //zapisz ścieżkę zdjęcia 2
        $trip->path_photo_3 = $photo_name_3;            //zapisz ścieżkę zdjęcia 3
        $trip->date_start = $request->date_start;       //zapisz datę rozpoczecia
        $trip->date_end = $request->date_end;           //zapisz datę zakończenia

        $res = $trip->save();                           //zapisz rekor w bazie danych

        if ($res) {
            return redirect('admin')->with('success', 'Dodałeś wycieczkę z powodzeniem!');  //jeśli wszystko jest ok zwróć ścieżkę z komunikatem
        } else {
            return back()->with('fail', 'Coś poszło nie tak!');                             //jeśli coś poszło nie tak wróć z komunikatem
        }
    }

    /*USUWANIE WYCIECZKI*/
    public function delete($id){                                                        //Przyjmowany argument id pochodzi z ścieżki
        $trip = Trip::where('id', '=', $id)->first();                                   //Pobierz dane o wycieczce z bazy danych
        unlink(public_path().'\assets\\'.$trip->path_photo_1);                          //usuń zdjęcie 1
        unlink(public_path().'\assets\\'.$trip->path_photo_2);                          //usuń zdjęcie 2
        unlink(public_path().'\assets\\'.$trip->path_photo_3);                          //usuń zdjęcie 3
        Trip::where('id', '=', $id)->delete();                                          //usuń rekord
        return redirect('admin')->with('success', 'Usunięto wycieczkę z powodzeniem');  //zwróć ścieżkę z komunikatem
    }

    /*EDYTOWANIE WYCIECZKI WIDOK*/
    public function edit($id){
        $user = $this->get_user();                      //Pobierz dane zalogowanego użytkownika
        $trip = Trip::where('id', '=', $id)->first();   //Pobierz wycieczkę o id podanym w ścieżce
        
        if ($trip == null){                             //jeśli nie ma w bazie
            return redirect('/');                       //to zwróć ścieżkę strony głównej
        }

        return view('admin.edit',[       //Zwróć widok z parametrami
            'user'=>$user,
            'trip'=>$trip
        ]);
    }

    public function edit_trip(Request $request){                            //Request - przyjęcie danych z formularza
        $request->validate([                                                //walidacja                 
            'hotel' => 'required',                                          //sprawdzenie czy nazwa hotelu jest podana
            'price' => 'required|min:0|regex:/^\d*(\.\d{1,2})?$/',          //sprawdzenie czy cena jest podana, czy jest większa od 0 oraz czy cena zawiera kropkę, a nie przecinek
            'country' => 'required',                                        //sprawdzenie czy kraj jest podany
            'food' => 'required',                                           //sprawdzenie czy wyżywienie jest podane
            'transport' => 'required',                                      //sprawdzenie czy transport jest podany
            'description' => 'required',                                    //sprawdzenie czy opis jest podany
            'date_start' => 'required|date|after:today',                    //sprawdzenie czy data rozpoczęcia jest podana, czy data jest datą oraz czy jest to data większa od dzisiaj(minimum jutro)
            'date_end' => 'required|date|after:date_start',                 //sprawdzenie czy data zakończenia jest podana, czy data jest datą oraz czy jest to data większa od datey rozpoczęcia
            'photo_1' => 'image|mimes:jpg,png,jpeg|max:2048',               //sprawdzenie  czy plik to zdjęcie, czy posiada odpowiedni format oraz czy rozmiar nie jest za duży
            'photo_2' => 'image|mimes:jpg,png,jpeg|max:2048',               //sprawdzenie  czy plik to zdjęcie, czy posiada odpowiedni format oraz czy rozmiar nie jest za duży
            'photo_3' => 'image|mimes:jpg,png,jpeg|max:2048',               //sprawdzenie  czy plik to zdjęcie, czy posiada odpowiedni format oraz czy rozmiar nie jest za duży
        ]);

        $photo_1 = request()->file('photo_1');                                  //zapisanie zdjęcia w zmiennej
        $this->update_photo($photo_1, $request);                                //podmiana zdjęcia
        
        $photo_2 = request()->file('photo_2');                                  //zapisanie zdjęcia w zmiennej
        $this->update_photo($photo_1, $request);                                //podmiana zdjęcia

        $photo_3 = request()->file('photo_3');                                  //zapisanie zdjęcia w zmiennej
        $this->update_photo($photo_1, $request);                                //podmiana zdjęcia

        Trip::where('id', '=', $request->id)->update([                          //aktualizacja bazy
            'hotel_name' => $request->hotel,
            'price' => $request->price,
            'country' => $request->country,
            'food' => $request->food,
            'transport' => $request->transport,
            'description' => $request->description,
            'date_start' => $request->date_start,
            'date_end' => $request->date_end,
        ]);

        return redirect('admin')->with('success', 'Edycja wycieczki zakończona powodzeniem!');  //zwróć ścieżkę z komunikatem

    }
}
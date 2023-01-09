<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TripController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*INDEX + PODSTRONY*/
Route::get('/', [Controller::class,'index'])->name('index');
Route::get('/trips-abroad', [Controller::class,'trips_abroad']);
Route::get('/trips-poland', [Controller::class,'trips_poland']);
Route::get('/trips', [Controller::class,'trips']);
Route::get('/trip-{id}',[TripController::class, 'trip']);

/*REJESTRACJA*/
Route::get('/register',[UserController::class,'register'])->middleware('AlreadyLoggedIn');
Route::post('/register-user',[UserController::class,'register_user'])->name('register-user');

/*LOGOWANIE*/
Route::get('/login',[UserController::class,'login'])->middleware('AlreadyLoggedIn');
Route::post('/login-user',[UserController::class,'login_user'])->name('login-user');
Route::get('/logout',[UserController::class, 'logout'])->middleware('isLoggedIn');

/*ADMIN*/
Route::get('/admin', [Controller::class,'admin'])->middleware('AdminCheck');
Route::get('/create', [TripController::class,'create'])->middleware('AdminCheck');
Route::post('/create-trip', [TripController::class,'create_trip'])->name('create-trip');
Route::get('/delete-trip-{id}', [TripController::class,'delete'])->middleware('AdminCheck');
Route::get('/edit-trip-{id}', [TripController::class,'edit'])->middleware('AdminCheck');
Route::post('/edit-trip', [TripController::class,'edit_trip'])->name('edit-trip');

/*KONTO*/
Route::get('/account', [UserController::class,'account'])->middleware('isLoggedIn');
Route::get('/account-edit', [UserController::class,'account_edit'])->middleware('isLoggedIn');
Route::post('/account-edit-user', [UserController::class,'account_edit_user'])->name('account-edit-user')->middleware('isLoggedIn');
Route::get('/account-delete', [UserController::class,'account_delete'])->middleware('isLoggedIn');
Route::get('/account-orders', [UserController::class,'account_order'])->middleware('isLoggedIn');

/*ZAMÓWIENIA*/
Route::get('/order-{id}',[UserController::class, 'account_order_user'])->middleware('isLoggedIn');
Route::get('/status-{status}-{id}',[Controller::class, 'order_status'])->middleware('AdminCheck');
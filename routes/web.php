<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RestoController;

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

Route::get('/', function () {
    return view('welcome');
});


//Route::post('registerUser','RestoController@registerUser');
//Route::post('loginUser','RestoController@login');

Route::post('/registration',[RestoController::class,'registerUser']);
Route::post('loginUser',[RestoController::class,'login']);

Route::view('registration','registration');
Route::view('login','login');

route::get('home',[RestoController::class,'home']);


Route::get('/logout', function () {

        if(Session()->has('user'))
       {
           session()->pull('user');
       }

       return redirect('login');
});
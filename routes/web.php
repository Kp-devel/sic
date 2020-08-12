<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('gestor.home');
})->name("inicio");


Auth::routes();

Route::group(['middleware' => ['auth']], function(){
    
    //Route::get('/home', 'HomeController@index')->name('home');


});


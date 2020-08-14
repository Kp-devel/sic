<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('gestor.home');
})->name("inicio");

Route::get('/wel', function () {
    return view('layouts.welcome');
})->name("inicio_wel");

Route::get('/gestion', function () {
    return view('gestor.gestion');
})->name("gestion");

Auth::routes();

Route::group(['middleware' => ['auth']], function(){
    
    //Route::get('/home', 'HomeController@index')->name('home');


});


<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('gestor.home');
})->name("inicio");

Route::get('panelcontrolllamadas', function () {
    return view('admin.controlLlamadas');
})->name("panelcontrolllamadas");



Auth::routes();

Route::group(['middleware' => ['auth']], function(){
    
    //Route::get('/home', 'HomeController@index')->name('home');

});


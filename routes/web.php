<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('gestor.home');
})->name("inicio");

//clientes
Route::get('clientes', function () {return view('gestor.clientes');})->name("clientes");

// control de llamadas - elastix
Route::get('panelcontrolllamadas', 'ControlLLamadaController@panelcontrolllamadas')->name('panelcontrolllamadas');
Route::post('controlLLamadas', 'ControlLLamadaController@controlLLamadas')->name('controlLLamadas');
Route::get('panelcontrolllamadasgestor', 'ControlLLamadaController@panelcontrolllamadasgestor')->name('panelcontrolllamadasgestor');
Route::post('controlLLamadasGestor', 'ControlLLamadaController@controlLLamadasGestor')->name('controlLLamadasGestor');
Route::get('llamarExtension', 'ControlLLamadaController@llamarExtension')->name('llamarExtension');
Route::get('ftpArchivos', 'ControlLLamadaController@ftpArchivos')->name('ftpArchivos');

// empleado
Route::get('agentesElastix/{cartera}', 'EmpleadoController@agentesElastix')->name('agentesElastix');




Auth::routes();

Route::group(['middleware' => ['auth']], function(){
    
    //Route::get('/home', 'HomeController@index')->name('home');

});


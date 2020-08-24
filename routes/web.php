<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('gestor.home');
})->name("inicio");

//clientes
Route::get('clientes', function () {return view('gestor.clientes');})->name("clientes");
Route::get('listClientes', 'ClienteController@listaClientes');
Route::get('listRespuestas', 'ClienteController@listaRespuestas');
Route::get('datosEstandar', 'ClienteController@datosEstandar');
Route::get('datosMes', 'ClienteController@datosMes');
Route::get('estadosCampana', 'ClienteController@estadoCampana');

// control de llamadas - elastix
Route::get('panelcontrolllamadas', 'ControlLLamadaController@panelcontrolllamadas')->name('panelcontrolllamadas');
Route::post('controlLLamadas', 'ControlLLamadaController@controlLLamadas')->name('controlLLamadas');
Route::get('panelcontrolllamadasgestor', 'ControlLLamadaController@panelcontrolllamadasgestor')->name('panelcontrolllamadasgestor');
Route::post('controlLLamadasGestor', 'ControlLLamadaController@controlLLamadasGestor')->name('controlLLamadasGestor');

// empleado
Route::get('agentesElastix/{cartera}', 'EmpleadoController@agentesElastix')->name('agentesElastix');




Auth::routes();

Route::group(['middleware' => ['auth']], function(){
    
    //Route::get('/home', 'HomeController@index')->name('home');

});


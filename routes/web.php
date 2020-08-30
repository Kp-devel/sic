<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::group(['middleware' => ['auth']], function(){
    
    Route::get('/', function () {
        return view('gestor.clientes');
    })->name("inicio");
    
    //clientes
    //Route::get('clientes', function () {return view('gestor.clientes');})->name("clientes");
    Route::get('listClientes', 'ClienteController@listaClientes');
    Route::post('datosEstandar', 'ClienteController@datosEstandar');
    Route::get('datosMes', 'ClienteController@datosMes');
    Route::get('estadosCampana', 'ClienteController@estadoCampana');
    Route::get('infoCliente', 'ClienteController@infoCliente');
    Route::get('historicoGestiones', 'ClienteController@historicoGestiones');
    Route::get('infoDeuda/{id}', 'ClienteController@infoDeuda');
    
    //telefonos
    Route::get('listaTel', 'TelefonoController@listaTelefonos');
    Route::post('insertarTel', 'TelefonoController@insertarTelefonos');
    
    //Gestion
    Route::get('listaRespuesta', 'GestionController@listaRespuestas');
    Route::post('insertarGestion', 'GestionController@insertarGestion');
    
    //Pagos
    Route::get('listaPagos', 'PagoController@listaPagos');
    
    //campañas
    Route::get('estadosCampana', 'CampanaController@estadosCampana');
    
    //respuestas
    Route::get('listRespuestas', 'RespuestaController@listRespuestas');
    
    // control de llamadas - elastix
    Route::get('panelcontrolllamadas', 'ControlLLamadaController@panelcontrolllamadas')->name('panelcontrolllamadas');
    Route::post('controlLLamadas', 'ControlLLamadaController@controlLLamadas')->name('controlLLamadas');
    Route::get('panelcontrolllamadasgestor', 'ControlLLamadaController@panelcontrolllamadasgestor')->name('panelcontrolllamadasgestor');
    Route::post('controlLLamadasGestor', 'ControlLLamadaController@controlLLamadasGestor')->name('controlLLamadasGestor');
    
    // empleado
    Route::get('agentesElastix/{cartera}', 'EmpleadoController@agentesElastix')->name('agentesElastix');    
    

});


<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::group(['middleware' => ['auth']], function(){
    
    Route::get('/', function () {
        return view('gestor.clientes');
    })->name("inicio");
    
    Route::get('/home', function () {
        return view('gestor.clientes');
    });
    //clientes
    //Route::get('clientes', function () {return view('gestor.clientes');})->name("clientes");
    Route::post('listClientes', 'ClienteController@listaClientes');
    Route::post('datosEstandar', 'ClienteController@datosEstandar');
    Route::get('datosMes', 'ClienteController@datosMes');
    // Route::get('estadosCampana', 'ClienteController@estadoCampana');
    Route::get('detalleCliente/{id}', 'ClienteController@detalleCliente');

    // Route::get('infoCliente/{id}', 'ClienteController@infoCliente');
    Route::get('historicoGestiones/{id}', 'ClienteController@historicoGestiones');
    // Route::get('infoDeuda/{id}', 'ClienteController@infoDeuda');
    
    //telefonos
    Route::get('listaTel/{id}', 'TelefonoController@listaTelefonos');
    Route::post('insertarTel', 'TelefonoController@insertarTelefonos');
    Route::put('actualizarEstadoTelefono', 'TelefonoController@actualizarEstadoTelefono');
    
    //Gestion
    Route::post('insertarGestion', 'GestionController@insertarGestion');
    Route::get('validarContacto/{id}', 'GestionController@validarContacto');
    Route::get('validarPDP/{id}', 'GestionController@validarPDP');
    Route::post('validarDetalleIdentico', 'GestionController@validarDetalleIdentico');
    
    //Recordatorio
    Route::post('insertarRecordatorio', 'RecordatorioController@insertarRecordatorio');
    Route::get('listarRecordatorio', 'RecordatorioController@listarRecordatorio');

    //Pagos
    Route::get('listaPagos/{id}', 'PagoController@listaPagos');
    
    //campañas
    Route::get('estadosCampana', 'CampanaController@estadosCampana');
    
    //respuestas
    Route::get('listRespuestas', 'RespuestaController@listRespuestas');
    Route::get('listaMotivosNoPago', 'RespuestaController@listaMotivosNoPago');
    Route::get('listaRespuesta/{ubi}', 'RespuestaController@listaRespuestaUbicabilidad');
    Route::get('listaEntidades', 'RespuestaController@listaEntidades');
    Route::get('listaScore', 'RespuestaController@listaScore');
    
    // control de llamadas - elastix
    Route::get('panelcontrolllamadas', 'ControlLLamadaController@panelcontrolllamadas')->name('panelcontrolllamadas');
    Route::post('controlLLamadas', 'ControlLLamadaController@controlLLamadas')->name('controlLLamadas');
    Route::get('panelcontrolllamadasgestor', 'ControlLLamadaController@panelcontrolllamadasgestor')->name('panelcontrolllamadasgestor');
    Route::post('controlLLamadasGestor', 'ControlLLamadaController@controlLLamadasGestor')->name('controlLLamadasGestor');
    
    // empleado
    Route::get('agentesElastix/{cartera}', 'EmpleadoController@agentesElastix')->name('agentesElastix');    
    

});


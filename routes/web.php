<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::group(['middleware' => ['auth']], function(){
    
    Route::get('/', 'HomeController@inicio')->name('inicio');
    Route::get('/home', 'HomeController@inicio')->name('home');
    Route::get('/menu', 'HomeController@menuPrincipal')->name('menu');
    Route::get('/clientes', 'HomeController@menuClientes')->name('clientes');
    
    //clientes
    //Route::get('clientes', function () {return view('gestor.clientes');})->name("clientes");
    Route::post('listClientes', 'ClienteController@listaClientes');
    Route::post('datosEstandar', 'ClienteController@datosEstandar');
    Route::get('datosMes', 'ClienteController@datosMes');
    // Route::get('estadosCampana', 'ClienteController@estadoCampana');
    Route::get('detalleCliente/{id}', 'ClienteController@detalleCliente');
    Route::put('updateEmail', 'ClienteController@updateEmail');
    
    // Route::get('infoCliente/{id}', 'ClienteController@infoCliente');
    Route::get('historicoGestiones/{id}', 'ClienteController@historicoGestiones');
    // Route::get('infoDeuda/{id}', 'ClienteController@infoDeuda');
    
    //telefonos
    Route::get('listaTel/{id}', 'TelefonoController@listaTelefonos');
    Route::post('insertarTel', 'TelefonoController@insertarTelefonos');
    Route::put('actualizarEstadoTelefono', 'TelefonoController@actualizarEstadoTelefono');
    
    //Gestion
    Route::post('insertarGestion', 'GestionController@insertarGestion');
    // Route::get('validarContacto/{id}', 'GestionController@validarContacto');
    // Route::get('validarPDP/{id}', 'GestionController@validarPDP');
    Route::post('validarDetalleIdentico', 'GestionController@validarDetalleIdentico');
    
    //Recordatorio
    Route::post('insertarRecordatorio', 'RecordatorioController@insertarRecordatorio');
    Route::get('listarRecordatorio', 'RecordatorioController@listarRecordatorio');

    //Pagos
    Route::get('listaPagos/{id}', 'PagoController@listaPagos');
    
    //campañas
    Route::get('estadosCampana', 'CampanaController@estadosCampana');
    
    //respuestas
    Route::get('listasPanelBusqueda', 'RespuestaController@listasPanelBusqueda');
    Route::get('listasBusquedaPorCartera/{car}', 'RespuestaController@listasBusquedaPorCartera');
    Route::get('listRespuestas', 'RespuestaController@listRespuestas');
    Route::get('listaMotivosNoPago', 'RespuestaController@listaMotivosNoPago');
    Route::get('listaRespuesta/{ubi}', 'RespuestaController@listaRespuestaUbicabilidad');
    Route::get('listaRespuestaSms/{ubi}', 'RespuestaController@listaRespuestaUbicSms');
    Route::get('listaEntidades', 'RespuestaController@listaEntidades');
    Route::get('listaScore', 'RespuestaController@listaScore');
    Route::get('listaOficinas', 'RespuestaController@listaOficinas');
    
// --------------------------------------------------------------------------------------------
    // vistas sms
    Route::get('/sms', 'HomeController@sms')->name('sms');
    
    // Bandeja sms
    Route::get('/smsbandeja', 'HomeController@smsbandeja')->name('smsbandeja');
    Route::get('/bandejaMsj', 'SmsBandejaController@bandejaMsj')->name('bandejaMsj');
    Route::get('/chat/{numero}', 'SmsBandejaController@chat')->name('chat');
    
    //campana sms
    Route::get('/smscampanas', 'HomeController@smscampanas')->name('smscampanas');
    Route::get('/smscrearcampana', 'HomeController@smscrearcampana')->name('smscrearcampana');
    Route::post('/buscarCampana', 'SmsCampanaController@buscarCampana')->name('buscarCampana');
    Route::get('/detalleCampana/{id}', 'SmsCampanaController@detalleCampana')->name('detalleCampana');
    Route::get('/condicionCampana/{id}', 'SmsCampanaController@condicionCampana')->name('condicionCampana');
    Route::get('/enviarCampana/{id}', 'SmsCampanaController@enviarCampana')->name('enviarCampana');
    Route::get('/listCampanasDia', 'SmsCampanaController@listCampanasDia')->name('listCampanasDia');
    Route::post('/datosclientesCampana', 'SmsCampanaController@datosclientesCampana')->name('datosclientesCampana');
    Route::post('/insertCampana', 'SmsCampanaController@insertCampana')->name('insertCampana');

    //speech
    Route::get('/carteraSpeech/{cartera}', 'SmsSpeechController@carteraSpeech')->name('carteraSpeech');
    Route::post('/insertSpeech', 'SmsSpeechController@insertSpeech')->name('insertSpeech');
    Route::get('/listEtiquetas', 'SmsSpeechController@etiquetas')->name('listEtiquetas');
    
    //condiciones:entidades,score,prioridad,etc
    Route::get('/tagCondicion/{car}/{tipo}', 'SmsCampanaController@tagCondicion')->name('tagCondicion');

    //carteras
    Route::get('listCarterasUsuario', 'CarteraController@listCarterasUsuario');
    
// indicadores---------------------------------------------------------------------------------
    //vistas
    Route::get('/indicadores', 'HomeController@indicadores')->name('indicadores');
    Route::get('/indicadoresoperativos', 'HomeController@indicadoresoperativos')->name('indicadoresoperativos');
    Route::get('/estructuracartera', 'HomeController@indestructuracartera')->name('estructuracartera');
    Route::get('/estructuragestor', 'HomeController@indestructuragestor')->name('estructuragestor');
    Route::get('/crearplantrabajo', 'HomeController@indcrearplantrabajo')->name('crearplantrabajo');
    Route::get('/seguimientoplantrabajo', 'HomeController@indseguimientoplantrabajo')->name('seguimientoplantrabajo');
    
    // indicadores operativos ---------------------------------------------------------------------------------------------------------------
    Route::post('reporteEstructuraCartera', 'EstructuraController@reporteEstructuraCartera');
    Route::post('reporteEstructuraGestor', 'EstructuraController@reporteEstructuraGestor');
    Route::get('listaGestores/{cartera}', 'EstructuraController@listaGestores');
    Route::get('listaAsignacion', 'IndicadorController@asignacion');
    Route::post('listaEstructuras', 'IndicadorController@estructuras');
    Route::post('reporteIndicadoresOperativos', 'IndicadorController@reporteIndicadoresOperativos');
    
    //Plan de Trabajo-----------------------------------------------------------------------------------------------------------------------
    Route::post('listaPlanes', 'PlanController@listaPlanes');
    Route::post('resumenPlan', 'PlanController@resumenPlan');
    Route::post('insertarPlan', 'PlanController@insertarPlan');
    Route::get('usuariosPlan/{id}', 'PlanController@usuariosPlan');
    Route::post('resultadosPlan', 'PlanController@resultadosPlan');
    
    //Reporte general------------------------------------------------------------------------------------------------------------------------
    Route::get('/reportegeneral', 'HomeController@indreportegeneral')->name('reportegeneral');
    Route::post('reporteGeneralGestiones', 'ReporteController@reporteGeneralGestiones');
    
    //Reporte gestión telef por gestor-------------------------------------------------------------------------------------------------------
    Route::get('/reportegestor', 'HomeController@indreportegestor')->name('reportegestor');
    Route::get('asignacionCall', 'ReporteController@asignacionCall');
    Route::post('reporteResumenGestor', 'ReporteController@reporteResumenGestor');
    Route::post('descargarGestionesGestor', 'ReporteController@descargarGestionesGestor');
        
//Reporte Primer y Ultima gestion--------------------------------------------------------------------------------------------------------
    Route::get('/reporteprimerayultimagestion', 'HomeController@indreporteprimyultgestion')->name('reporteprimerayultimagestion');
    Route::post('primerayultimagestion', 'ReporteController@primerayultimagestion');

//Reporte cant de gestiones por hora--------------------------------------------------------------------------------------------------------
    Route::get('/reportegestionhora', 'HomeController@indreportegestionhora')->name('reportegestionhora');
    Route::get('cantGestioneHora/{cartera}', 'ReporteController@cantGestioneHora');

// ELASTIX ------------------------------------------------------------------------------------------------------------------------------
    // control de llamadas - elastix
    Route::get('panelcontrolllamadas', 'ControlLLamadaController@panelcontrolllamadas')->name('panelcontrolllamadas');
    Route::post('controlLLamadas', 'ControlLLamadaController@controlLLamadas')->name('controlLLamadas');
    Route::get('panelcontrolllamadasgestor', 'ControlLLamadaController@panelcontrolllamadasgestor')->name('panelcontrolllamadasgestor');
    Route::post('controlLLamadasGestor', 'ControlLLamadaController@controlLLamadasGestor')->name('controlLLamadasGestor');
    
    // empleado
    Route::get('agentesElastix/{cartera}', 'EmpleadoController@agentesElastix')->name('agentesElastix');    
    

    
    //errors---------------------------------------------------------------------------
    // 403
    Route::get('/403', function(){return view('errors.403');});
    
});


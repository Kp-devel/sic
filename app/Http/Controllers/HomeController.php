<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cartera;
use App\Incidencia;
use App\Respuesta;

class HomeController extends Controller
{
    
    public function inicio(){
        $tipo_acceso=auth()->user()->emp_tip_acc;
        $perfil="";
        if($tipo_acceso==1 || $tipo_acceso==5 || $tipo_acceso==6 || $tipo_acceso==7){
            return view('admin.menuPrincipal');
        }
        if($tipo_acceso==2){
            return view('gestor.clientes');
        }
    }

    public function menuPrincipal(){
        $tipo_acceso=auth()->user()->emp_tip_acc;
        if($tipo_acceso==1 || $tipo_acceso==5 || $tipo_acceso==6 || $tipo_acceso==7){
            return view('admin.menuPrincipal');
        }else{
            return view('errors.403');
        }
    }

    public function menuClientes(){
        return view('gestor.clientes');
    }

    public function sms(){
        $tipo_acceso=auth()->user()->emp_tip_acc;
        if($tipo_acceso==1 || $tipo_acceso==5 || $tipo_acceso==6 || $tipo_acceso==7){
            return view('admin.sms.panelControl');
        }else{
            return view('errors.403');
        }
    }

    public function smsbandeja(){
        $tipo_acceso=auth()->user()->emp_tip_acc;
        if($tipo_acceso==1 || $tipo_acceso==5 || $tipo_acceso==6 || $tipo_acceso==7){
            return view('admin.sms.bandeja');
        }else{
            return view('errors.403');
        }
    }

    public function smscampanas(){
        $tipo_acceso=auth()->user()->emp_tip_acc;
        if($tipo_acceso==1 || $tipo_acceso==5 || $tipo_acceso==6 || $tipo_acceso==7){
            $carteras=Cartera::listCarterasUsuarioSms();  
            $carteras=json_encode($carteras);
            $rol=2;
            return view('admin.sms.listaCampanas',compact('carteras','rol'));
        }else{
            return view('errors.403');
        }
    }

    public function smscrearcampana(){
        $tipo_acceso=auth()->user()->emp_tip_acc;
        if($tipo_acceso==1 || $tipo_acceso==5 || $tipo_acceso==6 || $tipo_acceso==7){
            $carteras=Cartera::listCarterasUsuarioSms();       
            $carteras=json_encode($carteras);
            $rol=2;
            return view('admin.sms.crearCampana',compact('carteras','rol'));
        }else{
            return view('errors.403');
        }
    }
    
    public function smslistanegranumero(){
        $tipo_acceso=auth()->user()->emp_tip_acc;
        if($tipo_acceso==1 || $tipo_acceso==5 || $tipo_acceso==6 || $tipo_acceso==7){
            return view('admin.sms.listaNegraNumero');
        }else{
            return view('errors.403');
        }
    }

    public function smslistanegraarchivo(){
        $tipo_acceso=auth()->user()->emp_tip_acc;
        if($tipo_acceso==1 || $tipo_acceso==5 || $tipo_acceso==6 || $tipo_acceso==7){
            return view('admin.sms.listaNegraArchivo');
        }else{
            return view('errors.403');
        }
    }

    public function smsbuscarlistanegra(){
        $tipo_acceso=auth()->user()->emp_tip_acc;
        if($tipo_acceso==1 || $tipo_acceso==5 || $tipo_acceso==6 || $tipo_acceso==7){
            return view('admin.sms.listaNegraBuscar');
        }else{
            return view('errors.403');
        }
    }

    public function indicadores(){
        $tipo_acceso=auth()->user()->emp_tip_acc;
        if($tipo_acceso==1 || $tipo_acceso==5 || $tipo_acceso==6 || $tipo_acceso==7){
            return view('admin.indicadores.indicadores');
        }else{
            return view('errors.403');
        }
    }

    public function indicadoresoperativos(){
        $tipo_acceso=auth()->user()->emp_tip_acc;
        if($tipo_acceso==1 || $tipo_acceso==5 || $tipo_acceso==6 || $tipo_acceso==7){
            $carteras=Cartera::listCarterasUsuario();       
            $carteras=json_encode($carteras);
            return view('admin.indicadores.indicadoresOperativos',compact('carteras'));
        }else{
            return view('errors.403');
        }
    }

    public function indestructuracartera(){
        $tipo_acceso=auth()->user()->emp_tip_acc;
        if($tipo_acceso==1 || $tipo_acceso==5 || $tipo_acceso==6 || $tipo_acceso==7){
            $carteras=Cartera::listCarterasUsuario();       
            $carteras=json_encode($carteras);
            return view('admin.indicadores.estructuraCartera',compact('carteras'));
        }else{
            return view('errors.403');
        }
    }

    public function indestructuragestor(){
        $tipo_acceso=auth()->user()->emp_tip_acc;
        if($tipo_acceso==1 || $tipo_acceso==5 || $tipo_acceso==6 || $tipo_acceso==7){
            $carteras=Cartera::listCarterasUsuario();       
            $carteras=json_encode($carteras);
            return view('admin.indicadores.estructuraGestor',compact('carteras'));
        }else{
            return view('errors.403');
        }
    }

    public function indcrearplantrabajo(){
        $tipo_acceso=auth()->user()->emp_tip_acc;
        if($tipo_acceso==1 || $tipo_acceso==5 || $tipo_acceso==6 || $tipo_acceso==7){
            $carteras=Cartera::listCarterasUsuario();       
            $respuestas=Respuesta::listRespuestasUbicabilidad();
            $carteras=json_encode($carteras);
            $respuestas=json_encode($respuestas);
            return view('admin.indicadores.crearPlan',compact('carteras','respuestas'));
        }else{
            return view('errors.403');
        }
    }
    
    public function indseguimientoplantrabajo(){
        $tipo_acceso=auth()->user()->emp_tip_acc;
        if($tipo_acceso==1 || $tipo_acceso==5 || $tipo_acceso==6 || $tipo_acceso==7){
            $carteras=Cartera::listCarterasUsuario();       
            $carteras=json_encode($carteras);
            return view('admin.indicadores.seguimientoPlan',compact('carteras'));
        }else{
            return view('errors.403');
        }
    }

    public function indreportegeneral(){
        $tipo_acceso=auth()->user()->emp_tip_acc;
        if($tipo_acceso==1 || $tipo_acceso==5 || $tipo_acceso==6 || $tipo_acceso==7){
            $carteras=Cartera::listCarterasUsuario();       
            $carteras=json_encode($carteras);
            return view('admin.indicadores.reporteGeneral',compact('carteras'));
        }else{
            return view('errors.403');
        }
    }

    public function indreportegestor(){
        $tipo_acceso=auth()->user()->emp_tip_acc;
        if($tipo_acceso==1 || $tipo_acceso==5 || $tipo_acceso==6 || $tipo_acceso==7){
            $carteras=Cartera::listCarterasUsuario();       
            $carteras=json_encode($carteras);
            return view('admin.indicadores.reporteGestor',compact('carteras'));
        }else{
            return view('errors.403');
        }
    }

    public function indreportegestionhora(){
        $tipo_acceso=auth()->user()->emp_tip_acc;
        if($tipo_acceso==1 || $tipo_acceso==5 || $tipo_acceso==6 || $tipo_acceso==7){
            $carteras=Cartera::listCarterasUsuario();       
            $carteras=json_encode($carteras);
            return view('admin.indicadores.reporteGestionHora',compact('carteras'));
        }else{
            return view('errors.403');
        }
    }

    public function indreporteprimyultgestion(){
        $tipo_acceso=auth()->user()->emp_tip_acc;
        if($tipo_acceso==1 || $tipo_acceso==5 || $tipo_acceso==6 || $tipo_acceso==7){
            $carteras=Cartera::listCarterasUsuario();       
            $carteras=json_encode($carteras);
            return view('admin.indicadores.reportePrimyUltGestion',compact('carteras'));
        }else{
            return view('errors.403');
        }
    }

    public function indresumengestion(){
        $tipo_acceso=auth()->user()->emp_tip_acc;
        if($tipo_acceso==1 || $tipo_acceso==5 || $tipo_acceso==6 || $tipo_acceso==7){
            $carteras=Cartera::listCarterasUsuario();       
            $carteras=json_encode($carteras);
            return view('admin.indicadores.reporteResumenGestion',compact('carteras'));
        }else{
            return view('errors.403');
        }
    }
    
    public function indresumengestionconsolidada(){
        $tipo_acceso=auth()->user()->emp_tip_acc;
        if($tipo_acceso==5){
            return view('admin.indicadores.reporteResumenGestionConsolidada');
        }else{
            return view('errors.403');
        }
    }

    public function indcomparativocartera(){
        $tipo_acceso=auth()->user()->emp_tip_acc;
        if($tipo_acceso==1 || $tipo_acceso==5){
            $carteras=Cartera::listCarterasUsuario();       
            $carteras=json_encode($carteras);
            return view('admin.indicadores.comparativoCartera',compact('carteras'));
        }else{
            return view('errors.403');
        }
    }
    
    public function timingyproyectado(){
        $tipo_acceso=auth()->user()->emp_tip_acc;
        if($tipo_acceso==1 || $tipo_acceso==5 || $tipo_acceso==6 || $tipo_acceso==7){
            $carteras=Cartera::listCarterasUsuario();       
            $carteras=json_encode($carteras);
            return view('admin.indicadores.timingyproyectado',compact('carteras'));
        }else{
            return view('errors.403');
        }
    }
    
    public function incidencias(){
        $tipo_acceso=auth()->user()->emp_tip_acc;
        if($tipo_acceso==1 || $tipo_acceso==5 || $tipo_acceso==6 || $tipo_acceso==7){
            if($tipo_acceso==1){
                $supervisores=array();
            }else{
                $supervisores=Incidencia::incListaSupervisores();       
            }
            $gestores=Incidencia::incListaGestores();       
            $incidencias=Incidencia::tiposIncidencias();       
            $datos=array();
            $datos=[$supervisores,$gestores,$incidencias];
            $datos=json_encode($datos);
            return view('admin.incidencias.incidencias',compact('datos'));
        }else{
            return view('errors.403');
        }
    }

    public function nuevaincidencia(){
        $tipo_acceso=auth()->user()->emp_tip_acc;
        if($tipo_acceso==1 || $tipo_acceso==5 || $tipo_acceso==6 || $tipo_acceso==7){
            $carteras=Cartera::listCarterasUsuario();       
            $carteras=json_encode($carteras);
            return view('admin.incidencias.registrarIncidencia',compact('carteras'));
        }else{
            return view('errors.403');
        }
    }

    public function estadospdps(){
        $tipo_acceso=auth()->user()->emp_tip_acc;
        if($tipo_acceso==1 || $tipo_acceso==5 || $tipo_acceso==6 || $tipo_acceso==7){
            $carteras=Cartera::listCarterasUsuario();       
            $carteras=json_encode($carteras);
            return view('admin.indicadores.estadoPdps',compact('carteras'));
        }else{
            return view('errors.403');
        }
    }

    public function estandarpdps(){
        $tipo_acceso=auth()->user()->emp_tip_acc;
        if($tipo_acceso==1 || $tipo_acceso==5 || $tipo_acceso==6 || $tipo_acceso==7){
            $carteras=Cartera::listCarterasUsuario();       
            $carteras=json_encode($carteras);
            return view('admin.indicadores.estandarPdps',compact('carteras'));
        }else{
            return view('errors.403');
        }
    }

    public function pdps(){
        $tipo_acceso=auth()->user()->emp_tip_acc;
        if($tipo_acceso==1 || $tipo_acceso==5 || $tipo_acceso==6 || $tipo_acceso==7){
            $carteras=Cartera::listCarterasUsuario();       
            $carteras=json_encode($carteras);
            return view('admin.indicadores.pdps',compact('carteras'));
        }else{
            return view('errors.403');
        }
    }

    public function listadopdps(){
        $tipo_acceso=auth()->user()->emp_tip_acc;
        if($tipo_acceso==1 || $tipo_acceso==5 || $tipo_acceso==6 || $tipo_acceso==7){
            $carteras=Cartera::listCarterasUsuario();       
            $carteras=json_encode($carteras);
            return view('admin.indicadores.listadoPdps',compact('carteras'));
        }else{
            return view('errors.403');
        }
    }

    public function indlistadoactualizaciones(){
        $tipo_acceso=auth()->user()->emp_tip_acc;
        if($tipo_acceso==5){
            return view('admin.indicadores.listadoActualizaciones');
        }else{
            return view('errors.403');
        }
    }
    
    public function predictivo(){
        $tipo_acceso=auth()->user()->emp_tip_acc;
        if($tipo_acceso==1 || $tipo_acceso==6){
            return view('admin.predictivo.predictivo');
        }else{
            return view('errors.403');
        }
    }


    public function registrargestiones(){
        $tipo_acceso=auth()->user()->emp_tip_acc;
        if($tipo_acceso==1 || $tipo_acceso==5 || $tipo_acceso==6 || $tipo_acceso==7){
            $carteras=Cartera::listCarterasUsuario();       
            $carteras=json_encode($carteras);
            return view('admin.predictivo.frmGestiones',compact('carteras'));
        }else{
            return view('errors.403');
        }
    }

    public function crearpredictivo(){
        $tipo_acceso=auth()->user()->emp_tip_acc;
        if($tipo_acceso==1 || $tipo_acceso==5 || $tipo_acceso==6 || $tipo_acceso==7){
            $carteras=Cartera::listCarterasUsuario();       
            $carteras=json_encode($carteras);
            return view('admin.predictivo.frmPredictivo',compact('carteras'));
        }else{
            return view('errors.403');
        }
    }
    
}

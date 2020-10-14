<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cartera;

class HomeController extends Controller
{
    
    public function inicio(){
        $tipo_acceso=auth()->user()->emp_tip_acc;
        
        if($tipo_acceso==1){
            return view('admin.menuPrincipal');
        }
        if($tipo_acceso==2){
            return view('gestor.clientes');
        }
    }

    public function menuPrincipal(){
        $tipo_acceso=auth()->user()->emp_tip_acc;
        if($tipo_acceso==1){
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
        if($tipo_acceso==1){
            return view('admin.sms.panelControl');
        }else{
            return view('errors.403');
        }
    }


    public function smsbandeja(){
        $tipo_acceso=auth()->user()->emp_tip_acc;
        if($tipo_acceso==1){
            return view('admin.sms.bandeja');
        }else{
            return view('errors.403');
        }
    }

    public function smscampanas(){
        $tipo_acceso=auth()->user()->emp_tip_acc;
        if($tipo_acceso==1){
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
        if($tipo_acceso==1){
            $carteras=Cartera::listCarterasUsuarioSms();       
            $carteras=json_encode($carteras);
            $rol=2;
            return view('admin.sms.crearCampana',compact('carteras','rol'));
        }else{
            return view('errors.403');
        }
    }
    
    public function indicadores(){
        $tipo_acceso=auth()->user()->emp_tip_acc;
        if($tipo_acceso==1){
            return view('admin.indicadores.indicadores');
        }else{
            return view('errors.403');
        }
    }

    public function indicadoresoperativos(){
        $tipo_acceso=auth()->user()->emp_tip_acc;
        if($tipo_acceso==1){
            $carteras=Cartera::listCarterasUsuario();       
            $carteras=json_encode($carteras);
            return view('admin.indicadores.indicadoresOperativos',compact('carteras'));
        }else{
            return view('errors.403');
        }
    }

    public function indestructuracartera(){
        $tipo_acceso=auth()->user()->emp_tip_acc;
        if($tipo_acceso==1){
            $carteras=Cartera::listCarterasUsuario();       
            $carteras=json_encode($carteras);
            return view('admin.indicadores.estructuraCartera',compact('carteras'));
        }else{
            return view('errors.403');
        }
    }

    public function indestructuragestor(){
        $tipo_acceso=auth()->user()->emp_tip_acc;
        if($tipo_acceso==1){
            $carteras=Cartera::listCarterasUsuario();       
            $carteras=json_encode($carteras);
            return view('admin.indicadores.estructuraGestor',compact('carteras'));
        }else{
            return view('errors.403');
        }
    }

    public function indcrearplantrabajo(){
        $tipo_acceso=auth()->user()->emp_tip_acc;
        if($tipo_acceso==1){
            $carteras=Cartera::listCarterasUsuario();       
            $carteras=json_encode($carteras);
            return view('admin.indicadores.crearPlan',compact('carteras'));
        }else{
            return view('errors.403');
        }
    }
    
    public function indseguimientoplantrabajo(){
        $tipo_acceso=auth()->user()->emp_tip_acc;
        if($tipo_acceso==1){
            $carteras=Cartera::listCarterasUsuario();       
            $carteras=json_encode($carteras);
            return view('admin.indicadores.seguimientoPlan',compact('carteras'));
        }else{
            return view('errors.403');
        }
    }
}

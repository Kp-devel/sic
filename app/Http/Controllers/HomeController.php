<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
            return "No puede acceder a esta página";
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
            return "No puede acceder a esta página";
        }
    }

    public function smscampanas(){
        $tipo_acceso=auth()->user()->emp_tip_acc;
        if($tipo_acceso==1){
            return view('admin.sms.listaCampañas');
        }else{
            return "No puede acceder a esta página";
        }
    }

    public function smsbandeja(){
        $tipo_acceso=auth()->user()->emp_tip_acc;
        if($tipo_acceso==1){
            return view('admin.sms.bandeja');
        }else{
            return "No puede acceder a esta página";
        }
    }

    
}

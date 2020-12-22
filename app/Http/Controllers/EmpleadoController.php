<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empleado;

class EmpleadoController extends Controller
{
    public function codigoEmpleado(){
        while($codigo = rand(999,9999)){
            $res=Empleado::codigoEmpleado($codigo);
            if(count($res)==0){
                return $codigo;
                break;
            }
        }
    }
    
    public function insertarEmpleado(Request $rq){
        return Empleado::insertarEmpleado($rq);
    }

    public function listEmpleados(Request $rq){
        if($rq->codigo!='' || $rq->nombre!='' || $rq->perfil!=''){
            return Empleado::listEmpleados($rq);
        }
    }

    public function updateEmpleado(Request $rq){
        return Empleado::updateEmpleado($rq);
    }

    public function updateClave(Request $rq){
        return Empleado::updateClave($rq);
    }

    public function insertarGestor(Request $rq){
        return Empleado::insertarGestor($rq);
    }

    public function listGestores(Request $rq){
        return Empleado::listGestores($rq);
    }

    public function listGestoresActivos(){
        return Empleado::listGestoresActivos();
    }

    public function updateFirma(Request $rq){
        return Empleado::updateFirma($rq);
    }

    public function updateGestor(Request $rq){
        return Empleado::updateGestor($rq);
    }

    public function historialLaboral($firma){
        return Empleado::historialLaboral($firma);
    }

    public function registroHistorialLaboral(Request $rq){
        $tipo=$rq->tipoBtn;
        if($tipo==1){
            return Empleado::insertHistorialLaboral($rq);
        }
        if($tipo==2){
            return Empleado::updateHistorialLaboral($rq);
        }
    }

    public function listEmpleadosActivos(){
        return Empleado::listEmpleadosActivos();
    }

    public function updateUsuario(Request $rq){
        return Empleado::updateUsuario($rq);
    }
    

    public function agentesElastix($cartera){
        return Empleado::agentesElastix($cartera);
    }
}

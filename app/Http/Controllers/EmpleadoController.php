<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empleado;

class EmpleadoController extends Controller
{
    public function codigoEmpleado(){
        while($codigo = rand(999,9999)){
            $res=Empleado::codigoEmpleado($codigo);
            if(count($res)>0){
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

    public function agentesElastix($cartera){
        return Empleado::agentesElastix($cartera);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Plan;

class PlanController extends Controller
{
    public function listaPlanes(Request $rq){
        return Plan::listaPlanes($rq);
    }

    public function resumenPlan(Request $rq){
        return Plan::resumenPlan($rq);
    }

    public function insertarPlan(Request $rq){
        return Plan::insertarPlan($rq);
    }

    public function usuariosPlan($id){
        $clientes="";
        $cartera="";
        $res=Plan::datosPlan($id);
        if($res!=''){
            $clientes=$res[0]->clientes;
            $cartera=$res[0]->cartera;
        }
        return Plan::usuariosPlan($clientes,$cartera);
    }

    public function resultadosPlan(Request $rq){
        $idEmpleado=$rq->idEmpleado;
        $idPlan=$rq->idPlan;
        $clientes="";
        $cartera="";
        $fechaFin="";
        $fechaInicio="";
        $res=Plan::datosPlan($idPlan);
        if($res!=''){
            $clientes=$res[0]->clientes;
            $cartera=$res[0]->cartera;
            $fechaInicio=$res[0]->fechaInicio;
            $fechaFin=$res[0]->fechaFin;
        }
        return Plan::resultadoPlan($idEmpleado,$clientes,$cartera,$fechaInicio,$fechaFin);
    }
}

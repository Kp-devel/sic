<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Plan;
use App\Cartera;
use Carbon\Carbon;

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

    public function datosPlanUsuario(){
        return Plan::datosPlanUsuario();
    }

    public function reportePlan(){
        return Plan::reportePlan();
    }

    public function reporteListaPlan(Request $rq){
        return Plan::reporteListaPlan($rq);
    }

    public function reporteCumplimiento(Request $rq){
        $datos=array();
        $datosAgrupados=array();
        $dias=[];
        $fechaInicio = Carbon::parse($rq->fechaInicio);
        $fecha = Carbon::parse($rq->fechaInicio);
        $fechaFin = Carbon::parse($rq->fechaFin);
        $diasDiferencia = ($fechaFin->diffInDays($fechaInicio));
        $datosPlan=Plan::codigosCarteraPlan($rq);
        foreach ($datosPlan as $d) {
            $gestiones=Plan::reporteCantGestiones($d->id_cartera,$d->clientes,$d->fecha_i,$d->fecha_f);
            array_push($datos,["idCartera"=>$d->id_cartera,"cartera"=>$d->nombre_cartera,"cobertura"=>round(($gestiones[0]->gestionados/$d->cant_clientes)*100),"fecha"=>$d->fecha_i]);
        }
        $carteras=Cartera::listCarteras();
        
        for($i=0;$i<=$diasDiferencia;$i++){
            $fecha = Carbon::parse($rq->fechaInicio);
            if($i==0){
                $dias[0]=$fechaInicio;
            }else{
                $dias[$i]=$fecha->addDays($i);
            }
        }
        // foreach ($dias as $dia) {
        //     return $dia;
        // }
        return $dias;
    }
}

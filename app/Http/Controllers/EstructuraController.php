<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Estructura;

class EstructuraController extends Controller
{
    public function reporteEstructuraCartera(Request $rq){
        $ubicabilidad=$rq->ubicabilidad;
        if($ubicabilidad=='todos'){
            return Estructura::reporteEstructuraCarteraTodo($rq);
        }else{
            return Estructura::reporteEstructuraCarteraGestion($rq);
        }
    }

    public function listaGestores($cartera){
        return Estructura::listaGestores($cartera);
    }

    public  function reporteEstructuraGestor(Request $rq){
        return Estructura::estructuraGestor($rq);
    }

    public function reporteEstructuraGestorCartera(Request $rq){
        $ubicabilidad=$rq->ubicabilidad;
        if($ubicabilidad=='todos'){
            return Estructura::reporteEstructuraGestorCarteraTodo($rq);
        }else{
            return Estructura::reporteEstructuraGestorCarteraGestion($rq);
        }
    }

    public function reporteEstructuraGestionCartera(Request $rq){
        $tipo=$rq->tipo;
        if($tipo=='pagos'){
            return Estructura::reporteEstructuraCarteraPagos($rq);
        }else{
            return Estructura::reporteEstructuraGestionCartera($rq);
        }
    }
    


}

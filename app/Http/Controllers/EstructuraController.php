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
}

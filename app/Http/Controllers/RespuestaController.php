<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Respuesta;

class RespuestaController extends Controller
{
    public function listasPanelBusqueda(){
        $respuestas=Respuesta::listRespuestas();
        $motivonopago=Respuesta::listaMotivosNoPago();
        $entidades=Respuesta::listaEntidades();
        $score=Respuesta::listaScore();
        $oficinas=Respuesta::listaOficinas();
        $descuentos=Respuesta::listaDescuentos();
        $prioridad=Respuesta::listaPrioridad();
        return $opcionesBusqueda=[
            "respuestas"=>$respuestas,
            "motivonopago"=>$motivonopago,
            "entidades"=>$entidades,
            "score"=>$score,
            "oficinas"=>$oficinas,
            "descuentos"=>$descuentos,
            "prioridad"=>$prioridad
        ];
    }

    public function listRespuestas(){
        return Respuesta::listRespuestas();
    }

    public function listaMotivosNoPago(){
        return Respuesta::listaMotivosNoPago();
    }

    public function listaRespuestaUbicabilidad($ubic){
        return Respuesta::listaRespuestaUbicabilidad($ubic);
    }

    public function listaEntidades(){
        return Respuesta::listaEntidades();
    }

    public function listaScore(){
        return Respuesta::listaScore();
    }

    public function listaOficinas(){
        return Respuesta::listaOficinas();
    }
}

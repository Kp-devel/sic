<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Respuesta;
use App\Cartera;

class RespuestaController extends Controller
{
    public function listasPanelBusqueda(){
        $respuestas=Respuesta::listRespuestas();
        $motivonopago=Respuesta::listaMotivosNoPago();
        $oficinas=Respuesta::listaOficinas();
        $carteras=Cartera::listCarteras();
        // $entidades=Respuesta::listaEntidades();
        // $score=Respuesta::listaScore();
        // $descuentos=Respuesta::listaDescuentos();
        // $prioridad=Respuesta::listaPrioridad();
        return $opcionesBusqueda=[
            "respuestas"=>$respuestas,
            "motivonopago"=>$motivonopago,
            "oficinas"=>$oficinas,
            "carteras"=>$carteras
            // "entidades"=>$entidades,
            // "score"=>$score,
            // "descuentos"=>$descuentos,
            // "prioridad"=>$prioridad
        ];
    }

    public function listasBusquedaPorCartera($cartera){
        $entidades=Respuesta::listaEntidades($cartera);
        $score=Respuesta::listaScore($cartera);
        $descuentos=Respuesta::listaDescuentos($cartera);
        $prioridad=Respuesta::listaPrioridad($cartera);
        return $opcionesBusqueda=[
            "entidades"=>$entidades,
            "score"=>$score,
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

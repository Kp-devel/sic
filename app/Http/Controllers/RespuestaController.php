<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Respuesta;

class RespuestaController extends Controller
{
    public function listRespuestas(){
        return Respuesta::listRespuestas();
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

}

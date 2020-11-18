<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Respuesta;

class PredictivoController extends Controller
{
    public function condiciones($cartera){
        $entidades=Respuesta::listaEntidades($cartera);
        $score=Respuesta::listaScore($cartera);
        $prioridad=Respuesta::listaPrioridad($cartera);
        $tramos=Respuesta::listaTramo($cartera);
        $zonas=Respuesta::listaZona($cartera);
        return $datos=[
            "entidades"=>$entidades,
            "score"=>$score,
            "tramos"=>$tramos,
            "prioridades"=>$prioridad,
            "zonas"=>$zonas
        ];
    }
}

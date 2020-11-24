<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RepositorioExport;
use Illuminate\Http\Request;
use App\Predictivo;
use App\Respuesta;
use Carbon\Carbon;

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

    public function calcularCampana(Request $rq){
        return Predictivo::repositorio($rq,0,'');
    }

    public function crearCampana(Request $rq){
        $fecha=Carbon::now();
        Predictivo::crearCampana($rq,$fecha);
        $datos=Predictivo::IdCampana($rq,$fecha);
        Predictivo::repositorio($rq,1,$datos[0]->id);
        return $datos;
    }

    public function descargar($idCampana){
        return (new RepositorioExport($idCampana))->download('base_predictivo.csv');        
    }

    public function asignar($idcampana,$usuario){
        Predictivo::asignar($idcampana,$usuario);
        Predictivo::validacionAsignacion($idcampana,1);
        return "ok";
    }
    

    public function listaCampanas(Request $rq){
        return Predictivo::listaCampanas($rq);
    }

    public function devolverAsignacion(Request $rq){
        Predictivo::devolverAsignacion($rq);
        Predictivo::AsignarPdpsTT($rq);
        Predictivo::validacionAsignacion($rq->idCampana,0);
        return "ok";
    }

    public function eliminarCampana($idCampana){
        return Predictivo::eliminarCampana($idCampana);
    }
    
    public function datosGestiones($idCampana){
        return Predictivo::datosGestiones($idCampana);
    }

    public function generarGestiones($idCampana,$total){
        Predictivo::generarGestiones($idCampana);
        Predictivo::actualizarCantidad($idCampana,$total);
        return "ok";
    }

    public function actualizarFechaCampana(Request $rq){
        return Predictivo::actualizarFechaCampana($rq);
    }
    
}

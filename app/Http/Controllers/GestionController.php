<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gestion;
use App\Recordatorio;
use Carbon\Carbon;

class GestionController extends Controller
{

    public function insertarGestion(Request $rq){
        $detalle=$rq->detalle;
        $monto=$rq->montoPDP;
        $fechapc=$rq->fechaPDP;
        $tel=$rq->telefono;
        $resp=$rq->respuesta;
        $rec=$rq->rec;
        $fechaRec=$rq->fechaRec;
        $horaRec=$rq->horaRec;
        $id=$rq->id;
        $fechaGestion=Carbon::now();

        if($tel!="" && $detalle!="" && $resp!="" && $id!=""){
            if($resp==1 || $resp==2 || $resp==43){
                if($fechapc!="" && $monto!=""){
                    Gestion::insertarGestion($rq,$fechaGestion);
                    $idGestion=Gestion::selectIdGestion($fechaGestion,$id,$tel);
                    if($resp==1 || $resp==43){
                        Gestion::insertarPDP($rq,$fechaGestion,$idGestion[0]->id);
                    }
                    Gestion::updateUltGestion($id,$idGestion[0]->id);
                }
            }else{
                Gestion::insertarGestion($rq,$fechaGestion);
                $idGestion=Gestion::selectIdGestion($fechaGestion,$id,$tel);
                Gestion::updateUltGestion($id,$idGestion[0]->id);   
            }
                    
            if($rec==true && $fechaRec!="" && $horaRec!=""){
                Recordatorio::insertRecordatorio($rq);
            }
            return "ok";
        }
    }

    public function validarContacto($id){
        return Gestion::validarContacto($id);
    }

    public function validarPDP($id){
        return Gestion::validarPDP($id);
    }
}

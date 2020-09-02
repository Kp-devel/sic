<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Recordatorio;

class RecordatorioController extends Controller
{
    public function insertarRecordatorio(Request $rq){
        $rec=$rq->rec;
        $fechaRec=$rq->fechaRec;
        $horaRec=$rq->horaRec;
        $id=$rq->id;
        $tel=$rq->tel_rec;
        if($rec==true && $fechaRec!="" && $horaRec!="" && $tel!=""){
           Recordatorio::updateEstadoRecordatorio($id); 
           Recordatorio::insertRecordatorio($rq);
           return "ok";
        }
    }

    public function listarRecordatorio(){
        return Recordatorio::listarRecordatorio();
    }
}

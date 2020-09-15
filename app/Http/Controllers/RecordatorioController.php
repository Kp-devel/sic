<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Recordatorio;
use App\Telefono;
use App\Gestion;
use App\Events\WebsocketsRecordatorio;

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

    // public function listarRecordatorio(){
    //     return Recordatorio::listarRecordatorio();
    // }

    public function listarRecordatorio(){
        $datos=Recordatorio::listarRecordatorio();
        if(count($datos)>0){
            $telefonos=Telefono::infoTelefonos($datos[0]->id);
            $validacion_contacto=Gestion::validarContacto($datos[0]->id);
            $validacion_pdp=Gestion::validarPDP($datos[0]->id);

            $datosgenerales=['recordatorios'=>$datos,
                            'telefonos'=>$telefonos,
                            'validar_contacto'=>$validacion_contacto,
                            'pdps'=>$validacion_pdp
                            ];
            $success = event(new WebsocketsRecordatorio($datosgenerales));
            return $success;
        }
    }
}

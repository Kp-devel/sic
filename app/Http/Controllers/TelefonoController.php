<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Telefono;
use Carbon\Carbon;

class TelefonoController extends Controller
{
    public function listaTelefonos($id){
        if($id!='undefined'){
            return Telefono::infoTelefonos($id);
        }
    }

    public function insertarTelefonos(Request $rq){
        if($rq->telefono!=""){
            $fecha=Carbon::now();
            Telefono::insertarTelefonos($rq,$fecha);
            Telefono::insertarBitacoraTelefonos($rq,$fecha);
            return "ok";
        }
    }

    public function actualizarEstadoTelefono(Request $rq){
        return Telefono::actualizarEstadoTelefono($rq);
    }
    
}

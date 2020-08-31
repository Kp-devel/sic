<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Telefono;

class TelefonoController extends Controller
{
    public function listaTelefonos($id){
        return Telefono::infoTelefonos($id);
    }

    public function insertarTelefonos(Request $rq){
        if($rq->telefono!=""){
            return Telefono::insertarTelefonos($rq);
        }
    }

    public function actualizarEstadoTelefono(Request $rq){
        return Telefono::actualizarEstadoTelefono($rq);
    }
    
}

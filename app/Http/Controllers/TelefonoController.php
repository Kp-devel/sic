<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Telefono;

class TelefonoController extends Controller
{
    public function listaTelefonos(Request $rq){
        return Telefono::infoTelefonos($rq);
    }

    public function insertarTelefonos(Request $rq){
        return Telefono::insertarTelefonos($rq);
    }
}

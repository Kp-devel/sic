<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gestion;

class GestionController extends Controller
{
    public function listaRespuestas(Request $rq){
        return Gestion::listaRespuestas($rq);
    }

    public function insertarGestion(Request $rq){
        return Gestion::insertarGestion($rq);
    }
}

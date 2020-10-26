<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Incidencia;

class IncidenciaController extends Controller
{
    public function tiposIncidencias(){
        return Incidencia::tiposIncidencias();
    }

    public function insertIncidencia(Request $rq){
        return Incidencia::insertIncidencia($rq);
    }

    public function buscarIncidencias(Request $rq){
        return Incidencia::buscarIncidencias($rq);
    }
}

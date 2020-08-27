<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Respuesta;

class RespuestaController extends Controller
{
    public function listRespuestas(){
        return Respuesta::listRespuestas();
    }
}

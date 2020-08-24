<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;

class ClienteController extends Controller
{
    public function listaRespuestas(Request $rq){
        return cliente::listarRespuestas($rq);
    }
    public function listaClientes(Request $rq){
        return cliente::listarClientes($rq);
    }

    public function datosMes(Request $rq){
        return cliente::datosMes($rq);
    }

    public function datosEstandar(Request $rq){
        return cliente::datosEstandar($rq);
    }

    public function estadoCampana(Request $rq){
        return cliente::estadosCampana($rq);
    }
}

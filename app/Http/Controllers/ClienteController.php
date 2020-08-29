<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;

class ClienteController extends Controller
{
    public function listaClientes(Request $rq){
        return cliente::listarClientes($rq);
    }

    public function datosMes(){
        return cliente::datosMes();
    }

    public function datosEstandar(Request $rq){
        return cliente::datosEstandar($rq);
    }

    public function estadoCampana(Request $rq){
        return cliente::estadosCampana($rq);
    }

    public function infoCliente(Request $rq){
        return cliente::infoCliente($rq);
    }

    public function historicoGestiones(Request $rq){
        return cliente::historicoGestiones($rq);
    }

    public function infoDeuda(Request $rq){
        return cliente::infoDeuda($rq);
    }
}

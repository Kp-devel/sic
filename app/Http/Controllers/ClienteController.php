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

    public function infoCliente($id){
        return cliente::infoCliente($id);
    }

    public function historicoGestiones($id){
        return cliente::historicoGestiones($id);
    }

    public function infoDeuda($id){
        return cliente::infoDeuda($id);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;
use App\Telefono;

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

    // public function infoCliente($id){
    //     return cliente::infoCliente($id);
    // }

    public function historicoGestiones($id){
        return cliente::historicoGestiones($id);
    }

    // public function infoDeuda($id){
    //     return cliente::infoDeuda($id);
    // }

    public function detalleCliente($id){
        $infoCliente=cliente::infoCliente($id);
        $infoCuenta=cliente::infoDeuda($id);
        $historicoGestiones=cliente::historicoGestiones($id);
        $telefonos=Telefono::infoTelefonos($id);

        $datosgenerales=['infoCliente'=>$infoCliente,
                         'cuentas'=>$infoCuenta,
                         'gestiones'=>$historicoGestiones,
                         'telefonos'=>$telefonos
                        ];
        return $datosgenerales;                        
    }
}

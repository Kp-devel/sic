<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pago;

class PagoController extends Controller
{
    public function listaPagos(Request $rq){
        return Pago::infoPagos($rq);
    }
}

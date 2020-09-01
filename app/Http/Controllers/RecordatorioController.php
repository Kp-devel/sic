<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Recordatorio;

class RecordatorioController extends Controller
{
    public function listarRecordatorio(Request $rq){
        return Recordatorio::listarRecordatorio($rq);
    }

    public function insertarRecordatorio(Request $rq){
        return Recordatorio::insertarRecordatorio($rq);
    }
}

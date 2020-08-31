<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Recordatorio;

class RecordatorioController extends Controller
{
    public function insertarRecordatorio(Request $rq){
        return Recordatorio::insertRecordatorio($rq);
    }
}

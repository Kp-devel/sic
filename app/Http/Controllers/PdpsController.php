<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pdps;

class PdpsController extends Controller
{
    public function reporteEstadosPdps(Request $rq){
        return Pdps::reporteEstadosPdps($rq);
    }

    public function reporteEstandarPdps(Request $rq){
        return Pdps::reporteEstandarPdps($rq);
    }

    public function reportePdps(Request $rq){
        return Pdps::reportePdps($rq);
    }
}

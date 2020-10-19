<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reporte;

class ReporteController extends Controller
{
    public function asignacionCall(){
        return Reporte::asignacionCall();
    }

    public function reporteGeneralGestiones(Request $rq){
        return Reporte::reporteGeneralGestiones($rq);
    }
    
    public function reporteResumenGestor(Request $rq){
        return Reporte::reporteResumenGestor($rq);
    }

    public function descargarGestionesGestor(Request $rq){
        return Reporte::descargarGestionesGestor($rq);
    }

    public function primerayultimagestion(Request $rq){
        return Reporte::primerayultimagestion($rq);
    }

    public function cantGestioneHora($cartera){
        return Reporte::cantGestioneHora($cartera);
    }

}

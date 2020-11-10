<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reporte;
use App\Exports\GestionesExport;
use Maatwebsite\Excel\Facades\Excel;

class ReporteController extends Controller
{
    public function asignacionCall(){
        return Reporte::asignacionCall();
    }

    public function reporteGeneralGestiones($cartera,$fecInicio,$fecFin,$perfil){
        return (new GestionesExport($cartera,$fecInicio,$fecFin,$perfil))->download('reporte_general.xlsx');
        // return Excel::download(new GestionesExport, 'users.xlsx');
        //  return Reporte::reporteGeneralGestiones($rq);
    }

    // public function reporteGeneralGestiones(Request $rq){
    //     // return (new GestionesExport($rq))->download('reporte_general.xlsx');
    //     // return Excel::download(new GestionesExport, 'users.xlsx');
    //      return Reporte::reporteGeneralGestiones($rq);
    // }
    
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

    public function resumenGestionDia($cartera){
        $resumen=Reporte::resumenGestor($cartera);
        $gestiones=Reporte::resumenGestionesCartera($cartera);
        $datos=["resumen"=>$resumen,"gestiones"=>$gestiones];
        return $datos;
    }

    public function resumenGestionConsolidada($fecha){
        return Reporte::resumenGestionesCarteraConsolidado($fecha);
    }

    public function reportecomparativocartera(Request $rq){
        $comparativo=$rq->comparativo;
        $cartera=$rq->cartera;
        if($comparativo=='afecha'){
            if($cartera=='34' || $cartera=='88' || $cartera=='2' || $cartera=='89' || $cartera=='70' ||  $cartera=='20' || $cartera=='72' || $cartera=='5'){
                return Reporte::reporteComparativoCarteraPagos($rq);
            }else{
                return Reporte::reporteComparativoCarteraCon($rq);
            }
        }else{
            if($cartera=='34' || $cartera=='88' || $cartera=='2' || $cartera=='89' || $cartera=='70' ||  $cartera=='20' || $cartera=='72' || $cartera=='5'){
                return Reporte::reporteComparativoCarteraPagosCierre($rq);
            }else{
                return Reporte::reporteComparativoCarteraConCierre($rq);
            }
        }
    }
}

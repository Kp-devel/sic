<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cartera; 
use App\SmsCampana;

class SmsCampanaController extends Controller
{
    public function buscarCampana(Request $rq){
        return SmsCampana::buscarCampana($rq);
    }

    public function detalleCampana($id){
        return SmsCampana::detalleCampana($id);
    }

    public function condicionCampana($id){
        return SmsCampana::condicionCampana($id);
    }

    public function enviarCampana($id){
        return SmsCampana::enviarCampana($id);
    }   

    public function listCampanasDia(){
        return SmsCampana::listCampanasDia();
    }
}

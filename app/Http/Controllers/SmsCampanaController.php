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

    public function datosclientesCampana(Request $rq){
        return SmsCampana::datosclientesCampana($rq);
    }

    public function tagCondicion($cartera,$tipo){
        return SmsCampana::tagCondicion($cartera,$tipo);
    }

    public function insertCampana(Request $rq){
        return SmsCampana::insertCampana($rq);
    }
}

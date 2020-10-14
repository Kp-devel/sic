<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Plan;

class PlanController extends Controller
{
    public function listaPlanes(Request $rq){
        return Plan::listaPlanes($rq);
    }

    public function resumenPlan(Request $rq){
        return Plan::resumenPlan($rq);
    }

    public function insertarPlan(Request $rq){
        return Plan::insertarPlan($rq);
    }
}

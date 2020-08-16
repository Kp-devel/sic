<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empleado;

class EmpleadoController extends Controller
{
    public function agentesElastix($cartera){
        return Empleado::agentesElastix($cartera);
    }
}

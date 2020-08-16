<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Empleado extends Model
{
    public static function agentesElastix($cartera){
        return DB::connection('elastix')->select(DB::raw("
            SELECT 
                src_FK as extension,
                concat(codigo,' - ',nombre) as agente
            FROM agente 
            where cartera=:car
        "),array("car"=>$cartera));
    }

}

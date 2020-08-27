<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Respuesta extends Model
{
    protected $connection = 'mysql';
    
    public static function listRespuestas(){
        return DB::connection('mysql')->select(DB::raw("
            SELECT 
                res_id,res_des
            from 
                respuesta
            WHERE 
                res_est=0 and res_pas=0
            "));
    }
}

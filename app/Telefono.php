<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Telefono extends Model
{
    public static function infoTelefonos(Request $rq){
        $id=$rq->id;
        //$id=121049517;
        $sql="
            SELECT cli_tel_tel as telefono
            FROM
                cliente_telefono
            WHERE 
            cli_id_FK=$id
            AND cli_tel_est=0 AND cli_tel_pas=0
        ";
        $query=DB::connection('mysql')->select(DB::raw($sql));
        return $query;
    }

    public static function insertarTelefonos(Request $rq){
        
        $telefono=$rq->telefono;
        $fec_actual=date("Y-m-d H:i:00");
        //$id=$rq->id;
        $id=121049517;
        $insertado = DB::connection('mysql')->insert("
            insert into cliente_telefono (cli_id_FK,cli_tel_tel,cli_tel_est,cli_tel_pas,valor,fecha_add)
            values ($id,'$telefono',0,0,'','$fec_actual')
        ");

        return response()->json ($insertado);
    }
}

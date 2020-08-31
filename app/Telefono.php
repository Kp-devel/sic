<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Telefono extends Model
{
    public static function infoTelefonos($id){
        $sql="
            SELECT 
                cli_id_FK as id,
                cli_tel_tel as telefono,
                cli_tel_est as estado
            FROM
                cliente_telefono
            WHERE 
                cli_id_FK=:id
            AND cli_tel_est=0 AND cli_tel_pas=0
            order by fecha_add desc
        ";
        $query=DB::connection('mysql')->select(DB::raw($sql),array("id"=>$id));
        return $query;
    }

    public static function insertarTelefonos(Request $rq){
        $telefono=$rq->telefono;
        $id=$rq->id;
        //$id=121049517;
        $insertado = DB::connection('mysql')->insert("
            insert into cliente_telefono (cli_id_FK,cli_tel_tel,cli_tel_est,cli_tel_pas,valor,fecha_add)
            values (:id,:tel,0,0,'',date(now()))
        ",array("id"=>$id,"tel"=>$telefono));

        return "ok";
    }

    public static function actualizarEstadoTelefono(Request $rq){
        $telefono=$rq->telefono;
        $id=$rq->id;
        $estado=$rq->estado;
        $est=0;$pas=0;
        if($estado==1){
            $est=1;
            $pas=0;
        }
        if($estado==2){
            $est=0;
            $pas=1;
        }
        $insertado = DB::connection('mysql')->update("
            update cliente_telefono 
            set cli_tel_est=:est,
                cli_tel_pas=:pas
            where cli_id_FK=:id
            and cli_tel_tel=:tel
        ",array("id"=>$id,"tel"=>$telefono,"est"=>$est,"pas"=>$pas));

        return "ok";
    }
    
}

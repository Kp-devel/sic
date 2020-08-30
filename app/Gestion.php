<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Gestion extends Model
{
    public static function listaRespuestas(Request $rq){
        $id=$rq->id;

        $sql="
            select 
                res_id as id,
                res_des as respuesta
            from respuesta
            WHERE 
                res_ubi=$id 
                and res_est=0 
                and res_pas=0
        ";

        $query=DB::connection('mysql')->select(DB::raw($sql));
        return $query;
    }
    
    public static function insertarGestion(Request $rq){
        
        $resId=$rq->resId;
        $fechaPDP='0000-00-00';
        $montoPDP=0;
        $fechaConf='0000-00-00';
        $montoConf=0;

        if($resId==1 || $resId==43 ){
            $fechaPDP=$rq->fechaPDP;
            $montoPDP=$rq->montoPDP;
        }else{
            $fechaConf=$rq->fechaPDP;
            $montoConf=$rq->montoPDP;
        }
        
        $telefono=$rq->telefono;
        $detalle=$rq->detalle;
        $moneda=$rq->moneda;

        $fechaGestion=date("Y-m-d H:i:s");
        $id=$rq->id;
        //$id=121049517;
        $emp_id_FK=4090;
        $insertado = DB::connection('mysql')->insert("
            insert into gestion_cliente (cli_id_FK,emp_id_FK,ges_cli_acc,res_id_FK,
            ges_cli_fec,ges_cli_med,ges_cli_det,ges_cli_com_fec,ges_cli_com_can,
            ges_cli_com_mon,ges_cli_ret,ges_cli_est,ges_cli_pas,ges_cli_conf_can,
            ges_cli_conf_fec,ges_cli_fec_visit)
            values ($id,$emp_id_FK,2,$resId,'$fechaGestion','$telefono','$detalle',
            '$fechaPDP',$montoPDP,$moneda,0,0,0,$montoConf,$fechaConf,'')
        ");

        return response()->json ($insertado);
    }
}

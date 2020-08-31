<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Gestion extends Model
{
    
    public static function insertarGestion(Request $rq,$fechaGestion){
        $detalle=$rq->detalle;
        $monto=isset($rq->montoPDP)?$rq->montoPDP:'';
        $fechapc=isset($rq->fechaPDP)?$rq->fechaPDP:'';
        $moneda=$rq->moneda;
        $tel=$rq->telefono;
        $resp=$rq->respuesta;
        $id=$rq->id;
        $idEmpleado=auth()->user()->emp_id;

        $fechaPDP='0000-00-00';
        $montoPDP=0;
        $fechaConf='0000-00-00';
        $montoConf=0;

        if($resp==1 || $resp==43 ){
            $fechaPDP=$fechapc;
            $montoPDP=$monto;
        }
        if($resp==2){
            $fechaConf=$fechapc;
            $montoConf=$monto;
        }
        
        DB::connection('mysql')->insert("
            insert into gestion_cliente (
                cli_id_FK,emp_id_FK,ges_cli_acc,res_id_FK,ges_cli_fec,ges_cli_med,
                ges_cli_det,ges_cli_com_fec,ges_cli_com_can,ges_cli_com_mon,ges_cli_ret,
                ges_cli_est,ges_cli_pas,ges_cli_conf_can,ges_cli_conf_fec,ges_cli_fec_visit)
            values (:id,:idEmp,2,:res,:fecGes,:tel,:det,:fecpdp,:monpdp,:monedapdp,0,0,0,:monconf,:fecconf,'0000-00-00')
        ",array("id"=>$id,"idEmp"=>$idEmpleado,"res"=>$resp,"fecGes"=>$fechaGestion,"tel"=>$tel,
                "det"=>$detalle,"fecpdp"=>$fechaPDP,"monpdp"=>$montoPDP,"monedapdp"=>$moneda,"monconf"=>$montoConf,"fecconf"=>$fechaConf));

        return "ok";
    }

    public static function insertarPDP(Request $rq,$fechaGestion,$idGestion){
        $monto=$rq->montoPDP;
        $fechapc=$rq->fechaPDP;
        $moneda=$rq->moneda;
        $id=$rq->id;
        $idEmpleado=auth()->user()->emp_id;
        
        DB::connection('mysql')->insert("
            insert into  compromiso_cliente(
                cli_id_FK,emp_id_FK,ges_cli_id_FK,com_cli_fec,com_cli_fec_pag,com_cli_can,
                com_cli_mon,com_cli_est,com_cli_pas)
            values (:id,:idEmp,:idGes,:fecGes,:fecpdp,:monto,:moneda,0,0)
        ",array("id"=>$id,"idEmp"=>$idEmpleado,"idGes"=>$idGestion,"fecGes"=>$fechaGestion,"fecpdp"=>$fechapc,"monto"=>$monto,"moneda"=>$moneda));
            
        return "ok";
    }

    public static function selectIdGestion($fechaGestion,$id,$tel){
        $idEmpleado=auth()->user()->emp_id;
        return DB::select(DB::raw("
            select ges_cli_id as id
            from gestion_cliente
            where ges_cli_fec=:fec
            and cli_id_FK=:id
            and emp_id_FK=:idEmp
            and ges_cli_med=:tel
        "),array("fec"=>$fechaGestion,"id"=>$id,"idEmp"=>$idEmpleado,"tel"=>$tel));
    }

    public static function updateUltGestion($id,$idGestion){
        DB::update("
            update cliente
            set ges_cli_tel_id_FK=:idGes
            where cli_id=:id
        ",array("id"=>$id,"idGes"=>$idGestion));
        return "ok";
    }
}

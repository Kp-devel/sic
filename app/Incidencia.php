<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Incidencia extends Model
{
    public static function tiposIncidencias(){
        return DB::connection('mysql')->select(DB::raw("
                    SELECT
                        tip_inc_id as id,
                        tip_inc_des as incidencia
                    FROM
                        db_incidencias.tipo_incidencia
                    WHERE
                        tip_inc_est = 0
        "));
    }

    public static function insertIncidencia(Request $rq){
        $gestor=$rq->gestor;
        $incidencia=$rq->incidencia;
        $detalle=$rq->detalle;
        $fecha=isset($rq->fecha)?$rq->fecha:'0000-00-00';
        $usuario=auth()->user()->emp_nom;
        $codigo=auth()->user()->emp_cod;
        $tipoUsuario=session()->get('datos')->perfil;
        DB::connection('mysql')->insert("
                INSERT INTO db_incidencias.incidencia 
                (inc_gestor,inc_usuario,inc_tipo_usuario,tip_inc_id_FK,inc_detalle,inc_fecha,inc_codigo,fecha_add,inc_est)
                VALUES (:gestor,:usu,:tipusu,:inc,:det,:fec,:cod,now(),0)              
        ",array('gestor'=>$gestor,"usu"=>$usuario,"tipusu"=>$tipoUsuario,"inc"=>$incidencia,"det"=>$detalle,"fec"=>$fecha,"cod"=>$codigo));
        return "ok";
    }

    public static function buscarIncidencias(Request $rq){
        $incidencia=$rq->incidencia;
        $fecha=$rq->fecha;
        $codigo=auth()->user()->emp_cod;
        $tipoacceso=auth()->user()->emp_tip_acc;
        $sql="";
        if($tipoacceso!=7){
            $sql.=" and inc_codigo=$codigo ";
        }
        if($fecha!=''){
            $sql.=" and (case when tip_inc_id_FK=4 then date(inc_fecha)='$fecha'
                         ELSE date(fecha_add)='$fecha'
                    END)";
        }
        if($incidencia!=''){
            $sql.=" and tip_inc_id_FK=$incidencia ";
        }
        return DB::connection('mysql')->select(DB::raw("
                    SELECT
                        inc_gestor as gestor,
                        inc_usuario as usuario,
                        inc_tipo_usuario as tipo_usuario,
                        tip_inc_des as incidencia,
                        tip_inc_id_FK as idIncidencia,
                        inc_detalle as detalle,
                        inc_fecha as fecha_permiso,
                        fecha_add,
                        if(tip_inc_id_FK=4,date(inc_fecha),fecha_add) as fecha
                    FROM
                        db_incidencias.incidencia i 
                    INNER JOIN db_incidencias.tipo_incidencia t on i.tip_inc_id_FK=t.tip_inc_id
                    WHERE
                        inc_est=0
                    $sql
        "));
    }
    
}

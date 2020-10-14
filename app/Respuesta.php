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
                and res_id not in (46,39,10,8,7,13)
                and res_acc like('%2%')
            order by res_des 
            "));
    }

    public static function listaRespuestaUbicabilidad($ubic){
        $sql="
            select 
                res_id as id,
                res_des as respuesta
            from respuesta
            WHERE 
                res_ubi=:ubi
                and res_est=0 
                and res_pas=0
                and res_id not in (46,39,10,8,7,13)
                and res_acc like('%2%')
            order by res_des 
        ";

        $query=DB::connection('mysql')->select(DB::raw($sql),array("ubi"=>$ubic));
        return $query;
    }

    public static function listaMotivosNoPago(){
        return DB::connection('mysql')->select(DB::raw("
            SELECT 
                mot_id as id,
                mot_res as motivo
            from 
                motivo_nopago
            WHERE 
                mot_est=0
            "));
    }

    public static function listaEntidades($cartera){
        // $cartera=session()->get('datos')->idcartera;
        $sql="
            SELECT
                tag_valor as id,
                tag_valor as valor
            FROM
                creditoy_lotesms.tag_condicion
            WHERE 
                car_id_FK in (:car)
            and tag_tipo='entidades'
            and tag_est=0
            group by tag_valor
        ";
        $query=DB::connection('mysql')->select(DB::raw($sql),array("car"=>$cartera));
        return $query;
    }

    public static function listaScore($cartera){
        // $cartera=session()->get('datos')->idcartera;
        $sql="
            SELECT
                tag_valor as id,
                tag_valor as valor
            FROM
                creditoy_lotesms.tag_condicion
            WHERE 
                car_id_FK in (:car)
            and tag_tipo='score'
            and tag_est=0
            group by tag_valor
        ";
        $query=DB::connection('mysql')->select(DB::raw($sql),array("car"=>$cartera));
        return $query;
    }

    public static function listaOficinas(){
        $sql="
            SELECT 
                loc_id as idoficina,
                concat(loc_cod,'-',loc_nom)  as local
            FROM local 
            WHERE 
                loc_pas<>1 
            AND loc_est<>1 
            ORDER BY loc_nom ASC 
        ";
        $query=DB::connection('mysql')->select(DB::raw($sql));
        return $query;
    }

    public static function listaDescuentos($cartera){
        // $cartera=session()->get('datos')->idcartera;
        $sql="
            SELECT
                tag_valor as valor
            FROM
                creditoy_lotesms.tag_condicion
            WHERE 
                car_id_FK in (:car)
            and tag_tipo='descuento'
            and tag_est=0
            group by tag_valor
        ";
        $query=DB::connection('mysql')->select(DB::raw($sql),array("car"=>$cartera));
        return $query;
    }

    public static function listaPrioridad($cartera){
        // $cartera=session()->get('datos')->idcartera;
        $sql="
            SELECT
                tag_valor as valor
            FROM
                creditoy_lotesms.tag_condicion
            WHERE 
                car_id_FK in (:car)
            and tag_tipo='prioridad'
            and tag_est=0
            group by tag_valor
        ";
        $query=DB::connection('mysql')->select(DB::raw($sql),array("car"=>$cartera));
        return $query;
    }

    public static function listaRespuestaUbicSms($ubic){
        $sql="
            select 
                res_id as id,
                res_des as respuesta
            from respuesta
            WHERE 
                res_ubi=:ubi
                and res_est=0 
                and res_pas=0
                and res_id NOT IN (1, 43, 2, 6,	12,	13,	19,	22,	27,	28,	37,	38,	41,	46)
                and res_acc like('%2%')
            order by res_des 
        ";

        $query=DB::connection('mysql')->select(DB::raw($sql),array("ubi"=>$ubic));
        return $query;
    }
    
}

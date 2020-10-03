<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SmsCampana extends Model
{
    public static function buscarCampana(Request $rq){
        $fecha=$rq->fecha_programada;
        $cartera=$rq->cartera;
        return DB::connection('mysql')->select(DB::raw(
            "SELECT
                camp_id as id,
                camp_nom as nombre,
                camp_fec_prog as fecha,
                car_nom as cartera,
                format(camp_cant_sms,0) as cant_sms,
                format(camp_cant_cli,0) as cant_cli,
                fecha_create,
                if(date(camp_fec_prog)=date(now()),0,1) as enviar
            FROM
                creditoy_lotesms.campana c
            INNER JOIN creditoy_cobranzas.cartera cc on c.car_id_FK=cc.car_id
            WHERE 
                case when :cart is null then car_id_FK=car_id_FK
                    else car_id_FK=:car
                end
            and date(camp_fec_prog)=:fec
            and car_est=0 and car_pas=0
            and camp_est=0
            ORDER BY camp_id DESC
        "),array("car"=>$cartera,"fec"=>$fecha,"cart"=>$cartera));
    }

    public static function detalleCampana($id){
        return DB::connection('mysql')->select(DB::raw(
            "SELECT
                camp_nom as nombre,
                camp_fec_prog as fecha_prog,
                fecha_create,
                car_nom as cartera,
                format(camp_cant_sms,0) as cant_sms,
                format(camp_cant_cli,0) as cant_cli
            FROM
                creditoy_lotesms.campana c
            INNER JOIN creditoy_cobranzas.cartera cc on c.car_id_FK=cc.car_id
            WHERE car_est=0 and car_pas=0
            and camp_id=:id
        "),array("id"=>$id));
    }

    public static function condicionCampana($id){
        return DB::connection('mysql')->select(DB::raw("
            SELECT
                s.spc_nom as nomSpc,
                spc_des as sms,
                con_nom as nomCond,
                con_des as descripcion,
                con_cli as cantcli,
                con_sms as cantsms,
                case when con_destino=1 then 'Todos los clientes'
                     when con_destino=2 then 'Clientes nuevos'
                     when con_destino=3 then 'Clientes sin gestión en el mes'
                end as destino,
                case when con_opcion_num=1 then 'Número última gestión'
                     when con_opcion_num=2 then 'Todos los números'
                end as numero
            FROM
                creditoy_lotesms.condicion c
            INNER JOIN creditoy_lotesms.speech s ON c.spc_id_FK=s.spc_id
            WHERE
                con_est = 0
            AND camp_id_FK = :id
        "),array("id"=>$id));
    }

    public static function enviarCampana($id){
        $IDMAX=DB::connection('mysql')->select(DB::raw("SELECT MAX(camp_id) as idmax FROM creditoy_sms.campana"));
        if(count($IDMAX)){
            $res=DB::connection('mysql')->select(DB::raw("call creditoy_lotesms.CARGA(:id);"),array("id"=>$id));
            if(count($res)>0){
                $sqlCampana="INSERT INTO creditoy_sms.campana (camp_id,camp_nom,camp_fec_reg,camp_est,lote_id_FK,lote_canal) VALUES (".($IDMAX[0]->idmax+1).",".$res[0]->campana_nombres.")";
                DB::connection('mysql')->insert($sqlCampana);
                for($i=0;$i<count($res);$i++){
                    $sqlRepositorio=$res[$i]->sql_query."".($IDMAX[0]->idmax+1).")";   
                    DB::insert($sqlRepositorio);
                }
                return "ok";
            }
        }
    }

    public static function listCampanasDia(){
        $usuario=auth()->user()->emp_cod;
        $rol=DB::connection('mysql')->select(DB::raw("select rol_id_FK as rol from creditoy_lotesms.usuario where usuario=:usu limit 1"),array("usu"=>$usuario));
        
        return DB::connection('mysql')->select(DB::raw("
            call creditoy_lotesms.MONITOREO(:rol,:usu);
        "),array("rol"=>$rol[0]->rol,"usu"=>$usuario));
    }

}

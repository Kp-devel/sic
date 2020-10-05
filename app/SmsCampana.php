<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SmsCampana extends Model
{
    public static function buscarCampana(Request $rq){
        $fecha=$rq->fecha_programada;
        $cartera=$rq->cartera;
        $usuario=auth()->user()->emp_cod;
        $rol=DB::connection('mysql')->select(DB::raw("select rol_id_FK as rol from creditoy_lotesms.usuario where usuario=:usu limit 1"),array("usu"=>$usuario));
        $sql="";

        if($rol==1){
            $sql.="case when :cart is null then car_id_FK=car_id_FK
                        else car_id_FK=:car
                    end";
        }else{
            $sql.="case when :cart is null then car_id_FK IN (SELECT car_id_Fk FROM creditoy_lotesms.empleado where usu_FK=$usuario)
                        else car_id_FK=:car
                    end";
        }
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
                $sql
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
                    DB::connection('mysql')->insert($sqlRepositorio);
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

    public static function datosclientesCampana(Request $rq){
        $condiciones=$rq->condiciones;
        $cartera=$rq->cartera;
        $opcion=$rq->opcion;
        $destinatario=$rq->destinatario;
        
        if($opcion==1){
            return DB::connection('mysql')->select(DB::raw("
                    CALL creditoy_lotesms.SMS('',:car,:cond,:dest,'',0)
            "),array("car"=>$cartera,"cond"=>$condiciones,"dest"=>$destinatario));
        }else{
            return DB::connection('mysql')->select(DB::raw("
                    CALL creditoy_lotesms.SMS_TLN('',:car,:cond,:dest,'',0)
            "),array("car"=>$cartera,"cond"=>$condiciones,"dest"=>$destinatario));
        }
    }



    public static function tagCondicion($cartera,$tipo){   
        return DB::connection('mysql')->select(DB::raw(
            "SELECT
                case WHEN tag_tipo='tramo' THEN
                    case when car_id_FK in (2,34,88,89,5) THEN SUBSTR(tag_valor,LOCATE('.',tag_valor)+2,LENGTH(tag_valor))
                    ELSE tag_valor
                    END 
                ELSE tag_valor
                END as val,	
                tag_valor as valor
            FROM
                creditoy_lotesms.tag_condicion
            WHERE 
                tag_est=0
            AND tag_tipo=:tipo
            AND car_id_FK=:car
        "
        ),array("car"=>$cartera,"tipo"=>$tipo));
    }

    public static function insertCampana(Request $rq){
        $nomCampana=$rq->nombre;
        $cartera=$rq->cartera;
        $totalClientes=$rq->totalClientes;
        $totalSms=$rq->totalSms;
        $fechaProg=$rq->fecha;
        $fecha=Carbon::now();

        DB::connection('mysql')->insert("
            insert into creditoy_lotesms.campana (camp_nom,car_id_FK,camp_fec_prog,camp_cant_cli,camp_cant_sms,est_id_Fk,est_id_Fk_claro,camp_ord,camp_est,fecha_create)
            values (:nom,:car,:fecha_pro,:cli,:sms,0,0,0,0,:fecha)
        ",array("nom"=>$nomCampana,"car"=>$cartera,"fecha_pro"=>$fechaProg,"cli"=>$totalClientes,"sms"=>$totalSms,"fecha"=>$fecha));

        $idCamp=DB::connection('mysql')->select(DB::raw("
                select 
                    camp_id as id 
                from 
                    creditoy_lotesms.campana 
                where 
                    fecha_create=:fecha    
                and car_id_FK=:car
                and camp_nom=:nom 
                and camp_cant_cli=:cli
                and camp_cant_sms=:sms
        "),array("nom"=>$nomCampana,"car"=>$cartera,"cli"=>$totalClientes,"sms"=>$totalSms,"fecha"=>$fecha));

        DB::connection('mysql')->update("UPDATE creditoy_lotesms.campana c
                    INNER JOIN creditoy_lotesms.orden_envio o ON c.car_id_FK=o.car_id_FK
                    SET camp_ord=ord_num
                    WHERE date(camp_fec_prog)>date(now())
                    and camp_id=:id
                ",array("id"=>$idCamp[0]->id));

        $detalle=$rq->detalle;
        
        for($i=0;$i<count($detalle);$i++){
  
            $nomCond=$detalle[$i]['nombre'];
            $idspeech=$detalle[$i]['idSpeech'];
            $descripcion=$detalle[$i]['textcondicion'];
            $sql=$detalle[$i]['baseCondicion'];
            $tipoNum=$detalle[$i]['codNumeros'];
            $cantCli=$detalle[$i]['cantClientes'];
            $cantSms=$detalle[$i]['cantSms'];
            $destino=$detalle[$i]['idDestino'];

            DB::connection('mysql')->insert("
                insert into creditoy_lotesms.condicion (con_nom,camp_id_FK,spc_id_FK,con_des,con_sql,con_destino,con_opcion_num,con_cli,con_sms,con_est,fecha_create)
                values (:nom,:idcamp,:idsp,:desc,:sql,:dest,:num,:cli,:sms,0,:fecha)
            ",array("nom"=>strval($nomCond),"idcamp"=>$idCamp[0]->id,"idsp"=>$idspeech,"num"=>$tipoNum,"desc"=>$descripcion,"sql"=>$sql,"dest"=>$destino,"cli"=>$cantCli,"sms"=>$cantSms,"fecha"=>$fecha));
        }
        

        return "ok";
    }
}

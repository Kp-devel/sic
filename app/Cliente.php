<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Cliente extends Model
{
    protected $connection = 'mysql';

    public static function listarRespuestas(Request $rq){
        return DB::connection('mysql')->select(DB::raw("
            SELECT 
                * 
            from 
                respuesta
            WHERE 
                res_est=0 and res_pas=0
            "));
    }
    public static function listarClientes(Request $rq){
        $codigo=$rq->codigo;
        $dni=$rq->dni;
        $nombre=$rq->nombre;
        $telefono=$rq->telefono;
        $tramo=$rq->tramo;
        $respuesta=$rq->respuesta;
        $fec_desde=$rq->fec_desde;
        $fec_hasta=$rq->fec_hasta;
        $ordenar=$rq->ordenar;
        $camp=$rq->camp;
        //dd($camp);

        
        
        if($camp!= "null"){

            $sql_cartera="
                select car_id_FK as idcartera from cliente where cli_est=0 and cli_pas=0 and emp_tel_id_FK=2531 LIMIT 1
            ";
            $query_cartera=DB::connection('mysql')->select(DB::raw($sql_cartera));
            foreach($query_cartera as $q){
                $car_id=$q->idcartera;
            }
            $cartera=$car_id;
            $fec_actual=date("Y-m-d H:i:00");
            //fecha_i <= '2020-07-25 16:04:18' and fecha_f >= '2020-07-25 16:50:51'
            //$fec_actual='2020-07-25 16:04:18';
        
            $sql_campana = " select clientes,fecha_i,fecha_f from indicadores.campana
                        WHERE id_cartera=$cartera and fecha_i <= '$fec_actual' and fecha_f >= '$fec_actual' 
                        LIMIT 1";
            
            $query_campana=DB::connection('mysql')->select(DB::raw($sql_campana));
            //dd($query_campana);
            if($query_campana!=[]){
                foreach($query_campana as $q){
                    $cadena = $q->clientes;
                }
                $cadena_cli=$cadena;
                $array=explode(',',$cadena_cli);
                $cantidad_cli=count($array);
            }else{
                $cantidad_cli=0;
            }

        }else{
            $cantidad_cli=0;
        }

        $sql="
            SELECT 
                cli_cod as codigo,
                cli_nom as nombre,
                cli_num_doc as dni,
                det_cli_deu_cap as capital,
                det_cli_deu_mor as deuda,
                det_cli_imp_can as importe,
                det_cli_pro as producto,
                if(ges_cli_med is null,'-',ges_cli_med) as telefono,
                if(res_id_FK is null,'Sin Gestión',res_des) as ult_resp
            FROM 
                cliente as c
            inner JOIN detalle_cliente dc ON c.cli_id = dc.cli_id_FK
            left JOIN gestion_cliente g ON c.ges_cli_tel_id_FK=g.ges_cli_id
            left JOIN respuesta as r on r.res_id=g.res_id_FK
            where 
                cli_est=0 and cli_pas=0 
                and det_cli_est=0 and det_cli_pas=0
                and emp_tel_id_FK=2531
                and det_cli_deu_mor = (SELECT MAX(det_cli_deu_mor) FROM detalle_cliente WHERE det_cli_est = 0 AND det_cli_pas = 0 AND cli_id_FK = c.cli_id)
                    
        ";
        if($codigo!= "null"){
            $sql = $sql." and cli_cod=$codigo ";
        }
        if($dni!= "null"){
            $sql = $sql." and cli_num_doc=$dni ";
        }
        if($nombre!= "null"){
            $sql = $sql." and cli_nom like '%$nombre%' ";
        }
        if($telefono!= "null"){
            $sql = $sql." and cli_tel_tel=$telefono ";
        }
        if($tramo!= "null"){
            $sql = $sql." and det_cli_tra like '%$tramo%' ";
        }
        if($respuesta!= "null"){
            $sql = $sql." and res_id_FK=$respuesta ";
        }
        if($fec_desde!= "undefined-undefined-"){
            $sql = $sql." and date_format(ges_cli_com_fec,'%Y-%m-%d') >='$fec_desde' ";
        }
        if($fec_hasta!= "undefined-undefined-"){
            $sql = $sql." and date_format(ges_cli_com_fec,'%Y-%m-%d') <='$fec_hasta' ";
        }
 
        if( $cantidad_cli>0){
            $sql = $sql." and cli_cod in ($cadena_cli) and emp_tel_id_FK=2531 ";
        }

        $sql= $sql." GROUP BY cli_id";

        if($ordenar!= "null"){
            if($ordenar=='1'){
                $sql = $sql." order by det_cli_deu_cap desc ";
            }
            if($ordenar=='2'){
                $sql = $sql." order by det_cli_deu_mor desc ";
            }
            if($ordenar=='3'){
                $sql = $sql." order by det_cli_imp_can desc ";
            }
        }else{
                $sql = $sql." order by det_cli_deu_mor desc ";
        }

        $query=DB::connection('mysql')->select(DB::raw($sql));
        return $query;
    }

    public static function datosMes(Request $rq){

        $sql_cartera="
            select car_id_FK as idcartera from cliente where cli_est=0 and cli_pas=0 and emp_tel_id_FK=2531 LIMIT 1
        ";
        $query_cartera=DB::connection('mysql')->select(DB::raw($sql_cartera));
        foreach($query_cartera as $q){
            $car_id=$q->idcartera;
        }
        $cartera=$car_id;

        if($cartera=='34' || $cartera=='88' || $cartera=='2' || $cartera=='89' || $cartera=='88' ||
        $cartera=='70' || $cartera=='20' || $cartera=='72' || $cartera=='5'){
            $sql_metas="
            SELECT  if(meta is null,0,meta) as meta,  recupero, if((recupero/meta)>0,format((recupero/meta)*100,2),0) as alcance, DATE_FORMAT(fecha,'%d') as fecha
            FROM
            (
                select 
                  if(sum(pag_cli_mon)>0,sum(pag_cli_mon),0) as recupero,emp_meta as meta, max(pag_cli_fec) as fecha
                from pago_cliente_2 as p
                inner join 
                    cliente as c on p.pag_cli_cod=c.cli_cod
                inner join 
                    empleado as e on c.emp_tel_id_FK=e.emp_id
                where 
                    cli_est=0 and cli_pas=0
                    and emp_cod=4090					
                    and date_format(pag_cli_fec,'%Y-%m') = date_format(now(),'%Y-%m')
            ) a
            ";
        }else{
            $sql_metas="
            SELECT  if(meta is null,0,meta) as meta,  recupero, if((recupero/meta)>0,format((recupero/meta)*100,2),0) as alcance, DATE_FORMAT(fecha,'%d') as fecha
            FROM
            (
                select  
                    if(sum(ges_cli_conf_can)>0,sum(ges_cli_conf_can),0) as recupero,
                    emp_meta as meta,max(ges_cli_conf_fec) as fecha
                from 
                    gestion_cliente as g
                INNER JOIN 
                    cliente as c on g.cli_id_FK=c.cli_id
                inner join 
                    empleado as e on c.emp_tel_id_FK=e.emp_id
                where 
                    cli_est=0 and cli_pas=0
                    and emp_cod=4090
                and date_format(ges_cli_conf_fec,'%Y-%m') = date_format(now(),'%Y-%m')
                and res_id_fk=2
            ) a
            ";
        }

        $sql_datos="
            SELECT 
                CARTERA,
                USUARIO,
                SUM(MONTO_CAIDO) AS caido,
                SUM(MONTO_CUMPLIDO) AS cumplido,
                SUM(MONTO_PENDIENTE) AS pendiente,
                SUM(MONTO) AS total
            FROM 
            (SELECT 
                CARTERA,
                USUARIO,
                SUBSTR(USUARIO,1,4) AS COD,
                CASE WHEN ESTADO='CAIDO' THEN MONTO
                END AS MONTO_CAIDO,
                CASE WHEN ESTADO='P' THEN MONTO 
                END AS MONTO_PENDIENTE,
                CASE WHEN ESTADO='CUM' THEN MONTO 
                END AS MONTO_CUMPLIDO,
                MONTO
            FROM 
            (SELECT
            CAR.car_id AS CARTERA,
            CONCAT(E2.emp_cod,'-',E2.emp_nom) as USUARIO,
            COMCLI.com_cli_can AS MONTO,
            CASE WHEN COMCLI.com_cli_est<>0 THEN 'CUM'
            WHEN DATEDIFF(DATE_FORMAT(now(),'%Y-%m-%d'),DATE_FORMAT(COMCLI.com_cli_fec_pag,'%Y-%m-%d'))<=0 THEN 'P'
            WHEN DATEDIFF(DATE_FORMAT(now(),'%Y-%m-%d'),DATE_FORMAT(COMCLI.com_cli_fec_pag,'%Y-%m-%d'))>0 THEN 'CAIDO'
            ELSE '' END AS ESTADO
            FROM
            (
            SELECT MAX(CC.com_cli_id) AS com_cli_id, C.cli_id, C.cli_cod, C.cli_nom, C.car_id_FK, C.loc_id_FK, C.emp_tel_id_FK, C.emp_dom_id_FK
            FROM (SELECT cli_id, cli_cod, cli_nom, car_id_FK, loc_id_FK, emp_tel_id_FK, emp_dom_id_FK FROM cliente WHERE cli_est=0 AND cli_pas=0) C
            INNER JOIN compromiso_cliente CC ON C.cli_id=CC.cli_id_FK
            INNER JOIN gestion_cliente g ON CC.ges_cli_id_FK=g.ges_cli_id
            WHERE DATE_FORMAT(CC.com_cli_fec_pag,'%Y-%m')=DATE_FORMAT(now(),'%Y-%m')
            AND ges_cli_acc IN (1,2)
            GROUP BY C.cli_id
            ) T1  
            LEFT JOIN compromiso_cliente COMCLI ON T1.com_cli_id=COMCLI.com_cli_id
            LEFT JOIN empleado E2 ON T1.emp_tel_id_FK=E2.emp_id
            LEFT JOIN cartera CAR ON T1.car_id_FK=CAR.car_id
            WHERE CAR.car_est=0 AND CAR.car_pas=0
            AND E2.emp_cod IN (4090) 
            )X
            )K
            GROUP BY USUARIO
            ORDER BY CARTERA, COD
        ";

        $sql_pdp="
            SELECT if(SUM(ges_cli_com_can)>0,SUM(ges_cli_com_can),0) as monto_pdp
            from gestion_cliente as gc
            INNER JOIN cliente as c on gc.cli_id_FK=c.cli_id
            INNER JOIN empleado as e on c.emp_tel_id_FK=e.emp_id
            WHERE emp_cod=7696 AND cli_est=0 and cli_pas=0
            and DATE_FORMAT(ges_cli_fec,'%Y-%m')=DATE_FORMAT(NOW(),'%Y-%m')
        ";

        $sql_pagos="
            select if(SUM(pag_cli_mon)>0,SUM(pag_cli_mon),0) monto_pago
            from pago_cliente_2 as p
            INNER JOIN cliente as c on p.pag_cli_cod=c.cli_cod
            INNER JOIN empleado as e on c.emp_tel_id_FK=e.emp_id
            WHERE emp_cod=7696 AND cli_est=0 and cli_pas=0
            and DATE_FORMAT(pag_cli_fec,'%Y-%m')=DATE_FORMAT(NOW(),'%Y-%m')
        ";

        $metas=DB::connection('mysql')->select(DB::raw($sql_metas));
        $datos=DB::connection('mysql')->select(DB::raw($sql_datos));
        $pdp=DB::connection('mysql')->select(DB::raw($sql_pdp));
        $pagos=DB::connection('mysql')->select(DB::raw($sql_pagos));
        

        return response()->json(['metas' => $metas, 'datos' => $datos, 'pdp' => $pdp , 'pagos' => $pagos]);
        //return $query;
    }

    public static function datosEstandar(Request $rq){
        $firma=$rq->firma;
        $sql="
            SELECT 
                count(cli_id_FK) as gestiones,
                sum(contacto) as contactos,
                format((sum(contacto)/count(cli_id_FK))*100,0) as contactabilidad, 
                sum(pdp) as pdps,
                sum(monto_pdp) as monto_pdps,
                sum(conf) as confs,
                sum(monto_conf) as monto_confs
            FROM
                (SELECT
                    cli_id_FK,
                    if(res_ubi=0,1,0) as contacto,
                    if(res_id in (1,43),1,0) as pdp,
                    if(res_id in (1,43),ges_cli_com_can,0) as monto_pdp,
                    if(res_id in (2),1,0) as conf,
                    if(res_id in (2),ges_cli_conf_can,0) as monto_conf
                FROM
                    cliente c
                INNER JOIN gestion_cliente g ON g.cli_id_FK=c.cli_id
                INNER JOIN respuesta r ON g.res_id_FK=r.res_id
                WHERE
                    cli_est=0
                and cli_pas=0
                and date(ges_cli_fec) = date(NOW())
                AND RIGHT (rtrim(ges_cli_det), 4) LIKE ('%$firma')
                )b                   
        ";
        $query=DB::connection('mysql')->select(DB::raw($sql));
        return $query;
    }

    public static function estadosCampana(Request $rq){

        $sql_cartera="
                select car_id_FK as idcartera from cliente where cli_est=0 and cli_pas=0 and emp_tel_id_FK=2531 LIMIT 1
            ";
        $query_cartera=DB::connection('mysql')->select(DB::raw($sql_cartera));
        foreach($query_cartera as $q){
            $car_id=$q->idcartera;
        }
        $cartera=$car_id;

        //$fec_actual=date("Y-m-d H:i:00");
        $fec_actual='2020-07-25 16:04:18';

        $sql="
            select 
            id_cartera,nombre_camp,fecha_i,fecha_f,
            DATE_FORMAT(fecha_i, '%d/%m') as dia,TIME_FORMAT(fecha_i, '%H:%i %p') as hora,
            (case 
                WHEN fecha_i > '$fec_actual' THEN 'PC'
                WHEN fecha_i = '$fec_actual' or (fecha_i < '$fec_actual' and fecha_f >= '$fec_actual') THEN 'CE'
                WHEN fecha_i < '$fec_actual' or fecha_f < '$fec_actual' THEN 'CC'
            end) as estado
            from indicadores.campana 
            where id_cartera=$cartera
                and '$fec_actual' BETWEEN fecha_i and fecha_f
            ORDER BY fecha_i asc
            limit 1
        ";

        $query=DB::connection('mysql')->select(DB::raw($sql));
        return $query;
    }
}

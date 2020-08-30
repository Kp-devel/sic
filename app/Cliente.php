<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

class Cliente extends Model
{
    protected $connection = 'mysql';

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
        $deuda=$rq->deuda;
        $sueldo=$rq->sueldo;
        $entidades=$rq->entidades;
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
            $fec_actual=date("Y-m-d H:i:s");
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

        $filtro="
            SELECT 
                cli_id as id,
                cli_cod as codigo,
                cli_nom as nombre,
                cli_num_doc as dni,
                det_cli_deu_cap as capital,
                det_cli_deu_mor as deuda,
                det_cli_imp_can as importe,
                det_cli_pro as producto,
                if(ges_cli_med is null,'-',ges_cli_med) as telefono,
                if(res_id_FK is null,'Sin Gestión',res_des) as ult_resp,
                date(ges_cli_fec) as fecha_ges,
                cli_ema as email
            FROM 
                cliente as c
            inner JOIN detalle_cliente dc ON c.cli_id = dc.cli_id_FK
            left JOIN gestion_cliente g ON c.ges_cli_tel_id_FK=g.ges_cli_id
            left JOIN respuesta as r on r.res_id=g.res_id_FK
        ";
            
        $sql="
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
            $sql = $sql." and cli_cod in ($cadena_cli) ";
        }

        if( $deuda =='1'){
            $sql = $sql." and det_cli_deu_mor <= 500 ";
        }else if($deuda =='2'){
            $sql = $sql." and det_cli_deu_mor > 500 and det_cli_deu_mor <= 1000 ";
        }else if($deuda =='3'){
            $sql = $sql." and det_cli_deu_mor > 1000 and det_cli_deu_mor <= 3000 ";
        }else if($deuda =='4'){
            $sql = $sql." and det_cli_deu_mor > 3000 ";
        }

        if( $sueldo =='1'){
            $filtro= $filtro." left join cliente_sueldo as s on c.cli_id=s.cli_id_FK";
            $sql = $sql." and cli_suel_can <= 500 ";
        }else if($sueldo =='2'){
            $filtro= $filtro." left join cliente_sueldo as s on c.cli_id=s.cli_id_FK";
            $sql = $sql." and cli_suel_can > 500 and cli_suel_can <= 1000 ";
        }else if($sueldo =='3'){
            $filtro= $filtro." left join cliente_sueldo as s on c.cli_id=s.cli_id_FK";
            $sql = $sql." and cli_suel_can > 1000 and cli_suel_can <= 3000 ";
        }else if($sueldo =='4'){
            $filtro= $filtro." left join cliente_sueldo as s on c.cli_id=s.cli_id_FK";
            $sql = $sql." and cli_suel_can > 3000 ";
        }

        if( $entidades =='0'){
            $filtro= $filtro." left join cliente_infAdic as i on c.cli_id=i.cli_id_FK";
            $sql = $sql." and cli_inf_entidades like '%BP' ";
        }else if($entidades =='1'){
            $filtro= $filtro." left join cliente_infAdic as i on c.cli_id=i.cli_id_FK";
            $sql = $sql." and cli_inf_entidades like '%BP + 1%' ";
        }else if($entidades =='2'){
            $filtro= $filtro." left join cliente_infAdic as i on c.cli_id=i.cli_id_FK";
            $sql = $sql." and cli_inf_entidades like '%BP + 2%' ";
        }else if($entidades =='3'){
            $filtro= $filtro." left join cliente_infAdic as i on c.cli_id=i.cli_id_FK";
            $sql = $sql." and cli_inf_entidades like '%BP + 3%' ";
        }

        $sql= $sql." GROUP BY cli_id";

        if($ordenar!= "null"){
            if($ordenar=='1'){
                $sql = $sql." order by ges_cli_fec asc,det_cli_deu_cap desc ";
            }
            if($ordenar=='2'){
                $sql = $sql." order by ges_cli_fec asc,det_cli_deu_mor desc ";
            }
            if($ordenar=='3'){
                $sql = $sql." order by ges_cli_fec asc,det_cli_imp_can desc ";
            }
        }else{
                $sql = $sql." order by ges_cli_fec asc,det_cli_deu_mor desc";
        }

        $query=DB::connection('mysql')->select(DB::raw($filtro." ".$sql));
        return $query;
    }

    public static function datosMes(){
        $sql="SELECT
                    cli_id,
                    if(emp_meta is null,0,emp_meta) as meta,
                    sum(monto_conf) as monto_conf,
                    max(fecha_conf) as fecha_conf,
                    sum(monto_pago) as monto_pago,
                    max(fecha_pago) as fecha_pago,
                    if(sum(monto_pago)=0,sum(monto_conf),sum(monto_pago)) as recupero,
                    if(sum(monto_pago)=0,max(fecha_conf),max(fecha_pago)) as fecha_recupero,
                    sum(monto_pdp) as monto_pdp,
                    sum(pendiente) as pdp_pendiente,
                    sum(caidos) as pdp_caidos,
                    sum(cumplido) as pdp_cumplido
            FROM
                    cliente c
            LEFT JOIN (
                SELECT
                    g.cli_id_FK,
                    sum(ges_cli_conf_can) as monto_conf,
                    day(max(ges_cli_conf_fec)) as fecha_conf,
                    sum(ges_cli_com_can) as monto_pdp,
                    sum(if(com_cli_est <> 0,com_cli_can,0)) as cumplido,
                    sum(if( com_cli_est=0 and DATEDIFF(DATE_FORMAT(now(),'%Y-%m-%d'),DATE_FORMAT(com_cli_fec_pag,'%Y-%m-%d')) <= 0,com_cli_can,0)) as pendiente,
                    sum(if( com_cli_est=0 and DATEDIFF(DATE_FORMAT(now(),'%Y-%m-%d'),DATE_FORMAT(com_cli_fec_pag,'%Y-%m-%d')) > 0,com_cli_can,0)) as caidos
                FROM
                    gestion_cliente g
                LEFT JOIN compromiso_cliente cc ON cc.cli_id_FK=g.cli_id_FK and cc.ges_cli_id_FK=g.ges_cli_id and date_format(com_cli_fec_pag,'%Y-%m') = date_format(now(),'%Y-%m')
                WHERE
                    date_format(ges_cli_fec,'%Y-%m') = date_format(now(),'%Y-%m')
                    and res_id_FK in (1,2,43)
                    -- and g.emp_id_FK=2531	
                    and ges_cli_acc IN (1, 2)
                GROUP BY cli_id_FK
            )g ON c.cli_id = g.cli_id_FK
            INNER JOIN empleado e on c.emp_tel_id_FK=e.emp_id
            LEFT JOIN (
                SELECT
                    pag_cli_cod,
                    sum(pag_cli_mon) as monto_pago,
                    day(max(pag_cli_fec)) as fecha_pago
                FROM
                    pago_cliente_2
                WHERE
                    date_format(pag_cli_fec, '%Y-%m') = date_format(now(), '%Y-%m')
                AND car_id_FK = :car
                GROUP BY pag_cli_cod
            ) p ON c.cli_cod = p.pag_cli_cod
            WHERE
                    cli_est=0
            and cli_pas=0
            and emp_tel_id_FK=:emp
            -- GROUP BY cli_id
        ";
        $datos=DB::connection('mysql')->select(DB::raw($sql),array("emp"=>2531,"car"=>72));
        return $datos;
        // return response()->json(['metas' => $metas, 'datos' => $datos, 'pdp' => $pdp , 'pagos' => $pagos]);
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


    public static function infoCliente(Request $rq){
        $id=$rq->id;
        //$id=121049517;
        $sql="
            select 
                cli_inf_entidades as entidades,
                cli_inf_score as score,
                cli_dir_dir as direccion,
                cli_dir_dis as distrito,
                cli_dir_pro as provincia,
                cli_dir_dep as departamento,
                cli_suel_emp as laboral,
                cli_suel_can as sueldo
        
            from
                cliente_infAdic as i
            left join
                cliente_direccion_2 as d on i.cli_id_FK=d.cli_id_FK
            left join 
                cliente_sueldo as s on i.cli_id_FK=s.cli_id_FK
            where i.cli_id_FK = $id
        ";
        $query=DB::connection('mysql')->select(DB::raw($sql));
        return $query;
    }
    
    public static function historicoGestiones(Request $rq){
        $id=$rq->id;
       // $id=121049517;
        $sql="
            SELECT
            emp_id_FK,ges_cli_acc,emp_tip_acc,
            DATE_FORMAT(ges_cli_fec,'%Y-%m-%d') as fecha,
	        DATE_FORMAT(ges_cli_fec,'%H:%i:%s') as hora,
            (CASE
                WHEN emp_tip_acc =1 THEN 'ADMINISTRADOR'
                WHEN emp_tip_acc =2 THEN 'G. TELEFONICO'
                WHEN emp_tip_acc =3 THEN 'G. DOMICILIARIO'
                WHEN emp_tip_acc =4 THEN 'DIGITADOR'
                WHEN emp_tip_acc =5 THEN 'SUPERVISOR'
            end) as perfil,
            ges_cli_med as medio,
            (case
                WHEN res_ubi=0 THEN 'C'
                WHEN res_ubi=1 THEN 'NC'
                WHEN res_ubi=2 THEN 'ND'
            end) as ubic,
            res_des as respuesta,
            ges_cli_det as detalle,
            ges_cli_com_fec as fecha_pdp,
            ges_cli_com_can as monto_pdp,
            res_id_FK as res_id
            FROM 
                gestion_cliente as gc
            INNER JOIN 
                respuesta as r on gc.res_id_FK=r.res_id
            INNER JOIN
                empleado as e on gc.emp_id_FK=e.emp_id
            WHERE 
                cli_id_FK=$id
                AND date_format(ges_cli_fec,'%Y-%m') BETWEEN date_format(now()- INTERVAL 12 MONTH, '%Y-%m') and date_format(now(), '%Y-%m')
            ORDER BY ges_cli_id DESC
        ";

        $query=DB::connection('mysql')->select(DB::raw($sql));
        return $query;
    }

    public static function infoDeuda($id){
        $sql="
            SELECT
                cuenta,
                tipo_cuenta,
                tarjeta,
                producto,
                fecha_deuda,
                dias,
                tramo,
                moneda,
                capital,
                deuda,
                dscto,
                importe_dscto,
                importe,
                (case 
                    WHEN dscto_ant IS NULL THEN '-2'
                    WHEN CAST(dscto AS UNSIGNED)=0 THEN '-3'
                    WHEN CAST(dscto AS UNSIGNED) > CAST(dscto_ant AS UNSIGNED) THEN '1'
                    WHEN CAST(dscto AS UNSIGNED) < CAST(dscto_ant AS UNSIGNED) THEN '-1'
                    WHEN CAST(dscto AS UNSIGNED) = CAST(dscto_ant AS UNSIGNED) THEN '0'
                END) AS indicador_dscto
            FROM
            (SELECT 
                    det_cli_num_doc as cuenta,
                    det_cli_tip_doc as tipo_cuenta,
                    det_cli_num_doc as tarjeta,
                    det_cli_pro as producto,
                    det_cli_fec_deu as fecha_deuda,
                    det_cli_dia_atr as dias,
                    det_cli_tra as tramo,
                    (case 
                            WHEN det_cli_mon =1 THEN 'SOLES'
                            WHEN det_cli_mon =2 THEN 'DOLARES'
                    end) as moneda,
                    det_cli_deu_cap as capital,
                    det_cli_deu_mor as deuda,
                    det_cli_dscto as dscto,
                    det_cli_imp_dscto as importe_dscto,
                    det_cli_imp_can as importe,
                    (SELECT det_dsc_dscto FROM detalle_dscto WHERE det_dsc_fec=DATE_FORMAT(DATE_ADD(DATE(NOW()),INTERVAL -1 MONTH),'%Y%m') AND det_dsc_num_doc=det_cli_num_doc and det_dsc_est=0) as dscto_ant
            FROM 
                    detalle_cliente
            WHERE 
                    cli_id_FK=:id
                    AND det_cli_est = 0
                    AND det_cli_pas = 0
            )t
        ";

        $query=DB::connection('mysql')->select(DB::raw($sql),array("id"=>$id));
       return $query;
   }
}

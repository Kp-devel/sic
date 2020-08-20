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
        $pdp_desde=$rq->pdp_desde;
        $pdp_hasta=$rq->pdp_hasta;
        $ordenar=$rq->ordenar;

        $sql="
            SELECT 
                dc.cli_id_FK,
                cli_id as id,
                cli_cod as codigo,
                cli_nom as nombre,
                cli_num_doc as dni,
                det_cli_num_doc as cuenta,
                det_cli_tra as tramo,
                det_cli_deu_cap as capital,
                det_cli_deu_mor as deuda,
                det_cli_imp_can as importe,
                det_cli_pro as producto,
                cli_tel_tel as telefono,
                if(res_des is null,'Sin Gestión',res_des) as ult_resp,
                ges_cli_com_can as monto
            FROM 
                cliente as c
            left JOIN
                (select max(ges_cli_id) as maxid,cli_id_FK from creditoy_cobranzas.gestion_cliente where date_format(ges_cli_fec,'%Y-%m')=date_format(now(),'%Y-%m') GROUP BY cli_id_FK) as g
                on g.cli_id_FK=c.cli_id
            left JOIN 
                creditoy_cobranzas.gestion_cliente as gg on gg.ges_cli_id=g.maxid
            left JOIN
                detalle_cliente as dc ON c.cli_id=dc.cli_id_FK
            left JOIN 
                empleado as e ON c.emp_tel_id_FK=e.emp_id
            left JOIN 
                cliente_telefono as ct ON ct.cli_id_FK=c.cli_id
            left JOIN
                respuesta as r on r.res_id=gg.res_id_FK
            where 
                cli_est=0 and cli_pas=0 and det_cli_est=0 and det_cli_pas=0
                and emp_cod=4090
                and det_cli_deu_mor = (SELECT MAX(det_cli_deu_mor) FROM detalle_cliente WHERE det_cli_est = 0 AND det_cli_pas = 0 AND cli_id_FK = c.cli_id ORDER BY det_cli_deu_mor DESC LIMIT 1)
                    
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
        if($pdp_desde!= "null"){
            $sql = $sql." and ges_cli_com_can >=$pdp_desde ";
        }
        if($pdp_hasta!= "null"){
            $sql = $sql." and ges_cli_com_can <=$pdp_hasta ";
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
        }
        

        $query=DB::connection('mysql')->select(DB::raw($sql));
        return $query;

        /*return DB::connection('mysql')->select(DB::raw("
                SELECT 
                    dc.cli_id_FK,
                    cli_id as id,
                    cli_cod as codigo,
                    cli_nom as nombre,
                    cli_num_doc as dni,
                    det_cli_num_doc as cuenta,
                    det_cli_tra as tramo,
                    det_cli_deu_cap as capital,
                    det_cli_deu_mor as deuda,
                    det_cli_imp_can as importe,
                    det_cli_pro as producto,
                    cli_tel_tel as telefono,
                    res_des as ult_resp
                FROM
                    cliente as c
                INNER JOIN
                    detalle_cliente as dc ON c.cli_id=dc.cli_id_FK
                INNER JOIN 
                    empleado as e ON c.emp_tel_id_FK=e.emp_id
                INNER JOIN 
                    cliente_telefono as ct ON ct.cli_id_FK=c.cli_id
                INNER JOIN 
                    gestion_cliente as gc on gc.cli_id_FK=c.cli_id
                INNER JOIN
                    respuesta as r on r.res_id=gc.res_id_FK
                WHERE
                    cli_est=0 and cli_pas=0 and det_cli_est=0 and det_cli_pas=0 and cli_tel_est =0 AND cli_tel_pas=0 and res_est=0 and res_pas=0
                    and emp_cod=4090
                    and cli_cod=:codigo
                    and det_cli_deu_mor = (SELECT MAX(det_cli_deu_mor) FROM detalle_cliente WHERE det_cli_est = 0 AND det_cli_pas = 0 AND cli_id_FK = c.cli_id ORDER BY det_cli_deu_mor DESC LIMIT 1)
                    and ges_cli_id = (SELECT MAX(ges_cli_id) FROM gestion_cliente WHERE cli_id_FK = c.cli_id ORDER BY ges_cli_id DESC LIMIT 1)
                GROUP BY cli_id
            "),array("codigo"=>$codigo));*/
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
}

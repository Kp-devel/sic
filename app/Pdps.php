<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Pdps extends Model
{
    public static function reporteEstadosPdps(Request $rq){
        $cartera=$rq->cartera;
        $gestor=$rq->gestor;
        $arrayParametros=array();
        $sql="";
        if($gestor!=''){
            $var="('%$gestor%')";
            $sql.=" and ges_cli_det like $var";
            // array_push($arrayParametros,"gestor=>$var");
        }
        

        return DB::connection('mysql')->select(DB::raw("
                    SELECT
                        date(com_cli_fec_pag) as fecha,
                        sum(if(com_cli_est <> 0,com_cli_can,0)) as cumplidos,
                        sum(if( com_cli_est=0 and DATEDIFF(DATE_FORMAT(now(),'%Y-%m-%d'),DATE_FORMAT(com_cli_fec_pag,'%Y-%m-%d')) > 0,com_cli_can,0)) as caidos,
                        sum(com_cli_can) as generados
                    FROM
                        cliente c
                    INNER JOIN gestion_cliente g on c.cli_id=g.cli_id_FK
                    INNER JOIN compromiso_cliente cc on g.ges_cli_id=cc.ges_cli_id_FK
                    WHERE cli_est=0
                    and cli_pas=0
                    and car_id_FK=:car
                    $sql
                    and DATE_FORMAT(com_cli_fec_pag,'%Y%m')=DATE_FORMAT(date(NOW()),'%Y%m')
                    and com_cli_fec_pag<date(NOW())
                    GROUP BY date(com_cli_fec_pag)
                    ORDER BY date(com_cli_fec_pag)
        "),array("car"=>$cartera));
    }

    public static function reporteEstandarPdps(Request $rq){
        $cartera=$rq->cartera;
        $gestor=$rq->gestor;
        $arrayParametros=array();
        $sql="";

        if($gestor!=''){
            $var="('%$gestor%')";
            $sql.=" and ges_cli_det like $var";
            // array_push($arrayParametros,"gestor=>$var");
        }
        

        return DB::connection('mysql')->select(DB::raw("
                    SELECT
                        date(com_cli_fec) as fecha,
                        sum(if(com_cli_est <> 0,1,0)) as cant_cumplidos,
                        sum(if(com_cli_est <> 0,com_cli_can,0)) as monto_cumplidos,
                        sum(com_cli_can) as generados,
                        if(estandar>sum(com_cli_can),1,0) as color,
                        estandar
                    FROM
                        cliente c
                    INNER JOIN gestion_cliente g on c.cli_id=g.cli_id_FK
                    INNER JOIN compromiso_cliente cc on g.ges_cli_id=cc.ges_cli_id_FK
                    INNER JOIN creditoy_reporte.estandar_pdp_cartera ec on c.car_id_FK=ec.car_id_FK
                    WHERE cli_est=0
                    and cli_pas=0
                    and c.car_id_FK=:car
                    $sql
                    and DATE_FORMAT(com_cli_fec,'%Y%m')=DATE_FORMAT(date(NOW()),'%Y%m')
                    and com_cli_fec<date(NOW())
                    and estado=0
                    GROUP BY date(com_cli_fec)
                    ORDER BY date(com_cli_fec)
        "),array("car"=>$cartera));
    }

    public static function reportePdps(Request $rq){
        $cartera=$rq->cartera;
        $gestor=$rq->gestor;
        $arrayParametros=array();
        $sql="";

        if($gestor!=''){
            $var="('%$gestor%')";
            $sql.=" and ges_cli_det like $var";
            // array_push($arrayParametros,"gestor=>$var");
        }
        

        return DB::connection('mysql')->select(DB::raw("
                    SELECT
                        fecha,
                        round((dia0/generados)*100) as dato0,
                        round((dia1/generados)*100) as dato1,
                        round((dia2/generados)*100) as dato2,
                        round((dia3/generados)*100) as dato3,
                        round((dia4/generados)*100) as dato4,
                        round((dia5/generados)*100) as dato5,
                        round((dia6/generados)*100) as dato6,
                        round((dia7/generados)*100) as dato7,
                        generados,
                        dia0,cant0,
                        dia1,cant1,
                        dia2,cant2,
                        dia3,cant3,
                        dia4,cant4,
                        dia5,cant5,
                        dia6,cant6,
                        dia7,cant7
                    FROM
                    (SELECT
                            date(com_cli_fec) as fecha,
                            sum(if(date(com_cli_fec)=date(com_cli_fec_pag),com_cli_can,0)) as dia0,
                            sum(if(date(com_cli_fec)=date(com_cli_fec_pag),1,0)) as cant0,
                            sum(if(date(com_cli_fec_pag)=DATE_ADD(date(com_cli_fec),INTERVAL 1 DAY),com_cli_can,0)) as dia1,
                            sum(if(date(com_cli_fec_pag)=DATE_ADD(date(com_cli_fec),INTERVAL 1 DAY),1,0)) as cant1,
                            sum(if(date(com_cli_fec_pag)=DATE_ADD(date(com_cli_fec),INTERVAL 2 DAY),com_cli_can,0)) as dia2,
                            sum(if(date(com_cli_fec_pag)=DATE_ADD(date(com_cli_fec),INTERVAL 2 DAY),1,0)) as cant2,
                            sum(if(date(com_cli_fec_pag)=DATE_ADD(date(com_cli_fec),INTERVAL 3 DAY),com_cli_can,0)) as dia3,
                            sum(if(date(com_cli_fec_pag)=DATE_ADD(date(com_cli_fec),INTERVAL 3 DAY),1,0)) as cant3,
                            sum(if(date(com_cli_fec_pag)=DATE_ADD(date(com_cli_fec),INTERVAL 4 DAY),com_cli_can,0)) as dia4,
                            sum(if(date(com_cli_fec_pag)=DATE_ADD(date(com_cli_fec),INTERVAL 4 DAY),1,0)) as cant4,
                            sum(if(date(com_cli_fec_pag)=DATE_ADD(date(com_cli_fec),INTERVAL 5 DAY),com_cli_can,0)) as dia5,
                            sum(if(date(com_cli_fec_pag)=DATE_ADD(date(com_cli_fec),INTERVAL 5 DAY),1,0)) as cant5,
                            sum(if(date(com_cli_fec_pag)=DATE_ADD(date(com_cli_fec),INTERVAL 6 DAY),com_cli_can,0)) as dia6,
                            sum(if(date(com_cli_fec_pag)=DATE_ADD(date(com_cli_fec),INTERVAL 6 DAY),1,0)) as cant6,
                            sum(if(date(com_cli_fec_pag)=DATE_ADD(date(com_cli_fec),INTERVAL 7 DAY),com_cli_can,0)) as dia7,
                            sum(if(date(com_cli_fec_pag)=DATE_ADD(date(com_cli_fec),INTERVAL 7 DAY),1,0)) as cant7,
                            sum(com_cli_can) as generados
                    FROM
                            cliente c
                    INNER JOIN gestion_cliente g on c.cli_id=g.cli_id_FK
                    INNER JOIN compromiso_cliente cc on g.ges_cli_id=cc.ges_cli_id_FK
                    WHERE cli_est=0
                    and cli_pas=0
                    and c.car_id_FK=:car
                    $sql
                    and DATE_FORMAT(com_cli_fec,'%Y%m')=DATE_FORMAT(date(NOW()),'%Y%m')
                    and com_cli_fec<date(NOW())
                    GROUP BY date(com_cli_fec)
                    ORDER BY date(com_cli_fec)
                    )t
        "),array("car"=>$cartera));
    }

    public static function listaPdps(Request $rq){
        $cartera=$rq->cartera;
        $codigo=$rq->codigo;
        $documento=$rq->documento;
        $nombre=$rq->nombre;
        $tipo_gestor=$rq->tipo_gestor;
        $oficina=$rq->oficina;
        $tipo_pdp=$rq->tipo_pdp;
        $monto=$rq->monto;
        $fechaPdpInicio=$rq->fechaInicio;
        $fechaPdpFin=$rq->fechaFin;
        $carteras=session()->get('datos')->idcartera;
        $sql="";
        
        if($fechaPdpInicio!='' && $fechaPdpFin!=''){
            $sql.=" AND date(com_cli_fec_pag) between '$fechaPdpInicio' and '$fechaPdpFin' ";
        }

        if($cartera!=''){
            $sql.=" AND car_id_Fk=$cartera ";
        }else{
            if($carteras!=0){
                $sql.=" AND car_id_Fk in ($carteras) ";
            }
        }

        if($codigo!=''){
            $sql.=" AND cli_cod=$codigo ";
        }

        if($documento!=''){
            $sql.=" AND cli_num_doc=$documento ";
        }
        
        if($nombre!= null){
            $nom = explode(' ',$nombre);
            for($i=0; $i < count($nom); $i++){
                $sql .= " AND cli_nom like '%".$nom[$i]."%' ";
            }
        }

        if($tipo_gestor!=''){
            $sql.=" AND e.emp_tip_acc=$tipo_gestor ";
        }

        if($oficina!=''){
            $sql.=" AND loc_id=$oficina ";
        }

        if($tipo_pdp!=''){
            $sql.=" AND res_id_FK=$tipo_pdp ";
        }

        if($monto==1){
            $sql.=" AND com_cli_can>=500 ";
        }

        if($monto==2){
            $sql.=" AND com_cli_can>=1000 ";
        }
        
        return DB::connection('mysql')->select(DB::raw("
                    SELECT 
                        id,
                        codigo,
                        nombre,
                        tipo_documento,
                        numero_documento,
                        cartera,
                        gestor_tel,
                        oficina,
                        gestor_gestion,
                        case when tipo=1 THEN 'ADMINISTRADOR'
                                when tipo=2 THEN 'G. TELEFONICO'
                                when tipo=3 THEN 'G. DOMICILIARIO'
                                when tipo=4 THEN 'DIGITADOR'
                        end as tipo_gestor,
                        gestion,
                        fecha_pdp,
                        monto_pdp,
                        moneda
                    FROM 
                    (SELECT
                            cli_id as id,
                            com_cli_fec,
                            cli_cod as codigo,
                            cli_nom as nombre,
                            cli_tip_doc as tipo_documento,
                            cli_num_doc as numero_documento,
                            car_nom as cartera,
                            CONCAT(ce.emp_cod,' - ',ce.emp_nom) as gestor_tel,
                            CONCAT(e.emp_cod,' - ',e.emp_nom) as gestor_gestion,
                            loc_nom as oficina,
                            concat(res_des,'. ',g.ges_cli_det) as gestion,
                            date(com_cli_fec_pag) as fecha_pdp,
                            com_cli_can as monto_pdp,
                            if(com_cli_mon=0,'S/.','$/.') as moneda,
                            e.emp_tip_acc as tipo
                        FROM
                            cliente c
                        INNER JOIN compromiso_cliente cc ON c.cli_id = cc.cli_id_FK
                        INNER JOIN gestion_cliente g ON cc.ges_cli_id_FK=g.ges_cli_id
                        INNER JOIN empleado e ON cc.emp_id_FK = e.emp_id
                        INNER JOIN cartera ca ON c.car_id_FK=ca.car_id
                        INNER JOIN respuesta r ON g.res_id_FK=r.res_id
                        LEFT JOIN empleado ce ON c.emp_tel_id_FK = ce.emp_id
                        LEFT JOIN `local` l ON l.loc_id=c.loc_id_FK
                        WHERE
                            cli_pas <> 1
                        AND cli_est <> 1
                        AND com_cli_pas <> 1
                        AND com_cli_est <> 1 
                        $sql
                        ORDER BY com_cli_fec desc
                    )t 
                    where id>0
                    GROUP BY codigo
                    ORDER BY monto_pdp DESC
        "));
    }


    public static function descargarListaPdps(Request $rq){
        $cartera=$rq->cartera;
        $codigo=$rq->codigo;
        $documento=$rq->documento;
        $nombre=$rq->nombre;
        $tipo_gestor=$rq->tipo_gestor;
        $oficina=$rq->oficina;
        $tipo_pdp=$rq->tipo_pdp;
        $monto=$rq->monto;
        $fechaPdpInicio=$rq->fechaInicio;
        $fechaPdpFin=$rq->fechaFin;
        $carteras=session()->get('datos')->idcartera;
        $sql="";
        
        if($fechaPdpInicio!='' && $fechaPdpFin!=''){
            $sql.=" AND date(com_cli_fec_pag) between '$fechaPdpInicio' and '$fechaPdpFin' ";
        }

        if($cartera!=''){
            $sql.=" AND car_id_Fk=$cartera ";
        }else{
            if($carteras!=0){
                $sql.=" AND car_id_Fk in ($carteras) ";
            }
        }

        if($codigo!=''){
            $sql.=" AND cli_cod=$codigo ";
        }

        if($documento!=''){
            $sql.=" AND cli_num_doc=$documento ";
        }
        
        if($nombre!= null){
            $nom = explode(' ',$nombre);
            for($i=0; $i < count($nom); $i++){
                $sql .= " AND cli_nom like '%".$nom[$i]."%' ";
            }
        }

        if($tipo_gestor!=''){
            $sql.=" AND e.emp_tip_acc=$tipo_gestor ";
        }

        if($oficina!=''){
            $sql.=" AND loc_id=$oficina ";
        }

        if($tipo_pdp!=''){
            $sql.=" AND res_id_FK=$tipo_pdp ";
        }

        if($monto==1){
            $sql.=" AND com_cli_can>=500 ";
        }

        if($monto==2){
            $sql.=" AND com_cli_can>=1000 ";
        }
        
        return DB::connection('mysql')->select(DB::raw("
                    SELECT 
                        codigo as 'Código',
                        nombre as 'Nombre',
                        fecha as 'Fecha Gestión',
                        medio as 'Medio',
                        cartera as 'Cartera',
                        gestor_tel as 'Asig. G. Telf.',
                        oficina as 'Oficina',
                        gestor_gestion as 'Uuario-Gestor',
                        case when tipo=1 THEN 'ADMINISTRADOR'
                                when tipo=2 THEN 'G. TELEFONICO'
                                when tipo=3 THEN 'G. DOMICILIARIO'
                                when tipo=4 THEN 'DIGITADOR'
                        end as 'Tipo',
                        detalle as 'Detalle',
                        fecha_pdp as 'Fecha Compromiso',
                        monto_pdp as 'Monto',
                        moneda as 'Moneda',
                        direccion as 'Dirección',
                        distrito as 'Distrito',
                        provincia as 'Provincia',
                        departamento as 'Departamento'
                    FROM 
                    (SELECT
                            cli_id as id,
                            com_cli_fec,
                            cli_cod as codigo,
                            cli_nom as nombre,
                            car_nom as cartera,
                            CONCAT(ce.emp_cod,' - ',ce.emp_nom) as gestor_tel,
                            CONCAT(e.emp_cod,' - ',e.emp_nom) as gestor_gestion,
                            loc_nom as oficina,
                            g.ges_cli_det as detalle,
                            date(com_cli_fec_pag) as fecha_pdp,
                            com_cli_can as monto_pdp,
                            if(com_cli_mon=0,'SOLES','DOLARES') as moneda,
                            e.emp_tip_acc as tipo,
                            ges_cli_fec as fecha,
                            ges_cli_med as medio,
                            cli_dir_dir as direccion,
                            cli_dir_dis as distrito,
                            cli_dir_pro as provincia,
                            cli_dir_dep as departamento
                        FROM
                            cliente c
                        INNER JOIN compromiso_cliente cc ON c.cli_id = cc.cli_id_FK
                        INNER JOIN gestion_cliente g ON cc.ges_cli_id_FK=g.ges_cli_id
                        INNER JOIN empleado e ON cc.emp_id_FK = e.emp_id
                        INNER JOIN cartera ca ON c.car_id_FK=ca.car_id
                        INNER JOIN respuesta r ON g.res_id_FK=r.res_id
                        LEFT JOIN empleado ce ON c.emp_tel_id_FK = ce.emp_id
                        LEFT JOIN `local` l ON l.loc_id=c.loc_id_FK
                        LEFT JOIN cliente_direccion_2 cd ON c.cli_id=cd.cli_id_FK and cli_dir_est=0 AND cli_dir_pas=0
                        WHERE
                            cli_pas <> 1
                        AND cli_est <> 1
                        AND com_cli_pas <> 1
                        AND com_cli_est <> 1 
                        $sql
                        GROUP BY ges_cli_id
                        ORDER BY com_cli_fec desc
                    )t 
                    where id>0
                    GROUP BY codigo
                    ORDER BY monto_pdp DESC
        "));
    }

}

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

}

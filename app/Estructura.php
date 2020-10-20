<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Estructura extends Model
{
    public static function reporteEstructuraCarteraTodo(Request $rq){
        $cartera=$rq->cartera;
        $ubicabilidad=$rq->ubicabilidad;
        $estructura=$rq->estructura;
        $mes=date("Ym", strtotime($rq->mes));
        
        return DB::connection('mysql')->select(DB::raw("
            SELECT 
                estructura,
                count(cartera) as clientes,
                sum(capital) as capital,
                sum(saldo_deuda) as deuda,
                sum(monto_camp) as importe 
            FROM
            (SELECT 
                case when :estr1='tramo' then if(car_id_FK in (34,88,89,2),if(tramo<=2016,2016,tramo),tramo)
                     when :estr2='score' then score
                     when :estr3='entidades' then entidades
                     when :estr4='dep' then dep
                     when :estr5='dep_ind' then dep_ind
                     when :estr6='prioridad' then prioridad
                     when :estr7='saldo_deuda' then 
                            (case WHEN saldo_deuda<500 THEN 'A: [0-500>'
                                  WHEN saldo_deuda<1000 THEN 'B: [500-1000>'
                                  WHEN saldo_deuda<3000 THEN 'C: [1000-3000>'
                                  WHEN saldo_deuda>=3000 THEN 'D: [3000-+>'
                            end)
                    when :estr8='capital' then 
                            (case WHEN capital<500 THEN 'A: [0-500>'
                                  WHEN capital<1000 THEN 'B: [500-1000>'
                                  WHEN capital<3000 THEN 'C: [1000-3000>'
                                  WHEN capital>=3000 THEN 'D: [3000-+>'
                            end)
                    when :estr9='monto_camp' then 
                            (case WHEN monto_camp<500 THEN 'A: [0-500>'
                                  WHEN monto_camp<1000 THEN 'B: [500-1000>'
                                  WHEN monto_camp<3000 THEN 'C: [1000-3000>'
                                  WHEN monto_camp>=3000 THEN 'D: [3000-+>'
                            end)
                end as estructura,
                cartera,
                capital,
                saldo_deuda,
                monto_camp
            FROM indicadores.cartera_detalle
            WHERE 
                car_id_fk=:car
            and date_format(fecha,'%Y%m')=:mes
            )t
            group by estructura
            Order by clientes desc
        "),array("car"=>$cartera,"mes"=>$mes,
            "estr1"=>$estructura,"estr2"=>$estructura,"estr3"=>$estructura,
            "estr4"=>$estructura,"estr5"=>$estructura,"estr6"=>$estructura,
            "estr7"=>$estructura,"estr8"=>$estructura,"estr9"=>$estructura,
            ));
    }

    public static function reporteEstructuraCarteraGestion(Request $rq){
        $cartera=$rq->cartera;
        $ubicabilidad=$rq->ubicabilidad;
        $estructura=$rq->estructura;
        $mes=date("Ym", strtotime($rq->mes));

        return DB::connection('mysql')->select(DB::raw("
                    select 
                        estructura,
                        COUNT(clientes) as clientes,
                        sum(capital) as capital,
                        sum(saldo_deuda) as deuda,
                        sum(monto_camp) as importe
                    from
                    (SELECT
                            cli_cod as clientes,
                            case when :estr1='tramo' then if(c.car_id_FK in (34,88,89,2),if(tramo<=2016,2016,tramo),tramo)
                                when :estr2='score' then score
                                when :estr3='entidades' then entidades
                                when :estr4='dep' then dep
                                when :estr5='dep_ind' then dep_ind
                                when :estr6='prioridad' then prioridad
                                when :estr7='saldo_deuda' then 
                                        (case WHEN saldo_deuda<500 THEN 'A: [0-500>'
                                            WHEN saldo_deuda<1000 THEN 'B: [500-1000>'
                                            WHEN saldo_deuda<3000 THEN 'C: [1000-3000>'
                                            WHEN saldo_deuda>=3000 THEN 'D: [3000-+>'
                                        end)
                                when :estr8='capital' then 
                                        (case WHEN capital<500 THEN 'A: [0-500>'
                                            WHEN capital<1000 THEN 'B: [500-1000>'
                                            WHEN capital<3000 THEN 'C: [1000-3000>'
                                            WHEN capital>=3000 THEN 'D: [3000-+>'
                                        end)
                                when :estr9='monto_camp' then 
                                        (case WHEN monto_camp<500 THEN 'A: [0-500>'
                                            WHEN monto_camp<1000 THEN 'B: [500-1000>'
                                            WHEN monto_camp<3000 THEN 'C: [1000-3000>'
                                            WHEN monto_camp>=3000 THEN 'D: [3000-+>'
                                        end)
                            end as estructura,
                            (CASE 
                                WHEN res_id_FK IN ( 38, 6, 22, 41 ) THEN 'cfrn'
                                WHEN res_id_FK IN ( 2,37,33,10,1,8,43,39,7,3,5,9,34,17,21,18,28,30,35,36,46,47,48,49 ) THEN 'contacto'
                                WHEN res_id_FK IN ( 32 ) THEN 'nodisponible'
                                WHEN res_id_FK IN ( 19,27,12,26,13,4,11,12,20,14,15,16,23,24,29,31 ) THEN 'inubicable'
                                WHEN res_id_FK IN ( 45,44, 25 ) THEN 'nocontacto'
                                WHEN res_id_FK IS NULL THEN 'singestion'
                            END) AS ubicabilidad,
                            capital,
                            saldo_deuda,
                            monto_camp
                        FROM
                            cliente c
                            INNER JOIN indicadores.cartera_detalle cd ON c.cli_cod = cd.cuenta 
                            LEFT JOIN(select max(ges_cli_id) as maxid,cli_id_FK 
                                      from cliente cc
                                      inner join gestion_cliente cg on cc.cli_id=cg.cli_id_FK
                                      where 
                                        cli_est=0 and cli_pas=0 and car_id_FK=:car3
                                        and ges_cli_est=0 
                                        and date_format(ges_cli_fec,'%Y%m') = :mes 
                                      GROUP BY cli_id_FK
                            ) as g on g.cli_id_FK=c.cli_id
                            LEFT join gestion_cliente as gg on gg.ges_cli_id=g.maxid
                        WHERE
                            cli_est =0 and cli_pas=0
                            AND c.car_id_FK =:car
                            AND cd.car_id_FK=:car2
                            AND date_format( fecha, '%Y%m' ) = :mes2		
                        GROUP BY	
                            cli_cod
                    ) a
                    WHERE ubicabilidad=:ubic
                    group by estructura
                    Order by clientes desc
        "),array("car"=>$cartera,"car2"=>$cartera,"car3"=>$cartera,
                "mes"=>$mes,"mes2"=>$mes,"ubic"=>$ubicabilidad,
                "estr1"=>$estructura,"estr2"=>$estructura,"estr3"=>$estructura,
                "estr4"=>$estructura,"estr5"=>$estructura,"estr6"=>$estructura,
                "estr7"=>$estructura,"estr8"=>$estructura,"estr9"=>$estructura
            ));

    }

    public static function listaGestores($cartera)
    {
        return DB::connection('mysql')->select(DB::raw("
                select 
                    emp_id as id,
                    emp_nom as gestor,
                    emp_firma as firma,
                    encargado as codigo
                from sub_empleado 
                where 
                    emp_est=0
                    and car_id_FK=:car
                order by emp_nom asc
        "),array('car' =>$cartera));
        
    }

    public static function estructuraGestor(Request $rq){
        $cartera=$rq->cartera;
        $firma=$rq->gestor;
        $estructura=$rq->estructura;
        $fecInicio=$rq->fechaInicio;
        $fecFin=$rq->fechaFin;
        $tipo=$rq->tipoAnalisis;
        $respuesta="";
        if($tipo=="pdps"){
            $respuesta="and res_id_fk in (1,43)";
        }
        if($tipo=="confirmacion"){
            $respuesta="and res_id_fk in (2)";
        }

        return DB::connection('mysql')->select(DB::raw("
                    select 
                        estructura,
                        count(cli_cod) as clientes,
                        sum(capital) as capital,
                        sum(saldo_deuda) as deuda,
                        sum(monto_camp) as importe,
                        case when :tipo1='pdps' then sum(can_pdp)
                            when :tipo2='confirmacion' then sum(can_conf)
                            else sum(gestiones)
                        end as cantidad,
                        case when :tipo3='pdps' then sum(monto_pdp)
                            when :tipo4='confirmacion' then sum(monto_conf)
                            else sum(gestiones)/count(cli_cod)
                        end as total
                    from
                        (select 
                            cli_cod, 
                            case when :estr1='tramo' then if(c.car_id_FK in (34,88,89,2),if(tramo<=2016,2016,tramo),tramo)
                                    when :estr2='score' then score
                                    when :estr3='entidades' then entidades
                                    when :estr4='dep' then dep
                                    when :estr5='dep_ind' then dep_ind
                                    when :estr6='prioridad' then prioridad
                                    when :estr7='saldo_deuda' then 
                                                    (case WHEN saldo_deuda<500 THEN 'A: [0-500>'
                                                            WHEN saldo_deuda<1000 THEN 'B: [500-1000>'
                                                            WHEN saldo_deuda<3000 THEN 'C: [1000-3000>'
                                                            WHEN saldo_deuda>=3000 THEN 'D: [3000-+>'
                                                    end)
                                    when :estr8='capital' then 
                                                    (case WHEN capital<500 THEN 'A: [0-500>'
                                                            WHEN capital<1000 THEN 'B: [500-1000>'
                                                            WHEN capital<3000 THEN 'C: [1000-3000>'
                                                            WHEN capital>=3000 THEN 'D: [3000-+>'
                                                    end)
                                    when :estr9='monto_camp' then 
                                                    (case WHEN monto_camp<500 THEN 'A: [0-500>'
                                                            WHEN monto_camp<1000 THEN 'B: [500-1000>'
                                                            WHEN monto_camp<3000 THEN 'C: [1000-3000>'
                                                            WHEN monto_camp>=3000 THEN 'D: [3000-+>'
                                                    end)
                                    when :estr10='rango_sueldo' then rango_sueldo
                            end as estructura,
                            count(ges_cli_id) as gestiones,
                            sum(ges_cli_com_can) as monto_pdp,
                            sum(ges_cli_conf_can) as monto_conf,
                            count(ges_cli_com_can) as can_pdp,
                            count(ges_cli_conf_can) as can_conf,
                            capital,
                            saldo_deuda,
                            monto_camp
                        from gestion_cliente as g
                        inner join cliente as c on g.cli_id_FK=c.cli_id
                        inner join indicadores.cartera_detalle as cd on c.cli_cod=cd.cuenta
                        where 
                            (date(ges_cli_fec) between :fecInicio and :fecFin)
                            and (date_format(fecha,'%Y%m'))=(date_format(:fec,'%Y%m'))
                            and c.car_id_FK=:car1
                            and cd.car_id_fk=:car2
                            $respuesta
                            and ges_cli_det like :firma
                            and ges_cli_est=0
                        group by cli_cod
                    ) t
                group by estructura
                order by clientes desc
        "),array('car1' =>$cartera,'car2' =>$cartera,"firma"=>'%'.$firma,"fec"=>$fecInicio,"fecInicio"=>$fecInicio,"fecFin"=>$fecFin,
                "estr1"=>$estructura,"estr2"=>$estructura,"estr3"=>$estructura,"estr4"=>$estructura,"estr5"=>$estructura,
                "estr6"=>$estructura,"estr7"=>$estructura,"estr8"=>$estructura,"estr9"=>$estructura,"estr10"=>$estructura,
                "tipo1"=>$tipo,"tipo2"=>$tipo,"tipo3"=>$tipo,"tipo4"=>$tipo));
    }

    public static function reporteEstructuraGestorCarteraTodo(Request $rq){
        $cartera=$rq->cartera;
        $ubicabilidad=$rq->ubicabilidad;
        $estructura=$rq->estructura;
        $gestor=$rq->gestor;
        $mes=date("Ym", strtotime($rq->mes));
        
        return DB::connection('mysql')->select(DB::raw("
            SELECT 
                estructura,
                count(cartera) as clientes,
                sum(capital) as capital,
                sum(saldo_deuda) as deuda,
                sum(monto_camp) as importe 
            FROM
            (SELECT 
                case when :estr1='tramo' then if(d.car_id_FK in (34,88,89,2),if(tramo<=2016,2016,tramo),tramo)
                     when :estr2='score' then score
                     when :estr3='entidades' then entidades
                     when :estr4='dep' then dep
                     when :estr5='dep_ind' then dep_ind
                     when :estr6='prioridad' then prioridad
                     when :estr7='saldo_deuda' then 
                            (case WHEN saldo_deuda<500 THEN 'A: [0-500>'
                                  WHEN saldo_deuda<1000 THEN 'B: [500-1000>'
                                  WHEN saldo_deuda<3000 THEN 'C: [1000-3000>'
                                  WHEN saldo_deuda>=3000 THEN 'D: [3000-+>'
                            end)
                    when :estr8='capital' then 
                            (case WHEN capital<500 THEN 'A: [0-500>'
                                  WHEN capital<1000 THEN 'B: [500-1000>'
                                  WHEN capital<3000 THEN 'C: [1000-3000>'
                                  WHEN capital>=3000 THEN 'D: [3000-+>'
                            end)
                    when :estr9='monto_camp' then 
                            (case WHEN monto_camp<500 THEN 'A: [0-500>'
                                  WHEN monto_camp<1000 THEN 'B: [500-1000>'
                                  WHEN monto_camp<3000 THEN 'C: [1000-3000>'
                                  WHEN monto_camp>=3000 THEN 'D: [3000-+>'
                            end)
                end as estructura,
                cartera,
                capital,
                saldo_deuda,
                monto_camp
            FROM indicadores.cartera_detalle d
            inner join cliente c on d.cuenta=c.cli_cod
            WHERE 
                c.car_id_fk=:car1
            and d.car_id_fk=:car2
            and emp_tel_id_FK=(select emp_id from empleado where emp_cod=:emp)
            and date_format(fecha,'%Y%m')=:mes
            )t
            group by estructura
            Order by clientes desc
        "),array("car1"=>$cartera,"car2"=>$cartera,"mes"=>$mes,"emp"=>$gestor,
            "estr1"=>$estructura,"estr2"=>$estructura,"estr3"=>$estructura,
            "estr4"=>$estructura,"estr5"=>$estructura,"estr6"=>$estructura,
            "estr7"=>$estructura,"estr8"=>$estructura,"estr9"=>$estructura,
            ));
    }

    public static function reporteEstructuraGestorCarteraGestion(Request $rq){
        $cartera=$rq->cartera;
        $ubicabilidad=$rq->ubicabilidad;
        $estructura=$rq->estructura;
        $gestor=$rq->gestor;
        $mes=date("Ym", strtotime($rq->mes));

        return DB::connection('mysql')->select(DB::raw("
                    select 
                        estructura,
                        COUNT(clientes) as clientes,
                        sum(capital) as capital,
                        sum(saldo_deuda) as deuda,
                        sum(monto_camp) as importe
                    from
                    (SELECT
                            cli_cod as clientes,
                            case when :estr1='tramo' then if(c.car_id_FK in (34,88,89,2),if(tramo<=2016,2016,tramo),tramo)
                                when :estr2='score' then score
                                when :estr3='entidades' then entidades
                                when :estr4='dep' then dep
                                when :estr5='dep_ind' then dep_ind
                                when :estr6='prioridad' then prioridad
                                when :estr7='saldo_deuda' then 
                                        (case WHEN saldo_deuda<500 THEN 'A: [0-500>'
                                            WHEN saldo_deuda<1000 THEN 'B: [500-1000>'
                                            WHEN saldo_deuda<3000 THEN 'C: [1000-3000>'
                                            WHEN saldo_deuda>=3000 THEN 'D: [3000-+>'
                                        end)
                                when :estr8='capital' then 
                                        (case WHEN capital<500 THEN 'A: [0-500>'
                                            WHEN capital<1000 THEN 'B: [500-1000>'
                                            WHEN capital<3000 THEN 'C: [1000-3000>'
                                            WHEN capital>=3000 THEN 'D: [3000-+>'
                                        end)
                                when :estr9='monto_camp' then 
                                        (case WHEN monto_camp<500 THEN 'A: [0-500>'
                                            WHEN monto_camp<1000 THEN 'B: [500-1000>'
                                            WHEN monto_camp<3000 THEN 'C: [1000-3000>'
                                            WHEN monto_camp>=3000 THEN 'D: [3000-+>'
                                        end)
                            end as estructura,
                            (CASE 
                                WHEN res_id_FK IN ( 38, 6, 22, 41 ) THEN 'cfrn'
                                WHEN res_id_FK IN ( 2,37,33,10,1,8,43,39,7,3,5,9,34,17,21,18,28,30,35,36,46,47,48,49 ) THEN 'contacto'
                                WHEN res_id_FK IN ( 32 ) THEN 'nodisponible'
                                WHEN res_id_FK IN ( 19,27,12,26,13,4,11,12,20,14,15,16,23,24,29,31 ) THEN 'inubicable'
                                WHEN res_id_FK IN ( 45,44, 25 ) THEN 'nocontacto'
                                WHEN res_id_FK IS NULL THEN 'singestion'
                            END) AS ubicabilidad,
                            capital,
                            saldo_deuda,
                            monto_camp
                        FROM
                            cliente c
                            INNER JOIN indicadores.cartera_detalle cd ON c.cli_cod = cd.cuenta 
                            LEFT JOIN(select max(ges_cli_id) as maxid,cli_id_FK 
                                      from cliente cc
                                      inner join gestion_cliente cg on cc.cli_id=cg.cli_id_FK
                                      where 
                                        cli_est=0 and cli_pas=0 and car_id_FK=:car3
                                        and ges_cli_est=0 
                                        and emp_id_FK=(select emp_id from empleado where emp_cod=:emp2)
                                        and date_format(ges_cli_fec,'%Y%m') = :mes 
                                      GROUP BY cli_id_FK
                            ) as g on g.cli_id_FK=c.cli_id
                            LEFT join gestion_cliente as gg on gg.ges_cli_id=g.maxid
                        WHERE
                            cli_est =0 and cli_pas=0
                            AND c.car_id_FK =:car
                            AND cd.car_id_FK=:car2
                            and emp_tel_id_FK=(select emp_id from empleado where emp_cod=:emp1)
                            AND date_format( fecha, '%Y%m' ) = :mes2		
                        GROUP BY	
                            cli_cod
                    ) a
                    WHERE ubicabilidad=:ubic
                    group by estructura
                    Order by clientes desc
        "),array("car"=>$cartera,"car2"=>$cartera,"car3"=>$cartera,"emp1"=>$gestor,
                "emp2"=>$gestor,"mes"=>$mes,"mes2"=>$mes,"ubic"=>$ubicabilidad,
                "estr1"=>$estructura,"estr2"=>$estructura,"estr3"=>$estructura,
                "estr4"=>$estructura,"estr5"=>$estructura,"estr6"=>$estructura,
                "estr7"=>$estructura,"estr8"=>$estructura,"estr9"=>$estructura
            ));

    }
    
}

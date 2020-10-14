<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Plan extends Model
{
    public static function listaPlanes(Request $rq){
        $cartera = $rq->cartera;
        $fechaInicio = $rq->fechaInicio;
        $fechaFin = $rq->fechaFin;
        return DB::connection('mysql')->select(DB::raw("
                select 
                    fecha_i as fecha, 
                    fecha_f as fechaFin,
                    nombre_cartera as cartera,
                    nombre_plan as nombre,
                    cant_clientes as clientes,
                    speech,
                    detalle
                from indicadores.plan
                where id_cartera=:car
                and fecha_i between :fecInicio and :fecFin
        "),array("car"=>$cartera,"fecInicio"=>$fechaInicio,"fecFin"=>$fechaFin));
    }

    public static function resumenPlan(Request $rq){
        $cartera = $rq->cartera;
        $tramo = implode(',',$rq->tramo);
        $departamento = implode(',',$rq->departamento);
        $prioridad = implode(',',$rq->prioridad);
        $situacion = implode(',',$rq->situacion);
        $call = implode(',',$rq->call);
        $sueldo = implode(',',$rq->sueldo);
        $capital = implode(',',$rq->capital);
        $deuda = implode(',',$rq->deuda);
        $importe = implode(',',$rq->importe);
        $ubicabilidad = implode(',',$rq->ubicabilidad);
        $entidad = implode(',',$rq->entidad);
        $tipoCliente = implode(',',$rq->tipoCliente);
        $sql="";

        if($tramo!=''){
            $sql.=" and tramo in ($tramo)";
        }
        if($departamento!=''){
            $sql.=" and dep in ($departamento)";
        }
        if($prioridad!=''){
            $sql.=" and prioridad in ($prioridad)";
        }
        if($situacion!=''){
            $sql.=" and dep_ind in ($situacion)";
        }
        if($call!=''){
            $sql.=" and cal_nom in ($call)";
        }
        if($sueldo!=''){
            $sql.=" and rango_sueldo in ($sueldo)";
        }
        if($capital!=''){
            $sql.=" and capital in ($capital)";
        }
        if($deuda!=''){
            $sql.=" and saldo_deuda in ($deuda)";
        }
        if($importe!=''){
            $sql.=" and monto_camp in ($importe)";
        }
        if($ubicabilidad!=''){
            $sql.=" and ubicabilidad in ($ubicabilidad)";
        }
        if($entidad!=''){
            $sql.=" and entidad in ($entidad)";
        }
        if($tipoCliente!=''){
            $sql.=" and nuevo in ($tipoCliente)";
        }

        return DB::connection('mysql')->select(DB::raw("
                SELECT
                    count(cuenta) as cantidad,
                    emp_cod as usuario, 
                    emp_nom as gestor
                FROM 
                (SELECT
                    cuenta,
                        cli_nom,
                        if(cli_tel_tel is null,'0',cli_tel_tel) as cli_tel_tel,
                        capital as cap,
                        saldo_deuda as sal,
                        monto_camp as importe,
                        rango_sueldo,
                        dep_ind,
                        prioridad,
                        if(cal_nom is null,'SIN CALL',cal_nom) as cal_nom,
                        if(emp_cod is null,'NO ASIGNADO',emp_cod) as emp_cod,
                        if(emp_nom is null,'NO ASIGNADO',emp_nom) as emp_nom,
                        cartera,
                        cd.car_id_fk as car,
                        (CASE WHEN dep LIKE '%TACNA%' or dep LIKE '%JUNIN%' or dep LIKE '%HUANUCO%' or dep LIKE '%UCAYALI%' or
                                dep LIKE '%LORETO%' or dep LIKE '%CUSCO%' or dep LIKE '%OTROS%' or dep LIKE '%MOQUEGUA%' OR
                                dep LIKE '%HUANCAVELICA%' or dep LIKE '%SAN MARTIN%' or dep LIKE '%PUNO%' or dep LIKE '%TUMBES%' or 
                                dep LIKE '%AYACUCHO%' or dep LIKE '%PASCO%' THEN 'OTROS'
                            ELSE dep
                        END) AS dep,
                        if(tramo <=2016,2016,tramo) AS tramo,
                        (CASE 
                                WHEN capital <500 THEN 'A'
                                WHEN capital >= 500 and capital < 1000 THEN 'B'
                                WHEN capital >= 1000 and capital < 3000 THEN 'C'
                                WHEN capital >= 3000 THEN 'D'
                        END) AS capital,
                        (CASE 
                                WHEN saldo_deuda <500 THEN 'A'
                                WHEN saldo_deuda >= 500 and saldo_deuda < 1000 THEN 'B'
                                WHEN saldo_deuda >= 1000 and saldo_deuda < 3000 THEN 'C'
                                WHEN saldo_deuda >= 3000 THEN 'D'
                        END) AS saldo_deuda,
                        (CASE 
                                WHEN monto_camp <500 THEN 'A'
                                WHEN monto_camp >= 500 and monto_camp < 1000 THEN 'B'
                                WHEN monto_camp >= 1000 and monto_camp < 3000 THEN 'C'
                                WHEN monto_camp >= 3000 THEN 'D'
                        END) AS monto_camp,
                        (CASE 
                                WHEN ges_cli_fec IS NULL OR DATE_FORMAT(ges_cli_fec,'%Y%m')<DATE_FORMAT(NOW(),'%Y%m') THEN 'SG' 
                                WHEN res_id_FK IN ( 38, 6, 22, 41 ) THEN 'cfrn'
                                WHEN res_id_FK IN ( 2,37,33,10,1,8,43,39,7,3,5,9,34,17,21,18,28,30,35,36,46,47,48,49 ) THEN 'contacto'
                                WHEN res_id_FK IN ( 32 ) THEN 'nodisponible'
                                WHEN res_id_FK IN ( 19,27,12,26,13,4,11,12,20,14,15,16,23,24,29,31 ) THEN 'inubicable'
                                WHEN res_id_FK IN ( 45,44, 25 ) THEN 'nocontacto'
                                ELSE 'NO ENCONTRADO'
                        END) AS ubicabilidad,
                    (CASE 
                        WHEN entidades like '%1%' or entidades = 2 THEN 2
                        WHEN entidades like '%2%' or entidades = 3 THEN 3
                        WHEN entidades like '%3%' or entidades >= 4 THEN 4
                        ELSE 1
                    END) AS entidad,
                    if(cli_nuev_cod is null,'NO','NUEVO') as nuevo
                FROM
                    indicadores.cartera_detalle cd
                INNER JOIN creditoy_cobranzas.cliente c ON c.cli_cod = cd.cuenta
                LEFT JOIN creditoy_cobranzas.cliente_telefono as tele on c.cli_id=tele.cli_id_FK and cli_tel_est=0 and cli_tel_pas=0
                left JOIN creditoy_cobranzas.empleado as e on c.emp_tel_id_FK=e.emp_id and e.emp_est=0 and e.emp_pas=0
                left JOIN creditoy_cobranzas.call_telefonica as cal on e.cal_id_FK=cal.cal_id
                LEFT JOIN creditoy_cobranzas.nuevo_cliente as cn on c.cli_cod=cn.cli_nuev_cod
                LEFT JOIN gestion_cliente g on c.ges_cli_tel_id_FK=g.ges_cli_id
                WHERE 
                        cli_est=0
                    and cli_pas=0
                    and c.car_id_fk=:car1
                    and cd.car_id_FK=:car2
                    and date_format(cd.fecha,'%Y%m')=date_format(now(),'%Y%m') 
                GROUP BY cuenta
                )t
            where 
                1=1
                $sql
            group by emp_cod
        "),array("car1"=>$cartera,"car2"=>$cartera));
    }

    public static function insertarPlan(Request $rq){
        $cartera = $rq->cartera;        
        $nombreCartera = $rq->nombreCartera;
        $nombrePlan=$rq->plan;
        $total=$rq->total;
        $speech=$rq->speech;
        $fechaInicio=$rq->fechaInicio;
        $fechaFin=$rq->fechaFin;
        $tramo = implode(',',$rq->tramo);
        $departamento = implode(',',$rq->departamento);
        $prioridad = implode(',',$rq->prioridad);
        $situacion = implode(',',$rq->situacion);
        $call = implode(',',$rq->call);
        $sueldo = implode(',',$rq->sueldo);
        $capital = implode(',',$rq->capital);
        $deuda = implode(',',$rq->deuda);
        $importe = implode(',',$rq->importe);
        $ubicabilidad = implode(',',$rq->ubicabilidad);
        $entidad = implode(',',$rq->entidad);
        $tipoCliente = implode(',',$rq->tipoCliente);
        $usuarios = implode(',',$rq->usuarios);
        $sql="";

        if($usuarios!=''){
            $sql.=" and emp_cod in ($usuarios)";
        }
        if($tramo!='' || $tramo!='TODOS'){
            $sql.=" and tramo in ($tramo)";
        }
        if($departamento!='' || $departamento!='TODOS'){
            $sql.=" and dep in ($departamento)";
        }
        if($prioridad!='' || $prioridad!='TODOS'){
            $sql.=" and prioridad in ($prioridad)";
        }
        if($situacion!='' || $situacion!='TODOS'){
            $sql.=" and dep_ind in ($situacion)";
        }
        if($call!='' || $call!='TODOS'){
            $sql.=" and cal_nom in ($call)";
        }
        if($sueldo!='' || $sueldo!='TODOS'){
            $sql.=" and rango_sueldo in ($sueldo)";
        }
        if($capital!='' || $capital!='TODOS'){
            $sql.=" and capital in ($capital)";
        }
        if($deuda!='' || $deuda!='TODOS'){
            $sql.=" and saldo_deuda in ($deuda)";
        }
        if($importe!='' || $importe!='TODOS'){
            $sql.=" and monto_camp in ($importe)";
        }
        if($ubicabilidad!='' || $ubicabilidad!='TODOS'){
            $sql.=" and ubicabilidad in ($ubicabilidad)";
        }
        if($entidad!='' || $entidad!='TODOS'){
            $sql.=" and entidad in ($entidad)";
        }
        if($tipoCliente!='' || $tipoCliente!='TODOS'){
            $sql.=" and nuevo in ($tipoCliente)";
        }
        

        $detalle="Tramo: ".$tramo.";";
        $detalle.="Departamentos: ".str_replace("'","",$departamento).";";
        $detalle.="Prioridad: ".str_replace("'","",$prioridad).";";
        $detalle.="Situación Laboral: ".str_replace("'","",$situacion).";";
        $detalle.="Call: ".str_replace("'","",$call).";";
        $detalle.="Rango Sueldo: ".str_replace("'","",$sueldo).";";
        $detalle.="Rango Capital: ".str_replace("'","",$capital).";";
        $detalle.="Rango Deuda: ".str_replace("'","",$deuda).";";
        $detalle.="Rango Importe: ".str_replace("'","",$importe).";";
        $detalle.="Ubicabilidad: ".str_replace("'","",$ubicabilidad).";";
        $detalle.="Entidades: ".$entidad.";";
        $detalle.="TipoCliente: ".str_replace("'","",$tipoCliente).";";
        $detalle.="Usuarios: ".str_replace("'","",$usuarios).";";

        DB::connection('mysql')->select(DB::raw("
                INSERT INTO indicadores.plan(
                    id_cartera,
                    nombre_cartera,
                    nombre_plan,
                    clientes,
                    cant_clientes,
                    speech,
                    detalle,
                    fecha_i,
                    fecha_f,
                    fecha_reg
                )
                SELECT
                    car,
                    cartera,
                    '$nombrePlan',
                    group_concat(cli_cod),
                    '$total',
                    '$speech',
                    '$detalle',
                    '$fechaInicio',
                    '$fechaFin',
                    now()
                FROM 
                (SELECT
                    cuenta,
                        cli_cod,
                        capital as cap,
                        rango_sueldo,
                        dep_ind,
                        prioridad,
                        if(cal_nom is null,'SIN CALL',cal_nom) as cal_nom,
                        if(emp_cod is null,'NO ASIGNADO',emp_cod) as emp_cod,
                        if(emp_nom is null,'NO ASIGNADO',emp_nom) as emp_nom,
                        cartera,
                        cd.car_id_fk as car,
                        (CASE WHEN dep LIKE '%TACNA%' or dep LIKE '%JUNIN%' or dep LIKE '%HUANUCO%' or dep LIKE '%UCAYALI%' or
                                dep LIKE '%LORETO%' or dep LIKE '%CUSCO%' or dep LIKE '%OTROS%' or dep LIKE '%MOQUEGUA%' OR
                                dep LIKE '%HUANCAVELICA%' or dep LIKE '%SAN MARTIN%' or dep LIKE '%PUNO%' or dep LIKE '%TUMBES%' or 
                                dep LIKE '%AYACUCHO%' or dep LIKE '%PASCO%' THEN 'OTROS'
                            ELSE dep
                        END) AS dep,
                        if(tramo <=2016,2016,tramo) AS tramo,
                        (CASE 
                                WHEN capital <500 THEN 'A'
                                WHEN capital >= 500 and capital < 1000 THEN 'B'
                                WHEN capital >= 1000 and capital < 3000 THEN 'C'
                                WHEN capital >= 3000 THEN 'D'
                        END) AS capital,
                        (CASE 
                                WHEN saldo_deuda <500 THEN 'A'
                                WHEN saldo_deuda >= 500 and saldo_deuda < 1000 THEN 'B'
                                WHEN saldo_deuda >= 1000 and saldo_deuda < 3000 THEN 'C'
                                WHEN saldo_deuda >= 3000 THEN 'D'
                        END) AS saldo_deuda,
                        (CASE 
                                WHEN monto_camp <500 THEN 'A'
                                WHEN monto_camp >= 500 and monto_camp < 1000 THEN 'B'
                                WHEN monto_camp >= 1000 and monto_camp < 3000 THEN 'C'
                                WHEN monto_camp >= 3000 THEN 'D'
                        END) AS monto_camp,
                        (CASE 
                                WHEN ges_cli_fec IS NULL OR DATE_FORMAT(ges_cli_fec,'%Y%m')<DATE_FORMAT(NOW(),'%Y%m') THEN 'SG' 
                                WHEN res_id_FK IN ( 38, 6, 22, 41 ) THEN 'cfrn'
                                WHEN res_id_FK IN ( 2,37,33,10,1,8,43,39,7,3,5,9,34,17,21,18,28,30,35,36,46,47,48,49 ) THEN 'contacto'
                                WHEN res_id_FK IN ( 32 ) THEN 'nodisponible'
                                WHEN res_id_FK IN ( 19,27,12,26,13,4,11,12,20,14,15,16,23,24,29,31 ) THEN 'inubicable'
                                WHEN res_id_FK IN ( 45,44, 25 ) THEN 'nocontacto'
                                ELSE 'NO ENCONTRADO'
                        END) AS ubicabilidad,
                    (CASE 
                        WHEN entidades like '%1%' or entidades = 2 THEN 2
                        WHEN entidades like '%2%' or entidades = 3 THEN 3
                        WHEN entidades like '%3%' or entidades >= 4 THEN 4
                        ELSE 1
                    END) AS entidad,
                    if(cli_nuev_cod is null,'NO','NUEVO') as nuevo
                FROM
                    indicadores.cartera_detalle cd
                INNER JOIN creditoy_cobranzas.cliente c ON c.cli_cod = cd.cuenta
                LEFT JOIN creditoy_cobranzas.cliente_telefono as tele on c.cli_id=tele.cli_id_FK and cli_tel_est=0 and cli_tel_pas=0
                left JOIN creditoy_cobranzas.empleado as e on c.emp_tel_id_FK=e.emp_id and e.emp_est=0 and e.emp_pas=0
                left JOIN creditoy_cobranzas.call_telefonica as cal on e.cal_id_FK=cal.cal_id
                LEFT JOIN creditoy_cobranzas.nuevo_cliente as cn on c.cli_cod=cn.cli_nuev_cod
                LEFT JOIN gestion_cliente g on c.ges_cli_tel_id_FK=g.ges_cli_id
                WHERE 
                        cli_est=0
                    and cli_pas=0
                    and c.car_id_fk=:car1
                    and cd.car_id_FK=:car2
                    and date_format(cd.fecha,'%Y%m')=date_format(now(),'%Y%m') 
                GROUP BY cuenta
                )t
            where 
                1=1
                $sql
        "),array("car1"=>$cartera,"car2"=>$cartera));
        return "ok";
    }
}

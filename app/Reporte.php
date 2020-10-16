<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Reporte extends Model
{
    public static function asignacionCall(){
        return DB::connection('mysql')->select(DB::raw("
                 SELECT
                     cal_id as id,
                     cal_nom as valor
                 FROM
                     call_telefonica
                 WHERE
                     cal_est=0
        "));
    }

    public static function reporteGeneralGestiones(Request $rq){
        $cartera=$rq->cartera;
        $perfil=$rq->perfil;
        $fechaInicio=$rq->fechaInicio;
        $fechaFin=$rq->fechaFin;
        $sql="";
        if($perfil!=''){
            $sql=" and emp_tip_acc=$perfil ";
        }
        return DB::connection('mysql')->select(DB::raw("
                    SELECT
                        cli_cod as 'Código',
                        cli_nom as 'Nombre',
                        car_nom as 'Cartera',
                        ges_cli_fec as 'Fecha de Gestión',
                        hour(ges_cli_fec)	 as 'Hora',
                        minute(ges_cli_fec)	as 'Minuto',
                        second(ges_cli_fec)	as 'Segundo',
                        CONCAT(emp_cod,' - ',emp_nom) as 'Usuario / Gestor',
                        CASE
                            WHEN emp_tip_acc = 1 THEN
                                'ADMINISTRADOR'
                            WHEN emp_tip_acc = 2 THEN
                                'G. TELEFONICO'
                            WHEN emp_tip_acc = 3 THEN
                                'G. DOMICILIARIO'
                            WHEN emp_tip_acc = 4 THEN
                                'DIGITADOR'
                            WHEN emp_tip_acc = 5 THEN
                                'SUPERVISOR'
                            ELSE
                                ''
                        END AS 'Perfil',
                        ges_cli_med as 'Medio',
                        CASE
                            WHEN ges_cli_acc = 1 THEN
                                'LLAMADA RECIBIDA'
                            WHEN ges_cli_acc = 2 THEN
                                'LLAMADA SALIENTE'
                            WHEN ges_cli_acc = 3 THEN
                                'RECIBIR VISITA'
                            WHEN ges_cli_acc = 4 THEN
                                'REALIZAR VISITA'
                            WHEN ges_cli_acc = 5 THEN
                                'LLAMADA RECIBIDA - SMS'
                            WHEN ges_cli_acc = 6 THEN
                                'LLAMADA RECIBIDA - IVR'
                            WHEN ges_cli_acc = 7 THEN
                                'LLAMADA RECIBIDA - EMAIL'
                            ELSE
                                ''
                        END AS 'Acción',
                        ges_cli_fec_visit as 'Fecha de Visita',
                        CASE WHEN res_ubi=0 THEN 'CONTACTO' 
                                WHEN res_ubi=1 THEN 'NO CONTACTO' 
                                WHEN res_ubi=2 THEN 'NO DISPONIBLE'
                        END AS 'Ubic.',
                        res_des as 'Rspta.',
                        mot_res as 'Motivo No Pago',
                        ges_cli_det as 'Detalle',
                        ges_cli_com_fec as 'Fecha Compromiso',
                        ges_cli_com_can as 'Monto Compromiso',
                        ges_cli_com_mon as 'Moneda',
                        ges_cli_conf_fec as 'Fecha Confirmacion',
                        ges_cli_conf_can as 'Monto Confirmacion',
                        cli_dir_dir as 'Dirección',
                        cli_dir_dis as 'Distrito',
                        cli_dir_pro as 'Provincia',
                        cli_dir_dep as 'Departamento'
                    FROM
                        cliente c
                    INNER JOIN gestion_cliente g ON c.cli_id=g.cli_id_FK
                    INNER JOIN empleado e on g.emp_id_FK=e.emp_id
                    INNER JOIN cartera ca on c.car_id_FK=ca.car_id
                    LEFT JOIN cliente_direccion_2 cd ON c.cli_id=cd.cli_id_FK and cli_dir_est=0 AND cli_dir_pas=0
                    INNER JOIN respuesta r on g.res_id_FK=r.res_id
                    LEFT JOIN motivo_nopago m on g.mot_id_FK=m.mot_id
                    WHERE
                        cli_est=0
                    and cli_pas=0
                    and car_id_FK=:car
                    and (date(ges_cli_fec) BETWEEN :fecInicio and :fecFin)
                    $sql
                    and car_est=0 
                    and car_pas=0
                    and res_est=0
                    GROUP BY cli_id,ges_cli_fec    
        "),array("car"=>$cartera,"fecInicio"=>$fechaInicio,"fecFin"=>$fechaFin));
    }

    public static function reporteResumenGestor(Request $rq){
        $cartera=$rq->cartera;
        $call=$rq->call;
        $fechaInicio=$rq->fechaInicio;
        $fechaFin=$rq->fechaFin;
        $sql="";
        if($call!=''){
            $sql=" and cal_id_FK=$call ";
        }
        return DB::connection('mysql')->select(DB::raw("
                    SELECT
                        idEmpleado,
                        gestor,
                        cartera,
                        'Gestor Telefónico' as perfil,
                        callg,
                        clientes,
                        deuda,
                        gestiones,
                        contactos,
                        negociaciones,
                        nodisponibles,
                        nocontactos,
                        clientes_gestionados,
                        clientes_contacto,
                        pdps,
                        montopdps,
                        nuevos_sin_gestion_mes,
                        sin_gestion_mes,
                        concat(format(((clientes-sin_gestion_mes)/clientes)*100,0),'%') as cobertura
                    FROM
                    (SELECT
                        idEmpleado,
                        cartera,
                        concat(emp_cod,' - ',emp_nom) as gestor,
                        cal_nom as callg,
                        count(cli_cod) as clientes,
                        sum(saldo_deuda) as deuda,
                        sum(cliente_gestionados) as clientes_gestionados,
                        sum(gestiones) as gestiones,
                        sum(cliente_contacto) as clientes_contacto,
                        sum(contactos) as contactos,
                        sum(nocontactos) as nocontactos,
                        sum(nodisponibles) as nodisponibles,
                        sum(negociaciones) AS negociaciones,
                        sum(pdps) as pdps,
                        sum(montopdps) as montopdps,
                        sum(nuevos_sin_gestion) as nuevos_sin_gestion_mes,
                        sum(sin_gestion_mes) as sin_gestion_mes
                        FROM
                            (SELECT 
                                idEmpleado,
                                cli_cod,
                                cartera,
                                saldo_deuda,
                                if(sum(gestion)>0,1,0) as cliente_gestionados,
                                sum(gestion) as gestiones,
                                if(sum(contacto)>0,1,0) as cliente_contacto,
                                sum(contacto) as contactos,
                                sum(nocontacto) as nocontactos,
                                sum(nodisponible) as nodisponibles,
                                sum(negociacion) AS negociaciones,
                                sum(pdp) as pdps,
                                sum(monto_pdp) as montopdps,
                                if(sum(gestion_mes)=0 and nuevo like ('NUEVO%'),1,0) as nuevos_sin_gestion,
                                if(sum(gestion_mes)=0,1,0) as sin_gestion_mes
                            FROM
                                (SELECT
                                    c.emp_tel_id_FK as idEmpleado,
                                    cli_cod,
                                    cli_id,
                                    emp_tel_id_FK as id_ult_ges,
                                    if(g.ges_cli_id is null,0,1) as gestion,
                                    if(gmes.ges_cli_id is null,0,1) as gestion_mes,
                                    if(res_ubi=0,1,0) as contacto,
                                    if(res_ubi=1,1,0) as nocontacto,
                                    if(res_ubi=2,1,0) as nodisponible,
                                    if(g.res_id_FK=33 AND g.mot_id_FK=3,1,0) as negociacion,
                                    if(g.res_id_FK in (1,43),1,0) as pdp,
                                    if(g.res_id_FK in (1,43),g.ges_cli_com_can,0) as monto_pdp
                                FROM	
                                    cliente c 
                                LEFT JOIN gestion_cliente g on c.cli_id=g.cli_id_FK and g.ges_cli_est=0 and (date(g.ges_cli_fec) BETWEEN :fecInicio1 and :fecFin1)
                                LEFT JOIN gestion_cliente gmes on c.cli_id=gmes.cli_id_FK and gmes.ges_cli_est=0 and DATE_FORMAT(gmes.ges_cli_fec,'%Y%m')=DATE_FORMAT(:fecInicio2,'%Y%m')
                                LEFT JOIN respuesta r ON g.res_id_FK=r.res_id and res_est=0
                                WHERE
                                    cli_est=0
                                and cli_pas=0
                                and c.car_id_FK=:car1
                            )t
                            INNER JOIN indicadores.cartera_detalle i ON t.cli_cod=i.cuenta
                            WHERE
                                DATE_FORMAT(fecha,'%Y%m')=DATE_FORMAT(:fecInicio3,'%Y%m')
                            and i.car_id_fk=:car2
                            GROUP BY cli_cod
                        )tt
                        INNER JOIN empleado e ON e.emp_id=tt.idEmpleado
                        INNER JOIN call_telefonica ct on e.cal_id_FK=ct.cal_id
                        WHERE
                            emp_est=0
                        and emp_pas=0
                        and emp_tip_acc=2
                        $sql
                        GROUP BY idEmpleado
                        )d 

        "),array("car1"=>$cartera,"car2"=>$cartera,"fecInicio1"=>$fechaInicio,
                "fecInicio2"=>$fechaInicio,"fecInicio3"=>$fechaInicio,"fecFin1"=>$fechaFin));
    }
}

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
                    LEFT JOIN empleado e on g.emp_id_FK=e.emp_id
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
                    GROUP BY ges_cli_id   
        "),array("car"=>$cartera,"fecInicio"=>$fechaInicio,"fecFin"=>$fechaFin));
    }

    public static function reporteResumenGestor(Request $rq){
        $cartera=$rq->cartera;
        $call=$rq->call;
        $fechaInicio=$rq->fechaInicio;
        $fechaFin=$rq->fechaFin;
        $sql="";
        $caresp=",".$cartera.",";
        if($call!=''){
            $sql=" and cal_id_FK=$call ";
        }

        return DB::connection('mysql')->select(DB::raw("
                    (SELECT
                        idEmpleado as id,
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
                                LEFT JOIN gestion_cliente g on c.cli_id=g.cli_id_FK and g.ges_cli_est=0 and (date(g.ges_cli_fec) BETWEEN :fecInicio1 and :fecFin1) and c.emp_tel_id_FK=g.emp_id_FK 
                                LEFT JOIN gestion_cliente gmes on c.cli_id=gmes.cli_id_FK and gmes.ges_cli_est=0 and DATE_FORMAT(gmes.ges_cli_fec,'%Y%m')=DATE_FORMAT(:fecInicio2,'%Y%m')
                                LEFT JOIN respuesta r ON g.res_id_FK=r.res_id and res_est=0
                                WHERE
                                    cli_est=0
                                and cli_pas=0
                                and c.car_id_FK=:car1
                                GROUP BY cli_cod,g.ges_cli_fec
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
                    )
                    UNION
                    (
                        SELECT
                            idEmpleado,
                            gestor,
                            cartera,
                            'Supervisor' as perfil,
                            '-' as callg,
                            0 as clientes,
                            0 as deuda,
                            gestiones,
                            contactos,
                            negociaciones,
                            nodisponibles,
                            nocontactos,
                            clientes_gestionados,
                            clientes_contacto,
                            pdps,
                            montopdps,
                            0 as nuevos_sin_gestion_mes,
                            0 as sin_gestion_mes,
                            0 as cobertura
                    FROM
                    (SELECT
                        idEmpleado,
                        cartera,
                        concat(emp_cod,' - ',emp_nom) as gestor,
                        sum(cliente_gestionados) as clientes_gestionados,
                        sum(gestiones) as gestiones,
                        sum(cliente_contacto) as clientes_contacto,
                        sum(contactos) as contactos,
                        sum(nocontactos) as nocontactos,
                        sum(nodisponibles) as nodisponibles,
                        sum(negociaciones) AS negociaciones,
                        sum(pdps) as pdps,
                        sum(montopdps) as montopdps
                    FROM
                    (SELECT 
                        idEmpleado,
                        cartera,
                        cli_cod,
                        if(sum(gestion)>0,1,0) as cliente_gestionados,
                        sum(gestion) as gestiones,
                        if(sum(contacto)>0,1,0) as cliente_contacto,
                        sum(contacto) as contactos,
                        sum(nocontacto) as nocontactos,
                        sum(nodisponible) as nodisponibles,
                        sum(negociacion) AS negociaciones,
                        sum(pdp) as pdps,
                        sum(monto_pdp) as montopdps
                    FROM
                    (SELECT
                        emp_id_FK as idEmpleado,
                        car_nom as cartera,
                        cli_cod,
                        cli_id,
                        if(g.ges_cli_id is null,0,1) as gestion,
                        if(res_ubi=0,1,0) as contacto,
                        if(res_ubi=1,1,0) as nocontacto,
                        if(res_ubi=2,1,0) as nodisponible,
                        if(g.res_id_FK=33 AND g.mot_id_FK=3,1,0) as negociacion,
                        if(g.res_id_FK in (1,43),1,0) as pdp,
                        if(g.res_id_FK in (1,43),g.ges_cli_com_can,0) as monto_pdp
                    FROM	
                        cliente c
                    INNER JOIN gestion_cliente g on c.cli_id=g.cli_id_FK
                    INNER JOIN respuesta r ON g.res_id_FK=r.res_id and res_est=0 
                    INNER JOIN cartera ca on c.car_id_FK=ca.car_id
                    WHERE
                        cli_est=0
                    and cli_pas=0
                    and c.car_id_FK=:car3
                    and g.ges_cli_est=0 
                    and (date(g.ges_cli_fec) BETWEEN :fecInicio4 and :fecFin4)
                    and emp_id_FK in (select 
                                            emp_id
                                        FROM
                                        (SELECT
                                            emp_id,
                                            CONCAT(',',res_car_id_FK,',') as carteras
                                        FROM
                                            empleado
                                        WHERE
                                            emp_tip_acc = 1
                                            AND emp_est = 0
                                            and res_car_id_FK is not null
                                        )ee
                                        where carteras like ('%$caresp%')
                                    )
                    GROUP BY cli_cod,g.ges_cli_fec,emp_id_FK
                    )t
                    )tt
                    INNER JOIN empleado e ON e.emp_id=tt.idEmpleado
                    WHERE
                        emp_est=0
                    and emp_pas=0
                    and emp_tip_acc=1
                    GROUP BY idEmpleado
                    )d 
                )
        "),array("car1"=>$cartera,"car2"=>$cartera,"car3"=>$cartera,"fecInicio1"=>$fechaInicio,
                "fecInicio2"=>$fechaInicio,"fecInicio3"=>$fechaInicio,"fecFin1"=>$fechaFin,
                "fecInicio4"=>$fechaInicio,"fecFin4"=>$fechaFin));
    }

    public static function primerayultimagestion(Request $rq){
        $cartera=$rq->cartera;
        $call=$rq->call;
        $fecha=$rq->fecha;
        $horaInicio=$rq->horaInicio;
        $horaFin=$rq->horaFin;
        $sql="";
        $horasql="";
        if($call!=''){
            $sql=" and cal_id_FK=$call ";
        }
        if($horaInicio!='' && $horaFin!=''){
            $horasql=" and (time(g.ges_cli_fec) BETWEEN '$horaInicio' and '$horaFin')";
        }
        
        return DB::connection('mysql')->select(DB::raw("
                    SELECT 
                        gestor,
                        cartera,
                        perfil,
                        count(cli_cod) as clientes,
                        sum(saldo_deuda) as deuda,
                        callg,
                        min(primerages) as primerages,
                        max(ultges) as ultimages
                    FROM
                        (SELECT
                            CONCAT(emp_cod,' - ',emp_nom) as gestor,
                            cli_cod,
                            cartera,
                            'Gestor Telefónico' as perfil,
                            cal_nom as callg,
                            saldo_deuda,
                            min(time(ges_cli_fec)) as primerages,
                            max(time(ges_cli_fec)) as ultges
                        FROM	
                            cliente c
                        LEFT JOIN gestion_cliente g on c.cli_id=g.cli_id_FK and g.ges_cli_est=0 and date(g.ges_cli_fec)=:fec1 and c.emp_tel_id_FK=g.emp_id_FK $horasql
                        INNER JOIN indicadores.cartera_detalle i ON c.cli_cod=i.cuenta
                        INNER JOIN empleado e ON c.emp_tel_id_FK=e.emp_id
                        LEFT JOIN call_telefonica ct on e.cal_id_FK=ct.cal_id
                        WHERE
                            cli_est=0
                        and cli_pas=0
                        and c.car_id_FK=:car1
                        and i.car_id_FK=:car2
                        and date_format(fecha,'%Y%m')=date_format(:fec2,'%Y%m')
                        and emp_tip_acc=2
                        $sql
                        GROUP BY cli_cod
                    )t
                    GROUP BY gestor
        "),array("car1"=>$cartera,"car2"=>$cartera,"fec1"=>$fecha,"fec2"=>$fecha));
    }


    public static function cantGestioneHora($cartera){
        return DB::connection('mysql')->select(DB::raw("
                    SELECT
                        emp_nom as gestor,
                        if(hh1 is null,0,hh1) as hora1,
                        if(hh2 is null,0,hh2) as hora2,
                        if(	hh3 is null,0,	hh3) as hora3, 
                        if(	hh4 is null,0,	hh4) as hora4, 
                        if(	hh5 is null,0,	hh5) as hora5, 
                        if(	hh6 is null,0,	hh6) as hora6, 
                        if(	hh7 is null,0,	hh7) as hora7, 
                        if(	hh8 is null,0,	hh8) as hora8, 
                        if(	hh9 is null,0,	hh9) as hora9, 
                        if(	hh10 is null,0,	hh10) as hora10, 
                        if(	hh11 is null,0,	hh11) as hora11, 
                        if(	hh12 is null,0,	hh12) as hora12, 
                        if(	hh13 is null,0,	hh13) as hora13,
                        if(total is null,0,total) as total
                    FROM
                    sub_empleado s
                    LEFT JOIN (SELECT
                            firma,
                            sum(hor1) as hh1,
                            sum(hor2) as hh2,
                            sum(hor3) as hh3,
                            sum(hor4) as hh4,
                            sum(hor5) as hh5,
                            sum(hor6) as hh6,
                            sum(hor7) as hh7,
                            sum(hor8) as hh8,
                            sum(hor9) as hh9,
                            sum(hor10) as hh10,
                            sum(hor11) as hh11,
                            sum(hor12) as hh12,
                            sum(hor13) as hh13,
                            sum(hor1) +	sum(hor2) +	sum(hor3) +	sum(hor4) +	sum(hor5) +	sum(hor6) +	sum(hor7) +	sum(hor8) +	sum(hor9) +	sum(hor10) +	sum(hor11) +	sum(hor12) +	sum(hor13) +	sum(hor13) as total
                    FROM
                        (SELECT
                            RIGHT(TRIM( TRAILING ' ' FROM  ges_cli_det),3) as firma,
                            if(hour(ges_cli_fec)>=8 and hour(ges_cli_fec)<9,1,0) as hor1,
                            if(hour(ges_cli_fec)>=9 and hour(ges_cli_fec)<10,1,0) as hor2,
                            if(hour(ges_cli_fec)>=10 and hour(ges_cli_fec)<11,1,0) as hor3,
                            if(hour(ges_cli_fec)>=11 and hour(ges_cli_fec)<12,1,0) as hor4,
                            if(hour(ges_cli_fec)>=12 and hour(ges_cli_fec)<13,1,0) as hor5,
                            if(hour(ges_cli_fec)>=13 and hour(ges_cli_fec)<14,1,0) as hor6,
                            if(hour(ges_cli_fec)>=14 and hour(ges_cli_fec)<15,1,0) as hor7,
                            if(hour(ges_cli_fec)>=15 and hour(ges_cli_fec)<16,1,0) as hor8,
                            if(hour(ges_cli_fec)>=16 and hour(ges_cli_fec)<17,1,0) as hor9,
                            if(hour(ges_cli_fec)>=17 and hour(ges_cli_fec)<18,1,0) as hor10,
                            if(hour(ges_cli_fec)>=18 and hour(ges_cli_fec)<19,1,0) as hor11,
                            if(hour(ges_cli_fec)>=19 and hour(ges_cli_fec)<20,1,0) as hor12,
                            if(hour(ges_cli_fec)>=20 and hour(ges_cli_fec)<21,1,0) as hor13,
                            HOUR(ges_cli_fec)
                        FROM
                                gestion_cliente g
                            LEFT JOIN cliente c  on g.cli_id_FK=c.cli_id
                        WHERE 
                                cli_est=0
                            and cli_pas=0
                            and car_id_FK=:car1
                        and date(ges_cli_fec)=date(NOW())
                        )t 
                    GROUP BY firma
                    )tt ON tt.firma=RIGHT(s.emp_firma,3)
                    WHERE 
                        emp_est=0
                    and car_id_FK=:car2
                    order by total desc
        "),array("car1"=>$cartera,"car2"=>$cartera));
    }

    public static function descargarGestionesGestor(Request $rq){
        $opcion=$rq->opcion;
        $cartera=$rq->cartera;
        $id=$rq->id;
        $fechaInicio=$rq->fechaInicio;
        $fechaFin=$rq->fechaFin;
        $sql="";
        if(strpos($id,",")!=false){
            $id=substr($id,0,strlen($id)-1);
        }
        if($opcion==0 || $opcion==5){
            $sql=" and res_ubi=0 ";
        }
        if($opcion==1){
            $sql=" and res_ubi=1 ";
        }
        if($opcion==2){
            $sql=" and res_ubi=2 ";
        }
        if($opcion==3){
            $sql=" and res_id_FK=33 and mot_id_FK=3 ";
        }
        if($opcion==6){
            $sql=" and res_id_Fk in (1,43) ";
        }
        
        return DB::connection('mysql')->select(DB::raw("
                    SELECT
                        cli_cod as 'Código',
                        cli_nom as 'Nombre',
                        (
                            SELECT
                                count(*)
                            FROM
                                gestion_cliente
                            WHERE
                                ges_cli_est = 0
                            AND cli_id_FK = t.cli_id
                            AND emp_id_FK = t.emp_id_FK
                            AND DATE_FORMAT(date(ges_cli_fec), '%Y%m') = DATE_FORMAT(date(:fecInicio2), '%Y%m')
                            AND ges_cli_acc IN (1,2)
                        ) AS 'Cant. de llamadas en el mes',
                        format(sum(det_cli_deu_mor_sol),2) as 'Saldo Moroso Total (S/.)',
                        ges_cli_fec as 'Fecha de Gestión',
                        gestor as 'Usuario / Gestor',
                        perfil AS 'Perfil',
                        ges_cli_med as 'Medio',
                        accion AS 'Acción',
                        ubicabilidad as 'Ubic.',
                        res_des as 'Rspta.',
                        mot_res as 'Motivo No Pago',
                        ges_cli_det as 'Detalle',
                        fecha as 'Fecha',
                        CAST(monto AS SIGNED) as 'Monto',
                        if(ges_cli_com_mon=0,'SOLES','DOLARES') as 'Moneda',
                        cli_dir_dir as 'Dirección',
                        cli_dir_dis as 'Distrito',
                        cli_dir_pro as 'Provincia',
                        cli_dir_dep as 'Departamento'
                    FROM
                    (SELECT
                        emp_id_FK,
                        cli_id,
                        cli_cod,
                        cli_nom,
                        ges_cli_fec,
                        CONCAT(emp_cod,' - ',emp_nom) as gestor,
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
                        END AS perfil,
                        ges_cli_med,
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
                        END AS accion,
                        CASE WHEN res_ubi=0 THEN 'CONTACTO' 
                                WHEN res_ubi=1 THEN 'NO CONTACTO' 
                                WHEN res_ubi=2 THEN 'NO DISPONIBLE'
                        END AS ubicabilidad,
                        res_des ,
                        mot_res ,
                        ges_cli_det,
                        case when res_id_FK=2 then ges_cli_conf_fec
                                when res_id_FK in (1,43) then ges_cli_com_fec
                        end as fecha,
                        case when res_id_FK=2 then ges_cli_conf_can
                                when res_id_FK in (1,43) then ges_cli_com_can
                        end as monto,
                        ges_cli_com_mon,
                        cli_dir_dir,
                        cli_dir_dis,
                        cli_dir_pro,
                        cli_dir_dep
                    FROM
                        cliente c
                    INNER JOIN gestion_cliente g ON c.cli_id=g.cli_id_FK
                    INNER JOIN empleado e on g.emp_id_FK=e.emp_id
                    LEFT JOIN cliente_direccion_2 cd ON c.cli_id=cd.cli_id_FK and cli_dir_est=0 AND cli_dir_pas=0
                    INNER JOIN respuesta r on g.res_id_FK=r.res_id
                    LEFT JOIN motivo_nopago m on g.mot_id_FK=m.mot_id
                    WHERE
                        cli_est=0
                    and cli_pas=0
                    and car_id_FK=:car
                    and (date(ges_cli_fec) BETWEEN :fecInicio1 and :fecFin1)
                    and if (emp_tip_acc=2, emp_tel_id_FK=emp_id_FK,emp_tel_id_FK=emp_tel_id_FK)
                    and emp_id in ($id)
                    $sql
                    and res_est=0
                    GROUP BY cli_id,ges_cli_fec
                )t
                INNER JOIN detalle_cliente d on t.cli_id=d.cli_id_FK
                WHERE det_cli_est=0 and det_cli_pas=0
                GROUP BY cli_id,ges_cli_fec
        "),array("car"=>$cartera,"fecInicio1"=>$fechaInicio,"fecFin1"=>$fechaFin,"fecInicio2"=>$fechaInicio));
    }

    public static function resumenGestor($cartera){
        return DB::connection('mysql')->select(DB::raw("
                    SELECT
                        ss.emp_nom AS gestor,
                        ss.emp_firma as firma,
                        if(gestiones is null,0,gestiones) as gestiones,
                        if(gestiones is null,0,cont) as contacto,
                        if(gestiones is null,0,no_cont) as no_contacto,
                        if(gestiones is null,0,no_disp) as no_disponible
                    FROM
                        sub_empleado ss
                        LEFT JOIN (SELECT
                                if(emp_nom is null,'SIN FIRMA',emp_nom) as emp_nom,
                                emp_firma,
                                sum(gestiones) as gestiones,
                                sum(cont) as cont,
                                sum(no_cont) as no_cont,
                                sum(no_disp) as no_disp
                            FROM
                            (SELECT          	
                            firma,
                                fecha,
                                sum(gestion) as gestiones,
                                sum(contacto) as cont,
                                sum(no_contacto) as no_cont,
                                sum(no_disponible) as no_disp,
                                sum(pdp) as pdps,
                                sum(pago) AS pagos
                            FROM
                            (SELECT
                                date(ges_cli_fec) as fecha,
                                cli_id,
                                RIGHT(TRIM( TRAILING ' ' FROM  gc.ges_cli_det),3) as firma,
                                1 as gestion,
                                if(res_ubi=0,1,0) as contacto,
                                if(res_ubi=1,1,0) as no_contacto,
                                if(res_ubi=2,1,0) as no_disponible,
                                if(res_id in (1,43),ges_cli_com_can,0) as pdp,
                                if(res_id in (2),ges_cli_conf_can,0) as pago
                            FROM 
                                cliente c
                            INNER JOIN gestion_cliente gc ON gc.cli_id_FK=c.cli_id
                            INNER JOIN respuesta r ON gc.res_id_FK=r.res_id
                            WHERE
                                cli_est=0
                                and cli_pas=0
                                and car_id_FK=:car2
                                and DATE(ges_cli_fec) = date(NOW())
                            )t
                            GROUP BY firma
                        )tt 
                        LEFT JOIN sub_empleado s ON tt.firma=s.emp_firma AND emp_est=0
                        GROUP BY emp_nom
                        ORDER BY gestiones desc 
                    )e ON e.emp_nom=ss.emp_nom
                    WHERE ss.emp_est=0
                    and ss.car_id_FK=:car
                    ORDER BY gestiones desc
        "),array("car"=>$cartera,"car2"=>$cartera));
    }

    public static function resumenGestionesCartera($cartera){
        return DB::connection('mysql')->select(DB::raw("
                    SELECT
                        cartera,
                        gestiones,
                        contactos,
                        no_contacto,
                        no_disponible,
                        pdps,
                        monto_pdps,
                        confs,
                        monto_confs
                    FROM
                    (SELECT          	
                            cartera,
                            sum(gestion) as gestiones,
                            sum(contacto) as contactos,
                            sum(no_contacto) as no_contacto,
                            sum(no_disponible) as no_disponible,
                            sum(pdp) as pdps,
                            sum(monto_pdp) AS monto_pdps,
                            sum(conf) as confs,
                            sum(monto_conf) AS monto_confs
                        FROM
                        (SELECT
                            car_nom as cartera,
                            cli_id,
                            1 as gestion,
                            if(res_ubi=0,1,0) as contacto,
                            if(res_ubi=1,1,0) as no_contacto,
                            if(res_ubi=2,1,0) as no_disponible,
                            if(res_id in (1,43),1,0) as pdp,
                            if(res_id in (1,43),ges_cli_com_can,0) as monto_pdp,
                            if(res_id in (2),1,0) as conf,
                            if(res_id in (2),ges_cli_conf_can,0) as monto_conf
                        FROM 
                            cliente c
                        INNER JOIN gestion_cliente gc ON gc.cli_id_FK=c.cli_id
                        INNER JOIN respuesta r ON gc.res_id_FK=r.res_id
                        INNER JOIN cartera cc ON c.car_id_FK=cc.car_id
                        WHERE
                            cli_est=0
                            and cli_pas=0
                            and car_id_FK = :car
                            and DATE(ges_cli_fec) = date(NOW())
                        )t
                    GROUP BY cartera
                )tt
                ORDER BY gestiones desc
        "),array("car"=>$cartera));
    }
    
    
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Empleado extends Model
{
    public static function codigoEmpleado($codigo){
        return DB::connection('mysql')->select(DB::raw("
            select emp_id from empleado where emp_cod=:cod
        "),array("cod"=>$codigo));
    }

    public static function insertarEmpleado(Request $rq){
        $codigo=$rq->codigo;
        $nombre=$rq->nombre;
        $meta=isset($rq->meta)?$rq->meta:'';
        $clave=bcrypt($rq->clave);
        $tipo_acceso=$rq->tipo_acceso;
        $local=$rq->local;
        $call=$rq->call;
        $carteras=implode(',',$rq->carteras);
        if($tipo_acceso==2){
            $carteras='';
        }

        DB::connection('mysql')->insert("
            insert into empleado 
            (emp_cod, emp_nom, emp_cla, emp_tip_acc, loc_id_FK, emp_est, emp_pas, cal_id_FK,emp_ges,res_car_id_FK,emp_meta,password)
            values(:cod, :nom, '', :tipo, :local, 0, 0, :cal, null, :car, :meta, :clave)
        ",array('cod'=>$codigo,'nom'=>$nombre, 'clave'=>$clave,'tipo'=>$tipo_acceso, 'local'=>$local, 'cal'=>$call,'meta'=>$meta,'car'=>$carteras));
        return "ok";
    }

    public static function listEmpleados(Request $rq){
        $codigo=$rq->codigo;
        $nombre=$rq->nombre;
        $perfil=$rq->perfil;
        $sql="";
        $parametros=array();
        if($codigo!=''){
            $sql.=" and emp_cod like (:cod) ";
            $parametros["cod"]="%".$codigo."%";
        }
        if($nombre!=''){
            $sql.=" and emp_nom like (:nom) ";
            $parametros["nom"]="%".$nombre."%";
        }
        if($perfil!=''){
            $sql.=" and emp_tip_acc=:perfil ";
            $parametros["perfil"]=$perfil;
        }
        
        return DB::connection('mysql')->select(DB::raw("
                    select 
                        emp_id as id,
                        emp_cod as codigo, 
                        emp_nom as nombre, 
                        case when emp_tip_acc=1 then 'Supervisor'
                                when emp_tip_acc=2 then 'Gestor Telefónico'
                                when emp_tip_acc=5 then 'Administrador'
                                when emp_tip_acc=6 then 'Sistemas'
                                when emp_tip_acc=7 then 'RRHH'
                        end as perfil,
                        concat(loc_cod,' - ',loc_nom) as locals, 
                        if(emp_est=0,'ACTIVO','INACTIVO') as estado, 
                        emp_est as idestado,
                        cal_nom as calls,
                        res_car_id_FK,
                        format(emp_meta,2) as meta
                from empleado e
                left join `local` l on e.loc_id_FK=l.loc_id
                left join call_telefonica c on e.cal_id_FK=c.cal_id
                where 1=1
            $sql
        "),$parametros);
    }

    public static function agentesElastix($cartera){
        return DB::connection('elastix')->select(DB::raw("
            SELECT 
                src_FK as extension,
                concat(codigo,' - ',nombre) as agente
            FROM agente 
            where cartera=:car
        "),array("car"=>$cartera));
    }

}

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
        $carteras=$rq->carteras;
        if($tipo_acceso==2){
            $carteras='';
        }else{
            $carteras=implode(',',$rq->carteras);
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
                        emp_tip_acc as idperfil,
                        concat(loc_cod,' - ',loc_nom) as locals, 
                        loc_id_FK as idlocals,
                        if(emp_est=0,'ACTIVO','INACTIVO') as estado, 
                        emp_est as idestado,
                        cal_nom as calls,
                        cal_id_FK as idcalls,
                        res_car_id_FK as carteras,
                        format(emp_meta,2) as meta,
                        emp_meta as meta_n
                from empleado e
                left join `local` l on e.loc_id_FK=l.loc_id
                left join call_telefonica c on e.cal_id_FK=c.cal_id
                where 1=1
            $sql
        "),$parametros);
    }

    public static function updateClave(Request $rq){
        $id=$rq->id;
        $clave=bcrypt($rq->clave);
        return DB::connection('mysql')->update("
            update empleado 
            set password=:pass
            where emp_id=:id
        ",array("id"=>$id,"pass"=>$clave));
    }

    public static function updateEmpleado(Request $rq){
        $id=$rq->id;
        $nombre=$rq->nombre;
        $meta=isset($rq->meta)?$rq->meta:'';
        $tipo_acceso=$rq->tipo_acceso;
        $local=$rq->local;
        $call=$rq->call;
        $carteras=$rq->carteras;
        if($tipo_acceso==2){
            $carteras='';
        }else{
            $carteras=implode(',',$rq->carteras);
        }

        DB::connection('mysql')->update("
            update empleado 
            set emp_nom=:nom, emp_tip_acc=:tipo, loc_id_FK=:local, cal_id_FK=:cal,res_car_id_FK=:car,emp_meta=:meta
            where emp_id=:id
        ",array('id'=>$id,'nom'=>$nombre,'tipo'=>$tipo_acceso, 'local'=>$local, 'cal'=>$call,'car'=>$carteras,'meta'=>$meta));
        return "ok";
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

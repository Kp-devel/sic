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
            $nom = explode(' ',$nombre);
            for($i=0; $i < count($nom); $i++){
                $sql .= " AND emp_nom like (:nom_$i) ";
                $parametros["nom_$i"]="%".$nom[$i]."%";
            }
            // $sql.=" and emp_nom like (:nom) ";
            // $parametros["nom"]="%".$nombre."%";
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

    public static function insertarGestor(Request $rq){
        $dni=$rq->dni;
        $nombre=$rq->nombre;
        $fecha_ingreso=$rq->fecha_ingreso;
        $cartera=$rq->cartera;
        $modalidad=$rq->modalidad;
        $contacto=0;
        $pdp=0;
        if($modalidad=='TC'){
          $contacto=150;
          $pdp=6; 
        }
        if($modalidad=='MM' || $modalidad=='MT'){
            $contacto=130;
            $pdp=3;
        }
        if($modalidad=='PRC'){
            $contacto=60;
            $pdp=1; 
        }

        DB::connection('mysql')->insert("
            insert into sub_empleado
            (emp_nom, emp_firma, emp_mod,car_id_FK,encargado,emp_est_con,emp_est_com,emp_est,emp_tolerancia)
            values(:nom, '', :mod, :car, '', :con, :pdp, 0, null)
        ",array('nom'=>$nombre, 'mod'=>$modalidad,'car'=>$cartera,'con'=>$contacto,'pdp'=>$pdp));
        return "ok";
    }

    public static function listGestores(Request $rq){
        $codigo=$rq->codigo;
        $nombre=$rq->nombre;
        $firma=$rq->firma;
        $modalidad=$rq->modalidad;
        $dni=$rq->dni;
        $estado=$rq->estado;
        $cartera=$rq->cartera;
        $sql="";
        $parametros=array();
        if($codigo!=''){
            $sql.=" and encargado like (:cod) ";
            $parametros["cod"]="%".$codigo."%";
        }
        if($nombre!=''){
            $nom = explode(' ',$nombre);
            for($i=0; $i < count($nom); $i++){
                $sql .= " AND s.emp_nom like (:nom_$i) ";
                $parametros["nom_$i"]="%".$nom[$i]."%";
            }
            // $sql.=" and s.emp_nom like (:nom) ";
            // $parametros["nom"]="%".$nombre."%";
        }
        if($modalidad!=''){
            $sql.=" and s.emp_mod=:mod ";
            $parametros["mod"]=$modalidad;
        }
        if($firma!=''){
            $sql.=" and s.emp_firma like (:firma) ";
            $parametros["firma"]="%".$firma."%";
        }
        // if($dni!=''){
        //     $sql.=" and s.emp_dni=:dni ";
        //     $parametros["dni"]=$dni;
        // }
        if($cartera!=''){
            $sql.=" and s.car_id_FK=:car ";
            $parametros["car"]=$cartera;
        }

        if($estado!=''){
            $sql.=" and s.emp_est=:est ";
            $parametros["est"]=$estado;
        }

        return DB::connection('mysql')->select(DB::raw("
                    select 
                        s.emp_id as id,
                        s.emp_nom as nombre, 
                        concat(e.emp_cod,' - ', e.emp_nom) as usuario, 
                        s.emp_mod as modalidad,
                        if(s.emp_est=0,'ACTIVO','INACTIVO') as estado, 
                        s.emp_est as idestado,
                        s.emp_firma as firma,
                        c.car_nom as cartera,
                        c.car_id as idcartera,
                        encargado as codigousuario
                from sub_empleado s
                left join empleado e on s.encargado=e.emp_cod
                left join cartera c on s.car_id_FK=c.car_id
                where s.emp_id<>495
            $sql
        "),$parametros);
    }

    public static function updateFirma(Request $rq){
        $id=$rq->id;
        $firma=$rq->firma;
        return DB::connection('mysql')->update("
            update sub_empleado 
            set emp_firma=:firma
            where emp_id=:id
        ",array("id"=>$id,"firma"=>$firma));
    }

    public static function updateGestor(Request $rq){
        $id=$rq->id;
        $dni=$rq->dni;
        $nombre=$rq->nombre;
        $cartera=$rq->cartera;
        $modalidad=$rq->modalidad;
        $firma=isset($rq->firma)?$rq->firma:'';
        return DB::connection('mysql')->update("
            update sub_empleado 
            set emp_nom=:nom,emp_mod=:mod,emp_firma=:firma,car_id_FK=:car
            where emp_id=:id
        ",array("id"=>$id,"nom"=>$nombre,"mod"=>$modalidad,"firma"=>$firma,"car"=>$cartera));
    }

    public static function listGestoresActivos(){
        return DB::connection('mysql')->select(DB::raw("
                select 
                    s.emp_id as id,
                    s.emp_nom as nombre, 
                    s.emp_firma as firma
                from sub_empleado s
                where s.emp_id<>495
                and emp_est=0
        "));
    }

    public static function historialLaboral($firma){
        return DB::connection('mysql')->select(DB::raw("
                    SELECT 
                        a.emp_id as id,
                        a.emp_firma as firma,
                        fecha_ingreso as fechaIngreso,
                        fecha_salida as fechaSalida,
                        emp_pre_firma as firmaReemplazo,
                        c.car_nom as cartera,
                        s.emp_nom as reemplazo,
                        car_id as idcartera
                    FROM
                        creditoy_asignacion.asignacion a
                    INNER JOIN cartera c on a.car_id_FK=c.car_id
                    LEFT JOIN sub_empleado s on a.emp_pre_firma=s.emp_firma
                    WHERE
                        a.emp_firma=:firma
                    ORDER BY fecha_ingreso desc
        "),array("firma"=>$firma));
    }

    public static function insertHistorialLaboral(Request $rq){
        $firma=$rq->firma;
        $cartera=$rq->cartera;
        $fechaIngreso=$rq->fechaIngreso;
        $fechaSalida=isset($rq->fechaSalida)?$rq->fechaSalida:'';
        $reemplazo=isset($rq->reemplazo)?$rq->reemplazo:'';
        DB::connection('mysql')->insert("
            insert into creditoy_asignacion.asignacion 
            (emp_firma,fecha_ingreso,fecha_salida,emp_pre_firma,car_id_FK,meta_rec,estado)
            values (:firma,:fecIngreso,:fecSalida,:reemplazo,:cartera,0,0)
        ",array("firma"=>$firma,"fecIngreso"=>$fechaIngreso,"fecSalida"=>$fechaSalida,"reemplazo"=>$reemplazo,"cartera"=>$cartera));
        return "ok";
    }

    public static function updateHistorialLaboral(Request $rq){
        $id=$rq->id;
        $fechaIngreso=$rq->fechaIngreso;
        $fechaSalida=$rq->fechaSalida;
        $reemplazo=$rq->reemplazo;
        $cartera=$rq->cartera;
        DB::connection('mysql')->update("
            update creditoy_asignacion.asignacion 
            set fecha_ingreso=:fecIngreso,
                fecha_salida=:fecSalida,
                emp_pre_firma=:reemplazo,
                car_id_FK=:cartera
            where 
                emp_id=:id
        ",array("id"=>$id,"fecIngreso"=>$fechaIngreso,"fecSalida"=>$fechaSalida,"reemplazo"=>$reemplazo,"cartera"=>$cartera));
        return "ok";
    }

    public static function listEmpleadosActivos(){
        return DB::connection('mysql')->select(DB::raw("
                    select 
                        emp_id as id,
                        emp_cod as codigo, 
                        concat(emp_cod,' - ',emp_nom) as nombre
                from empleado e
                where emp_est=0
        "));
    }

    public static function updateUsuario(Request $rq){
        $id=$rq->id;
        $usuario=$rq->usuario;
        return DB::connection('mysql')->update("
            update sub_empleado
            set encargado=:usu
            where emp_id=:id
        ",array("id"=>$id,"usu"=>$usuario));
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

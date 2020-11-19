<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Predictivo extends Model
{
    public static function repositorio(Request $rq,$opcion,$idcampana){
        $cartera=$rq->cartera;
        $tipo_cliente=$rq->tipo_cliente;
        $tipo_numeros=$rq->tipo_numeros;
        $ubicabilidad=implode(',',$rq->ubicabilidad);
        $respuesta=implode("','",$rq->respuesta);
        $capital_i=$rq->capital_i;
        $capital_f=$rq->capital_f;
        $deuda_i=$rq->deuda_i;
        $deuda_f=$rq->deuda_f;
        $importe_i=$rq->importe_i;
        $importe_f=$rq->importe_f;
        $score=implode("','",$rq->score);
        $entidad=implode("','",$rq->entidad);
        $zona=implode("','",$rq->zona);
        $prioridad=implode("','",$rq->prioridad);
        $tramo=implode("','",$rq->tramo);
        $gestion_dia=$rq->gestion_dia;
        $codigos=$rq->codigos;

        $condicion="";

        if($capital_i!='' && $capital_f!=''){
            $condicion.=" and capital between $capital_i and $capital_f";
        }

        if($deuda_i!='' && $deuda_f!=''){
            $condicion.=" and deuda between $deuda_i and $deuda_f";
        }

        if($importe_i!='' && $importe_f!=''){
            $condicion.=" and importe between $importe_i and $importe_f";
        }

        if($ubicabilidad!=''){
            $condicion.=" and ubicabilidad in ($ubicabilidad)";
        }

        if($respuesta!=''){
            $condicion.=" and res_des in ('$respuesta')";
        }

        if($score!=''){
            $condicion.=" and score in ('$score')";
        }

        if($entidad!=''){
            $condicion.=" and entidades in ('$entidad')";
        }

        if($prioridad!=''){
            $condicion.=" and prioridad in ('$prioridad')";
        }

        if($zona!=''){
            $condicion.=" and zonas in ('$zona')";
        }

        if($tramo!=''){
            $condicion.=" and tramo in ('$tramo')";
        }

        if($gestion_dia!=''){
            $condicion.=" and ult_fecha not in (date(now()))";
        }

        if($codigos!=''){
            $condicion.=" and codigo not in ($codigos)";
        }

        return DB::connection('mysql')->select(DB::raw("
            call creditoy_predictivo.DATA_PREDICTIVO(:opt,:car,:cond,:tip_cli,:tip_num,:idcamp)
        "),array("opt"=>$opcion,"car"=>$cartera,"cond"=>$condicion,"tip_cli"=>$tipo_cliente,"tip_num"=>$tipo_numeros,"idcamp"=>$idcampana));
    }
    
    public static function crearCampana(Request $rq,$fecha){
        $cartera=$rq->cartera;
        $nombre=$rq->campana;
        $fechaInicio=$rq->fechaInicio;
        $fechaFin=$rq->fechaFin;
        $usuario=$rq->usuario;
        $total=$rq->total;
        $usu_logeado=auth()->user()->emp_cod;

        $tipo_cliente=$rq->tipo_cliente;
        $tipo_numeros=$rq->tipo_numeros;
        $ubicabilidad=implode(',',$rq->ubicabilidad);
        $respuesta=implode(',',$rq->respuesta);
        $capital_i=$rq->capital_i;
        $capital_f=$rq->capital_f;
        $deuda_i=$rq->deuda_i;
        $deuda_f=$rq->deuda_f;
        $importe_i=$rq->importe_i;
        $importe_f=$rq->importe_f;
        $score=implode(',',$rq->score);
        $entidad=implode(',',$rq->entidad);
        $zona=implode(',',$rq->zona);
        $prioridad=implode(',',$rq->prioridad);
        $tramo=implode(',',$rq->tramo);
        $gestion_dia=$rq->gestion_dia;
        $codigos=$rq->codigos;

        $detalle="";

        if($capital_i!='' && $capital_f!=''){
            $detalle.=" Capital: [$capital_i - $capital_f];";
        }

        if($deuda_i!='' && $deuda_f!=''){
            $detalle.=" Deuda: [$deuda_i - $deuda_f];";
        }

        if($importe_i!='' && $importe_f!=''){
            $detalle.=" Importe: [$importe_i - $importe_f];";
        }

        if($ubicabilidad!=''){
            $detalle.=" Ubicabilidad: ".str_replace("2","NO DISPONIBLE",str_replace("1","NO CONTACTO",str_replace("0","CONTACTO",$ubicabilidad))).";";
        }

        if($respuesta!=''){
            $detalle.=" Respuestas: $respuesta;";
        }

        if($score!=''){
            $detalle.=" Score: $score;";
        }

        if($entidad!=''){
            $detalle.=" Entidades: $entidad;";
        }

        if($prioridad!=''){
            $detalle.=" Prioridad: $prioridad;";
        }

        if($zona!=''){
            $detalle.=" Zonas: $zona;";
        }

        if($tramo!=''){
            $detalle.=" Tramo: $tramo;";
        }

        if($gestion_dia!=''){
            $detalle.=" Inhibir: Clientes Gestionados en el día;";
        }

        if($codigos!=''){
            $detalle.=" Inhibir Códigos: $codigos;";
        }

        return DB::connection('mysql')->insert("
                insert into creditoy_predictivo.predictivo (
                    car_id_FK,
                    pre_nom,
                    pre_detalle,
                    pre_total,
                    pre_fec_inicio,
                    pre_fec_fin,
                    pre_usuario,
                    emp_id_FK,
                    pre_est,
                    fecha_add,
                    fecha_update
                )
                VALUES(:car,:nom,:det,:total,:fecInicio,:fecFin,:usu,:emp,0,:fec,:fec2)
        ",array("car"=>$cartera,"nom"=>$nombre,"det"=>$detalle,"total"=>$total,"fecInicio"=>$fechaInicio,"fecFin"=>$fechaFin,"usu"=>$usuario,"emp"=>$usu_logeado,"fec"=>$fecha,"fec2"=>$fecha));
    }

    public static function IdCampana(Request $rq,$fecha){
        $cartera=$rq->cartera;
        $nombre=$rq->campana;        
        return DB::connection('mysql')->select(DB::raw("
            select 
                pre_id as id,
                pre_usuario as usuario
            from
                creditoy_predictivo.predictivo
            where
                car_id_FK=:car
                and fecha_add=:fec
                and pre_nom in (:nom)
            limit 1
        "),array("car"=>$cartera,"nom"=>$nombre,"fec"=>$fecha));
    }

    public static function asignar($idcampana,$usuario){
        DB::connection('mysql')->update("
            update cliente c
            inner join creditoy_predictivo.repositorio r on c.cli_cod=r.rep_codigo
            set emp_tel_id_FK=(select emp_id from empleado where emp_cod=:usu and emp_est=0 limit 1)
            where pre_id_FK=:id
        ",array("id"=>$idcampana,"usu"=>$usuario));
        return "ok";
    }

    public static function devolverAsignacion($idcampana){
        DB::connection('mysql')->update("
            update cliente c
            inner join creditoy_predictivo.repositorio r on c.cli_cod=r.rep_codigo
            set emp_tel_id_FK=rep_asignacion
            where pre_id_FK=:id
        ",array("id"=>$idcampana));
        return "ok";
    }

    public static function listaRepositorio($idcampana){
        return DB::connection('mysql')->select(DB::raw("
            select 
                rep_numero,
                rep_codigo,
                rep_nombre
            from
                creditoy_predictivo.repositorio 
            where pre_id_FK=:id
        "),array("id"=>$idcampana));
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Pago extends Model
{
    public static function infoPagos(Request $rq){
        $id=$rq->id;
        //$id=121049517;

        $sql_cartera="
            select car_id_FK as idcartera from cliente where cli_est=0 and cli_pas=0 and emp_tel_id_FK=2531 LIMIT 1
        ";
        $query_cartera=DB::connection('mysql')->select(DB::raw($sql_cartera));
        foreach($query_cartera as $q){
            $car_id=$q->idcartera;
        }
        $cartera=$car_id;

        if($cartera=='34' || $cartera=='88' || $cartera=='2' || $cartera=='89' || $cartera=='88' ||
        $cartera=='70' || $cartera=='20' || $cartera=='72' || $cartera=='5'){
            $sql="
                select 
                    if(sum(pag_cli_mon)>0,cli_cod,null) as codigo,
                    format(sum(pag_cli_mon),2) as pagos,
                    pag_cli_fec as fecha
                from pago_cliente_2 as p
                inner join 
                    cliente as c on p.pag_cli_cod=c.cli_cod
                where 
                    cli_est=0 and cli_pas=0
                    AND cli_id=$id
            ";
        }else{
            $sql="
            SELECT
                cli_cod as codigo,
                IF (sum(ges_cli_conf_can) > 0,format(sum(ges_cli_conf_can),2),0) AS pagos,
                ges_cli_conf_fec AS fecha
            FROM
                gestion_cliente AS g
            INNER JOIN cliente AS c ON g.cli_id_FK = c.cli_id
            WHERE
                cli_est = 0 AND cli_pas = 0
                AND cli_id_FK=$id
                AND res_id_fk = 2
            ";
        }
   
        $query=DB::connection('mysql')->select(DB::raw($sql));
        return $query;
    }
}

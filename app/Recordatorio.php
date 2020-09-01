<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Recordatorio extends Model
{
    public static function listarRecordatorio(Request $rq){
        $empId=2531;
        $fecActual=date("Y-m-d H:i:s");
        //$fec_actual='2020-08-31 23:55:00';
        $sql="
            select 
                cli_id_FK as id,
                ges_tel_id_FK as telefono,
                ges_rec_fec_hor as fecha_rec,
            from gestion_recordatorio as g
            INNER JOIN cliente as c on g.cli_id_FK=c.cli_id
            WHERE 
                emp_tel_id_FK=$empId
                and ges_rec_fec_hor > '$fecActual'
            ORDER BY ges_rec_fec_hor asc
            limit 1
        ";

        $query=DB::connection('mysql')->select(DB::raw($sql));
        return $query;
    }

    public static function insertarRecordatorio(Request $rq){
        $id=$rq->id;
        //$fechaRec=date("Y-m-d H:i:s");
        $empId=2531;
        $fechaRec=$rq->fechaRec;
        dd($fechaRec);
        /*$insertado = DB::connection('mysql')->insert("
            insert into gestion_recordatorio (cli_id_FK,ges_tel_id_FK,ges_rec_fec_hor,ges_rec_est,ges_rec_pas)
            values ($id,$empId,'$fechaRec',0,0)
        ");*/

        //return response()->json ($insertado);
    }
}

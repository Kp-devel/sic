<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Recordatorio extends Model
{
    public static function insertRecordatorio(Request $rq){
        $fechaRec=$rq->fechaRec." ".$rq->horaRec;
        $id=$rq->id;
        $tel=$rq->telefono;

        DB::connection('mysql')->insert("
            insert into gestion_recordatorio(cli_id_FK,ges_tel_id_FK,ges_rec_fec_hor,ges_rec_est,ges_rec_pas)
            values(:id,:tel,:fec,0,0)
        ",array("id"=>$id,"tel"=>$tel,"fec"=>$fechaRec));
    }
}

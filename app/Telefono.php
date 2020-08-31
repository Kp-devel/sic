<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Telefono extends Model
{
    public static function infoTelefonos(Request $rq){
        $id=$rq->id;
        //$id=121049517;
        $sql="
            SELECT 
                cli_id_FK, 
                if(nom is null , cli_tel_tel,nom) as telefono,
                frec,
                ubi
            from 
                (SELECT
                        cli_id_FK, cli_tel_tel,
                        (
                        SELECT
                            CASE WHEN bit_tel_tipo='Digitador' THEN CONCAT(cli_tel_tel,' - Campo')
                                WHEN bit_tel_tipo='Gestor' THEN CONCAT(cli_tel_tel,' - Call')
                                ELSE CONCAT(cli_tel_tel,' - Supervisor')
                            END 
                        FROM
                            bitacora_telefono
                        WHERE
                            bit_tel_cli_id = cli_id_FK
                        AND bit_tel_tel=cli_tel_tel
                        limit 1
                    )as nom,
                    (SELECT
                            count(*) as frec
                        FROM
                            gestion_cliente gc
                        WHERE
                            gc.ges_cli_med = cli_tel_tel
                            and gc.cli_id_FK=cli_id_FK) as frec,
                    (SELECT
                            count(*)
                        FROM
                            gestion_cliente gc
                        INNER JOIN respuesta r on r.res_id=gc.res_id_FK
                        WHERE
                            gc.ges_cli_med = cli_tel_tel
                            and gc.cli_id_FK=cli_id_FK
                            and res_ubi=0) as ubi
                FROM
                    cliente_telefono ct
                WHERE
                    ct.cli_id_FK =$id
                    AND cli_tel_est <> 1
                    AND cli_tel_pas <> 1
                    ORDER BY ubi desc,frec desc
                )tel
        ";
        $query=DB::connection('mysql')->select(DB::raw($sql));
        return $query;
    }

    public static function insertarTelefonos(Request $rq){
        
        $telefono=$rq->telefono;
        $fec_actual=date("Y-m-d H:i:s");
        $id=$rq->id;
        //$id=121049517;
        $insertado = DB::connection('mysql')->insert("
            insert into cliente_telefono (cli_id_FK,cli_tel_tel,cli_tel_est,cli_tel_pas,valor,fecha_add)
            values ($id,'$telefono',0,0,' ','$fec_actual')
        ");

        return response()->json ($insertado);
    }
}

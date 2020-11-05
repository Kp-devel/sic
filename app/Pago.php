<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Pago extends Model
{
    public static function infoPagos($id){
            $sql="
                select 
                    pag_cli_pro as cuenta,
                    format(pag_cli_mon,2) as pagos,
                    pag_cli_fec as fecha
                from 
                    pago_cliente_2 as p
                inner join 
                    cliente as c on p.pag_cli_cod=c.cli_cod
                where 
                    cli_est=0 and cli_pas=0
                    AND cli_id=:id
                order by pag_cli_fec desc
            ";
   
        $query=DB::connection('mysql')->select(DB::raw($sql),array("id"=>$id));
        return $query;
    }
}

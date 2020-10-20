<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cartera extends Model
{
    protected $connection = 'mysql';

    public static function listCarteras(){
        return DB::connection('mysql')->select(DB::raw("
            select 
                car_id as id, 
                car_nom as cartera
            from cartera
            where car_est=0 and car_pas=0
        "));
    }

    public static function listCarterasUsuarioSMS(){
        return DB::connection('mysql')->select(DB::raw("
            select 
                car_id as id, 
                car_nom as cartera
            from cartera
            where car_est=0 and car_pas=0
            and car_id in (SELECT car_id_FK from creditoy_lotesms.empleado WHERE emp_est=0 and usu_FK=:usu)
        "),array("usu"=>auth()->user()->emp_cod));
    }

    public static function listCarterasUsuario(){
        $carteras=session()->get('datos')->idcartera;
        $sql="";
        if($carteras!=0){
            $sql="and car_id in ($carteras)";
        }

        return DB::connection('mysql')->select(DB::raw("
            select 
                car_id as id, 
                car_nom as cartera
            from cartera
            where car_est=0 and car_pas=0
            $sql
        "),array("usu"=>auth()->user()->emp_cod));
    }
}

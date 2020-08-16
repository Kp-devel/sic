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
}

<?php

namespace App\Imports;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;
use App\BitacoraAsignacion;

class AsignacionMultipleBaseImport implements ToModel, WithBatchInserts,WithChunkReading,ShouldQueue
{
    public function __construct($cod_operacion,$cartera)
    {
        $this->cod_operacion = $cod_operacion;
        $this->cartera = $cartera;
    }

    public function model(array $row)
    {
        return new BitacoraAsignacion([
            'bit_asig_codigo_FK'=> $this->cod_operacion,
            'bit_rep_cli_cod'=> $row[0],
            'bit_rep_emp_tel_cod'=> 0,
            'bit_rep_emp_cod_asig'=> $row[1],
            'bit_rep_estado'=> 0,
        ]);
    }
    
    public function batchSize(): int
    {
        return 300;
    }

    public function chunkSize(): int
    {
        return 300;
    }

    /*DB::connection('mysql')->select(DB::raw("
                                        SELECT emp_cod
                                        FROM
                                            creditoy_cobranzas.cliente c
                                        INNER JOIN creditoy_cobranzas.empleado e on c.emp_tel_id_FK=e.emp_id
                                        WHERE
                                        cli_est=0
                                        and cli_pas=0
                                        and car_id_FK=:car
                                        and cli_cod=:cod
                                        limit 1
                                    "),array("cod"=>$row[0],"car"=>$this->cartera))
                                    */
}

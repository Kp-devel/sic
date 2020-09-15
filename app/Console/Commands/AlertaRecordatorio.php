<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Recordatorio;
use App\Telefono;
use App\Gestion;
use App\Events\WebsocketsRecordatorio;

class AlertaRecordatorio extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recordatorio:alerta';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Visualizar recordatorios';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $datos=Recordatorio::listarRecordatorio();
        if(count($datos)>0){
            $telefonos=Telefono::infoTelefonos($datos[0]->id);
            $validacion_contacto=Gestion::validarContacto($datos[0]->id);
            $validacion_pdp=Gestion::validarPDP($datos[0]->id);

            $datosgenerales=['recordatorios'=>$datos,
                            'telefonos'=>$telefonos,
                            'validar_contacto'=>$validacion_contacto,
                            'pdps'=>$validacion_pdp
                            ];
            $success = event(new WebsocketsRecordatorio($datosgenerales));
            return $success;
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\controlLLamada;
use App\Cartera;
use Illuminate\Support\Facades\Storage;
// use League\Flysystem\Filesystem;
// use League\Flysystem\Sftp\SftpAdapter;

class ControlLLamadaController extends Controller
{
    public function panelcontrolllamadas(){
        $carteras=Cartera::listCarteras();
        $carteras=json_encode($carteras);
        return view('admin.controlLlamadas',compact('carteras'));
    }
    
    public function controlLLamadas(Request $rq){
        return controlLLamada::controlLLamadas($rq);
    }

    public function panelcontrolllamadasgestor(){
        $carteras=Cartera::listCarteras();
        $carteras=json_encode($carteras);
        return view('admin.controlLlamadasGestor',compact('carteras'));
    }

    public function controlLLamadasGestor(Request $rq){
        return controlLLamada::controlLLamadasGestor($rq);
    }

    public function llamarExtension(){

        $socket=@fsockopen("192.168.1.221","5038",$errno,$errstr,15);
        if ($socket === false) {  
            echo $errno." : ".$errstr;
        }  

        fputs($socket,"Action:Login\r\n");
        fputs($socket,"UserName:admin\r\n");
        fputs($socket,"Secret:cycadmin2020\r\n\r\n");
        // sleep(1);
        // fputs($socket,"Action:Originate\r\n");
        // fputs($socket,"Channel:SIP/1001\r\n");
        // fputs($socket,"Context:form-internal\r\n");
        // fputs($socket,"Exten:942515462\r\n");
        // fputs($socket,"Priority:1\r\n");
        // fputs($socket,"Timeout:30000\r\n\r\n");
        // fputs($socket,"Callerid:3001\r\n\r\n");
        // fputs($socket,"Action:ExtensionState\r\n");
        // fputs($socket,"Context:extensions\r\n");
        // fputs($socket,"Exten:1001\r\n\r\n");
        // sleep(1);
        fputs($socket,"Action:Command\r\n");
        fputs($socket,"Command:sip show channels\r\n\r\n");

        fputs($socket,"Action:Logoff\r\n\r\n");
        
        while(!feof($socket)){
            echo fgets($socket)."<br>";
            // echo fread($socket,8035)."<br>";
            // echo "ok";
        }
        // echo $array;
        // fclose($socket);
        

    }

    public function ftpArchivos(){
        // $filesystem = new Filesystem(new SftpAdapter([
        //     'host' => '192.168.1.29',
        //     'port' => 22,
        //     'username' => 'root',
        //     'password' => 'cycadmin2020',
        //     // 'privateKey' => 'path/to/or/contents/of/privatekey',
        //     // 'root' => '/path/to/root',
        //     'timeout' => 10,
        // ]));
        echo Storage::disk('sftp')->files('/');;
        // Storage::disk('sftp')->getAdapter()->disconnect();
        
    }
}

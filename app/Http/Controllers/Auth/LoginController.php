<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    
    use AuthenticatesUsers;

    protected $redirectTo = '/';
    
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request, $user)
    {        
        $sql=collect(DB::connection('mysql')->select(DB::raw("
            select 
                if(emp_tip_acc in (1,5,6),e.res_car_id_FK,c.car_id_FK) as idcartera,
                case when emp_tip_acc=1 then 'Supervisor'
                     when emp_tip_acc=2 then 'Call'
                     when emp_tip_acc=5 then 'Administrador'
                     when emp_tip_acc=6 then 'Sistemas'
                end as perfil
            from 
                empleado e
            LEFT JOIN cliente c ON c.emp_tel_id_FK=e.emp_id AND cli_est=0 and cli_pas=0 
            where 
                emp_id=:id
            and emp_est=0
            and emp_pas=0
            LIMIT 1
        "),array("id"=>auth()->user()->emp_id)));
        
        if($sql->isNotEmpty()){
            $user->setSession($sql->toArray());
        }else{
            $this->guard()->logout();
            $request->session()->invalidate();
            return redirect('login')->withErrors(['error'=>'Este usuario no se encuentra activo']);
        }

    }

    public function username(){
        return 'emp_cod';
    }

}

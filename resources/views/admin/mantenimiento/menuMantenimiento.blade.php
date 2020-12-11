<div>
    <p class="text-white-light mb-0 px-4 pt-4 font-13 py-3">Mantenimiento</p>
    <div class="menu-option">
        <!-- empleados -->
        <a href="#submenuEmpleado" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapseExample" class="d-flex justify-content-between px-4 waves-effect">
            <div>
                <i class="fa fa-user-tie pr-2"></i> Empleados
            </div>
           <i class="fa fa-angle-down pt-1"></i>
        </a>
        <div class="collapse" id="submenuEmpleado" class="bg-blue-bold">
            <a href="{{route('registrarempleado')}}" class="bg-blue-bold text- px-5 waves-effect {{ request()->is('registrarempleado') ? 'menu-active' : '' }}">Registrar Empleado</a>
            <a href="{{route('listaempleado')}}" class="bg-blue-bold text- px-5 waves-effect {{ request()->is('listaempleado') ? 'menu-active' : '' }}">Lista de Empleados</a>
        </div>
        <!-- getores -->
        <!-- <a href="#submenuGestor" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapseExample" class="d-flex justify-content-between px-4 waves-effect">
            <div>
                <i class="fa fa-users pr-2"></i>Gestores
            </div>
           <i class="fa fa-angle-down pt-1"></i>
        </a>
        <div class="collapse" id="submenuGestor" class="bg-blue-bold">
            <a href="{{route('smslistanegranumero')}}" class="bg-blue-bold text- px-5 waves-effect {{ request()->is('smslistanegranumero') ? 'menu-active' : '' }}">Registrar Gestor</a>
            <a href="{{route('smslistanegraarchivo')}}" class="bg-blue-bold text- px-5 waves-effect {{ request()->is('smslistanegraarchivo') ? 'menu-active' : '' }}">Lista de Gestores</a>
        </div> -->
        <!-- carteras -->
        <!-- <a href="{{route('sms')}}" class="px-4 waves-effect {{ request()->is('sms') ? 'menu-active' : '' }}"><i class="fa fa-map-marker-alt pr-2">_</i>Locales</a>
        <a href="{{route('sms')}}" class="px-4 waves-effect {{ request()->is('sms') ? 'menu-active' : '' }}"><i class="fa fa-folder pr-2"></i> Paletas</a>
        <a href="{{route('sms')}}" class="px-4 waves-effect {{ request()->is('sms') ? 'menu-active' : '' }}"><i class="fa fa-circle-notch pr-2"></i> Call</a>
        <a href="{{route('sms')}}" class="px-4 waves-effect {{ request()->is('sms') ? 'menu-active' : '' }}"><i class="fa fa-briefcase pr-2"></i> Carteras</a> -->

    </div>
</div>

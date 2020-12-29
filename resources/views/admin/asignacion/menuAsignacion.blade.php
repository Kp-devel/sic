<div>
    <p class="text-white-light mb-0 px-4 pt-4 font-13 py-3">Asignación de Usuarios</p>
    <div class="menu-option">
        <a href="{{route('reporteconfirmaciones')}}" class="px-4 waves-effect {{ request()->is('reporteconfirmaciones') ? 'menu-active' : '' }}"><i class="fa fa-user pr-2"></i> Asignación Individual</a>
        <a href="{{route('reportepdps')}}" class="px-4 waves-effect {{ request()->is('reportepdps') ? 'menu-active' : '' }}"><i class="fa fa-users pr-2"></i>Asignación Múltiple</a>
        <a href="{{route('intercambio')}}" class="px-4 waves-effect {{ request()->is('intercambio') ? 'menu-active' : '' }}"><i class="fa fa-exchange-alt pr-2"></i> Migración de Clientes</a>
        <!-- <a href="{{route('sms')}}" class="px-4 waves-effect {{ request()->is('sms') ? 'menu-active' : '' }}"><i class="fa fa-circle-notch pr-2"></i> Call</a>
        <a href="{{route('sms')}}" class="px-4 waves-effect {{ request()->is('sms') ? 'menu-active' : '' }}"><i class="fa fa-briefcase pr-2"></i> Carteras</a>  -->
    </div>
</div>

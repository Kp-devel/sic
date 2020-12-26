<div>
    <p class="text-white-light mb-0 px-4 pt-4 font-13 py-3">Reportes Generales</p>
    <div class="menu-option">
        <a href="{{route('reporteconfirmaciones')}}" class="px-4 waves-effect {{ request()->is('reporteconfirmaciones') ? 'menu-active' : '' }}"><i class="fa fa-coins pr-2"></i>Reporte Confirmaciones</a>
        <a href="{{route('reportepdps')}}" class="px-4 waves-effect {{ request()->is('reportepdps') ? 'menu-active' : '' }}"><i class="fa fa-handshake pr-2"></i>Reporte Pdps</a>
        <!-- <a href="{{route('sms')}}" class="px-4 waves-effect {{ request()->is('sms') ? 'menu-active' : '' }}"><i class="fa fa-circle-notch pr-2"></i> Call</a>
        <a href="{{route('sms')}}" class="px-4 waves-effect {{ request()->is('sms') ? 'menu-active' : '' }}"><i class="fa fa-briefcase pr-2"></i> Carteras</a>  -->
    </div>
</div>

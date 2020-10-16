<div>
    <p class="text-white-light mb-0 px-4 pt-4 font-13 py-3">Programación y Envío SMS</p>
    <div class="menu-option">
        <a href="#submenuEstructura" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapseExample" class="px-4 d-flex justify-content-between waves-effect {{ request()->is('sms') ? 'menu-active' : '' }}">
           <div>
                <i class="fa fa-sitemap pr-2"></i>Estructuras
           </div>
           <i class="fa fa-angle-down pt-1"></i>
        </a>
        <div class="collapse" id="submenuEstructura" class="bg-blue-bold">
            <a href="{{route('estructuracartera')}}" class="bg-blue-bold text- px-5 waves-effect {{ request()->is('estructuracartera') ? 'menu-active' : '' }}">Por Cartera</a>
            <a href="{{route('estructuragestor')}}" class="bg-blue-bold text- px-5 waves-effect {{ request()->is('estructuragestor') ? 'menu-active' : '' }}">Por Gestor</a>
        </div>
        <a href="{{route('indicadoresoperativos')}}" class="px-4 waves-effect {{ request()->is('indicadoresoperativos') ? 'menu-active' : '' }}"><i class="fa fa-chart-line pr-2"></i>Indicadores Operativos</a>
        <a href="#submenuPlan" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapseExample" class="d-flex justify-content-between px-4 waves-effect {{ request()->is('smscampanas') ? 'menu-active' : '' }}">
            <div>
                <i class="fa fa-layer-group pr-2"></i>Plan de Trabajo
            </div>
           <i class="fa fa-angle-down pt-1"></i>
        </a>
        <div class="collapse" id="submenuPlan" class="bg-blue-bold">
            <a href="{{route('crearplantrabajo')}}" class="bg-blue-bold text- px-5 waves-effect {{ request()->is('crearplantrabajo') ? 'menu-active' : '' }}">Crear Plan</a>
            <a href="{{route('seguimientoplantrabajo')}}" class="bg-blue-bold text- px-5 waves-effect {{ request()->is('seguimientoplantrabajo') ? 'menu-active' : '' }}">Seguimiento</a>
        </div>
        <!-- <a href="" class="px-4 waves-effect {{ request()->is('reportegeneral') ? 'menu-active' : '' }}"><i class="fa fa-list-alt pr-2"></i>Reporte General</a> -->
        <a href="#submenureporte" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapseExample" class="d-flex justify-content-between px-4 waves-effect {{ request()->is('smscampanas') ? 'menu-active' : '' }}">
            <div>
                <i class="fa fa-list-alt pr-2"></i>Reportes
            </div>
           <i class="fa fa-angle-down pt-1"></i>
        </a>
        <div class="collapse" id="submenureporte" class="bg-blue-bold">
            <a href="{{route('reportegeneral')}}" class="bg-blue-bold text- px-5 waves-effect {{ request()->is('reportegeneral') ? 'menu-active' : '' }}">Reporte General</a>
            <a href="{{route('reportegestor')}}" class="bg-blue-bold text- px-5 waves-effect {{ request()->is('reportegestor') ? 'menu-active' : '' }}">Gest. Telefónica por Gestor</a>
        </div>
    </div>
</div>

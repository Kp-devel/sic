<div>
    <p class="text-white-light mb-0 px-4 pt-4 font-13 py-3">Programación y Envío SMS</p>
    <div class="menu-option">
        <a href="{{route('sms')}}" class="px-4 waves-effect {{ request()->is('sms') ? 'menu-active' : '' }}"><i class="fa fa-desktop pr-2"></i>Panel de Control</a>
        <a href="{{route('smscrearcampana')}}" class="px-4 waves-effect {{ request()->is('smscrearcampana') ? 'menu-active' : '' }}"><i class="fa fa-plus pr-2"></i>Crear Campaña</a>
        <a href="{{route('smscampanas')}}" class="px-4 waves-effect {{ request()->is('smscampanas') ? 'menu-active' : '' }}"><i class="fa fa-sms pr-2"></i>Lista de Campañas</a>
        <a href="{{route('smsbandeja')}}" class="px-4 waves-effect {{ request()->is('smsbandeja') ? 'menu-active' : '' }}"><i class="fa fa-envelope pr-2"></i>Bandeja de Entrada</a>                
        <!-- <a href="" class="px-4 waves-effect {{ request()->is('smsbandeja') ? 'menu-active' : '' }}"><i class="fa fa-chart-pie pr-2"></i>Reportes</a>                 -->
    </div>
</div>

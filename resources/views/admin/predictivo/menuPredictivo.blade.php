<div>
    <p class="text-white-light mb-0 px-4 pt-4 font-13 py-3">Predictivo</p>
    <div class="menu-option">
        <a href="{{route('crearpredictivo')}}" class="px-4 waves-effect {{ request()->is('crearpredictivo') ? 'menu-active' : '' }}"><i class="fa fa-plus pr-2"></i>Crear Campaña</a>
        <a href="{{route('smscrearcampana')}}" class="px-4 waves-effect {{ request()->is('smscrearcampana') ? 'menu-active' : '' }}"><i class="fa fa-list pr-2"></i>Lista de Campañas</a>
    </div>
</div>

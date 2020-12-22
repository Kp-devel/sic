@extends('admin.panel')

@section('menu')
    @include('admin.mantenimiento.menuMantenimiento')
@endsection

@section('panel-contenido')  
    <div class="px-4">
        <div class="d-flex">
            <i class="fa fa-users pr-2 fa-lg pt-3 text-green"></i>
            <div>
                <p class="subheader-title mb-0">Lista de Gestores</p>
                <p class="mb-0">Detalle</p>
            </div>
        </div>
        <div class="py-3">
            <lista-gestores
            :carteras="{{$carteras}}"
            :usuarios="{{$usuarios}}"
            :gestores="{{$gestores}}"
            />
        </div>
    </div>         
@endsection


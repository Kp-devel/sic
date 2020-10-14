@extends('admin.panel')

@section('menu')
    @include('admin.indicadores.menuIndicadores')
@endsection

@section('panel-contenido')  
    <div class="px-4">
        <div class="d-flex">
            <i class="fa fa-sitemap pr-2 fa-lg pt-3 text-green"></i>
            <div>
                <p class="subheader-title mb-0">Estructuras</p>
                <p class="mb-0">Por Gestor</p>
            </div>
        </div>
        <div class="py-3">
            <estructura-gestor :carteras="{{$carteras}}" />
        </div>
    </div>         
@endsection

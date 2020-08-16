@extends('admin.menuAdmin')

@section('panel-contenido')           
    <div class="contenedor">
        <control-llamadas-gestor :carteras="{{$carteras}}"/>
    </div>
@endsection

@extends('admin.menuAdmin')

@section('panel-contenido')           
    <div class="contenedor">
        <control-llamadas :carteras="{{$carteras}}"/>
    </div>
@endsection
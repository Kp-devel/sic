@extends('layouts.app')

@section('content')
<div class="row justify-content-left">
    <div class="col-md-6 mt-2">
        <!-- card -->
        <div class="card">
            <div class="card-body" style="background:#B0C4DE;">
                <div class="form-group row">
                    <div>
                        <i class="fas fa-user-circle fa-2x" style="color:#191970;" aria-hidden="true"></i>
                    </div>
                    <div>
                        <button class="px-2" style="background:#191970;border-radius: 20px;border:none; color:#FFFFFF">
                            <b>Listado de Clientes</b>
                        </button>
                    </div>
                </div>
                <div class="form-group row">
                        <label for="gestor" class="text-righ mr-2 mt-1"><b>Código</b></label>
                        <input type="text" style="border-radius: 10px;border:none;">
                        <label for="gestor" class="text-righ mt-1 ml-4 mr-2"><b>DNI/RUC</b></label>
                        <input type="text" style="border-radius: 10px;border:none;">
                </div>
                <div class="form-group row">
                    <label for="gestor" class="text-righ mt-1 mr-2"><b>Nombre</b></label>
                    <input type="text" style="border-radius: 10px;border:none;width:400px;">
                </div>
            </div>
        </div>
        
    </div>
</div>

@endsection

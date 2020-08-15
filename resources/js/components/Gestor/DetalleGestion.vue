<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-fondo">
                    <div class="card-body card-borde">
                        <div  class="row">
                            <div class="col-md-12 my-0 py-0">
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered">
                                        <thead class="cab-fondo">
                                            <th>Codigo</th>
                                            <th>Nombre</th>
                                            <th>DNI/RUC</th>
                                            <th>Capital</th>
                                            <th>Deuda</th>
                                            <th>IC</th>
                                            <th>Medio</th>
                                            <th>Producto</th>
                                            <th>Ult.Rpta</th>
                                        </thead>
                                        <tbody class="body-fondo">
                                            <tr>
                                                <td>1</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div  class="row">
                            <div class="col-md-5 my-0 py-0">
                                <div class="row my-0 py-0 justify-content-left">
                                    <div class="col-md-12 my-0 py-0">
                                        <button class="btn btn-azul">REGISTRO DE GESTIÓN</button>
                                    </div>
                                </div>
                                <div class="row my-0 py-0 mt-1">
                                    <div class="col-md-6 my-0 py-0">
                                        <label for="" class="text-righ"><b>Teléfono</b></label>
                                        <input type="text" class="form-control input-xs">
                                    </div>
                                    <div class="col-md-6 my-0 py-0">
                                        <label for="" class="text-righ"><b>Fecha PDP</b></label>
                                        <input type="text" class="form-control input-xs">
                                    </div>
                                </div>
                                <div class="row my-0 py-0 mt-1">
                                    <div class="col-md-6 my-0 py-0">
                                        <label for="" class="text-righ"><b>Ubicabilidad</b></label>
                                        <input type="text" class="form-control input-xs">
                                    </div>
                                    <div class="col-md-6 my-0 py-0">
                                        <label for="" class="text-righ"><b>Monto PDP</b></label>
                                        <input type="text" class="form-control input-xs">
                                    </div>
                                </div>
                                <div class="row my-0 py-0">
                                    <div class="col-md-8 my-0 py-0">
                                        <label for="" class="text-righ"><b>Respuesta</b></label>
                                        <input type="text" class="form-control input-xs">
                                    </div>
                                    <div class="col-md-4 my-0 py-0">
                                        <label for="" class="text-righ"><b>Moneda</b></label>
                                        <input type="text" class="form-control input-xs">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7 my-0 py-0">
                                <div class="row mt-4 py-0">
                                    <div class="col-md-12 my-0 py-0">
                                        <label for="" class="text-righ"><b>Detalle de Gestión</b></label>
                                        <textarea class="form-control input-xs" rows="4" cols="50"></textarea>
                                    </div>
                                </div>
                                <div class="row my-0 py-0">
                                    <div class="col-md-4 my-0 py-0">
                                        <div class="form-inline">
                                            <div class="form-group">
                                                <label for="" class="text-righ"><b>Recordatorio</b></label>
                                                <input type="checkbox" class="form-control input-xs ml-1">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 my-0 py-0">
                                        <label for="" class="text-righ"><b>Fecha</b></label>
                                        <input type="text" class="form-control input-xs">
                                    </div>
                                    <div class="col-md-4 my-0 py-0">
                                        <label for="" class="text-righ"><b>Hora</b></label>
                                        <input type="text" class="form-control input-xs">
                                    </div>
                                </div>
                                
                            </div>
                        </div>

                        <div  class="row justify-content-center mt-1">
                            <div class=" my-2 my-0 py-0">
                                <button class="btn btn-azul ml-2 boton-xs">Registrar</button>
                                <button class="btn btn-azul ml-2 boton-xs">Reprogramar</button>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<template>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 pr-1">
            <div class="card card-fondo">
                <div class="card-header card-borde rounded d-flex justify-content-left">
                    <div><i class="fas fa-user-circle fa-4x" style="color:#325CA6;"></i></div>
                    <button class="btn btn-azul ml-2">LISTADO DE CLIENTES</button>
                </div>
                <div class="card-body my-0 py-0">
                    <div class="row my-0 py-0">
                        <div class="col-md-6 my-0 py-0">
                                <label for="" class="text-righ"><b>Código</b></label>
                                <input type="text" class="form-control input-xs">
                        </div>
                        <div class="col-md-6 my-0 py-0">
                                <label for="" class="text-righ"><b>Dni/Ruc</b></label>
                                <input type="text" class="form-control input-xs">
                        </div>
                    </div>
                    <div class="row my-0 py-0">
                        <div class="col-md-12 my-0 py-0">
                                <label for="" class="text-righ"><b>Nombre</b></label>
                                <input type="text" class="form-control input-xs">
                        </div>
                    </div>
                    <div class="row my-0 py-0">
                        <div class="col-md-6 my-0 py-0">
                                <label for="" class="text-righ"><b>Teléfono</b></label>
                                <input type="text" class="form-control input-xs">
                        </div>
                        <div class="col-md-6 my-0 py-0">
                                <label for="" class="text-righ"><b>Tramo</b></label>
                                <input type="text" class="form-control input-xs">
                        </div>
                    </div>
                    <div class="row my-0 py-0">
                        <div class="col-md-12 my-0 py-0">
                                <label for="" class="text-righ"><b>Ult.Gestión</b></label>
                                <input type="text" class="form-control input-xs">
                        </div>
                    </div>
                    <div class="row my-0 py-0">
                        <div class="col-md-6 my-0 py-0">
                                <label for="" class="text-righ"><b>PDP Desde</b></label>
                                <input type="text" class="form-control input-xs">
                        </div>
                        <div class="col-md-6 my-0 py-0">
                                <label for="" class="text-righ"><b>PDP Hasta</b></label>
                                <input type="text" class="form-control input-xs">
                        </div>
                    </div>
                    <div class="row my-0 py-0">
                        <div class="col-md-6 my-0 py-0">
                                <label for="" class="text-righ"><b>Ordenar</b></label>
                                <input type="text" class="form-control input-xs">
                        </div>
                        <div class="col-md-6 my-0 py-0">
                                <label for="" class="text-righ"><b>Listar Campaña</b></label>
                                <input type="text" class="form-control input-xs">
                        </div>
                    </div>
                    <div class="row d-flex justify-content-center">
                        <div class="d-flex justify-content-center my-2 my-0 py-0">
                            <button class="btn btn-azul ml-2 boton-xs">
                                Buscar
                            </button>
                            <button class="btn btn-azul ml-2 boton-xs">Limpiar</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-fondo mt-2">
                <div class="card-header card-borde rounded d-flex justify-content-left">
                    <div><i class="fas fa-user-circle fa-4x" style="color:#325CA6;"></i></div>
                    <button class="btn btn-azul ml-2">DATOS DEL MES</button>
                </div>
                <div class="card-body my-0 py-0">
                    <div class="row my-0 py-0">
                        <div class="col-md-8 my-0 py-0">
                                <label for="" class="text-righ">META ASIGNADA</label>
                        </div>
                        <div class="col-md-4 my-0 py-0">
                                <label for="" class="text-righ">S/.50,000</label>
                        </div>
                    </div>
                    <div class="row my-0 py-0">
                        <div class="col-md-8 my-0 py-0">
                                <label for="" class="text-righ">RECUPERO AL 15</label>
                        </div>
                        <div class="col-md-4 my-0 py-0">
                                <label for="" class="text-righ">S/.25,000</label>
                        </div>
                    </div>
                    <div class="row my-0 py-0">
                        <div class="col-md-8 my-0 py-0">
                                <label for="" class="text-righ">ALCANCE DE META</label>
                        </div>
                        <div class="col-md-4 my-0 py-0">
                                <label for="" class="text-righ">50%</label>
                        </div>
                    </div>
                    <div class="row my-0 py-0">
                        <div class="col-md-8 my-0 py-0">
                                <label for="" class="text-righ">EFECTIVIDAD SOBRE PDPS</label>
                        </div>
                        <div class="col-md-4 my-0 py-0">
                                <label for="" class="text-righ">65%</label>
                        </div>
                    </div>
                    <div class="row my-0 py-0">
                        <div class="col-md-8 my-0 py-0">
                                <label for="" class="text-righ">PDPS CAÍDAS(S/.)</label>
                        </div>
                        <div class="col-md-4 my-0 py-0">
                                <label for="" class="text-righ">S/.11,000</label>
                        </div>
                    </div>
                    <div class="row my-0 py-0">
                        <div class="col-md-8 my-0 py-0">
                                <label for="" class="text-righ">PDPS PENDIENTES(S/.)</label>
                        </div>
                        <div class="col-md-4 my-0 py-0">
                                <label for="" class="text-righ">S/.33,000</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-fondo mt-2">
                <div class="card-header card-borde rounded d-flex justify-content-left">
                    <div><i class="fas fa-user-circle fa-4x" style="color:#325CA6;"></i></div>
                    <button class="btn btn-azul ml-2">ESTÁNDAR</button>
                </div>
                <div class="card-body my-1 py-1">
                    <div class="row d-flex justify-content-left">
                        <div class="col-md-3 my-0 py-0">
                            <input type="text" class="form-control input-xs">
                        </div>
                        <div class="col-md-4 my-0 py-0">
                            <button class="btn btn-azul boton-xs">Consultar</button>
                        </div>
                    </div>
                    <div class="row my-0 py-0">
                        <div class="col-md-8 my-0 py-0">
                                <label for="" class="text-righ">GESTIONES</label>
                        </div>
                        <div class="col-md-4 my-0 py-0">
                                <label for="" class="text-righ">200</label>
                        </div>
                    </div>
                    <div class="row my-0 py-0">
                        <div class="col-md-8 my-0 py-0">
                                <label for="" class="text-righ">CONTACTOS</label>
                        </div>
                        <div class="col-md-4 my-0 py-0">
                                <label for="" class="text-righ">40</label>
                        </div>
                    </div>
                    <div class="row my-0 py-0">
                        <div class="col-md-8 my-0 py-0">
                                <label for="" class="text-righ">CONTACTABILIDAD</label>
                        </div>
                        <div class="col-md-4 my-0 py-0">
                                <label for="" class="text-righ">20%</label>
                        </div>
                    </div>
                    <div class="row my-0 py-0">
                        <div class="col-md-8 my-0 py-0">
                                <label for="" class="text-righ">PDPS</label>
                        </div>
                        <div class="col-md-4 my-0 py-0">
                                <label for="" class="text-righ">2</label>
                        </div>
                    </div>
                    <div class="row my-0 py-0">
                        <div class="col-md-8 my-0 py-0">
                                <label for="" class="text-righ">MONTO PDPS</label>
                        </div>
                        <div class="col-md-4 my-0 py-0">
                                <label for="" class="text-righ">S/.1,000</label>
                        </div>
                    </div>
                    <div class="row my-0 py-0">
                        <div class="col-md-8 my-0 py-0">
                                <label for="" class="text-righ">MONTO CONFIRMACIONES</label>
                        </div>
                        <div class="col-md-4 my-0 py-0">
                                <label for="" class="text-righ">S/.1,500</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-9 pl-1">
            <div class="card bg-gray">
                <div class="card-body px-1 pt-1">
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
                                <tr>
                                    <td>2</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>4</td>
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
        </div>
    </div>
</div>
</template>
<template>
    <div>
        <div class="modal fade slideInDown" id="modal-recordatorio" 
        tabindex="-1" role="dialog"  aria-hidden="true">
            <div class="modal-dialog modal-dialog-top" role="document">
                <div class="modal-content " >
                    <div class="modal-body overflow-auto px-3 bg-gray-2 pb-0">
                        <div class="table-responsive" id="table-recordatorios">
                            <table class="table table-hover">
                                <thead class="bg-blue text-white text-center">
                                    <tr>
                                        <td class="align-middle">CODIGO</td>
                                        <td class="align-middle">NOMBRE</td>
                                        <td class="align-middle">DNI/RUC</td>
                                        <td class="align-middle">CAPITAL</td>
                                        <td class="align-middle">DEUDA</td>
                                        <td class="align-middle">IC</td>
                                        <td class="align-middle">MEDIO</td>
                                        <td class="align-middle">PRODUCTO</td>
                                        <td class="align-middle">ULT. RPTA</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="text-center">
                                        <td>1</td>
                                        <td>1</td>
                                        <td>1</td>
                                        <td>1</td>
                                        <td>1</td>
                                        <td>1</td>
                                        <td>1</td>
                                        <td>1</td>
                                        <td>1</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- formulario de registro -->
                        <formRegistrarGestion :idCliente="datos.idCLiente" :tipo="2"/>
                    </div>
                    <div class="modal-footer text-center py-0">
                        <a href="" class="close btn btn-block" data-dismiss="modal" aria-label="Close">
                            <span class="fa fa-chevron-up"></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import formRegistrarGestion from './FormRegistrarGestion';
    export default {
        data() {
            return {
                datos:{telefono:'',idCLiente:0},
                mensajeError:'',
            }
        },
        methods:{
            
        },
        components:{
            formRegistrarGestion
        }
    }
</script>

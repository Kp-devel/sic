<template>
    <div>
        <div class="modal fade slideInDown" id="modal-recordatorio" 
        tabindex="-1" role="dialog"  aria-hidden="true">
            <div class="modal-dialog modal-dialog-top" role="document">
                <div class="modal-content " >
                    <div class="modal-body px-3 bg-gray-2 pb-0" v-if="recordatorio==''">
                        <div class="d-flex justify-content-center py-5">
                            <div class="text-center">
                                <i class="fa fa-clock fa-2x text-blue"></i><br>
                                <p class="font-15 pt-1">No tiene recordatorios pendientes</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body overflow-auto px-3 bg-gray-2 pb-0" v-else>
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
                                        <td>{{recordatorio[0].codigo}}</td>
                                        <td>{{recordatorio[0].nombre}}</td>
                                        <td>{{recordatorio[0].dni}}</td>
                                        <td>{{recordatorio[0].capital}}</td>
                                        <td>{{recordatorio[0].deuda}}</td>
                                        <td>{{recordatorio[0].importe}}</td>
                                        <td>{{recordatorio[0].telefono}}</td>
                                        <td>{{recordatorio[0].producto}}</td>
                                        <td>{{recordatorio[0].ult_resp}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- gestiones -->
                        <div class="pr-2">
                            <div class="d-flex">
                                <p class=" badge bg-blue text-white py-2 px-3 min-w-125 text-left">HISTÓRICO GESTIONES</p>
                            </div>
                            <detalleGestiones :idCliente="recordatorio[0].id" :historico="historicoGestiones[0]" v-if="historicoGestiones"/>
                        </div>
                        <!-- formulario de registro -->
                        <formRegistrarGestion  :idCliente="recordatorio[0].id" :tipo="2" :telrecordatorio="recordatorio[0].tel_prog" :telefonosgenerales="telRecordatorio[0]" :valcontacto="contacto[0]" :datospdp="pdps[0]"/>
                        
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
    import detalleGestiones from './DetalleGestiones';
    export default {
        props:['recordatorio','telRecordatorio','pdps','contacto','historicoGestiones'],
        data() {
            return {
            
            }
        },
        methods:{

        },
        components:{
            formRegistrarGestion,
            detalleGestiones
        },
    }
</script>

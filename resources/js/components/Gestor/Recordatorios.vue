<template>
    <div>
        <div class="modal fade slideInDown" id="modal-recordatorio" 
        tabindex="-1" role="dialog"  aria-hidden="true">
            <div class="modal-dialog modal-dialog-top" role="document">
                <div class="modal-content " >
                    <div class="modal-body px-3 bg-gray-2 pb-0" v-if="datos==''">
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
                                        <td>{{recordatorio.codigo}}</td>
                                        <td>{{recordatorio.nombre}}</td>
                                        <td>{{recordatorio.dni}}</td>
                                        <td>{{recordatorio.capital}}</td>
                                        <td>{{recordatorio.deuda}}</td>
                                        <td>{{recordatorio.ic}}</td>
                                        <td>{{recordatorio.medio}}</td>
                                        <td>{{recordatorio.producto}}</td>
                                        <td>{{recordatorio.ultres}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- formulario de registro -->
                        <formRegistrarGestion :idCliente="recordatorio.id" :tipo="2" :telrecordatorio="recordatorio.tel_rec" />
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
                datos:[],
                recordatorio:{id:'',codigo:'',nombre:'',dni:'',capital:'',deuda:'',ic:'',medio:'',producto:'',ultres:'',tel_rec:''}
            }
        },
        created(){
            this.listaRecordatorios();
        },
        methods:{
            listaRecordatorios(){
                axios.get("listarRecordatorio").then(res=>{
                    if(res.data){
                        this.datos=res.data;
                        this.recordatorio.codigo=this.datos[0].codigo;
                        this.recordatorio.nombre=this.datos[0].nombre;
                        this.recordatorio.dni=this.datos[0].dni;
                        this.recordatorio.capital=this.datos[0].capital;
                        this.recordatorio.deuda=this.datos[0].deuda;
                        this.recordatorio.ic=this.datos[0].importe;
                        this.recordatorio.producto=this.datos[0].producto;
                        this.recordatorio.medio=this.datos[0].telefono;
                        this.recordatorio.ultres=this.datos[0].ult_resp;
                        this.recordatorio.id=this.datos[0].id;
                        this.recordatorio.tel_rec=this.datos[0].tel_prog;
                    }
                })
            }
        },
        mounted() {
            this.$root.$on('listarRecordatorios',() => {
               this.listaRecordatorios();
            } );
        },
        components:{
            formRegistrarGestion
        },
    }
</script>

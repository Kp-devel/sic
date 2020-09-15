<template>
    <div>       
        <!-- btn recordatorios -->
         <div class="panel-top text-center">
             <!-- fa-sort-down -->
            <a href="" class="btn-up" data-toggle="modal" data-target="#modal-recordatorio" @click.prevent="verRecordatorios()">
                <i class="fa fa-clock fa-lg"></i>
                <i v-if="recordatorio!=''" class="fa fa-circle text-danger pt-3 pl-0" style="position:absolute;"></i>
            </a>
        </div>
        <recordatorio :recordatorio="recordatorio" :telRecordatorio="telRecordatorio" :pdps="pdpsRecordatorio" :contacto="contactoRecordatorio"/>
        <!-- lista de clientes y menu -->
        <clientes :userlogeado="userlogeado"/>
        <!-- detalle de cliente -->
        <div v-if="viewDetalleCliente==true" class="bg-white">
             <div class="panelEstandar">
                <div class="d-flex mx-3 justify-content-between">
                    <div class="d-flex">
                        <div class="pr-2 pt-1">
                            <i class="rounded-circle fa fa-user bg-blue text-white p-1"></i>
                        </div>
                        <p class="font-18 font-bold">{{dataCliente[0].nombre}}</p>
                    </div>
                    <div>
                        <a href="" @click.prevent="cerrarDetalle()" class="icono-bars waves-effect pb-2"><i class="fa fa-times"></i></a>
                    </div>
                </div>
                <!-- modal de carga -->
                <div class="panel-carga bg-white" v-if="loadCarga">
                    <div class="d-flex justify-content-center pt-5">
                        <div class="spinner-border text-blue" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>
                <!-- datos -->
                <div v-else>
                    <div class="row p-0 mx-0">
                        <!-- panel de informacion de clientes -->
                        <div class="col-md-4 border-blue">
                            <div class="d-flex">
                                <p class=" badge bg-blue text-white py-2 px-3 min-w-125 text-left">INFORMACIÓN DEL CLIENTE</p>
                            </div>
                            <detalleCliente :datos="dataCliente" v-if="dataCliente.length>0" :info="detalleGeneral['infoCliente']" />
                        </div>
                        <!-- panel de historico de gestiones -->
                        <div class="col-md-8">
                            <div class="d-flex">
                                <p class=" badge bg-blue text-white py-2 px-3 min-w-125 text-left">HISTÓRICO GESTIONES</p>
                            </div>
                            <detalleGestiones :idCliente="idCliente" v-if="dataCliente.length>0" :historico="detalleGeneral['gestiones']"/>
                        </div>
                    </div><br>
                    <!-- panel de informacion deuda-->
                    <div class="row p-0 mx-0 my-2">
                        <div class="col-md-12">
                            <div class="d-flex">
                                <p class=" badge bg-blue text-white py-2 px-3 min-w-125 text-left">INFORMACIÓN DE LA DEUDA</p>
                            </div> 
                            <detalleCuentas  v-if="dataCliente.length>0" :cuentas="detalleGeneral['cuentas']" />
                        </div>
                    </div>
                    <!-- panel de registro de gestion -->
                    
                    <formRegistrarGestion :id-cliente="idCliente" :tipo="1" :telefonosgenerales="detalleGeneral['telefonos']" :valcontacto="detalleGeneral['validar_contacto']"  :datospdp="detalleGeneral['pdps']" />
                    
                    <!-- botones laterales -->
                    <div class="btns-lateral">
                        <a href="#" class="btn-lateral bg-danger" data-toggle="modal" data-target="#modal-pagos"  @click.prevent="viewPagos=true"><label class="texto-vertical">PAGOS</label></a>
                        <!--acá por ejemplo -->
                        <a href="" data-toggle="modal" data-target="#modal-telefonos" class="btn-lateral" @click.prevent="verTelefonos()"><label class="texto-vertical">TELF</label></a>
                    </div>

                    <!-- panel de telefonos -->
                    <detalleTelefonos v-if="viewTelefonos" :idCliente="idCliente" :telefonospanel="this.detalleGeneral['telefonos']"/>
                    <!-- panel de pagos -->
                    <detallePagos v-if="viewPagos" :idCliente="idCliente"/>
                </div>
             </div>
        </div>
    </div>
</template>

<script>
    import clientes from './Clientes';
    import detalleCliente from './DetalleCliente';
    import detalleGestiones from './DetalleGestiones';
    import detalleCuentas from './DetalleCuentas';
    import formRegistrarGestion from './FormRegistrarGestion';
    import detalleTelefonos from './DetalleTelefonos';
    import detallePagos from './DetallePagos';
    import recordatorio from './Recordatorios';
    
    export default {
        props:["userlogeado"],
        data() {
            return {
                viewDetalleCliente:false,
                viewTelefonos:false,
                viewPagos:false,
                dataCliente:[],
                detalleGeneral:[],
                idCliente:'',
                loadCarga:false,
                recordatorio:[],
                telRecordatorio:[],
                pdpsRecordatorio:[],
                contactoRecordatorio:[],
                // viewalerta:'false'
            }
        },
        created(){
            this.verRecordatorios();
        },
        methods:{
            cerrarDetalle(){
                this.viewDetalleCliente=false;
                this.detalleGeneral=[];
                $('#contenidoLista').toggleClass('pos_fixed');
            },       
            verTelefonos(){
                this.viewTelefonos=true;
                this.$root.$emit('limpiarFrmTel');
            },
            verRecordatorios(){
                // this.viewalerta='false';
                this.recordatorio=[];
                this.telRecordatorio=[];
                this.pdpsRecordatorio=[];
                this.contactoRecordatorio=[];
                axios.get("listarRecordatorio");
            },
            telefonosRecordatorio(tel){
                this.$root.$emit('telefonosRecordatorio',tel); 
            },
            datosgenerales(id){
                this.loadCarga=true;
                this.detalleGeneral=[];
                axios.get("detalleCliente/"+id).then(res=>{
                    if(res.data){
                        this.detalleGeneral=res.data;
                        this.loadCarga=false;
                    }
                })
                
            }
        },
        mounted() {
            this.$root.$on('verDetalle', (datos) => {
                this.dataCliente=datos;
                this.idCliente=datos[0].id;
                this.viewDetalleCliente=true;
                this.datosgenerales(this.idCliente);
                // $('html, body').animate({scrollTop:0}, 'slow');
            } );

            // websocktes
            var pusher = new Pusher('2e767ae318879ba2da40', {
                cluster: 'us2'
            });
            const this2=this
            var channel = pusher.subscribe('channel-recordatorio');
            channel.bind('evento-recordatorio', function(data) {
                    this2.recordatorio=[];
                    this2.telRecordatorio=[];
                    this2.pdpsRecordatorio=[];
                    this2.contactoRecordatorio=[];
                    // this2.viewalerta='true';
                    const recordatorio=this2.recordatorio;
                    const telRecordatorio=this2.telRecordatorio;
                    const pdpsRecordatorio=this2.pdpsRecordatorio;
                    const contactoRecordatorio=this2.contactoRecordatorio;
                    // const viewalerta=this2.viewalerta;
                
                    if(data){
                        recordatorio.push(data.data['recordatorios'][0]);
                        telRecordatorio.push(data.data['telefonos']);   
                        pdpsRecordatorio.push(data.data['pdps']);   
                        contactoRecordatorio.push(data.data['validar_contacto']);   
                        toastr.success('Los recordatorios sólo se encuentran disponibles 5min déspues de su hora de programada', 'Tienes un recordatorio activo',{"progressBar": true,"positionClass": "toast-bottom-right",});
                    }
            });
        },
        components:{
            clientes,
            detalleCliente,
            detalleGestiones,
            detalleCuentas,
            formRegistrarGestion,
            detalleTelefonos,
            detallePagos,
            recordatorio
        }
    }
</script>

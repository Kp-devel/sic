<template>
    <div>       
        <!-- btn recordatorios -->
         <div class="panel-top text-center">
             <!-- fa-sort-down -->
            <a href="" class="btn-up" data-toggle="modal" 
            data-target="#modal-recordatorio" @click.prevent="verRecordatorios()"><i class="fa fa-clock fa-lg"></i></a>
        </div>
        <recordatorio :cliente="dataCliente[0]"/>
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
                <div class="row p-0 mx-0">
                    <!-- panel de informacion de clientes -->
                    <div class="col-md-4">
                        <div class="d-flex">
                            <p class=" badge bg-blue text-white py-2 px-3 min-w-125 text-left">INFORMACIÓN DEL CLIENTE</p>
                        </div>
                        <detalleCliente :datos="dataCliente"/>
                    </div>
                    <!-- panel de historico de gestiones -->
                    <div class="col-md-8">
                        <div class="d-flex">
                            <p class=" badge bg-blue text-white py-2 px-3 min-w-125 text-left">HISTÓRICO GESTIONES</p>
                        </div>
                         <detalleGestiones :idCliente="idCliente" v-if="dataCliente.length>0"/>
                    </div>
                </div>
                <!-- panel de informacion deuda-->
                 <div class="row p-0 mx-0 my-2">
                    <div class="col-md-12">
                        <div class="d-flex">
                            <p class=" badge bg-blue text-white py-2 px-3 min-w-125 text-left">INFORMACIÓN DE LA DEUDA</p>
                        </div> 
                        <detalleCuentas :idCliente="idCliente" v-if="dataCliente.length>0"/>
                    </div>
                 </div>
                 <!-- panel de registro de gestion -->
                 <div v-if="dataCliente.length>0">
                    <formRegistrarGestion :id-cliente="idCliente" :tipo="1"/>
                 </div>
                 <!-- botones laterales -->
                 <div class="btns-lateral">
                    <a href="#" class="btn-lateral bg-danger" data-toggle="modal" data-target="#modal-pagos"><label class="texto-vertical">PAGOS</label></a>
                    <!--acá por ejemplo -->
                    <a href="" data-toggle="modal" data-target="#modal-telefonos" class="btn-lateral" @click.prevent="verTelefonos()"><label class="texto-vertical">TELF</label></a>
                 </div>

                 <!-- panel de telefonos -->
                 <detalleTelefonos :idCliente="idCliente"/>
                 <!-- panel de pagos -->
                 <detallePagos :idCliente="idCliente"/>
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
                dataCliente:[],
                idCliente:''
            }
        },
        created(){
            
        },
        methods:{
            cerrarDetalle(){
                this.viewDetalleCliente=false;
                $('#contenidoLista').toggleClass('pos_fixed');
            },       
            verTelefonos(){
                this.$root.$emit('limpiarFrmTel');
                //$('#modal-telefonos').modal();
            },
            verRecordatorios(){
                this.$root.$emit('listarRecordatorios');
                //$('#modal-recordatorio').modal();
            }
        },
        mounted() {
            this.$root.$on ('verDetalle', (datos) => {
                this.dataCliente=datos;
                this.idCliente=datos[0].id;
                this.viewDetalleCliente=true;
                // $('html, body').animate({scrollTop:0}, 'slow');
            } );
        },
        // updated(){
        //     // this.$nextTick(function(){
        //         $('[data-toggle="tooltip"]').tooltip();
        //     // })
        // },
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

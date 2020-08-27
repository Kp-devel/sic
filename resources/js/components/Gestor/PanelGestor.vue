<template>
    <div>
        <!-- btn recordatorios -->
         <div class="panel-top text-center">
             <!-- fa-sort-down -->
            <a href="" class="btn-up" @click.prevent="verRecordatorios()"><i class="fa fa-clock fa-lg"></i></a>
        </div>
        <recordatorio/>
        <!-- lista de clientes y menu -->
        <clientes/>
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
                         <detalleGestiones/>
                    </div>
                </div>
                <!-- panel de informacion deuda-->
                 <div class="row p-0 mx-0 my-2">
                    <div class="col-md-12">
                        <div class="d-flex">
                            <p class=" badge bg-blue text-white py-2 px-3 min-w-125 text-left">INFORMACIÓN DE LA DEUDA</p>
                        </div> 
                        <detalleCuentas/>
                    </div>
                 </div>
                 <!-- panel de registro de gestion -->
                 <div>
                    <formRegistrarGestion/>
                 </div>
                 <!-- botones laterales -->
                 <div class="btns-lateral">
                    <a href="#" class="btn-lateral bg-danger" @click.prevent="verPagos()"><label class="texto-vertical">PAGOS</label></a>
                    <a href="#" class="btn-lateral" @click.prevent="verTelefonos()"><label class="texto-vertical">TELF</label></a>
                 </div>

                 <!-- panel de telefonos -->
                 <detalleTelefonos/>
                 <!-- panel de pagos -->
                 <detallePagos/>
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
        data() {
            return {
                viewDetalleCliente:false,
                dataCliente:0
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
                $('#modal-telefonos').modal();
            },
            verPagos(){
                $('#modal-pagos').modal();
            },
            verRecordatorios(){
                $('#modal-recordatorio').modal();
            }
        },
        mounted() {
            this.$root.$on ('verDetalle', (datos) => {
                this.viewDetalleCliente=true;
                this.dataCliente=datos;
                // $('html, body').animate({scrollTop:0}, 'slow');
            } );
        },
        updated(){
            $('[data-toggle="tooltip"]').tooltip();
            // $('#mensaje').tooltip();
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

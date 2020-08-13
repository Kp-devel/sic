<template>
    <div class="">
        <!-- modal de carga -->
        <div  class="modal" tabindex="-1" role="dialog" id="modalCarga">
            <div class="text-center p-5 m-5 d-flex justify-content-center">
                <div class="spinner-border text-center text-white" style="width: 3rem; height: 3rem;" role="status">
                    <span class="sr-only text-white">Cargando...</span>
                </div>
                <!-- <spinner  :loading = "loadingModal" :color="color" :size="size" > </spinner> -->
            </div>
        </div>
        <!-- end modal de carga -->

        <div v-if="view_carga==true" class="d-flex justify-content-center pt-5">
            <div class="spinner-border text-center text-white" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only text-white">Cargando...</span>
            </div>
        </div>

        <div v-if="view_detalle==false && view_carga==false">
            <!-- busqueda -->
            <div class="row mx-0 p-5">
                <div class="col-md-4 offset-md-4">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Buscar por código del cliente" v-model="buscar_codigo"  @keyup="buscar(buscar_codigo)">
                        <a href="" class="input-group-append  p-0" @click.prevent="buscar(buscar_codigo)">
                            <span class="input-group-text bg-turquesa text-white"><i class="fa fa-search"></i></span>
                        </a>
                        <a href="#" class="px-2 rounded mx-2 px-1 pt-1 item-menu" data-toggle="modal" data-target="#busqueda-avanzada">
                            <i class="fa fa-expand fa-2x"></i>
                        </a>
                    </div>
                </div>
            </div> 
            <!-- endbusqueda -->
            <!-- contenido -->
            <div class="mx-4 card-contenedor">
                <div class="card-header bg-gray rounded d-flex justify-content-between">
                    <p class="font-15 mb-0"><i class="far fa-user pr-2"></i>{{formatoCant(total_clientes)}}</p>
                    <div class="d-flex">
                        <a href=""><i class="fa fa-sort-amount-up fa-lg text-dark"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                            <paginate name="paginar" :list="clientes" :per="20" class="p-0">
                                <table class="table table-hover">
                                        <tbody>
                                            <tr v-for="(item,index) in paginated('paginar')" :key="index">
                                                <td><i class="rounded-circle far fa-user p-2 text-white" :class="'bg-'+item.bg"></i></td>
                                                <td><p class="mb-0">{{item.codigo}}</p><small class="font-weight-bold mt-0 pt-0">Código</small></td>
                                                <td><p class="mb-0">{{item.cliente}}</p><small class="font-weight-bold mt-0 pt-0">Cliente</small></td>
                                                <td><p class="mb-0">{{item.dni}}</p><small class="font-weight-bold mt-0 pt-0">DNI</small></td>
                                                <td><p class="mb-0">S/.{{formatoMonto(item.capital)}}</p><small class="font-weight-bold mt-0 pt-0">Deuda Capital</small></td>
                                                <td><p class="mb-0">S/.{{formatoMonto(item.deuda)}}</p><small class="font-weight-bold mt-0 pt-0">Saldo Moroso Total</small></td>
                                                <td><p class="mb-0">S/.{{formatoMonto(item.importe)}}</p><small class="font-weight-bold mt-0 pt-0">Importe Canc. Total</small></td>
                                                <td><p class="mb-0">{{item.oficina}}</p><small class="font-weight-bold mt-0 pt-0">Oficina</small></td>
                                                <td><p class="mb-0">{{item.ult_gestion}}</p><small class="font-weight-bold mt-0 pt-0">Última Gestión</small></td>
                                                <td><p class="mb-0">{{item.fecha_pdp}}</p><small class="font-weight-bold mt-0 pt-0">Fecha Compromiso</small></td>
                                                <td><a href="#" class="btn-detalle" @click.prevent="btnDetalle(item.id)"><i class="fa fa-bars fa-lg"></i></a></td>
                                            </tr>
                                        </tbody>
                                </table>
                            </paginate>
                            <paginate-links for="paginar" 
                                :async="true"                     
                                :limit="5"
                                :classes="{'ul': 'pagination', 'li': 'page-item', 'a': 'page-link'}"
                            ></paginate-links>
                    </div>
                </div>
            </div>
        </div>

        <!-- detalle -->
        <detalleCliente  v-if="view_detalle==true" :detalle="detalle" :telefonos="telefonos" :id="idCliente" :respuestas="respuestas" />

        <!-- modal busqueda avanzada -->
        <div class="modal fade modalCarga" id="busqueda-avanzada" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-blue text-white px-5">
                        <h5 class="modal-title">Búsqueda Avanzada</h5>
                        <a href="" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </a>
                    </div>
                    <div class="modal-body px-5">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Código</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">DNI</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Nombre del Cliente</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Nro. de Doc. del Producto</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Producto</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Tramo</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Oficina</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Última Gestión</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Fecha de Compromiso</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Teléfono</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="text-right pb-2">
                                    <a href="" class="btn btn-success">Generar Busqueda</a>
                                    <a href="" class="btn shadow">Limpiar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end modal -->
    </div>
</template>

<script>
    import vuePaginate from '../../../../node_modules/vue-paginate';
    //import detalleCliente from './detalleCliente';

    export default {
        // props:["vrol"],
        data() {
            return {
                temp:[],
                clientes:[],
                detalle:[],
                telefonos:[],
                respuestas:[],
                total_clientes:0,
                paginate: ['paginar'],
                buscar_codigo:'',
                view_detalle:false,
                view_carga:true,
                idCliente:''
            }
        },
        created(){
            this.listCLientes();
            this.listRespuestas();
        },
        methods:{
            listCLientes(){    
                axios.get("listClientes").then(res=>{
                    if(res.data){
                        this.temp=res.data;
                        this.clientes=this.temp;
                        this.total_clientes=this.clientes.length;
                        this.view_carga=false;
                    }
                })
            },
            listRespuestas(){    
                axios.get("listRespuestas").then(res=>{
                    if(res.data){
                        this.respuestas=res.data;
                    }
                })
            },
            buscar(codigo){
                if(codigo!=""){
                    this.clientes=[];
                    for(var i=0;i<this.temp.length;i++){
                        if((this.temp[i].codigo).indexOf(codigo)!==-1){
                            this.clientes.push(this.temp[i]);
                        }
                    }
                }else{
                    this.clientes=this.temp;
                    
                }
                this.total_clientes=this.clientes.length;
            },
            btnDetalle(id){
                $("#modalCarga").modal({backdrop: 'static', keyboard: false});
                this.idCliente=id;
                this.view_detalle=false;
                axios.get("listDetalle/"+id).then(res=>{
                    if(res.data){
                        this.detalle=res.data;
                        this.view_detalle=true;
                        $("#modalCarga").modal('hide');
                    }
                });
                axios.get("listTelefonos/"+id).then(res=>{
                    if(res.data){
                        this.telefonos=res.data;
                    }
                });
            },

            formatoMonto(num){
                var nStr=parseFloat(num).toFixed(2);
                nStr += '';
                var x = nStr.split('.');
                var x1 = x[0];
                var x2 = x.length > 1 ? '.' + x[1] : '';
                var rgx = /(\d+)(\d{3})/;
                while (rgx.test(x1)) {
                        x1 = x1.replace(rgx, '$1' + ',' + '$2');
                }
                return x1 + x2
            },
            formatoCant(nStr){
                nStr += '';
                var x = nStr.split('.');
                var x1 = x[0];
                var x2 = x.length > 1 ? '.' + x[1] : '';
                var rgx = /(\d+)(\d{3})/;
                while (rgx.test(x1)) {
                        x1 = x1.replace(rgx, '$1' + ',' + '$2');
                }
                return x1 + x2
            }
        },
        mounted() {
            this.$root.$on ('cerrar', () => {
                this.view_detalle=false;
            } );
        },
        components:{
            // detalleCliente
        }
    }
</script>

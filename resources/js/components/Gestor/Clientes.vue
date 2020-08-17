<template>
    <div>
        <div class="panel-top text-center">
            <a href="" class="btn-up"><i class="fa fa-sort-down fa-lg"></i></a>
        </div>
        <div class="contenedor-general-2">
            <div class="content-menu-2">
                <div class="logo d-flex">
                    <img src="img/logo.png" width="45px" height="40px" class="pr-2">
                    <div>
                        <h5 class="mb-0 ">Crédito y Cobranzas S.A.C</h5>
                        <small>Ingeniería en su cobranza</small>
                    </div>
                </div>
                <hr class="mx-0 px-0">
                <div class="panel-busqueda">
                    <div class="d-flex">
                        <div class="pr-1">
                            <i class="rounded-circle fa fa-user bg-blue text-white p-1"></i>
                        </div>
                        <p class=" badge bg-blue text-white py-2 px-2 min-w-125 text-left">LISTA DE CLIENTES</p>
                    </div>
                    <div class="body mb-4 pl-4">
                        <table>
                            <tr class="font-12"> 
                                <td>Código</td>
                                <td class="pb-1"><input type="text" class="form-control font-12 form-control-sm"></td>
                                <td class="font-11">DNI/RUC</td>
                                <td><input type="text" class="form-control font-12 form-control-sm w-5"></td>
                            </tr>
                            <tr class="font-12"> 
                                <td>Nombre</td>
                                <td colspan="3" class="pb-1"><input type="text" class="form-control font-12 form-control-sm"></td>
                            </tr>
                            <tr class="font-12"> 
                                <td>Teléfono</td>
                                <td><input type="text" class="form-control font-12 form-control-sm"></td>
                                <td class="text-right pr-1">Tramo</td>
                                <td><input type="text" class="form-control font-12 form-control-sm w-5"></td>
                            </tr>
                            <tr class="font-12"> 
                                <td>Ult. Gest.</td>
                                <td colspan="3">
                                    <select class="form-control font-12 form-control-sm ">
                                        <option value="">Selecionar</option>
                                    </select>
                                </td>
                            </tr>
                            <tr class="font-12"> 
                                <td>PDP Desde</td>
                                <td><input type="text" class="form-control font-12 form-control-sm"></td>
                                <td class="text-right pr-1">PDP Hasta</td>
                                <td><input type="text" class="form-control font-12 form-control-sm w-5"></td>
                            </tr>
                            <tr class="font-12"> 
                                <td>Ordenar</td>
                                <td>
                                    <select class="form-control font-12 form-control-sm">
                                        <option value="">Seleccionar</option>
                                        <option value="">Capital</option>
                                        <option value="">Deuda</option>
                                        <option value="">IC</option>
                                    </select>
                                </td>
                                <td colspan="2">
                                    <div class="d-flex justify-content-end">
                                        Listar Campaña
                                        <div class="pt-1">
                                            <input type="checkbox" class="ml-2">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr class="font-12"> 
                                <td colspan="2" class="pt-3">
                                    <a href="#" class="btn btn-outline-blue btn-sm btn-block btn-waves">Buscar</a>
                                </td>
                                <td colspan="2" class="pt-3">
                                    <a href="#" class="btn  btn-sm btn-block btn-waves btn-outline-blue">Limpiar</a>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="datos-mes">
                    <div class="d-flex">
                        <div class="pr-1">
                            <i class="rounded-circle fa fa-chart-pie bg-blue text-white p-1"></i>
                        </div>
                        <p class=" badge bg-blue text-white py-2 px-2 min-w-125 text-left">DATOS DEL MES</p>
                    </div>
                    <div class="body mb-4 pl-4">
                       <table class="w-100">
                           <tr>
                               <td class="text-left font-bold">Meta Asignada</td>
                               <td class="text-right">S/50,000</td>
                           </tr>
                           <tr>
                               <td class="text-left font-bold">Recupero al 15</td>
                               <td class="text-right">S/25,000</td>
                           </tr>
                           <tr>
                               <td class="text-left font-bold">Alcance de Meta</td>
                               <td class="text-right">50%</td>
                           </tr>
                           <tr>
                               <td class="text-left font-bold">Efectividad sobre PDPS</td>
                               <td class="text-right">65%</td>
                           </tr>
                           <tr>
                               <td class="text-left font-bold">PDP Caídas (S/.)</td>
                               <td class="text-right">S/.11,000</td>
                           </tr>
                           <tr>
                               <td class="text-left font-bold">PDP Pendientes (S/.)</td>
                               <td class="text-right">S/.35,000</td>
                           </tr>
                       </table>
                    </div>
                </div>
                <div class="estandar">
                    <div class="d-flex">
                        <div class="pr-1">
                            <i class="rounded-circle fa fa-phone bg-blue text-white p-1"></i>
                        </div>
                        <p class=" badge bg-blue text-white py-2 px-2 min-w-125 text-left">ESTÁNDAR</p>
                    </div>
                    <div class="body mb-4 pl-4">
                        <div class="form-group row">
                            <!-- <label for="">Provincia</label> -->
                            <input type="text" class="form-control w-5 col-3 ml-3 form-control-sm" >
                            <a href="#" class="btn btn-outline-blue col-4 btn-sm btn-waves">Consultar</a>
                        </div>
                        <table class="w-100">
                           <tr>
                               <td class="text-left font-bold py-0">Gestiones</td>
                               <td class="text-right py-0">200</td>
                           </tr>
                           <tr>
                               <td class="text-left font-bold py-0">Contactos</td>
                               <td class="text-right py-0">40</td>
                           </tr>
                           <tr>
                               <td class="text-left font-bold">Contactabilidad</td>
                               <td class="text-right">20%</td>
                           </tr>
                           <tr>
                               <td class="text-left font-bold">PDPS</td>
                               <td class="text-right">2</td>
                           </tr>
                           <tr>
                               <td class="text-left font-bold">Monto PDPS</td>
                               <td class="text-right">S/.11,000</td>
                           </tr>
                           <tr>
                               <td class="text-left font-bold">Monto Confirmaciones</td>
                               <td class="text-right">S/.35,000</td>
                           </tr>
                       </table>
                    </div>
                </div>
                <div class="campana pb-3 pl-4">
                    <div class="btn-outline-blue rounded py-1 px-2 text-center">
                        Campaña más cercana: 08/08 - 12:00PM
                    </div>
                </div>
            </div>
            <div class="content-body-2">
                <div class="contenedor-body">
                    <nav class="navbar navbar-expand-lg navbar-transparent pt-3 pb-2 bg-white">
                        <div class="container-fluid px-0">
                            <div class="navbar-wrapper d-flex">
                                <a href="" class="icono-bars waves-effect" @click.prevent="menu()"><i class="fa fa-bars fa-lg"></i></a>
                            </div>
                            <div class="justify-content-end" id="navigation">
                                <ul class="navbar-nav">
                                    <li class="nav-item pt-1">
                                        <img src="img/center.jpeg" alt="" width="35px" height="35px" class=" rounded-circle border">
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                    <div class="px-3 py-1">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="bg-blue text-white">
                                    <tr class="text-center">
                                        <td class="align-middle">CODIGO</td>
                                        <td style="width:20%;">NOMBRE</td>
                                        <td class="align-middle">DNI/RUC</td>
                                        <td class="align-middle">CAPITAL</td>
                                        <td class="align-middle">DEUDA</td>
                                        <td class="align-middle">IC</td>
                                        <td class="align-middle">MEDIO</td>
                                        <td class="align-middle">PRODUCTO</td>
                                        <td class="align-middle">ULT. RPTA</td>
                                        <td class="border-0 bg-white rounded-0" style="width:10px;"></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>1</td>
                                        <td>1</td>
                                        <td>1</td>
                                        <td>1</td>
                                        <td>1</td>
                                        <td>1</td>
                                        <td>1</td>
                                        <td>1</td>
                                        <td class="border-0 bg-white">
                                            <a href="#" class="btn-phone "><i class="fa fa-phone"></i></a>
                                        </td>
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

<script>
    import vuePaginate from '../../../../node_modules/vue-paginate';
    //import detalleCliente from './detalleCliente';

    export default {
        // props:["vrol"],
        data() {
            return {

            }
        },
        created(){
           
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
            },
            menu(){
                 $('.content-menu-2').toggleClass('abrir-menu-2');            
                 $('.content-body-2').toggleClass('p-left-menu-2');               
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

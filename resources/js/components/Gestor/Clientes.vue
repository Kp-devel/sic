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
                        <p class=" badge bg-blue text-white py-2 px-2 min-w-125 text-left">LISTA DE CLIENTES <span v-if="lista.length>0">( {{total_clientes}} )</span> </p>
                    </div>
                    <div class="body mb-4 pl-4">
                        <table>
                            <tr class="font-12"> 
                                <td>Código</td>
                                <td class="pb-1"><input type="text" class="form-control font-12 form-control-sm" v-model="busqueda.codigo" @keypress="soloNumeros"></td>
                                <td class="font-11">DNI/RUC</td>
                                <td><input type="text" class="form-control font-12 form-control-sm w-5" v-model="busqueda.dni" @keypress="soloNumeros"></td>
                            </tr>
                            <tr class="font-12"> 
                                <td>Nombre</td>
                                <td colspan="3" class="pb-1"><input type="text" class="form-control font-12 form-control-sm" v-model="busqueda.nombre"></td>
                            </tr>
                            <tr class="font-12"> 
                                <td>Teléfono</td>
                                <td><input type="text" class="form-control font-12 form-control-sm" v-model="busqueda.telefono" @keypress="soloNumeros"></td>
                                <td class="text-right pr-1">Tramo</td>
                                <td><input type="text" class="form-control font-12 form-control-sm w-5" v-model="busqueda.tramo"></td>
                            </tr>
                            <tr class="font-12"> 
                                <td>Ult. Gest.</td>
                                <td colspan="3">
                                    <select class="form-control font-12 form-control-sm " v-model="busqueda.respuesta" @change="listRespuestas()">
                                        <option value="">Selecionar</option>
                                        <option v-for="(item,index) in respuestas" :key="index" :value="item.res_id">{{item.res_des}}</option>
                                    </select>
                                </td>
                            </tr>
                            <tr class="font-12"> 
                                <td>PDP Desde</td>
                                <td>
                                    <input 
                                        type="text" 
                                        class="form-control font-12 form-control-sm"                                        
                                        v-model="busqueda.pdp_desde">
                                </td>
                                <td class="text-right pr-1">PDP Hasta</td>
                                <td><input type="text" class="form-control font-12 form-control-sm w-5" v-model="busqueda.pdp_hasta"></td>
                            </tr>
                            <tr class="font-12"> 
                                <td>Ordenar</td>
                                <td>
                                    <select class="form-control font-12 form-control-sm" v-model="busqueda.ordenar">
                                        <option value="">Seleccionar</option>
                                        <option value="1">Capital</option>
                                        <option value="2">Deuda</option>
                                        <option value="3">IC</option>
                                    </select>
                                </td>
                                <td colspan="2">
                                    <div class="d-flex justify-content-end">
                                        Listar Campaña
                                        <div class="pt-1">
                                            <input type="checkbox" class="ml-2" v-model="busqueda.camp">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr class="font-12"> 
                                <td colspan="2" class="pt-3">
                                    <a href="#" @click="listCLientes()" class="btn btn-outline-blue btn-sm btn-block btn-waves">Buscar</a>
                                </td>
                                <td colspan="2" class="pt-3">
                                    <a href="#" @click="limpiar()"  class="btn  btn-sm btn-block btn-waves btn-outline-blue">Limpiar</a>
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
                           <template v-if="metas.length>0">
                                <tr>
                                    <td class="text-left font-bold">Meta Asignada</td>
                                    <td class="text-right">S/.{{formatoMonto(metas[0].meta)}}</td>
                                </tr>
                                <tr>
                                    <td class="text-left font-bold">Recupero al {{metas[0].fecha}}</td>
                                    <td class="text-right">S/.{{formatoMonto(metas[0].recupero)}}</td>
                                </tr>
                                <tr>
                                    <td class="text-left font-bold">Alcance de Meta</td>
                                    <td class="text-right">{{metas[0].alcance}}%</td>
                                </tr>
                            </template>
                            <template v-if="pdps.length>0 && pagos.length>0">
                                <tr>
                                    <td class="text-left font-bold">Efectividad sobre PDPS</td>
                                    <td class="text-right">{{(pagos[0].monto_pago/pdps[0].monto_pdp)>0? Math.round((pagos[0].monto_pago/pdps[0].monto_pdp)*100):'0'}}%</td>
                                </tr>
                            </template>
                            <template v-if="promesas.length>0">
                                <tr>
                                    <td class="text-left font-bold">PDP Caídas (S/.)</td>
                                    <td class="text-right">S/.{{promesas[0].caido? formatoMonto(promesas[0].caido):'0'}}</td>
                                </tr>
                                <tr>
                                    <td class="text-left font-bold">PDP Pendientes (S/.)</td>
                                    <td class="text-right">S/.{{promesas[0].pendiente? formatoMonto(promesas[0].pendiente):'0.00'}}</td>
                                </tr>
                            </template>
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
                            <input type="text" class="form-control w-5 col-3 ml-3 form-control-sm" v-model="firma" v-on:keyup.enter="datosEstandar()">
                            <a href="#" @click="datosEstandar()" class="btn btn-outline-blue col-4 btn-sm btn-waves">Consultar</a>
                        </div>
                        <div class="d-flex justify-content-center py-3" v-if="loading2">
                            <div class="spinner-border spinner-border-sm text-blue" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                        
                        <table class="w-100">
                            <template v-if="estandar.length>0 && loading2==false">
                                <tr>
                                    <td class="text-left font-bold py-0">Gestiones</td>
                                    <td class="text-right py-0">{{estandar[0].gestiones}}</td>
                                </tr>
                           
                                <tr>
                                    <td class="text-left font-bold py-0">Contactos</td>
                                    <td class="text-right py-0">{{estandar[0].contactos? estandar[0].contactos:'0'}}</td>
                                </tr>
                                <tr>
                                    <td class="text-left font-bold">Contactabilidad</td>
                                    <td class="text-right">{{estandar[0].contactabilidad? '-'+estandar[0].contactabilidad:'0'}}</td>
                                </tr>
                                <tr>
                                    <td class="text-left font-bold">PDPS</td>
                                    <td class="text-right">{{estandar[0].pdps? estandar[0].pdps:'0'}}</td>
                                </tr>
                                <tr>
                                    <td class="text-left font-bold">Monto PDPS</td>
                                    <td class="text-right">S/.{{estandar[0].monto_pdps? formatoMonto(estandar[0].monto_pdps):'0'}}</td>
                                </tr>
                                <tr>
                                    <td class="text-left font-bold">Monto Confirmaciones</td>
                                    <td class="text-right">S/.{{estandar[0].monto_confs? formatoMonto(estandar[0].monto_confs):'0'}}</td>
                                </tr>
                            </template>
                       </table>
                    </div>
                </div>
                <template v-if="estados.length>0">
                    <div class="campana pb-3 pl-4" v-if="estados[0].estado=='CE'">
                        <div class="btn-outline-blue bg-success rounded py-1 px-2 text-center">
                           <h5> {{estados[0].nombre_camp}}</h5>
                            <p>Campaña en Ejecución</p>
                        </div>
                    </div>
                    <div class="campana pb-3 pl-4" v-if="estados[0].estado=='PC'">
                        <div class="btn-outline-blue bg-primary rounded py-1 px-2 text-center">
                            Campaña más cercana: {{estados[0].dia}} {{estados[0].hora}}
                        </div>
                    </div>
                    <div class="campana pb-3 pl-4" v-if="estados[0].estado=='CC'">
                        <div class="btn-outline-blue bg-danger rounded py-1 px-2 text-center">
                            <h5> {{estados[0].nombre_camp}}</h5>
                            <p>Campaña en Detenida o Culminada</p>
                        </div>
                    </div>
                </template>
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
                            <paginate name="lista" :list="lista" :per="20" class="px-0">
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
                                        <tr class="text-center" v-if="lista=='' && loading==false">
                                            <td colspan="9" style="border:none;">No hay registros</td>
                                        </tr>
                                        <tr v-for="(item,index) in paginated('lista')" :key="index" v-else-if="loading==false">
                                            <td>{{item.codigo}}</td>
                                            <td>{{item.nombre}}</td>
                                            <td>{{item.dni}}</td>
                                            <td>{{formatoMonto(item.capital)}}</td>
                                            <td>{{formatoMonto(item.deuda)}}</td>
                                            <td>{{formatoMonto(item.importe)}}</td>
                                            <td>{{item.telefono}}</td>
                                            <td>{{item.producto}}</td>
                                            <td>{{item.ult_resp}}</td>
                                            <td class="border-0 bg-white">
                                                <a href="#" class="btn-phone "><i class="fa fa-phone"></i></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </paginate>
                            <template v-if="lista.length>0 && !loading">
                                <paginate-links  for="lista" 
                                    :async="true"                     
                                    :limit="4"
                                    :classes="{'ul': 'pagination', 'li': 'page-item', 'a': 'page-link'}"
                                ></paginate-links>
                            </template>
                        </div>
                        <div class="d-flex justify-content-center py-3" v-if="loading">
                            <div class="spinner-border text-blue" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
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
                paginate: ['lista'],
                lista: [],
                busqueda:{codigo:'',dni:'',nombre:'',telefono:'',tramo:'',respuesta:'',pdp_desde:'',pdp_hasta:'',ordenar:'',camp:''},
                //codigo:'',
                loading:false,
                loading2:false,
                respuestas: [],
                firma:'',
                estandar:[],
                metas:[],
                promesas:[],
                pdps:[],
                pagos:[],
                data:[],
                estados:[],
                metas:[],
            }
        },
        created(){
             this.listRespuestas(); 
             this.datosMes(); 
             this.estadoCampana();   
                      
        },
        watch:{
            'busqueda.pdp_desde': function(val){this.busqueda.pdp_desde = this.validarFormatoFecha(val)},
            'busqueda.pdp_hasta': function(val){this.busqueda.pdp_hasta = this.validarFormatoFecha(val)}            
        },
        methods:{
            validarFormatoFecha(value){
                let input = value;
                if (/\D\/$/.test(input)) input = input.substr(0, input.length - 3);
                let values = input.split('/').map(v=> v.replace(/\D/g, ''));     
                if (values[0]) values[0] = this.checkValue(values[0], 31);
                if (values[1]) values[1] = this.checkValue(values[1], 12);
                var output = values.map((v, i) => v.length == 2 && i < 2 ? v + ' / ' : v);                
                return output.join('').substr(0,14);
            },
            checkValue(str,max){
                if (str.charAt(0) !== '0' || str == '00') {
                    var num = parseInt(str);
                    if (isNaN(num) || num <= 0 || num > max) num = 1;
                    str = num > parseInt(max.toString().charAt(0)) 
                        && num.toString().length == 1 ? '0' + num : num.toString();
                };
                return str;
            },
            limpiar(){
                this.busqueda.codigo='';
                this.busqueda.dni='';
                this.busqueda.nombre='';
                this.busqueda.telefono='';
                this.busqueda.tramo='';
                this.busqueda.respuesta='';
                this.busqueda.pdp_desde='';
                this.busqueda.pdp_hasta='';
                this.busqueda.ordenar='';
                this.busqueda.camp='';
            },
            listCLientes(){
                //if(this.busqueda.codigo!="" && this.busqueda.dni!="" && this.busqueda.nombre!=""){
                    const codigo = this.busqueda.codigo;
                    const dni = this.busqueda.dni;
                    const nombre = this.busqueda.nombre;
                    const telefono = this.busqueda.telefono;
                    const tramo = this.busqueda.tramo;
                    const respuesta = this.busqueda.respuesta;
                    const pdp_desde = this.busqueda.pdp_desde;
                    const pdp_hasta = this.busqueda.pdp_hasta;
                    const ordenar = this.busqueda.ordenar;
                    const camp = this.busqueda.camp;
                    this.loading=true;

                    const fechas_i =  pdp_desde.split('/');                   
                    const nuevaFecha_i = `${fechas_i[2]}-${fechas_i[1]}-${fechas_i[0]}`
                    const fec_desde= nuevaFecha_i.split(' ').join('');

                    const fechas_f =  pdp_hasta.split('/');                   
                    const nuevaFecha_f = `${fechas_f[2]}-${fechas_f[1]}-${fechas_f[0]}`
                    const fec_hasta= nuevaFecha_f.split(' ').join('');

                    /*console.log(this.busqueda.pdp_desde);*/
                    //console.log(fec_desde);
                    // this.lista=[];
                    console.log(camp)
                    axios.get("listClientes?codigo="+ (codigo || null)+"&dni="+(dni || null)+"&nombre="+(nombre || null)
                                +"&telefono="+(telefono || null)+"&tramo="+(tramo || null)+"&respuesta="+(respuesta || null)
                                +"&fec_desde="+(fec_desde || null)+"&fec_hasta="+(fec_hasta || null)+"&ordenar="+(ordenar || null)
                                +"&camp="+(camp || null))
                    .then(res=>{
                        if(res.data){
                            this.lista=res.data;
                            this.loading=false;
                            this.total_clientes=this.lista.length;
                            //this.clientes=this.listCLientes;
                            //this.total_clientes=this.clientes.length;
                            //this.view_carga=false;
                        }
                    })
                //}
            },
            listRespuestas(){    
                axios.get("listRespuestas").then(res=>{
                    if(res.data){
                        this.respuestas=res.data;
                    }
                })
            },
            datosEstandar(){
                this.loading2=true;
                if(this.frima!=""){
                    const firma = this.firma;
                    axios.get("datosEstandar?firma="+firma).then(res=>{
                        if(res.data){
                            this.estandar=res.data;
                            this.loading2=false;
                            //console.log('=======');
                            //this.$forceUpdate();
                            //console.log(this.estandar);
                            //console.log(this.estandar[0].gestiones);
                        }
                    })
                }
            },

            datosMes(){
                axios.get("datosMes").then(res=>{
                    if(res.data){
                        //this.data=res.data;
                        this.metas=res.data.metas;
                        this.promesas=res.data.datos;
                        this.pdps=res.data.pdp;
                        this.pagos=res.data.pagos;
                        console.log(this.metas);
                    }
                })
            },

            estadoCampana(){
                axios.get("estadosCampana").then(res=>{
                    if(res.data){
                        this.estados=res.data;
                        console.log(this.estados);
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
            },

            soloNumeros(e){
                var key = window.event ? e.which : e.keyCode;
                if (key < 48 || key > 57) {
                    e.preventDefault();
                }
            },        
        },
        mounted() {
            this.$root.$on ('cerrar', () => {
                this.view_detalle=false;
            } );
        },

        /*computed:{
            buscarClientes(){
                return this.listCLientes.filter((item) => item.codigo.includes(this.codigo));
            }
        },*/

        components:{
            // detalleCliente
            vuePaginate
        }
    }
</script>

<template>
    <div>
        <div class="contenedor-general-2">
            <div class="content-menu-2">
                <div class="logo d-flex">
                    <img src="img/logo.png" width="45px" height="40px" class="pr-2">
                    <div>
                        <h5 class="mb-0 ">Crédito y Cobranzas S.A.C</h5>
                        <p class="mb-0 font-12">Ingeniería en su cobranza</p>
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
                                    <select class="form-control font-12 form-control-sm " v-model="busqueda.respuesta" @change="busqueda.motivo=''">
                                        <option value="">Selecionar</option>
                                        <option v-for="(item,index) in respuestas" :key="index" :value="item.res_id">{{item.res_des}}</option>
                                    </select>
                                </td>
                            </tr>
                            <tr class="font-12" v-if="busqueda.respuesta==33"> 
                                <td>Motivo No Pago</td>
                                <td colspan="3">
                                    <select class="form-control font-12 form-control-sm " v-model="busqueda.motivo">
                                        <option value="">Selecionar</option>
                                        <option v-for="(item,index) in motivosnopago" :key="index" :value="item.id">{{item.motivo}}</option>
                                    </select>
                                </td>
                            </tr>
                            <tr class="font-12"> 
                                <td>PDP Desde</td>
                                <td>
                                    <input 
                                        type="text" 
                                        class="form-control font-12 form-control-sm"                                        
                                        v-model="busqueda.pdp_desde" placeholder="dd/mm/aaaa">
                                </td>
                                <td class="text-right pr-1">PDP Hasta</td>
                                <td><input type="text" class="form-control font-12 form-control-sm w-5" v-model="busqueda.pdp_hasta" placeholder="dd/mm/aaaa"></td>
                            </tr>
                            <tr class="font-12"> 
                                <td>Entidades</td>
                                <td>
                                    <select class="form-control font-12 form-control-sm" v-model="busqueda.entidades" :disabled="entidades==''">
                                        <option value="">Seleccionar</option>
                                        <option v-for="(item,index) in entidades" :key="index" :value="item.valor">{{item.valor}}</option>
                                    </select>
                                </td>
                                <td class="text-right pr-1">Score</td>
                                <td>
                                    <select class="form-control font-12 form-control-sm" :disabled="score==''" v-model="busqueda.score">
                                        <option value="">Seleccionar</option>
                                        <option v-for="(item,index) in score" :key="index" :value="item.valor">{{item.valor}}</option>
                                    </select>
                                </td>
                            </tr>
                            <tr class="font-12"> 
                                <td>Rango Sueldo</td>
                                <td>
                                    <select class="form-control font-12 form-control-sm" v-model="busqueda.sueldo">
                                        <option value="">Seleccionar</option>
                                        <option value="1"><=500</option>
                                        <option value="2">>500<=1000</option>
                                        <option value="3">>1000<=3000</option>
                                        <option value="4">>3000</option>
                                    </select>
                                </td>
                                <td class="text-right pr-1">Rango Deuda</td>
                                <td>
                                    <select class="form-control font-12 form-control-sm" v-model="busqueda.deuda">
                                        <option value="">Seleccionar</option>
                                        <option value="1"><=500</option>
                                        <option value="2">>500<=1000</option>
                                        <option value="3">>1000<=3000</option>
                                        <option value="4">>3000</option>
                                    </select>
                                </td>
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
                                    <a href="" @click.prevent="listCLientes()" class="btn btn-outline-blue btn-sm btn-block btn-waves">Buscar</a>
                                </td>
                                <td colspan="2" class="pt-3">
                                    <a href="" @click.prevent="limpiar()"  class="btn  btn-sm btn-block btn-waves btn-outline-blue">Limpiar</a>
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
                        <table class="w-100" v-if="dataMes">
                            <tr>
                                <td class="text-left font-bold">Meta Asignada</td>
                                <td class="text-right">S/.{{formatoMonto(dataMes.meta)}}</td>
                            </tr>
                            <tr>
                                <td class="text-left font-bold">Recupero al {{dataMes.fecha_recupero}}</td>
                                <td class="text-right">S/.{{dataMes.recupero!=null?formatoMonto(dataMes.recupero):'0.00'}}</td>
                            </tr>
                            <tr>
                                <td class="text-left font-bold">Alcance de Meta</td>
                                <td class="text-right">{{dataMes.meta!=0?dataMes.alcance:0}}%</td>
                            </tr>
                            <tr>
                                <td class="text-left font-bold">Efectividad sobre PDPS</td>
                                <td class="text-right">{{dataMes.efectividad!=null?dataMes.efectividad:0}}%</td>
                            </tr>
                            <tr>
                                <td class="text-left font-bold">PDP Caídas (S/.)</td>
                                <td class="text-right">S/.{{dataMes.pdp_caidas!=null?formatoMonto(dataMes.pdp_caidas):'0.00'}}</td>
                            </tr>
                            <tr>
                                <td class="text-left font-bold">PDP Pendientes (S/.)</td>
                                <td class="text-right">S/.{{dataMes.pdp_pendiente!=null?formatoMonto(dataMes.pdp_pendiente):'0.00'}}</td>
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
                            <input type="text" class="form-control w-5 col-3 ml-3 form-control-sm" v-model="firma.firma" v-on:keyup.enter="datosEstandar()">
                            <a href="" @click.prevent="datosEstandar()" class="btn btn-outline-blue col-4 btn-sm btn-waves">Consultar</a>
                        </div>
                        <div class="d-flex justify-content-center py-3" v-if="loading2">
                            <div class="spinner-border spinner-border-sm text-blue" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                        
                        <table class="w-100" v-if="estandar.length>0 && loading2==false">
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
                                <td class="text-right">{{estandar[0].contactabilidad? estandar[0].contactabilidad:'0'}}%</td>
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
                       </table>
                    </div>
                </div>
                <div v-if="estados.length>0" class="mt-3 ml-4"> 
                    <div class="btn-outline-green rounded pt-0 pb-1" v-if="estados[0].estado=='CE'">
                        <div class="d-flex px-3 pb-1 pt-2">
                            <div class="pr-2">
                                <i class="fa fa-clock fa-lg"></i>
                            </div>
                            <div style="line-height:13px;">
                                <p class="mb-0 font-bold"> {{estados[0].nombre_camp}}</p>
                                <small>Campaña en Ejecución</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="campana" v-if="estados[0].estado=='PC'">
                        <div class="btn-outline-blue bg-primary rounded py-1 px-2 text-center">
                            Campaña más cercana: {{estados[0].dia}} {{estados[0].hora}}
                        </div>
                    </div>
                    <div class="btn-outline-red rounded pt-0 pb-1" v-if="estados[0].estado=='CC'">
                        <div class="d-flex px-3 pb-1 pt-2">
                            <div class="pr-2">
                                <i class="fa fa-clock fa-lg"></i>
                            </div>
                            <div style="line-height:13px;">
                                <p class="mb-0 font-bold"> {{estados[0].nombre_camp}}</p>
                                <small>Campaña en Detenida o Culminada</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body-2" id="contenidoLista">
                <div class="contenedor-body">
                    <nav class="navbar navbar-expand-lg navbar-transparent pt-3 pb-2 bg-white">
                        <div class="container-fluid px-0">
                            <div class="navbar-wrapper d-flex">
                                <a href="" class="icono-bars waves-effect" @click.prevent="menu()"><i class="fa fa-bars fa-lg"></i></a>
                            </div>
                            <button class="navbar-toggler p-0" type="button" data-toggle="collapse" data-target="#navigation"  aria-expanded="false" aria-label="Toggle navigation">
                                 <img src="img/center.jpeg" alt="" width="35px" height="35px" class=" rounded-circle border">
                            </button>
                            <div class="collapse navbar-collapse justify-content-end" id="navigation">
                                    <ul class="navbar-nav">
                                        <li class="nav-item pt-1 px-2 text-right">
                                            <p class="font-12 mb-0"><b>{{userlogeado}}</b><br>Call Center</p>
                                        </li>
                                        <li class="nav-item dropdown">
                                            <a href="#" class="nav-link dropdown-toggle px-0" id="dropdown-user" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <img src="img/center.jpeg" alt="" width="35px" height="35px" class=" rounded-circle border">
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right mt-1" aria-labelledby="dropdown-user">
                                                <a href="" class="dropdown-item" @click.prevent="cerrarsession()">
                                                    Cerrar Sessión
                                                </a>
                                                <form id="logout-form" action="logout" method="POST" style="display: none;">
                                                    <input type="hidden" name="_token" :value="csrf">
                                                </form>
                                            </div>
                                        </li>
                                    </ul>
                            </div>
                        </div>
                    </nav>
                    <div class="px-3 py-1">
                        <div class="table-responsive">
                            <paginate ref="paginator" name="lista" :list="lista" :per="20" class="px-0">
                                <table class="table table-hover">
                                    <thead class="bg-blue text-white">
                                        <tr class="text-center">
                                            <td class="align-middle">CODIGO</td>
                                            <td class="align-middle">NOMBRE</td>
                                            <td class="align-middle">DNI/RUC</td>
                                            <td class="align-middle">CAPITAL</td>
                                            <td class="align-middle">DEUDA</td>
                                            <td class="align-middle">IC</td>
                                            <td class="align-middle">MEDIO</td>
                                            <td class="align-middle">PRODUCTO</td>
                                            <td class="align-middle">ULT. RPTA</td>
                                            <td class="border-0 bg-white rounded-0" style="min-width:5px;"></td>
                                            <td class="border-0 bg-white rounded-0" style="min-width:5px;"></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="text-center" v-if="lista=='' && loading==false">
                                            <td colspan="9">No hay registros</td>
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
                                            <td class="border-0 bg-white rounded-0 px-0">
                                                <a href="" class="btn-phone" @click.prevent="detalle(item.id)"><i class="fa fa-phone fa-1x"></i></a>
                                            </td>
                                            <td class="border-0 bg-white rounded-0 px-0"><i class="fa fa-check text-green" v-if="item.fecha_ges==fecha_hoy"></i></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </paginate>
                        </div>
                        <paginate-links  for="lista" v-if="lista.length>0 && !loading" 
                            :async="true"                     
                            :limit="4"
                            :classes="{'ul': 'pagination', 'li': 'page-item', 'a': 'page-link'}"
                        ></paginate-links>
                            
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
        props:["userlogeado"],
        data() {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                paginate: ['lista'],
                lista: [],
                busqueda:{codigo:'',dni:'',nombre:'',telefono:'',tramo:'',respuesta:'',pdp_desde:'',pdp_hasta:'',ordenar:'',camp:'',deuda:'',sueldo:'',entidades:'',score:'',motivo:''},
                //codigo:'',
                loading:false,
                loading2:false,
                respuestas: [],
                entidades: [],
                score: [],
                firma:{firma:''},
                estandar:[],
                metas:[],
                promesas:[],
                pdps:[],
                pagos:[],
                data:[],
                estados:[],
                metas:[],
                fecha_hoy:'',
                dataMes:{meta:0,recupero:0,alcance:0,efectividad:0,pdp_caidas:0,pdp_pendiente:0,fecha_recupero:''},
                motivosnopago:[]
            }
        },
        created(){
             this.listRespuestas(); 
             this.listMotivosnopago();
             this.datosMes(); 
             this.estadoCampana();   
             this.diaActual();
             this.listEntidades();
             this.listScore();
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
                this.busqueda.deuda='';
                this.busqueda.sueldo='';
                this.busqueda.entidades='';
                this.busqueda.score='';
            },
            listCLientes(){
                //if(this.busqueda.codigo!="" && this.busqueda.dni!="" && this.busqueda.nombre!=""){
                    const fechas_i =  this.busqueda.pdp_desde.split('/');                   
                    const nuevaFecha_i = `${fechas_i[2]}-${fechas_i[1]}-${fechas_i[0]}`
                    const fec_desde= nuevaFecha_i.split(' ').join('');

                    const fechas_f =  this.busqueda.pdp_hasta.split('/');                   
                    const nuevaFecha_f = `${fechas_f[2]}-${fechas_f[1]}-${fechas_f[0]}`
                    const fec_hasta= nuevaFecha_f.split(' ').join('');

                    const dataBusqueda = {
                        codigo : this.busqueda.codigo,
                        dni : this.busqueda.dni,
                        nombre : this.busqueda.nombre,
                        telefono : this.busqueda.telefono,
                        tramo : this.busqueda.tramo,
                        respuesta : this.busqueda.respuesta,
                        fec_desde : fec_desde,
                        fec_hasta : fec_hasta,
                        ordenar : this.busqueda.ordenar,
                        camp : this.busqueda.camp,
                        deuda : this.busqueda.deuda,
                        sueldo : this.busqueda.sueldo,
                        entidades : this.busqueda.entidades,
                        score : this.busqueda.score,
                    };
                    this.loading=true;
                    /*console.log(this.busqueda.pdp_desde);*/
                    // this.lista=[];
                    //console.log(dataBusqueda);
                    axios.post("listClientes",dataBusqueda).then(res=>{
                        if(res.data){
                            this.lista=res.data;
                            this.loading=false;
                            this.total_clientes=this.lista.length;
                            // if(this.total_clientes>0){
                            //     this.inicioPaginacion();
                            // }
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
            listMotivosnopago(){
                axios.get("listaMotivosNoPago").then(res=>{
                    if(res.data){
                        this.motivosnopago=res.data;
                    }
                })
            },
            listEntidades(){
                axios.get("listaEntidades").then(res=>{
                    if(res.data){
                        this.entidades=res.data;
                    }
                })
            },
            listScore(){
                axios.get("listaScore").then(res=>{
                    if(res.data){
                        this.score=res.data;
                    }
                })
            },
            datosEstandar(){
                this.loading2=true;
                if(this.firma!=""){
                    axios.post("datosEstandar",this.firma).then(res=>{
                        if(res.data){
                            this.estandar=res.data;
                            this.loading2=false;
                        }
                    })
                }
            },
            datosMes(){
                axios.get("datosMes").then(res=>{
                    if(res.data){
                        const datos=res.data;
                        //console.log(datos);
                        this.dataMes.meta=datos[0].meta;
                        this.dataMes.recupero=datos[0].recupero;
                        this.dataMes.fecha_recupero=datos[0].fecha_recupero;
                        this.dataMes.alcance=((datos[0].recupero/datos[0].meta)*100).toFixed(2);
                        const pago=datos[0].monto_pago!=null?datos[0].monto_pago:0;
                        const pdp=datos[0].monto_pdp!=null?datos[0].monto_pdp:1;
                        this.dataMes.efectividad= Math.round((pago/pdp)*100);
                        this.dataMes.pdp_caidas=datos[0].pdp_caidos;
                        this.dataMes.pdp_pendiente=datos[0].pdp_pendiente;
                    }
                })
            },
            estadoCampana(){
                axios.get("estadosCampana").then(res=>{
                    if(res.data){
                        this.estados=res.data;
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
            detalle(id){
                let datos=[];
                $('#contenidoLista').toggleClass('pos_fixed');
                for(let i=0;i<this.lista.length;i++){
                    if(this.lista[i].id==id){
                        datos.push(this.lista[i]);
                        this.$root.$emit('verDetalle',datos);
                        break;
                    }
                }
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
            // inicioPaginacion() {
            //     if (this.$refs.paginator) {
            //         this.$refs.paginator.goToPage(1)
            //     }
            // },
            diaActual(){
                var n=new Date();
                var hoy=n.getFullYear()+"-"+this.addZero(n.getMonth()+1)+"-"+this.addZero(n.getDate());
                this.fecha_hoy=hoy;
            },
            addZero(i) {
                if (i < 10) {
                    i = '0' + i;
                }
                return i;
            },
            cerrarsession(){
                $('#logout-form').submit();
            }
        },
        components:{
            vuePaginate
        }
    }
</script>

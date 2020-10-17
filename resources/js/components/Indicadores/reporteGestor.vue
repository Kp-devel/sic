<template>
    <div >
         <div class="row mt-3 mb-1">
            <div class="col-md-4 col-xl-4">
                <div class="">
                    <label for="cartera" class="font-bold col-form-label text-dark text-righ">Nombre de Cartera</label>
                    <select name="cartera" id="cartera" class="form-control" v-model="busqueda.cartera">
                        <option selected value="">Seleccionar</option>
                        <option v-for="(item,index) in carteras" :key="index"  class="option" :value="item.id">{{item.cartera}}</option>
                    </select>
                    <small v-if="mensajeCartera" class="text-danger">{{mensajeCartera}}</small>
                </div>
            </div>
            <div class="col-md-3 col-xl-2">
                <div class="">
                    <label for="indicador" class="font-bold col-form-label text-dark text-righ">Call</label>
                    <select name="indicador" id="indicador" class="form-control" v-model="busqueda.call">
                        <option selected value="">Seleccionar</option>
                        <option v-for="(item,index) in calls" :key="index" class="option" :value="item.id">{{item.valor}}</option>
                    </select>
                </div>
            </div>
            <div class="col-md-5 col-xl-4">
                <label for="cartera" class="font-bold col-form-label text-dark text-righ">Fecha de Gestión (Desde-Hasta)</label>
                <div class="d-flex ">
                    <div class="w-50">
                        <input type="date" class="form-control" v-model="busqueda.fechaInicio">
                        <small v-if="mensajeFecInicio" class="text-danger">{{mensajeFecInicio}}</small>
                    </div>
                    <div class="w-50">
                        <!-- <label for="indicador" class="font-bold col-form-label text-dark text-righ">Fecha de Gestíon (Hasta)</label> -->
                        <input type="date" class="form-control" v-model="busqueda.fechaFin">
                        <small v-if="mensajeFecFin" class="text-danger">{{mensajeFecFin}}</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class=" py-3">
                    <a href="" @click.prevent="generarReporte()" class="btn btn-outline-blue btn-block waves-effect">
                        <span v-if="loading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Generar Reporte
                    </a>
                </div>
            </div>
        </div>
        <div class="table-responsive" id="table-report" v-if="viewTable" >
            <table class="table table-hover">
                <thead class="bg-blue text-white">
                    <tr class="text-center">
                        <td class="align-middle">Nombre</td>
                        <td class="align-middle">Cartera</td>
                        <td class="align-middle">Perfil</td>
                        <td class="align-middle">Call</td>
                        <td class="align-middle">Clientes<br>Asignados</td>
                        <td class="align-middle">Deuda<br>S/.</td>
                        <td class="align-middle">Gestiones</td>
                        <td class="align-middle">Contactos</td>
                        <td class="align-middle">En Negociación</td>
                        <td class="align-middle">No Disponible</td>
                        <td class="align-middle">No Contactos</td>
                        <td class="align-middle">Clientes<br>Gestionados</td>
                        <td class="align-middle">Clientes<br>Contactados</td>
                        <td class="align-middle">PDPS</td>
                        <td class="align-middle">Monto PDPS</td>
                        <td class="align-middle">Nuevos<br>Sin gestión</td>
                        <td class="align-middle">Sin gestión<br>en el mes</td>
                        <td class="align-middle">%<br>Cobertura</td>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="datos==''">
                        <td colspan="18" class="text-center">No existen datos relacionados</td>
                    </tr>
                    <tr v-else v-for="(item,index) in datos" :key="index">
                        <td>{{item.gestor}}</td>
                        <td>{{item.cartera}}</td>
                        <td>{{item.perfil}}</td>
                        <td>{{item.callg}}</td>
                        <td class="text-center">{{formatoNumero(item.clientes,'C')}}</td>
                        <td class="text-right">{{formatoNumero(item.deuda,'M')}}</td>
                        <td class="text-center">{{formatoNumero(item.gestiones,'C')}}</td>
                        <td class="text-center">{{formatoNumero(item.contactos,'C')}}</td>
                        <td class="text-center">{{formatoNumero(item.negociaciones,'C')}}</td>
                        <td class="text-center">{{formatoNumero(item.nodisponibles,'C')}}</td>
                        <td class="text-center">{{formatoNumero(item.nocontactos,'C')}}</td>
                        <td class="text-center">{{formatoNumero(item.clientes_gestionados,'C')}}</td>
                        <td class="text-center">{{formatoNumero(item.clientes_contacto,'C')}}</td>
                        <td class="text-center">{{formatoNumero(item.pdps,'C')}}</td>
                        <td class="text-right">{{formatoNumero(item.montopdps,'M')}}</td>
                        <td class="text-center bg-green-light-2">{{formatoNumero(item.nuevos_sin_gestion_mes,'C')}}</td>
                        <td class="text-center bg-green-light-2">{{formatoNumero(item.sin_gestion_mes,'C')}}</td>
                        <td class="text-center bg-green-light-2">{{item.cobertura}}</td>
                    </tr>
                </tbody>
                <tfoot class="bg-gray-2 font-bold" v-if="datos!=''">
                    <tr>
                        <td colspan="4" class="text-center">TOTAL ({{totalRegistro}})</td>
                        <td class="text-center">{{formatoNumero(total('clientes'),'C')}}</td>
                        <td class="text-right">{{formatoNumero(total('deuda'),'M')}}</td>
                        <td class="text-center">{{formatoNumero(total('gestiones'),'C')}}</td>
                        <td class="text-center">{{formatoNumero(total('contactos'),'C')}}</td>
                        <td class="text-center">{{formatoNumero(total('negociaciones'),'C')}}</td>
                        <td class="text-center">{{formatoNumero(total('nodisponibles'),'C')}}</td>
                        <td class="text-center">{{formatoNumero(total('nocontactos'),'C')}}</td>
                        <td class="text-center">{{formatoNumero(total('clientes_gestionados'),'C')}}</td>
                        <td class="text-center">{{formatoNumero(total('clientes_contacto'),'C')}}</td>
                        <td class="text-center">{{formatoNumero(total('pdps'),'C')}}</td>
                        <td class="text-right">{{formatoNumero(total('montopdps'),'M')}}</td>
                        <td class="text-center">{{formatoNumero(total('nuevos_sin_gestion_mes'),'C')}}</td>
                        <td class="text-center">{{formatoNumero(total('sin_gestion_mes'),'C')}}</td>
                        <td class="text-center">{{formatoNumero(((total('clientes')-total('nuevos_sin_gestion_mes'))/total('clientes'))*100,'M')}}%</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</template>

<script>
    import XLSX from '../../../../node_modules/xlsx';
    export default {
        props:['carteras'],
        data() {
            return {
                dataExportar: [],
                datos: [],
                calls:[],
                loading : false,
                busqueda:{cartera:'',call:'',fechaInicio:'',fechaFin:''},
                mensajeFecInicio:'',
                mensajeFecFin:'',
                mensajeCartera:'',
                viewTable:false,
                totalRegistro:0
            }
        },
        created(){
            this.listarCall();
        },
        methods:{
            listarCall(){
                axios.get("asignacionCall",this.busqueda).then(res=>{
                    if(res.data){
                        this.calls=res.data;
                    }
                });
            },
            generarReporte(){
                this.viewTable=false;
                this.loading=true;
                this.datos=[];
                this.mensajeCartera='';
                this.mensajeFecInicio='';
                this.mensajeFecFin='';
                // var fecha=this.fechaInicio.replace('-','')+"_"+this.fechaFin.replace('-','');
                // console.log(fecha);
                if(this.busqueda.cartera!='' && this.busqueda.fechaInicio!='' && this.busqueda.fechaFin!=''){
                    axios.post("reporteResumenGestor",this.busqueda).then(res=>{
                        if(res.data){
                            this.datos=res.data;
                            this.totalRegistro=this.datos.length;
                            this.loading=false;
                            this.viewTable=true;
                            /*let data = XLSX.utils.json_to_sheet(this.dataExportar)
                            const workbook = XLSX.utils.book_new()
                            const filename = 'Reporte_General'
                            XLSX.utils.book_append_sheet(workbook, data, filename)
                            XLSX.writeFile(workbook, `${filename}.xlsx`)
                            this.btnExportar=false;*/
                        }
                    })
                }else{
                    this.datos=[];
                    this.loading=false;
                    
                    if(!this.busqueda.cartera){
                        this.mensajeCartera="Selecciona una cartera";
                    }
                    if(!this.busqueda.fechaInicio){
                        this.mensajeFecInicio="Selecciona una fecha";
                    }
                    if(!this.busqueda.fechaFin){
                        this.mensajeFecFin="Selecciona una fecha";
                    }
                }
            },
            total(base) {
                return this.datos.reduce( (sum,cur) => sum+parseFloat(cur[base]) , 0);
            },
            formatoNumero(num,tipo){
                if(tipo=='M'){
                    var nStr=parseFloat(num).toFixed(2);
                }else{
                    var nStr=num;
                }
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
        },
        components: {
            XLSX
        }    
    }
</script>

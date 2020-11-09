<template>
    <div >
         <div class="row mt-3 mb-1">
            <div class="col-md-4">
                <div class="px-2">
                    <label for="cartera" class="font-bold col-form-label text-dark text-righ">Nombre de Cartera</label>
                    <select name="cartera" id="cartera" class="form-control" v-model="busqueda.cartera">
                        <option selected value="">Seleccionar</option>
                        <option v-for="(item,index) in carteras" :key="index"  class="option" :value="item.id">{{item.cartera}}</option>
                    </select>
                    <small v-if="mensajeCartera" class="text-danger">{{mensajeCartera}}</small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="px-2">
                    <label for="indicador" class="font-bold col-form-label text-dark text-righ">Perfil</label>
                    <select name="indicador" id="indicador" class="form-control" v-model="busqueda.perfil">
                        <option selected value="">Seleccionar</option>
                        <option class="option" value="1">Administrador</option>
                        <option class="option" value="2">Gestor Telefónico</option>
                    </select>
                </div>
            </div>
        </div>
                 <div class="row mb-3 mt-1">
            <div class="col-md-4">
                <div class="px-2">
                    <label for="cartera" class="font-bold col-form-label text-dark text-righ">Fecha de Gestíon (Desde)</label>
                    <input type="date" class="form-control" v-model="busqueda.fechaInicio">
                    <small v-if="mensajeFecInicio" class="text-danger">{{mensajeFecInicio}}</small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="px-2">
                    <label for="indicador" class="font-bold col-form-label text-dark text-righ">Fecha de Gestíon (Hasta)</label>
                    <input type="date" class="form-control" v-model="busqueda.fechaFin">
                    <small v-if="mensajeFecFin" class="text-danger">{{mensajeFecFin}}</small>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="px-2 py-3">
                    <a href="" @click.prevent="generarReporte()" class="btn btn-outline-blue btn-block waves-effect">
                        <span v-if="loading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Generar Reporte
                    </a>
                </div>
            </div>
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
                loading : false,
                busqueda:{cartera:'',perfil:'',fechaInicio:'',fechaFin:''},
                mensajeFecInicio:'',
                mensajeFecFin:'',
                mensajeCartera:''
            }
        },
        methods:{
            generarReporte(){
                this.loading=true;
                this.datos=[];
                this.mensajeCartera='';
                this.mensajeFecInicio='';
                this.mensajeFecFin='';
                // var fecha=this.fechaInicio.replace('-','')+"_"+this.fechaFin.replace('-','');
                // console.log(fecha);
                if(this.busqueda.cartera!='' && this.busqueda.fechaInicio!='' && this.busqueda.fechaFin!=''){
                    
                    axios.post("reporteGeneralGestiones",this.busqueda).then(res=>{
                        if(res.data){
                            this.dataExportar=res.data;
                            this.loading=false;
                            //Pay attention to the returned data here, some need to add data (res.data) to get it, otherwise the excel file that will be downloaded is [object][object]**
                            /*let blob = new Blob([res.data], { type: 'application/vnd.ms-excel' })
                            let link = document.createElement('a')
                            link.href = window.URL.createObjectURL(blob)
                            link.download = 'comisionjv.xlsx'
                            link.click()*/
                            let data = XLSX.utils.json_to_sheet(this.dataExportar)
                            const workbook = XLSX.utils.book_new()
                            const filename = 'Reporte_General'
                            XLSX.utils.book_append_sheet(workbook, data, filename)
                            XLSX.writeFile(workbook, `${filename}.xlsx`)
                            this.btnExportar=false;
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

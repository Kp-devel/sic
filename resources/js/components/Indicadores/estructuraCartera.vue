<template>
    <div >
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active text-dark" id="nav-cartera-tab" data-toggle="tab" href="#nav-cartera" role="tab" aria-controls="nav-home" aria-selected="true"><i class="fa fa-folder pr-1"></i>Cartera</a>
                <a class="nav-item nav-link text-dark" id="nav-gestion-tab" data-toggle="tab" href="#nav-gestion" role="tab" aria-controls="nav-profile" aria-selected="false"><i class="fa fa-headset pr-1"></i>Gestión</a>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-cartera" role="tabpanel" aria-labelledby="nav-cartera-tab">
                <div class="row my-3">
                    <div class="col-md-4">
                        <div class="px-2">
                            <label for="cartera" class="font-bold col-form-label text-dark text-righ">Nombre de Cartera</label>
                            <select name="cartera" id="cartera" class="form-control" v-model="busqueda.cartera">
                                <option selected value="">Seleccionar</option>
                                <option v-for="(item,index) in carteras" :key="index"  class="option" :value="item.id">{{item.cartera}}</option>
                            </select>
                        </div>
                        <div class="px-2">
                            <label for="ubic" class="font-bold col-form-label text-dark text-righ">Ubicabilidad</label>
                            <select name="ubic" id="ubic" class="form-control" v-model="busqueda.ubicabilidad">
                                <option selected value="">Seleccionar</option>
                                <option class="option" value="todos">TODOS</option>
                                <option class="option" value="cfrn">C-F-R-N</option>
                                <option class="option" value="contacto">CONTACTO</option>
                                <option class="option" value="nocontacto">NO CONTACTO</option>
                                <option class="option" value="nodisponible">NO DISPONIBLE</option>
                                <option class="option" value="inubicable">INUBICABLE</option>
                                <option class="option" value="singestion">SIN GESTIÓN</option>
                            </select>
                        </div>
                        <div class="px-2">
                            <label for="estructura" class="font-bold col-form-label text-dark text-righ">Estructura</label>
                            <select name="estructura" id="estructura" class="form-control" v-model="busqueda.estructura">
                                <option selected value="">Seleccionar</option>
                                <option class="option" value="tramo">TRAMO</option>
                                <option class="option" value="score">SCORE</option>
                                <option class="option" value="dep">DEPARTAMENTO</option>
                                <option class="option" value="entidades">ENTIDADES</option>
                                <option class="option" value="dep_ind">DEP. E IND.</option>
                                <option class="option" value="prioridad">PRIORIDAD</option>
                                <option class="option" value="saldo_deuda">RANGO DE DEUDA</option>
                                <option class="option" value="capital">RANGO CAPITAL</option>
                                <option class="option" value="monto_camp">RANGO IMPORTE CANC.</option>
                            </select>
                        </div>
                        <div class="px-2">
                            <label for="mes" class="font-bold col-form-label text-dark text-righ">Mes</label>
                            <input type="month" id="mes" name="mes" class="form-control" v-model="busqueda.mes">
                        </div>
                        <div class="px-2 py-3">
                            <a href="" @click.prevent="generarReporteCartera()" class="btn btn-outline-blue btn-block waves-effect">Generar Reporte</a>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div v-if="loading==true" class="d-flex justify-content-center pt-5">
                            <div class="pt-5 text-center">
                                <span class="spinner-border spinner-border-lg" role="status" aria-hidden="true"></span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center pt-5" v-else-if="datos==''">
                            <div class="pt-5 text-center">
                                <i class="fa fa-chart-pie fa-2x text-blue"></i>
                                <p>Genera un reporte usando los<br>filtros de la izquierda.</p>
                            </div>
                        </div>
                        <div v-else class="">
                            <div class="d-flex justify-content-center chart-container-pastel " >
                                <PieChart :chart-data="dataGraficaCartera" :options="confGraficaCartera" class="p-0"></PieChart>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="bg-blue text-center text-white">
                                        <tr>
                                            <td>Estructura</td>
                                            <td>Clientes</td>
                                            <td>Capital</td>
                                            <td>Deuda</td>
                                            <td>IC</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item,index) in datos" :key="index" class="text-center">
                                            <td>{{item.estructura}}</td>
                                            <td>{{formatoNumero(item.clientes,'C')}}</td>
                                            <td>{{formatoNumero(item.capital,'M')}}</td>
                                            <td>{{formatoNumero(item.deuda,'M')}}</td>
                                            <td>{{formatoNumero(item.importe,'M')}}</td>
                                        </tr>                   
                                    </tbody>
                                    <tfoot class="text-center font-bold bg-gray">
                                        <tr>
                                            <td>TOTAL</td>
                                            <td>{{formatoNumero(total('clientes'),'C')}}</td>
                                            <td>{{formatoNumero(total('capital'),'M')}}</td>
                                            <td>{{formatoNumero(total('deuda'),'M')}}</td>
                                            <td>{{formatoNumero(total('importe'),'M')}}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end tab panel -->
            <div class="tab-pane fade" id="nav-gestion" role="tabpanel" aria-labelledby="nav-gestion-tab">
                
            </div>
            <!-- end tab panel -->
        </div>
    </div>
</template>

<script>
    import PieChart from '../Chart/PieChart.js';
    import conf from '../Chart/conf.js';
    export default {
        props:['carteras'],
        data() {
            return {
                datos: [],
                loading : false,
                busqueda:{cartera:'',ubicabilidad:'',estructura:'',mes:''},
                dataGraficaCartera:[],
                confGraficaCartera:[],
            }
        },
        methods:{
            generarReporteCartera(){
                this.loading=true;
                this.datos=[];
                if(this.busqueda.cartera!='' && this.busqueda.ubicabilidad!='' && this.busqueda.estructura!='' && this.busqueda.mes!=''){
                    axios.post("reporteEstructuraCartera",this.busqueda).then(res=>{
                        if(res.data){
                            this.datos=res.data;
                            this.loading=false;
                            this.graficaReporteCartera();
                        }
                    })
                }else{
                    setTimeout(() => {
                        this.loading=false;
                        this.datos=[];
                    }, 500);
                }
            },
            graficaReporteCartera(){
                var arrayDatos=[];
                var arrayLabels=[];
                var ultDatos=0;
                for(var i=0;i<this.datos.length;i++){
                    if(i<=6){
                        arrayDatos.push(this.datos[i].clientes);
                        arrayLabels.push(this.datos[i].estructura+" - "+this.formatoNumero(this.datos[i].clientes,'C'));
                    }else{
                        ultDatos+=parseInt(this.datos[i].clientes);
                    }
                }
                if(ultDatos!=0){
                    arrayDatos.push(ultDatos);
                    arrayLabels.push("OTROS - "+this.formatoNumero(ultDatos,'C'));
                }

                this.dataGraficaCartera = {
                    labels: arrayLabels,
                    datasets: [{
                                label: 'mm',
                                data: arrayDatos,
                                backgroundColor: ['#41afa5','rgb(144, 196, 248)','rgb(119, 194, 234)','rgb(224,153,183)','rgb(239,153,120)','rgb(254,246,163)','rgb(226,230,154)','rgb(170,215,210)','rgb(229,229,229)'],
                                borderColor: ['#41afa5','#ffff'],
                                borderWidth: 8
                            }]                
                };

                this.confGraficaCartera={
                    title: {
                        display: true,
                        text: 'RESULTADOS - REPORTE ESTRUCTURA'
                    },
                    // showDatapoints: true,
                    responsive:true,
                    legend: {
                        position: 'right',
                    },
                    maintainAspectRatio: false ,
                    animation: {
                    duration: 0,
                    onComplete: function () {
                      var self = this,
                          chartInstance = this.chart,
                          ctx = chartInstance.ctx;
               
                      ctx.font = '12px Arial';
                      ctx.textAlign = "center";
                      ctx.fillStyle = "#17202A";
               
                      Chart.helpers.each(self.data.datasets.forEach(function (dataset, datasetIndex) {
                          var meta = self.getDatasetMeta(datasetIndex),
                              total = 0, //total values to compute fraction
                              labelxy = [],
                              offset = Math.PI / 2, //start sector from top
                              radius,
                              centerx,
                              centery, 
                              lastend = 0; //prev arc's end line: starting with 0
               
                          for (var val of dataset.data) { total += val; } 
               
                          Chart.helpers.each(meta.data.forEach( function (element, index) {
                              radius = 0.9 * element._model.outerRadius - element._model.innerRadius;
                              centerx = element._model.x;
                              centery = element._model.y;
                              var thispart = dataset.data[index],
                                  arcsector = Math.PI * (2 * thispart / total);
                              if (element.hasValue() && dataset.data[index] > 0) {
                                labelxy.push(lastend + arcsector / 2 + Math.PI + offset);
                              }
                              else {
                                labelxy.push(-1);
                              }
                              lastend += arcsector;
                          }), self)
               
                          var lradius = radius * 3 / 4;
                          for (var idx in labelxy) {
                            if (labelxy[idx] === -1) continue;
                            if(dataset.data[idx] >= 1){//para que muestre en la torta los mayores a 1%
                                var langle = labelxy[idx],
                                    dx = centerx + lradius * Math.cos(langle),
                                    dy = centery + lradius * Math.sin(langle),
                                    val = Math.round(dataset.data[idx] / total * 100);
                                    console.log(val);
                                ctx.fillText(val + '%', dx, dy);
                            }
                          }
               
                      }), self);
                    }
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
            PieChart,            
        }    
    }
</script>

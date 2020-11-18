<template>
    <div >
        <p class="font-bold text-blue"><b>Datos de Campaña</b></p>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="">Seleccionar Cartera</label>
                    <select class="selectpicker form-control" v-model="registro.cartera" @change="addCondiciones(registro.cartera)">
                        <option value="">Seleccionar</option>
                        <option v-for="(item,index) in carteras" :key="index" :value="item.id">{{item.cartera}}</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="">Nombre de la campaña</label>
                    <input type="text" class="form-control" v-model="registro.campana">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="">Usuario Predictivo</label>
                    <input type="text" class="form-control" v-model="registro.usuario">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="">Fecha Predictivo - Desde</label>
                    <input type="datetime-local" class="form-control" v-model="registro.fechaInicio">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="">Fecha Predictivo - Hasta</label>
                    <input type="datetime-local" class="form-control" v-model="registro.fechaFin">
                </div>
            </div>
        </div>
        <p class="font-bold text-blue pt-2"><b>Criterios de Selección</b></p>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <p class="font-bold">1. Tipo de Clientes:</p>
                    <select class="selectpicker form-control " title="Seleccionar"  v-model="detalle.tipo_cliente">
                        <option value="1">Todos los clientes</option>
                        <option value="2">Clientes nuevos</option>
                        <option value="3">Clientes sin gestión en el mes</option>
                    </select>
                </div>   
            </div>
        </div>
        <p class="font-bold">2. Tipo de Cuentas</p>
        <div class="row mt-3">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="">Ubicabilidad</label>
                    <select class="selectpicker form-control input-sb" data-actions-box="true"  multiple title="Seleccionar" v-model="detalle.ubicabilidad" @change="listaRespuestas(detalle.ubicabilidad)" >
                        <option value="0">Contacto</option>
                        <option value="1">No Contacto</option>
                        <option value="2">No Disponible</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Respuesta</label>
                    <select class="selectpicker form-control " data-actions-box="true"  multiple title="..." v-model="detalle.respuesta" :disabled="detalle.ubicabilidad==''"  data-selected-text-format="count > 3">
                        <option v-for="(item,index) in respuestas" :key="index" :value="item.respuesta">{{item.respuesta}}</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row frmmonto">
            <div class="col-md-4 ">
                <label for="">Capital</label>
                <div class="form-group d-flex">    
                        <input type="text" class="form-control input-sb px-0"  value=">=" style="width:10%" disabled>
                        <input type="text" class="form-control input-sb " v-model="detalle.capital_i" >
                        <input type="text" class="form-control input-sb flex-wrap px-0"  value="<=" style="width:10%" disabled>
                        <input type="text" class="form-control input-sb flex-wrap" v-model="detalle.capital_f">
                </div>
            </div>
            <div class="col-md-4">
                <label for="">Deuda</label>
                <div class="form-group d-flex">    
                        <input type="text" class="form-control input-sb px-0"  value=">=" style="width:10%" disabled>
                        <input type="text" class="form-control input-sb " v-model="detalle.deuda_i" >
                        <input type="text" class="form-control input-sb flex-wrap px-0"  value="<=" style="width:10%" disabled>
                        <input type="text" class="form-control input-sb flex-wrap" v-model="detalle.deuda_f">
                </div>
            </div>
            <div class="col-md-4">
                <label for="">Importe</label>
                <div class="form-group d-flex">    
                        <input type="text" class="form-control input-sb px-0"  value=">=" style="width:10%" disabled>
                        <input type="text" class="form-control input-sb " v-model="detalle.importe_i" >
                        <input type="text" class="form-control input-sb flex-wrap px-0"  value="<=" style="width:10%" disabled>
                        <input type="text" class="form-control input-sb flex-wrap" v-model="detalle.importe_f">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3" v-if="scors.length">
                <div class="form-group">
                    <label for="">Score</label>
                    <select v-model="detalle.score" class="selectpicker form-control " data-actions-box="true"  multiple title="..."  data-selected-text-format="count > 3" :disabled="!scors.length">
                        <option v-for="(item,index) in scors" :key="index" :value="item.valor">{{item.valor}}</option>
                    </select>
                </div>   
            </div>
            <div class="col-md-3" v-if="entidades.length">
                <div class="form-group">
                    <label for="">Entidades</label>
                    <select v-model="detalle.entidad" class="selectpicker form-control " data-actions-box="true"  multiple title="..."  data-selected-text-format="count > 3" :disabled="!entidades.length">
                        <option v-for="(item,index) in entidades" :key="index" :value="item.valor">{{item.valor}}</option>
                    </select>
                </div>   
            </div>
            <div class="col-md-3" v-if="prioridades.length">
                <div class="form-group">
                    <label for="">Prioridad</label>
                    <select v-model="detalle.prioridad" class="selectpicker form-control " data-actions-box="true"  multiple title="..."  data-selected-text-format="count > 3" :disabled="!prioridades.length">
                        <option v-for="(item,index) in prioridades" :key="index" :value="item.valor">{{item.valor}}</option>
                    </select>
                </div>   
            </div>
            <div class="col-md-3" v-if="tramos.length">
                <div class="form-group">
                    <label for="">Tramo</label>
                    <select v-model="detalle.tramo" class="selectpicker form-control " data-actions-box="true"  multiple title="..."  data-selected-text-format="count > 3" :disabled="!tramos.length">
                        <option v-for="(item,index) in tramos" :key="index" :value="item.valor">{{item.valor}}</option>
                    </select>
                </div>   
            </div>
            <div class="col-md-3" v-if="zonas.length">
                <div class="form-group">
                    <label for="">Zona</label>
                    <select v-model="detalle.zona" class="selectpicker form-control " data-actions-box="true"  multiple title="..."  data-selected-text-format="count > 3" :disabled="!zonas.length">
                        <option v-for="(item,index) in zonas" :key="index" :value="item.valor">{{item.valor}}</option>
                    </select>
                </div>   
            </div>
        </div>

        <p class="font-bold">3. Tipo de Números</p>
        <div class="row mt-3">
            <div class="col-md-4">
                <div class="form-group">
                    <select class="selectpicker form-control " title="Seleccionar" v-model="detalle.tipo_numeros">
                        <option value="1">Número última gestión</option>
                        <option value="2">Todos los números</option>
                    </select>
                </div>   
            </div>
        </div>
        <div class="my-3">
            <a href="" @click.prevent="generarCampana()" class="btn btn-outline-blue">
                Generar Campaña
            </a>
            <a href="" @click.prevent="limpiar()" class="btn btn-outline-blue">Limpiar</a>
        </div>

        <!-- modal detalle -->
        <div  class="modal modalCarga" tabindex="-1" role="dialog" id="modalDetalle" >
            <div v-if="loadingModal" class="d-flex justify-content-center align-items-center" style="margin-top:150px;">
                <div>
                    <span class="spinner-border spinner-border-xl text-white ml-3" role="status" aria-hidden="true"></span>
                    <p style="font-20px;" class="text-white">Cargando...</p>
                </div>
            </div>
            <div v-else class="d-flex justify-content-center align-items-center" style="margin-top:150px;" >
                <div class="text-center" v-if="viewResultados">
                    <p class="text-white font-25 mb-0">{{resultados}}</p>
                    <p class="text-white">registro(s)</p>
                    <a href="" class="btn btn-white" @click.prevent="cancelar()">Cancelar</a>
                    <a href="" class="btn btn-danger" @click.prevent="registrar()">Registrar Campaña</a>
                </div>
                <div class="text-center" v-else>
                    <p><i class="fa fa-thumbs-up fa-3x text-white"></i></p>
                    <p class="text-white font-20">Campaña Registrada con Éxito!</p>
                    <a href="" class="btn btn-white" @click.prevent="cancelar()">Cancelar</a>
                    <a href="" class="btn btn-danger" @click.prevent="descargar()">Descargar Archivo</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    
    export default {
        props:['carteras'],
        data() {
            return {
                spinnerRegistrar:false,
                viewResultados:false,
                registro:{cartera:'',fechaInicio:'',fechaFin:'',usuario:'',campana:'',detalle:'',codigos:'',numeros:''},
                detalle:{tipo_cliente:'',tipo_numeros:'',ubicabilidad:[],respuesta:[],capital_i:'',capital_f:'',deuda_i:'',deuda_f:'',importe_i:'',importe_f:'',score:[],entidad:[],zona:[],prioridad:[],tramo:[]},
                bloquear:false,
                respuestas:[],
                scors:[],
                entidades:[],
                zonas:[],
                prioridades:[],
                tramos:[],
                resultados:0,
                loadingModal:true
            }
        },
        methods:{
           listaRespuestas(ubi){
                this.respuestas=[];
                if(ubi.length!=0){
                    axios.get("listaRespuesta/"+ubi).then(res=>{
                        if(res.data){
                            this.respuestas=res.data;
                        }
                    })
                }
            },
            addCondiciones(cartera){
                this.scors=[];
                this.entidades=[];
                this.zonas=[];
                this.prioridades=[];
                this.tramos=[];
                if(cartera!=0){
                    axios.get("condiciones/"+cartera).then(res=>{
                        if(res.data){
                            var datos=res.data;
                            this.scors=datos['score'];
                            this.entidades=datos['entidades'];
                            this.zonas=datos['zonas'];
                            this.prioridades=datos['prioridades'];
                            this.tramos=datos['tramos'];
                        }
                    })
                }else{
                    this.mensaje="Selecciona una cartera";
                }
            },
           generarCampana(){
               this.loadingModal=true;
               $('#modalDetalle').modal({backdrop: 'static', keyboard: false});
               axios.post("",this.registro).then(res=>{
                    if(res.data){
                        this.resultados=res.data;
                        this.viewResultados=true;
                        this.loadingModal=false;
                        this.limpiar();
                    }
                });
           },
           limpiar(){
            this.registro={cartera:'',fechaInicio:'',fechaFin:'',usuario:'',campana:'',detalle:'',codigos:'',numeros:''};
            this.detalle={tipo_cliente:'',tipo_numeros:'',ubicabilidad:[],respuesta:[],capital_i:'',capital_f:'',deuda_i:'',deuda_f:'',importe_i:'',importe_f:'',score:[],entidad:[],zona:[],prioridad:[],tramo:[]};
           },
           cancelar(){
               $('#modalDetalle').modal('hide');
               this.viewResultados=false;
           },
           registrar(){
               this.spinnerRegistrar=true;
               axios.post("",this.busqueda).then(res=>{
                    if(res.data=="ok"){
                        this.spinnerRegistrar=false;
                        this.viewResultados=false;
                        this.limpiar();
                    }
                });
           }
        },
        updated() {
            $('.selectpicker').selectpicker('refresh'); 
        },
        components: {
            
        }    
    }
</script>

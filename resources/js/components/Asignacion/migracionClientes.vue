<template>
    <div>
        <div class="row">
            <div class="col-md-5">
                <div class="form-group">
                    <label for="">De</label>
                    <select class="selectpicker form-control" data-size="6" data-live-search="true" title="Seleccionar" v-model="registro.de_usuario" :disabled="bloquear">
                        <option  v-for="(item,index) in usuarios" :key="index" :value="item.id">{{item.nombre}}</option>
                    </select>
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <label for="">A</label>
                    <select class="selectpicker form-control show-tick" data-size="6" data-live-search="true" title="Seleccionar" v-model="registro.a_usuario" :disabled="bloquear">
                        <option  v-for="(item,index) in usuarios" :key="index" :value="item.id">{{item.nombre}}</option>
                    </select>
                </div>
            </div>
        </div>
        <div v-if="viewBtn">
            <a href="" class="btn btn-outline-blue" @click.prevent="calcularIntercambio()">
                <span v-if="spinnerBuscar" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Calcular Intercambio
            </a>
            <a href="" class="btn btn-outline-blue" @click.prevent="limpiar()">Limpiar</a>
        </div>
        <div class="mt-4 mb-3" v-if="viewTabla">
            <div class="row">
                <div class="col-md-4 text-center">
                    <table class="table table-hover">
                        <thead class="bg-blue-3 text-white text-center">
                            <tr>
                                <td colspan="2">ASIGNACIÓN ACTUAL</td>
                            </tr>
                            <tr>
                                <td>Usuario</td>
                                <td>Cant. Clientes</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item,index) in datos" :key="index">
                                <td class="text-left px-2">{{item.usuario}}</td>
                                <td class="text-center">{{item.cantidad_actual}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-1">
                    <div class="d-flex w-100 h-100 justify-content-center align-items-center">
                        <i class="fa fa-exchange-alt"></i>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <table class="table table-hover">
                        <thead class="bg-blue-3 text-white text-center">
                            <tr>
                                <td colspan="2">ASIGNACIÓN A REALIZAR</td>
                            </tr>
                            <tr>
                                <td>Usuario</td>
                                <td>Cant. Clientes</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item,index) in datos" :key="index">
                                <td class="text-left px-2">{{item.usuario}}</td>
                                <td class="text-center">{{item.cantidad}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <a href="" class="btn btn-outline-blue" @click.prevent="generarIntercambio()">
                <span v-if="spinnerIntercambio" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>  
                Generar Intercambio
            </a>
            <a href="" class="btn btn-outline-blue" @click.prevent="viewBtn=true;viewTabla=false;">Cancelar</a>
        </div>
    </div>
</template>

<script>
    
    export default {
        props:['usuarios'],
        data() {
            return {
                spinnerBuscar:false,
                registro:{de_usuario:'',a_usuario:''},
                viewTabla:false,
                datos:[],
                mensaje:{de_usuario:'',a_usuario:''},
                bloquear:false,
                viewBtn:true
            }
        },
        methods:{
            limpiar(){
                this.registro.de_usuario='';
                this.registro.a_usuario='';
            },
            calcularIntercambio(){
                if(this.registro.a_usuario!='' && this.registro.de_usuario!=''){
                    axios.post("consultarIntercambio",this.registro).then(res=>{
                        if(res.data){
                            this.bloquear=true;
                            this.viewBtn=false;
                            this.viewTabla=true;
                        }
                    });
                }else{
                    if(!this.registro.a_usuario){
                        this.mensaje.a_usuario='Completar campo';
                    }
                    if(!this.registro.de_usuario){
                        this.mensaje.de_usuario='Completar campo';
                    }
                }
            }
        },
        updated() {
            $('.selectpicker').selectpicker('refresh'); 
        },
         
    }
</script>

<template>
    <div >
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="">Tipo de Incidencia</label>
                    <select class="form-control" v-model="busqueda.incidencia">
                        <option value="">Seleccionar</option>
                        <option v-for="(item,index) in incidencias" :key="index"  class="option" :value="item.id">{{item.incidencia}}</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="">Fecha</label>
                    <input type="date" class="form-control" v-model="busqueda.fecha">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="text-white">-</label><br>
                    <a href="" @click.prevent="buscar()" class="btn btn-outline-blue px-2">
                        <span v-if="spinnerBuscar" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Buscar
                    </a>
                </div>
            </div>
        </div>
        <div class="table-responsive" v-if="viewTabla">
            <table class="table table-hover">
                <thead class="bg-blue-3 text-white text-center">
                    <tr>
                        <td>Usuario</td>
                        <td>Tipo de Usuario</td>
                        <td>Gestor</td>
                        <td>Incidencia ({{total}})</td>
                        <td>Fecha</td>
                        <td>Detalle</td>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="datos==''" class="text-center">
                        <td colspan="6">No se encontraron registros</td>
                    </tr>
                    <tr v-else v-for="(item,index) in datos" :key="index">
                        <td class="px-2">{{item.usuario}}</td>
                        <td class="px-2">{{item.tipo_usuario}}</td>
                        <td class="px-2">{{item.gestor}}</td>
                        <td class="px-2">{{item.incidencia}}</td>
                        <td class="text-center px-2">{{item.fecha}}
                            <a v-if="item.idIncidencia==4" href="#" id="tooltip"><i class="far fa-calendar text-blue"></i><span class="tooltiptext tooltiptext2 text-center">FR: {{item.fecha_add}}</span></a>
                        </td>
                        <td class="px-2">{{item.detalle}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    
    export default {
        props:['carteras'],
        data() {
            return {
                incidencias:[],
                busqueda:{incidencia:'',fecha:''},
                datos:[],
                spinnerBuscar:false,
                viewTabla:false,
                total:0
            }
        },
        created(){
            this.listarIncidencias();
        },
        methods:{
            listarIncidencias(){
                axios.get("tiposIncidencias").then(res=>{
                    if(res.data){
                        this.incidencias=res.data;
                    }
                });
            },
            buscar(){
                this.spinnerBuscar=true;
                this.viewTabla=false;
                axios.post("buscarIncidencias",this.busqueda).then(res=>{
                    if(res.data){
                        this.datos=res.data;
                        this.total=this.datos.length;
                        this.spinnerBuscar=false;
                        this.viewTabla=true;
                    }
                });
            }
        },
    }
</script>

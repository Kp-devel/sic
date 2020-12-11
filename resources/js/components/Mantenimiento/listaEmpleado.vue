<template>
    <div >
        <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    <label class="font-bold">Código</label>
                    <input class="form-control" v-model="buscar.codigo" @keypress.enter="buscarEmpleados()">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="font-bold">Nombre</label>
                    <input class="form-control" v-model="buscar.nombre" @keypress.enter="buscarEmpleados()">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="font-bold">Perfil</label>
                    <select class="form-control" v-model="buscar.perfil">
                        <option value="">Seleccionar</option>
                        <option value="5">ADMINISTRADOR</option>
                        <option value="1">SUPERVISOR</option>
                        <option value="2">GESTOR TELEFÓNICO</option>
                        <option value="7">RRHH</option>
                        <option value="6">SISTEMAS</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3 form-group">
                <label for="" class="text-white">.</label><br>
                <a href="" class="btn btn-outline-blue mb-3" @click.prevent="buscarEmpleados()">
                    <span v-if="spinnerBuscar" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Buscar
                </a>
            </div>
        </div>
        <div class="table-responsive my-2">
            <paginate ref="paginator" name="lista" :list="lista" :per="20" class="px-0">
                <table class="table table-hover">
                    <thead class="bg-blue-3 text-white text-center">
                        <tr>
                            <td>Código</td>
                            <td>Nombre ({{total}})</td>
                            <td>Meta</td>
                            <td>Perfil</td>
                            <td>Call</td>
                            <td>Local</td>
                            <td>Estado</td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="lista==''">
                            <td colspan="8" class="text-center">No hay resultados</td>
                        </tr>
                        <tr v-else v-for="(item,index) in paginated('lista')" :key="index">
                            <td class="text-center">{{item.codigo}}</td>
                            <td class="text-left px-2">{{item.nombre}}</td>
                            <td class="text-center">{{item.meta}}</td>
                            <td class="text-center">{{item.perfil}}</td>
                            <td class="text-center">{{item.calls}}</td>
                            <td class="text-center">{{item.locals}}</td>
                            <td class="text-center"><span class="badge p-2" :class="{'badge-success':item.idestado==0,'badge-danger':item.idestado!=0}">{{item.estado}}</span></td>
                            <td class="text-center">
                                <a href="" class="btn btn-outline-blue btn-sm"><i class="fa fa-edit fa-sm"></i></a>
                                <a href="" class="btn btn-outline-blue btn-sm"><i class="fa fa-key fa-sm"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </paginate>
        </div>
        <paginate-links  for="lista" v-if="lista.length>0" 
            :async="true"                     
            :limit="4"
            :classes="{'ul': 'pagination', 'li': 'page-item', 'a': 'page-link'}"
        ></paginate-links>
    </div>
</template>

<script>
    import vuePaginate from '../../../../node_modules/vue-paginate';
    export default {
        data() {
            return {
                buscar:{nombre:'',codigo:'',perfil:''},
                spinnerBuscar:'',
                paginate: ['lista'],
                lista:[],
                total:0
            }
        },
        methods:{
            buscarEmpleados(){
                if(this.codigo!='' || this.nombre!='' || this.perfil!=''){
                    this.spinnerBuscar=true;
                    axios.post("listEmpleados",this.buscar).then(res=>{
                        if(res.data){
                            this.lista=res.data;
                            this.total=this.lista.length;
                            this.spinnerBuscar=false;
                        }
                    });
                }
            },
        },
        components: {
            vuePaginate,
        }    
    }
</script>

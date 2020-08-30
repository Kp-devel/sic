<template>
    <div>
        <div class="modal fadeInRight" id="modal-telefonos" tabindex="-1" role="dialog"  aria-hidden="true">
            <div class="modal-dialog modal-dialog-rigth modal-xl" role="document" style="width:280px;">
                <div class="modal-content">
                <div class="modal-header bg-blue pt-3 pl-3 pr-4">
                    <p class="p-title mb-0 text-white"><i class="fa fa-phone pr-3"></i>TELÉFONOS</p>
                    <a href="" class="close " data-dismiss="modal" aria-label="Close">
                        <span class="fa fa-times text-white"></span>
                    </a>
                </div>
                <div class="modal-body overflow-auto pl-3 pr-4 bg-gray-2">
                    <div>
                        <form method="POST" autocomplete="off" @submit.prevent="registrar">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Ingresar teléfono</label>
                                <input type="text" class="form-control form-control-sm" v-model="arreglo.telefono" maxlength="9">
                                <small v-if="mensaje" class="text-danger">{{mensaje}}</small>
                            </div>
                            <button type="submit" class="btn btn-outline-blue btn-sm mb-4">Agregar</button>
                        </form>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="bg-blue text-white text-center">
                                    <tr>
                                        <td colspan="2">Número de Contacto</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- <tr class="text-center" >
                                        <td >No existen datos</td>
                                    </tr> -->
                                    <tr class="text-center" v-for="(item,index) in telefonos" :key="index" v-if="telefonos!=''">
                                        <td class="align-middle">{{item.telefono}}</td>
                                        <td>
                                            <select class="form-control form-control-sm">
                                                <option value="">Activo</option>
                                                <option value="">Inactivo</option>
                                                <option value="">Eliminar</option>
                                            </select>
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
    </div>
</template>

<script>
    export default {
        props:["datos"],
        data() {
            return {
                arreglo:{telefono:'',id:this.datos[0].id},
                mensaje:'',
                telefonos:[],
            }
        },
        created(){
           this.listaTelefonos();
        },
        methods:{
            listaTelefonos(){
                const id= this.datos[0].id;
                //console.log(id);
                axios.get("listaTel?id="+id).then(res=>{
                    if(res.data){
                        this.telefonos=res.data;
                        
                    }
                })
            },
            async registrar(){
               // console.log(this.arreglo);
                try{
                    const response = await axios.post('insertarTel',this.arreglo);
                    //console.log(response);
                    this.mensaje = " Registro con éxito";
                }catch(error){
                    console.error(error)
                    this.mensaje = " Error al Registrar";
                }
            },
        }
    }
</script>

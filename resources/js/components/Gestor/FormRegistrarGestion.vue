<template>
    <div>
        <div class="row px-0 mx-0 my-3 bg-gray-2 rounded">
            <div class="col-md-12">
                <div class="d-flex">
                    <p class=" badge bg-blue text-white py-2 px-3 min-w-125 text-left">REGISTRO DE GESTIÓN</p>
                </div> 
            </div>
            <div class="col-md-6">
                <div class="row px-0 mx-0 pb-2 pt-2">
                    <div class="col-md-6">
                        <table style="width:100%">
                            <tr class="font-12"> 
                                <td class="text-right pr-1" style="width:18px">Teléfono</td>
                                <td class="pb-2">
                                    <select class="form-control font-12 form-control-sm" v-model="telefono">
                                        <option value="">Seleccionar</option>
                                        <template v-for="(item,index) in telefonos" >      
                                            <option v-if="item.ubi>0" style="background-color:#79c753 !important;" :value="item.telefono"  :key="index">{{item.telefono}}</option>
                                            <option v-else-if="item.frec>0 && item.ubi==0" style="background-color:#ffd600 !important;" :value="item.telefono" :key="index">{{item.telefono}}</option>
                                            <option v-else style="background-color:#e46764 !important;" :key="index">{{item.telefono}}</option>
                                        </template>
                                    </select>
                                </td>
                            </tr>
                            <tr class="font-12"> 
                                <td class="text-right pr-1">Ubicabilidad</td>
                                <td class="pb-2">
                                    <select class="form-control font-12 form-control-sm" v-model="ubicabilidad" @change="obtenerRespuestas()" :disabled="telefono==''">
                                        <option value="">Seleccionar</option>
                                        <option value="0">Contacto</option>
                                        <option value="1">No Contacto</option>
                                        <option value="2">No Disponible</option>
                                    </select>
                                </td>
                            </tr>
                            <tr class="font-12"> 
                                <td class="text-right pr-1">Respuesta</td>
                                <td class="pb-2">
                                    <select class="form-control font-12 form-control-sm" :disabled="ubicabilidad==''" v-model="respuesta">
                                        <option value="">Seleccionar</option>
                                        <option v-for="(item,index) in respuestas" :key="index" :value="item.id">{{item.respuesta}}</option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table style="width:100%">
                            <tr class="font-12"> 
                                <td class="text-right pr-1">Fecha PDP</td>
                                <td class="pb-2">
                                    <input type="date" :min="fechaActual" class="form-control font-12 form-control-sm" :disabled="![1,2,43].includes(respuesta)" v-model="fechaPDP">
                                </td>
                            </tr>
                            <tr class="font-12"> 
                                <td class="text-right pr-1">Monto PDP</td>
                                <td class="pb-2">
                                    <input type="text" class="form-control font-12 form-control-sm" :disabled="![1,2,43].includes(respuesta)" v-model="montoPDP">
                                </td>
                            </tr>
                            <tr class="font-12"> 
                                <td class="text-right pr-1">Moneda</td>
                                <td class="pb-2">
                                    <select class="form-control font-12 form-control-sm" :disabled="![1,2,43].includes(respuesta)" v-model="moneda">
                                        <option value="">Seleccionar</option>
                                        <option :value="1">SOLES</option>
                                        <option :value="2">DOLARES</option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>  
            </div>
            <div class="col-md-6">
                <div class="row px-0 mx-0">
                    <div class="col-md-2 text-right">
                        <label class="font-12 pt-2">Detalle de Gestión</label>
                    </div>
                    <div class="col-md-10">
                        <textarea class="form-control w-100" rows="3" :disabled="respuesta==''" v-model="detalle"></textarea>
                        <small style="font-size:10px;">Max. 255 caractéres</small>
                    </div>
                </div>
                <div class="row px-0 mx-0 pt-2 pb-5">
                    <div class="col-md-2">
                        <div class="d-flex py-2">
                            <label class="font-12 pr-1 text-right">Recordatorio</label>
                            <input type="checkbox" class="">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex px-1">
                            <label class="font-12 pr-1 py-2">Fecha</label>
                            <input type="date" class="form-control font-12 form-control-sm" disabled>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex px-1">
                            <label class="font-12 pr-1 py-2">Hora</label>
                            <input type="time" class="form-control font-11 form-control-sm" disabled>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <a href="" class="btn btn-blue btn-block btn-sm" @click.prevent="registrar()">Registrar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>            
</template>

<script>
    export default {
        props:{idCliente:{type:String}},
        data() {
            return {
                respuestas:[],
                detalle:'',
                montoPDP:'',
                fechaPDP:null,
                moneda:'',
                ubicabilidad:'',
                respuesta:'',
                fechaActual:null,
                telefonos:[],
                telefono:'',
                mensaje:'',
            }
        },
        async created(){
            const fecha=new Date();
            let mes=fecha.getMonth()+1;
            let dia=fecha.getDate();
            const anio=fecha.getFullYear();
            mes=mes<10? '0'+mes:mes;
            dia=dia<10? '0'+dia:dia;
            this.fechaActual=`${anio}-${mes}-${dia}`;

            await this.listaTelefonos();
        },
        methods:{
            obtenerRespuestas(){
                if(this.ubicabilidad=="") return;
                this.respuestas=[];
                const id = this.ubicabilidad;
                axios.get("listaRespuesta?id=" + id).then(res=>{
                    if(res.data){
                        this.respuestas=res.data;
                    }
                })
            },

            async listaTelefonos(){
                const id= this.idCliente;
                try{
                    //console.log(id);
                    const res = await axios.get("listaTel?id="+id)
                    if(res.data){
                        this.telefonos=res.data;                           
                    }
                }catch(error){
                    console.error(error);
                }
            },

            async registrar(){
                
                try{
                    const data = {
                        id:this.idCliente,
                        resId:this.respuesta,
                        telefono:this.telefono ,
                        detalle:this.detalle ,
                        fechaPDP:this.fechaPDP,
                        montoPDP:this.montoPDP,
                        moneda:this.moneda,
                    };
                    console.log(data);
                    const response= await axios.post("insertarGestion",data);
                    console.log(response);
                    this.mensaje = "Registrar con éxito";
                }catch(error){
                    console.error(error)
                    this.mensaje = " Error al Registrar";
                }
            },
        }
    }
</script>

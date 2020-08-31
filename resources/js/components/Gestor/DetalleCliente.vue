<template>
    <div>
        <div class="panel-carga bg-white" v-if="loadCarga">
            <div class="d-flex justify-content-center pt-5">
                <div class="spinner-border text-blue" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table width="100%" v-if="infoCliente">
                <tr class="font-12"> 
                    <td class="text-right pr-1">Código</td>
                    <td class=""><label class="form-control font-12 form-control-sm mb-1 w-100 h-100">{{datos[0].codigo?datos[0].codigo:'-'}}</label></td>
                    <td class="font-11 pr-1 text-right">DNI/RUC</td>
                    <td><label class="form-control font-12 form-control-sm mb-1 w-100 h-100">{{datos[0].dni?datos[0].dni:'-'}}</label></td>
                </tr>
                <tr class="font-12"> 
                    <td class="text-right pr-1">Dirección</td>
                    <td colspan="3"><label class="form-control font-12 form-control-sm mb-1 w-100 h-100">{{infoCliente.direccion?infoCliente.direccion:'-'}}</label></td>
                </tr>
                <tr class="font-12"> 
                    <td class="text-right pr-1">Dist.</td>
                    <td><label class="form-control font-12 form-control-sm mb-1 w-100 h-100">{{infoCliente.distrito?infoCliente.distrito:'-'}}</label></td>
                    <td class="text-right pr-1">Prov.</td>
                    <td><label class="form-control font-12 form-control-sm mb-1 w-100 h-100">{{infoCliente.provincia?infoCliente.provincia:'-'}}</label></td>
                </tr>
                <tr class="font-12"> 
                    <td class="text-right pr-1">Depto.</td>
                    <td><label class="form-control font-12 form-control-sm mb-1 w-100 h-100">{{infoCliente.departamento?infoCliente.departamento:'-'}}</label></td>
                    <td class="text-right pr-1">Prioridad</td>
                    <td><label class="form-control font-12 form-control-sm mb-1 w-100 h-100">-</label></td>
                </tr>
                <tr class="font-12"> 
                    <td class="text-right pr-1">C. Laboral</td>
                    <td colspan="3"><label class="form-control font-12 form-control-sm mb-1 w-100 h-100">{{infoCliente.laboral?infoCliente.laboral:'-'}}</label></td>
                </tr>
                <tr class="font-12"> 
                    <td class="text-right pr-1">Sueldo</td>
                    <td colspan="3">
                        <div class="d-flex justify-content-between">
                            <div class="d-flex">
                                <label class="form-control font-12 form-control-sm mb-1 w-100 h-100">{{infoCliente.sueldo? 'S/.'+infoCliente.sueldo:'-' }}</label>
                            </div>
                            <div class="d-flex">
                                <label class="px-1 pt-2">Entidades</label>
                                <label class="form-control font-12 form-control-sm mb-1 w-100 h-100">{{infoCliente.entidades? infoCliente.entidades:'-'}}</label>
                            </div>
                            <div class="d-flex">
                                <label class="px-1 pt-2">Score</label>
                                <label class="form-control font-12 form-control-sm mb-1 w-100 h-100">{{infoCliente.score? infoCliente.score:'-'}}</label>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr class="font-12"> 
                    <td class="text-right pr-1">Email</td>
                    <td colspan="3"><label class="form-control font-12 form-control-sm mb-1 w-100 h-100">{{datos[0].email?datos[0].email:'-'}}</label></td>
                </tr>
            </table>
        </div>
    </div>
</template>

<script>
    export default {
        props:["datos"],
        data() {
            return {
                loadCarga:true,
                infoCliente:{direccion:'',distrito:'',provincia:'',departamento:'',laboral:'',sueldo:'',entidades:'',score:''}
            }
        },
        created(){
           this.infoCLiente();
        },
        methods:{
            infoCLiente(){
                const id= this.datos[0].id;
                //console.log(id);
                axios.get("infoCliente/"+id).then(res=>{
                    if(res.data){
                        const info=res.data;
                        //console.log(this.info);
                        this.infoCliente.direccion=info[0].direccion;
                        this.infoCliente.distrito=info[0].distrito;
                        this.infoCliente.provincia=info[0].provincia;
                        this.infoCliente.departamento=info[0].departamento;
                        this.infoCliente.laboral=info[0].laboral;
                        this.infoCliente.sueldo=info[0].sueldo;
                        this.infoCliente.entidades=info[0].entidades;
                        this.infoCliente.score=info[0].score;
                        this.loadCarga=false;
                    }
                })
            },
        }
    }
</script>

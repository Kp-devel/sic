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
            <table width="100%" v-if="infoClientes">
                <tr class="font-12"> 
                    <td class="text-right pr-1">Código</td>
                    <td class=""><label class="form-control font-12 form-control-sm mb-1 w-100 h-100">{{datos[0].codigo? datos[0].codigo:'-'}}</label></td>
                    <td class="font-11 pr-1 text-right">DNI/RUC</td>
                    <td><label class="form-control font-12 form-control-sm mb-1 w-100 h-100">{{datos[0].dni? datos[0].dni:'-'}}</label></td>
                </tr>
                <tr class="font-12"> 
                    <td class="text-right pr-1">Dirección</td>
                    <td colspan="3"><label class="form-control font-12 form-control-sm mb-1 w-100 h-100">{{infoClientes.direccion}}</label></td>
                </tr>
                <tr class="font-12"> 
                    <td class="text-right pr-1">Dist.</td>
                    <td><label class="form-control font-12 form-control-sm mb-1 w-100 h-100">{{infoClientes.distrito}}</label></td>
                    <td class="text-right pr-1">Prov.</td>
                    <td><label class="form-control font-12 form-control-sm mb-1 w-100 h-100">{{infoClientes.provincia}}</label></td>
                </tr>
                <tr class="font-12"> 
                    <td class="text-right pr-1">Depto.</td>
                    <td><label class="form-control font-12 form-control-sm mb-1 w-100 h-100">{{infoClientes.departamento}}</label></td>
                    <td class="text-right pr-1">Prioridad</td>
                    <td><label class="form-control font-12 form-control-sm mb-1 w-100 h-100">-</label></td>
                </tr>
                <tr class="font-12">
                    <td class="text-right pr-1">C. Laboral</td>
                    <td colspan="3"><label class="form-control font-12 form-control-sm mb-1 w-100 h-100">{{infoClientes.laboral}}</label></td>
                </tr>
                <tr class="font-12"> 
                    <td class="text-right pr-1">Sueldo</td>
                    <td colspan="3">
                        <div class="d-flex justify-content-between">
                            <div class="d-flex">
                                <label class="form-control font-12 form-control-sm mb-1 w-100 h-100">{{infoClientes.sueldo!='-'? 'S/.'+infoClientes.sueldo:'-' }}</label>
                            </div>
                            <div class="d-flex">
                                <label class="px-1 pt-2">Entidades</label>
                                <label class="form-control font-12 form-control-sm mb-1 w-100 h-100">{{infoClientes.entidades}}</label>
                            </div>
                            <div class="d-flex">
                                <label class="px-1 pt-2">Score</label>
                                <label class="form-control font-12 form-control-sm mb-1 w-100 h-100">{{infoClientes.score}}</label>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr class="font-12"> 
                    <td class="text-right pr-1">Email</td>
                    <td colspan="3"><label class="form-control font-12 form-control-sm mb-1 w-100 h-100">{{datos[0].email? datos[0].email:'-'}}</label></td>
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
                infoClientes:{direccion:'-',distrito:'-',provincia:'-',departamento:'-',laboral:'-',sueldo:'-',entidades:'-',score:'-'}
            }
        },
        created(){
           this.infoCLiente();
        },
        methods:{
            async infoCLiente(){
                this.loadCarga = true;
                const id= this.datos[0].id;
                //console.log(id);
                try{
                    let res = await axios.get("infoCliente/"+id)
                    if(res.data && res.data.length>0){
                        const info=res.data;
                        //console.log({res});
                        //console.log(res.data);
                        this.infoClientes.direccion=info[0].direccion? info[0].direccion:'-';
                        //console.log(this.infoClientes.direccion);
                        this.infoClientes.distrito=info[0].distrito? info[0].distrito:'-';
                        this.infoClientes.provincia=info[0].provincia? info[0].provincia:'-';
                        this.infoClientes.departamento=info[0].departamento? info[0].departamento:'-';
                        this.infoClientes.laboral=info[0].laboral? info[0].laboral:'-';
                        this.infoClientes.sueldo=info[0].sueldo? info[0].sueldo:'-';
                        this.infoClientes.entidades=info[0].entidades? info[0].entidades:'-';
                        this.infoClientes.score=info[0].score? info[0].score:'-'; 
                    }
                } catch(err) { console.error(err); }
                finally {this.loadCarga = false;  }
            
            },
        }
    }
</script>

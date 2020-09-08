<template>
    <div>
        <div class="table-responsive">
            <table width="100%" v-for="(item,index) in info" :key="index">
                <tr class="font-12"> 
                    <td class="text-right pr-1">Código</td>
                    <td class=""><label class="form-control font-12 form-control-sm mb-1 w-100 h-100">{{datos[0].codigo? datos[0].codigo:'-'}}</label></td>
                    <td class="font-11 pr-1 text-right">DNI/RUC</td>
                    <td><label class="form-control font-12 form-control-sm mb-1 w-100 h-100">{{formatoVacio(datos[0].dni)}}</label></td>
                </tr>
                <tr class="font-12"> 
                    <td class="text-right pr-1">Dirección</td>
                    <td colspan="3"><label class="form-control font-12 form-control-sm mb-1 w-100 h-100">{{formatoVacio(item.direccion)}}</label></td>
                </tr>
                <tr class="font-12"> 
                    <td class="text-right pr-1">Dist.</td>
                    <td><label class="form-control font-12 form-control-sm mb-1 w-100 h-100">{{formatoVacio(item.distrito)}}</label></td>
                    <td class="text-right pr-1">Prov.</td>
                    <td><label class="form-control font-12 form-control-sm mb-1 w-100 h-100">{{formatoVacio(item.provincia)}}</label></td>
                </tr>
                <tr class="font-12"> 
                    <td class="text-right pr-1">Depto.</td>
                    <td><label class="form-control font-12 form-control-sm mb-1 w-100 h-100">{{formatoVacio(item.departamento)}}</label></td>
                    <td class="text-right pr-1">Prioridad</td>
                    <td><label class="form-control font-12 form-control-sm mb-1 w-100 h-100">-</label></td>
                </tr>
                <tr class="font-12">
                    <td class="text-right pr-1">C. Laboral</td>
                    <td colspan="3"><label class="form-control font-12 form-control-sm mb-1 w-100 h-100">{{formatoVacio(item.laboral)}}</label></td>
                </tr>
                <tr class="font-12"> 
                    <td class="text-right pr-1">Sueldo</td>
                    <td colspan="3">
                        <div class="d-flex justify-content-between">
                            <div class="d-flex">
                                <label class="form-control font-12 form-control-sm mb-1 w-100 h-100">S/.{{formatoVacio(item.sueldo)}}</label>
                            </div>
                            <div class="d-flex">
                                <label class="px-1 pt-2">Entidades</label>
                                <label class="form-control font-12 form-control-sm mb-1 w-100 h-100">{{formatoVacio(item.entidades)}}</label>
                            </div>
                            <div class="d-flex">
                                <label class="px-1 pt-2">Score</label>
                                <label class="form-control font-12 form-control-sm mb-1 w-100 h-100">{{formatoVacio(item.score)}}</label>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr class="font-12"> 
                    <td class="text-right pr-1">Email</td>
                    <td colspan="3"><label class="form-control font-12 form-control-sm mb-1 w-100 h-100">{{formatoVacio(datos[0].email)}}</label></td>
                </tr>
            </table>
        </div>
    </div>
</template>

<script>
    export default {
        props:["datos","info"],
        data() {
            return {
                
            }
        },
        methods:{
            formatoVacio(item){
                if(item=='' || item=='null' || item==' ' || item==null){
                    return '-';
                }else{
                    return item;
                }
            }
        }
    }
</script>

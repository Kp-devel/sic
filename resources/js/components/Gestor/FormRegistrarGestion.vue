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
                                    <select class="form-control font-12 form-control-sm">
                                        <option value=""></option>
                                    </select>
                                </td>
                            </tr>
                            <tr class="font-12"> 
                                <td class="text-right pr-1">Ubicabilidad</td>
                                <td class="pb-2">
                                    <select class="form-control font-12 form-control-sm">
                                        <option value=""></option>
                                    </select>
                                </td>
                            </tr>
                            <tr class="font-12"> 
                                <td class="text-right pr-1">Respuesta</td>
                                <td class="pb-2">
                                    <select class="form-control font-12 form-control-sm">
                                        <option value=""></option>
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
                                    <input type="date" class="form-control font-12 form-control-sm" disabled>
                                </td>
                            </tr>
                            <tr class="font-12"> 
                                <td class="text-right pr-1">Monto PDP</td>
                                <td class="pb-2">
                                    <input type="text" class="form-control font-12 form-control-sm" disabled>
                                </td>
                            </tr>
                            <tr class="font-12"> 
                                <td class="text-right pr-1">Moneda</td>
                                <td class="pb-2">
                                    <input type="text" class="form-control font-12 form-control-sm" disabled>
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
                        <textarea class="form-control w-100" rows="3"></textarea>
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
                        <a href="" class="btn btn-blue btn-block btn-sm">Registrar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>            
</template>

<script>
    export default {
        data() {
            return {

            }
        },
        created(){
           
        },
        methods:{
            
        }
    }
</script>

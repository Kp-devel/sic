<template>
    <div>
        <div class="table-responsive" style="height:265px">
            <table class="table table-hover" v-if="gestiones">
                <thead class="bg-gray">
                    <tr class="text-center">
                        <td class="align-middle font-11">FECHA</td>
                        <td class="align-middle font-11">PERFIL</td>
                        <td class="align-middle font-11">MEDIO</td>
                        <td class="align-middle font-11">UBIC.</td>
                        <td class="align-middle font-11">RESPUESTA</td>
                        <td class="align-middle font-11">DETALLE</td>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item,index) in gestiones" :key="index" v-if="gestiones!=''">
                        <td class="font-11">{{item.fecha}}<br>{{item.hora}}</td>
                        <td class="text-center"><i class="fa fa-user-circle fa-lg"></i></td>
                        <td class="font-11">{{item.medio}}</td>
                        <td class="text-center font-11">{{item.ubic}}</td>
                        
                        <td class="font-11" v-if="item.res_id=='1'">
                            <a href="#" id="mensaje" class="text-black" data-toggle="tooltip" data-placement="bottom" :title="'Fecha PDP: '+item.fecha_pdp +' Monto PDP: '+item.monto_pdp">{{item.respuesta}}</a>
                        </td>
                        <td class="font-11" v-else-if="item.res_id!='1'">
                            {{item.respuesta}}
                        </td>
                        <td class="font-11">{{item.detalle}}</td>
                    </tr>
                </tbody>
            </table>
        </div>                     
    </div>
</template>

<script>
    export default {
        props:["datos"],
        data() {
            return {
                gestiones:[],
                
            }
        },
        created(){
           this.infoGestiones();
        },
        methods:{
            infoGestiones(){
                const id= this.datos[0].id;
                //console.log(id);
                axios.get("historicoGestiones?id="+id).then(res=>{
                    if(res.data){
                        this.gestiones=res.data;
                        //console.log(this.gestiones);
                    }
                })
            },
        },
        updated(){
            $('[data-toggle="tooltip"]').tooltip();
        },
    }
</script>

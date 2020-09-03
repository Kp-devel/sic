<template>
    <div>
        <div class="table-responsive" style="height:265px">
            <table class="table table-hover" v-if="gestiones">
                <thead class="bg-gray">
                    <tr class="text-center">
                        <td class="align-middle font-11" style="width:80px">FECHA</td>
                        <td class="align-middle font-11" style="width:20px">PERFIL</td>
                        <td class="align-middle font-11" style="width:90px">MEDIO</td>
                        <td class="align-middle font-11" style="width:20px">UBIC.</td>
                        <td class="align-middle font-11" style="width:170px">RESPUESTA</td>
                        <td class="align-middle font-11" >DETALLE</td>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="gestiones==''" class="text-center">
                        <td colspan="6">No existen gestiones asociadas al cliente</td>
                    </tr>
                    <tr v-for="(item,index) in gestiones" :key="index" v-else>
                        <td class="font-11">{{item.fecha}}<br>{{item.hora}}</td>
                        <td class="text-center">
                            <i class="fas fa-user-tie fa-lg" v-if="item.tipo==1 || item.tipo==5" ></i>
                            <i class="fa fa-headset fa-lg" v-if="item.tipo==2"></i>
                        </td>
                        <td class="font-11">{{item.medio}}</td>
                        <td class="text-center font-11">{{item.ubic}}</td>
                        
                        <td class="font-11" v-if="item.tolltip==1">
                            <a href="#" class="text-black" data-toggle="tooltip"  data-placement="right" :title="'Fecha: '+item.fecha_pdp +' Monto: '+item.monto_pdp">{{item.respuesta}}</a>
                            <!-- <div class="tooltip bs-tooltip-top" role="tooltip">
                                <div class="arrow"></div>
                                <div class="tooltip-inner">
                                    Some tooltip text!
                                </div>
                            </div> -->
                        </td>
                        <td class="font-11" v-else-if="item.tolltip==0">
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
        props:["idCliente"],
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
                const id= this.idCliente;
                axios.get("historicoGestiones/"+id).then(res=>{
                    if(res.data){
                        this.gestiones=res.data;
                        /*this.$nextTick(function(){
                            $('[data-toggle="tooltip"]').tooltip();
                        })*/
                    }
                })
            },
        },
        updated(){
            // this.$nextTick(function(){
                // $('[data-toggle="tooltip"]').tooltip();
            // })
        },
        mounted() {
            this.$root.$on ('listarGestiones',() => {
                this.infoGestiones();
            } );
        },
    }
</script>

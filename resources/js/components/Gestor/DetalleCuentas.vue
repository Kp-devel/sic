<template>
    <div>
        <div class="table-responsive">
            <table class="table table-hover">
                    <thead class="bg-gray">
                        <tr class="text-center">
                            <td class="align-middle font-11">Nº CUENTA</td>
                            <td class="align-middle font-11">TIPO CUENTA</td>
                            <td class="align-middle font-11">Nº TARJETA</td>
                            <td class="align-middle font-11">PRODUCTO</td>
                            <td class="align-middle font-11">FECHA DEUDA</td>
                            <td class="align-middle font-11">DIAS</td>
                            <td class="align-middle font-11">TRAMO</td>
                            <td class="align-middle font-11">MONEDA</td>
                            <td class="align-middle font-11">CAPITAL</td>
                            <td class="align-middle font-11">DEUDA</td>
                            <td class="align-middle font-11">DTO.</td>
                            <td class="align-middle font-11 bg-white border-0 rounded-0" style="width:5px;"></td>
                            <td class="align-middle font-11">IMP. DTO.</td>
                            <td class="align-middle font-11">IMP. CANC.</td>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <tr v-for="(item,index) in cuentas" :key="index" v-if="cuentas!=''">
                            <td>{{item.cuenta}}</td>
                            <td>{{item.tipo_cuenta}}</td>
                            <td>{{item.tarjeta}}</td>
                            <td>{{item.producto}}</td>
                            <td>{{item.fecha_deuda}}</td>
                            <td>{{item.dias}}</td>
                            <td>{{item.tramo}}</td>
                            <td>{{item.moneda}}</td>
                            <td>{{item.capital}}</td>
                            <td>{{item.deuda}}</td>
                            <td>{{item.dscto}}</td>
                            <td class="border-0 rounded-0">1</td>
                            <td>{{item.importe_dscto}}</td>
                            <td>{{item.importe}}</td>
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
                cuentas:[],
            }
        },
        created(){
           this.infoCuentas();
        },
        methods:{
            infoCuentas(){
                const id= this.datos[0].id;
                //console.log(id);
                axios.get("infoDeuda?id="+id).then(res=>{
                    if(res.data){
                        this.cuentas=res.data;
                        console.log(this.cuentas);
                    }
                })
            },
        },
    }
</script>

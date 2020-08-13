<template>
    <div class="">
        <div class="d-flex">
            <i class="fa fa-desktop pr-2 fa-lg pt-3 text-green"></i>
            <div>
                <p class="subheader-title mb-0">Panel de Control de Llamadas</p>
                <p class="mb-0">Monitoreo en tiempo real</p>
            </div>
    
        </div>
        <div class="py-3 row">
            <div class="col-md-3 form-group">
                <label for="exampleInputPassword1">Cartera</label>
                <select class="form-control">
                    <option value="">Banco Falabella</option>
                    <option value="">Ripley Castigo</option>
                    <option value="">Ripley Provision</option>
                </select>
            </div>
            <div class="col-md-2 form-group">
                <label >Fecha</label>
                <input type="date" class="form-control font-12">
            </div>
            <div class="col-md-3"></div>
            <!-- <div class="col-md-4 alert alert-green">
                <div class="d-flex justify-content-between">
                    <div class="d-flex">
                        <i class="fa fa-headphones-alt pr-2 fa-2x pt-2"></i>
                        <p class="mb-0"><b>1001 - Daniel Mendoza Uribe</b><br>00:10:00</p>
                    </div>
                    <a href=""><i class="fa fa-times"></i></a>
                </div>
            </div> -->
        </div>
        <div class="pb-4">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="text-center bg-blue text-white">
                        <tr>
                            <td class="align-middle">Fecha</td>
                            <td class="align-middle">Agente</td>
                            <td class="align-middle">Tiempo de<br>Logeo</td>
                            <td class="align-middle">Intento<br>Marcaciones</td>
                            <td class="align-middle">Llamadas<br>Conectadas</td>
                            <td class="align-middle">Llamadas<br>No Conectadas</td>
                            <td class="align-middle">Prom. Duración<br>de Llamadas</td>
                            <td class="align-middle">Intervalo de Dur.<br>de Llamadas</td>
                            <td class="align-middle">Número en<br>LLamada</td>
                            <td class="align-middle">Duración de<br>Llamada</td>
                            <td class="align-middle">Escuchar<br>Audio</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center">2020-08-15</td>
                            <td>1001 - Daniel Mendoza Uribe</td>
                            <td class="text-center">00:25:00</td>
                            <td class="text-center">15</td>
                            <td class="text-center">10</td>
                            <td class="text-center">5</td>
                            <td class="text-center">00:15:00</td>
                            <td class="text-center">00:02:00</td>
                            <td>925624122</td>
                            <td class="text-center">00:00:25</td>
                            <td class="text-center"><a href=""><i class="fa fa-volume-down fa-lg"></i></a></td>
                        </tr>
                        <tr>
                            <td class="text-center">2020-08-15</td>
                            <td>1001 - Daniel Mendoza Uribe</td>
                            <td class="text-center">00:25:00</td>
                            <td class="text-center">15</td>
                            <td class="text-center">10</td>
                            <td class="text-center">5</td>
                            <td class="text-center">00:15:00</td>
                            <td class="text-center">00:02:00</td>
                            <td>925624122</td>
                            <td class="text-center">00:00:25</td>
                            <td class="text-center"><a href=""><i class="fa fa-volume-down fa-lg"></i></a></td>
                        </tr>
                        <tr>
                            <td class="text-center">2020-08-15</td>
                            <td>1001 - Daniel Mendoza Uribe</td>
                            <td class="text-center">00:25:00</td>
                            <td class="text-center">15</td>
                            <td class="text-center">10</td>
                            <td class="text-center">5</td>
                            <td class="text-center">00:15:00</td>
                            <td class="text-center">00:02:00</td>
                            <td>925624122</td>
                            <td class="text-center">00:00:25</td>
                            <td class="text-center"><a href=""><i class="fa fa-volume-down fa-lg"></i></a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    import vuePaginate from '../../../../node_modules/vue-paginate';

    export default {
        // props:["vrol"],
        data() {
            return {
                temp:[]
            }
        },
        created(){
            
        },
        methods:{
            listCLientes(){    
                axios.get("listClientes").then(res=>{
                    if(res.data){
                        this.temp=res.data;
                        this.clientes=this.temp;
                        this.total_clientes=this.clientes.length;
                        this.view_carga=false;
                    }
                })
            },
        },
        components:{
           
        }
    }
</script>

<template>
    <div>
        <div class="table-responsive" style="height:265px">
            <table class="table table-hover">
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
                    <tr>
                        <td class="font-11">2020-06-25<br>00:00:00</td>
                        <td class="text-center"><i class="fa fa-user-circle fa-lg"></i></td>
                        <td class="font-11">984526315</td>
                        <td class="text-center font-11">C</td>
                        <td class="font-11"><a href="#" id="mensaje" class="text-black" data-toggle="tooltip" data-placement="bottom" title="Fecha PPD:2020-06-05 Monto PDP:S/.250.00">Compromiso de Pago</a></td>
                        <td class="font-11">tt pago xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx xx x x xxxx xxxxxxx</td>
                    </tr>
                    <tr>
                        <td class="font-11">2020-06-25<br>00:00:00</td>
                        <td class="text-center"><i class="fa fa-user-circle fa-lg"></i></td>
                        <td class="font-11">984526315</td>
                        <td class="text-center font-11">C</td>
                        <td class="font-11">Llamada Rechazada</td>
                        <td class="font-11">tt pago xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx xx x x xxxx xxxxxxx</td>
                    </tr>
                </tbody>
            </table>
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
            
        },
        updated(){
            $('[data-toggle="tooltip"]').tooltip();
        },
    }
</script>

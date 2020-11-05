<template>
    <div >
        <div  class="modal" tabindex="-1" role="dialog" id="modalCarga" >
            <div v-if="loadingModal" class="d-flex justify-content-center align-items-center" style="margin-top:150px;">
                <div>
                    <span class="spinner-border spinner-border-xl text-white ml-3" role="status" aria-hidden="true"></span>
                    <p style="font-20px;" class="text-white">Cargando...</p>
                </div>
            </div>
            <!-- <div v-else class="d-flex justify-content-center align-items-center" style="margin-top:150px;" >
                <div class="text-center">
                    <p><i class="fa fa-thumbs-up fa-4x text-white"></i></p>
                    <p style="font-20px;" class="text-white">Plan de Trabajo Registrado!</p>
                </div>
            </div> -->
        </div>
        <div v-if="viewForm" class="form-crear">
            <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-bold">Nombre de Cartera</label>
                            <select class="form-control" v-model="datos.cartera">
                                <option value="">Seleccionar</option>
                                <option v-for="(item,index) in carteras" :key="index" :value="item.id">{{item.cartera}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label class="font-bold">Nombre de Plan de Trabajo</label>
                            <input type="text" class="form-control" v-model="datos.nombre">
                        </div>
                    </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-2 col-lg-2 col-xl-2">
                    <label for="tramo" class="col-form-label text-dark text-righ"><b>Tramo</b></label>
                    <div class="form-check" v-for="(item,index) in tramos" :key="index">
                        <label class="form-check-label">
                            <input class="form-check-input" name="tramos" type="checkbox" :value="item" checked v-model="arrayTramos">{{item}}
                        </label>
                    </div>
                </div>
                <div class="col-md-4 col-lg-4 col-xl-4">
                    <label for="dep" class="col-form-label text-dark text-center"><b>Departamento</b></label>
                    <div class="row px-0">
                        <div class="col-xs-6 col-md-6 col-lg-6 mr-0 pr-0">
                            <div class="form-check" v-for="(item,index) in departamentos" :key="index" v-if="index<=4">
                                <label class="form-check-label">
                                    <input class="form-check-input" name="deps" type="checkbox" :value="item.valor" v-model="arrayDepartamentos">{{item.nombre}}
                                </label>
                            </div>
                        </div>
                        <div class="col-xs-6 col-md-6 col-lg-6 mr-0 pr-0">
                            <div class="form-check" v-for="(item,index) in departamentos" :key="index" v-if="index>4">
                                <label class="form-check-label">
                                    <input class="form-check-input" name="deps" type="checkbox" :value="item.valor" v-model="arrayDepartamentos">{{item.nombre}}
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-lg-2 col-xl-2">
                    <label for="pri" class="col-form-label text-dark text-righ"><b>Prioridad</b></label>
                    <div class="form-check" v-for="(item,index) in prioridad" :key="index">
                        <label class="form-check-label">
                            <input class="form-check-input" name="prioridades" type="checkbox" :value="item.valor" v-model="arrayPrioridad">{{item.nombre}}
                        </label>
                    </div>
                </div>
                <div class="col-md-2 col-lg-2 col-xl-2">
                    <label for="situacion" class="col-form-label text-dark text-righ"><b>Situación Laboral</b></label>
                    <div class="form-check" v-for="(item,index) in situacion_laboral" :key="index">
                        <label class="form-check-label">
                            <input class="form-check-input " name="situaciones" type="checkbox" :value="item.valor" v-model="arraySituacion">{{item.nombre}}
                        </label>
                    </div>
                </div>
                <div class="col-md-2 col-lg-2 col-xl-2">
                    <label for="call" class="col-form-label text-dark text-righ"><b>Call</b></label>
                    <div class="form-check" v-for="(item,index) in call" :key="index">
                        <label class="form-check-label">
                            <input class="form-check-input" name="calls" type="checkbox" :value="item.valor" v-model="arrayCall">{{item.nombre}}
                        </label>
                    </div>
                </div>
                <div class="col-md-2 col-lg-2 col-xl-2">
                    <label for="sueldo" class="col-form-label text-dark text-righ"><b>Rango Sueldo</b></label>
                    <div class="form-check" v-for="(item,index) in sueldos" :key="index">
                        <label class="form-check-label">
                            <input class="form-check-input" name="sueldos" type="checkbox" :value="item.valor" v-model="arraySueldos">{{item.nombre}}
                        </label>
                    </div>
                </div>
                <div class="col-md-2 col-lg-2 col-xl-2">
                    <label for="capital" class="col-form-label text-dark text-center"><b>Rango Capital</b></label>
                    <div class="form-check" v-for="(item,index) in capital" :key="index">
                        <label class="form-check-label">
                            <input class="form-check-input" name="capitales" type="checkbox" :value="item.valor" v-model="arrayCapital">{{item.nombre}}
                        </label>
                    </div>
                </div>
                <div class="col-md-2 col-lg-2 col-xl-2">
                    <label for="deuda" class="col-form-label text-dark text-righ"><b>Rango Deuda</b></label>
                    <div class="form-check" v-for="(item,index) in deuda" :key="index">
                        <label class="form-check-label">
                            <input class="form-check-input" name="deudas" type="checkbox" :value="item.valor" v-model="arrayDeuda">{{item.nombre}}
                        </label>
                    </div>   
                </div>
                <div class="col-md-2 col-lg-2 col-xl-2">
                    <label for="importe" class="col-form-label text-dark text-righ"><b>Rango IC</b></label>
                    <div class="form-check" v-for="(item,index) in importe" :key="index">
                        <label class="form-check-label" >
                            <input class="form-check-input" name="importes" type="checkbox" :value="item.valor" v-model="arrayImporte">{{item.nombre}}
                        </label>
                    </div>
                </div>
                <div class="col-md-2 col-lg-2 col-xl-2">
                    <label for="ubic" class="col-form-label text-dark text-righ"><b>Ubicabilidad</b></label>
                    <div class="form-check" v-for="(item,index) in ubicabilidad" :key="index">
                        <label class="form-check-label">
                            <input class="form-check-input" name="ubics" type="checkbox" :value="item.valor" v-model="arrayUbicabilidad">{{item.nombre}}
                        </label>
                    </div>
                </div>
                <div class="col-md-2 col-lg-2 col-xl-2">
                    <label class="col-form-label text-dark text-righ"><b>Entidades</b></label>
                    <div class="form-check" v-for="(item,index) in entidades" :key="index">
                        <label class="form-check-label">
                            <input class="form-check-input" name="entidades" type="checkbox" :value="item" v-model="arrayEntidades">{{item}}
                        </label>
                    </div>
                </div>
                <div class="col-md-3 col-lg-3 col-xl-3">
                    <label class="col-form-label text-dark text-righ"><b>Tipo Cliente</b></label>
                    <div class="form-check" v-for="(item,index) in tipoCliente" :key="index">
                        <label class="form-check-label">
                            <input class="form-check-input" name="clientes" type="checkbox" :value="item.valor" v-model="arrayTipo">{{item.nombre}}
                        </label>
                    </div>
                </div>
            </div>
            <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="font-bold">Horario de Atención Desde</label>
                            <input type="date" class="form-control" v-model="datos.fechaInicio">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="font-bold">Horario de Atención Hasta</label>
                            <input type="date" class="form-control" v-model="datos.fechaFin">
                        </div>
                    </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="font-bold">Escribir un speech</label>
                        <textarea name="" id="" class="form-control" rows="3" v-model="datos.speech"></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <a href="" @click.prevent="verResumen()" class="btn btn-outline-blue px-5 mt-2 mb-5">
                        <span v-if="spinnerbuscar" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Continuar
                    </a>
                </div>
            </div>
        </div>
        <div v-else class="form-resumen">
            <div>
                <div class="row fadeInDown">
                    <div class="col-md-5">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td colspan="2" class="font-bold text-center bg-gray">RESUMEN DE PLAN DE TRABAJO</td>
                                </tr>
                                <tr>
                                    <td class="px-3 bg-gray">Cartera</td>
                                    <td class="px-3">{{datos.nombreCartera}}</td>
                                </tr>
                                <tr>
                                    <td class="px-3 bg-gray">Plan de Trabajo</td>
                                    <td class="px-3">{{datos.nombre}}</td>
                                </tr>
                                <tr>
                                    <td class="px-3 bg-gray">Cant. Clientes</td>
                                    <td class="px-3">{{formatoNumero(datos.total,'C')}}</td>
                                </tr>
                                <tr>
                                    <td class="px-3 bg-gray">Fecha</td>
                                    <td class="px-3">{{datos.fechaInicio}} - {{datos.fechaFin}}</td>
                                </tr>
                                <!-- <tr>
                                    <td class="px-3 bg-gray">Tramo</td>
                                    <td class="px-3">{{detalleCondiciones.tramo}}</td>
                                </tr>
                                <tr>
                                    <td class="px-3 bg-gray">Departamento</td>
                                    <td class="px-3">{{detalleCondiciones.departamento}}</td>
                                </tr>
                                <tr>
                                    <td class="px-3 bg-gray">Prioridad</td>
                                    <td class="px-3">{{detalleCondiciones.prioridad}}</td>
                                </tr>
                                <tr>
                                    <td class="px-3 bg-gray">Situación Laboral</td>
                                    <td class="px-3">{{detalleCondiciones.situacion}}</td>
                                </tr>
                                <tr>
                                    <td class="px-3 bg-gray">Call</td>
                                    <td class="px-3">{{detalleCondiciones.call}}</td>
                                </tr>
                                <tr>
                                    <td class="px-3 bg-gray">Rango Sueldo</td>
                                    <td class="px-3">{{detalleCondiciones.sueldo}}</td>
                                </tr>
                                <tr>
                                    <td class="px-3 bg-gray">Rango Capital</td>
                                    <td class="px-3">{{detalleCondiciones.capital}}</td>
                                </tr>
                                <tr>
                                    <td class="px-3 bg-gray">Rango Deuda</td>
                                    <td class="px-3">{{detalleCondiciones.deuda}}</td>
                                </tr>
                                <tr>
                                    <td class="px-3 bg-gray">Rango Importe</td>
                                    <td class="px-3">{{detalleCondiciones.importe}}</td>
                                </tr>
                                <tr>
                                    <td class="px-3 bg-gray">Ubicabilidad</td>
                                    <td class="px-3">{{detalleCondiciones.ubicabilidad}}</td>
                                </tr>
                                <tr>
                                    <td class="px-3 bg-gray">Entidad</td>
                                    <td class="px-3">{{detalleCondiciones.entidad}}</td>
                                </tr>
                                <tr>
                                    <td class="px-3 bg-gray">Tipo de Clientes</td>
                                    <td class="px-3">{{detalleCondiciones.tipo}}</td>
                                </tr> -->
                                <tr>
                                    <td class="px-3 bg-gray">Speech</td>
                                    <td class="px-3">{{datos.speech}}</td>
                                </tr> 
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table">
                            <tbody>
                                <tr class="text-center bg-gray font-bold">
                                    <td>Código</td>
                                    <td>Gestor</td>
                                    <td>Cant. Clientes</td>
                                    <td class="border-0 bg-white"></td>
                                </tr>
                                <tr v-for="(item,index) in usuarios" :key="index">
                                    <td class="text-center">{{item.usuario}}</td>
                                    <td class="px-3">{{item.gestor}}</td>
                                    <td class="text-center">{{formatoNumero(item.cantidad,'C')}}</td>
                                    <td class="text-center border-0 bg-white">
                                        <div class="form-check">
                                            <input class="form-check-input" name="clientes" type="checkbox" :id="'check'+index" checked @change="seleccionCheck(index)">
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot class="">
                                <tr class="text-center bg-gray font-bold">
                                    <td colspan="2">Total clientes seleccionados</td>
                                    <td>{{formatoNumero(totalSelecionado,'C')}}</td>
                                    <td class="border-0 bg-white"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2 mb-5">
                        <a href="" class="btn btn-outline-blue" @click.prevent="regresar()">Regresar</a>
                        <a href="" class="btn btn-blue" v-if="usuarios.length>0" @click.prevent="generarPlan()">Generar Plan de Trabajo</a>
                    </div>
                
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    
    export default {
        props:['carteras'],
        data() {
            return {
                spinnerbuscar:false,
                viewForm:true,
                loadingModal:false,
                datos:{cartera:'',fechaInicio:'',fechaFin:'',nombre:'',speech:'',detalle:'',total:0,nombreCartera:''},
                tramos:[2016,2017,2018,2019,2020],
                departamentos:[{valor:"'Lambayeque'",nombre:'Lambayeque'},{valor:"'Libertad'",nombre:'Trujillo'},{valor:"'Piura'",nombre:'Piura'},{valor:"'Ancash'",nombre:'Ancash'},{valor:"'Lima'",nombre:'Lima'},{valor:"'Arequipa'",nombre:'Arequipa'},{valor:"'Ica'",nombre:'Ica'},{valor:"'Cajamarca'",nombre:'Cajamarca'},{valor:"'Callao'",nombre:'Callao'},{valor:"'Otros'",nombre:'Otros'}],
                prioridad:[{valor:"'Sin Dato'",nombre:'Sin Dato'},{valor:"'P1'",nombre:'P1'},{valor:"'P2'",nombre:'P2'},{valor:"'P3'",nombre:'P3'}],
                situacion_laboral:[{valor:"'Dependiente'",nombre:'Dependiente'},{valor:"'Independiente'",nombre:'Independiente'},{valor:"'Informal'",nombre:'Informal'},{valor:"'Mixto'",nombre:'Mixto'},{valor:"'Sin Dato'",nombre:'Sin Dato'}],
                call:[{valor:"'Call 01'",nombre:'Call 01'},{valor:"'Call 02'",nombre:'Call 02'},{valor:"'Call 03'",nombre:'Call 03'},{valor:"'Sin Call'",nombre:'Sin Call'}],
                sueldos:[{valor:"'AA'",nombre:'0-500'},{valor:"'BB'",nombre:'500-100'},{valor:"'CC'",nombre:'1000-3000'},{valor:"'DD'",nombre:'3000 +'},{valor:"'Sin Dato'",nombre:'Sin Dato'}],
                capital:[{valor:"'AA'",nombre:'0-500'},{valor:"'BB'",nombre:'500-100'},{valor:"'CC'",nombre:'1000-3000'},{valor:"'DD'",nombre:'3000 +'}],
                deuda:[{valor:"'AA'",nombre:'0-500'},{valor:"'BB'",nombre:'500-100'},{valor:"'CC'",nombre:'1000-3000'},{valor:"'DD'",nombre:'3000 +'}],
                importe:[{valor:"'AA'",nombre:'0-500'},{valor:"'BB'",nombre:'500-100'},{valor:"'CC'",nombre:'1000-3000'},{valor:"'DD'",nombre:'3000 +'}],
                ubicabilidad:[{valor:"'C-F-R-N'",nombre:'C-F-R-N'},{valor:"'Contacto'",nombre:'Contacto'},{valor:"'No Disponible'",nombre:'No Disponible'},{valor:"'No Contacto'",nombre:'No Contacto'},{valor:"'Ilocalizado'",nombre:'Ilocalizado'},{valor:"'Sin Gestión'",nombre:'Sin Gestión'}],
                entidades:[1,2,3,4],
                tipoCliente:[{valor:"'Nuevos/Nuevos Castigo'",nombre:'Nuevos/Nuevos Castigo'},{valor:"'Otros'",nombre:'Otros'}],
                arrayTramos:[],
                arrayDepartamentos:[],
                arrayPrioridad:[],
                arraySituacion:[], 
                arrayCall:[],
                arraySueldos:[],
                arrayCapital:[],
                arrayDeuda:[],
                arrayImporte:[],
                arrayUbicabilidad:[],
                arrayEntidades:[],
                arrayTipo:[],
                arrayUsuarios:[],
                usuarios:[],
                totalSelecionado:0,
                detalleCondiciones:{tramo:'',departamento:'',prioridad:'',situacion:'',call:'',sueldo:'',capital:'',deuda:'',importe:'',ubicabilidad:'',entidad:'',tipo:''},
                totales:{tramo:'',departamento:'',prioridad:'',situacion:'',call:'',sueldo:'',capital:'',deuda:'',importe:'',ubicabilidad:'',entidad:'',tipo:''}
            }
        },
        created(){
            this.SeleccionarTodo();
        },
        methods:{
            SeleccionarTodo(){
                this.tramos.forEach(element => {
                    this.arrayTramos.push(element);
                });
                this.departamentos.forEach(element => {
                    this.arrayDepartamentos.push(element.valor);
                });
                this.prioridad.forEach(element => {
                    this.arrayPrioridad.push(element.valor);
                });
                this.situacion_laboral.forEach(element => {
                    this.arraySituacion.push(element.valor);
                });
                this.call.forEach(element => {
                    this.arrayCall.push(element.valor);
                });
                this.sueldos.forEach(element => {
                    this.arraySueldos.push(element.valor);
                });
                this.capital.forEach(element => {
                    this.arrayCapital.push(element.valor);
                });
                this.deuda.forEach(element => {
                    this.arrayDeuda.push(element.valor);
                });
                this.importe.forEach(element => {
                    this.arrayImporte.push(element.valor);
                });
                this.ubicabilidad.forEach(element => {
                    this.arrayUbicabilidad.push(element.valor);
                });
                this.entidades.forEach(element => {
                    this.arrayEntidades.push(element);
                });
                this.tipoCliente.forEach(element => {
                    this.arrayTipo.push(element.valor);
                });
                this.totales.tramo=this.tramos.length;
                this.totales.departamento=this.departamentos.length;
                this.totales.prioridad=this.prioridad.length;
                this.totales.situacion=this.situacion_laboral.length;
                this.totales.call=this.call.length;
                this.totales.sueldo=this.sueldos.length;
                this.totales.capital=this.capital.length;
                this.totales.deuda=this.deuda.length;
                this.totales.importe=this.importe.length;
                this.totales.ubicabilidad=this.ubicabilidad.length;
                this.totales.entidad=this.entidades.length;
                this.totales.tipo=this.tipoCliente.length;
            },
            verResumen(){
                this.totalSelecionado=0;
                this.datos.total=0;
                this.arrayUsuarios=[];
                this.usuarios=[];
                var parametros={
                    cartera:this.datos.cartera,
                    tramo:this.arrayTramos.length==this.totales.tramo?["'TODOS'"]:this.arrayTramos,
                    departamento:this.arrayDepartamentos.length==this.totales.departamento?["'TODOS'"]:this.arrayDepartamentos,
                    prioridad:this.arrayPrioridad.length==this.totales.prioridad?["'TODOS'"]:this.arrayPrioridad,
                    situacion:this.arraySituacion.length==this.totales.situacion?["'TODOS'"]:this.arraySituacion,
                    call:this.arrayCall.length==this.totales.call?["'TODOS'"]:this.arrayCall,
                    sueldo:this.arraySueldos.length==this.totales.sueldo?["'TODOS'"]:this.arraySueldos,
                    deuda:this.arrayDeuda.length==this.totales.deuda?["'TODOS'"]:this.arrayDeuda,
                    capital:this.arrayCapital.length==this.totales.capital?["'TODOS'"]:this.arrayCapital,
                    importe:this.arrayImporte.length==this.totales.importe?["'TODOS'"]:this.arrayImporte,
                    ubicabilidad:this.arrayUbicabilidad.length==this.totales.ubicabilidad?["'TODOS'"]:this.arrayUbicabilidad,
                    entidad:this.arrayEntidades.length==this.totales.entidad?["'TODOS'"]:this.arrayEntidades,
                    tipoCliente:this.arrayTipo.length==this.totales.tipo?["'TODOS'"]:this.arrayTipo
                };
                if(this.datos.cartera!='' && this.datos.nombre!='' && this.datos.fechaInicio!='' && this.datos.fechaFin!=''){
                     this.spinnerbuscar=true;
                    axios.post("resumenPlan",parametros).then(res=>{
                        if(res.data){
                            this.usuarios=res.data;
                            this.spinnerbuscar=false;
                            for(var i=0;i<this.carteras.length;i++){
                                if(this.datos.cartera==this.carteras[i].id){
                                    this.datos.nombreCartera=this.carteras[i].cartera;
                                }
                            }
                            for(var i=0;i<this.usuarios.length;i++){
                                this.datos.total+=parseInt(this.usuarios[i].cantidad);
                                this.arrayUsuarios.push("'"+this.usuarios[i].usuario+"'");
                            }
                            this.totalSelecionado=this.datos.total;
                            this.viewForm=false;
                        }
                    })
                }
            },
            seleccionCheck(index){
                if( $('#check'+index).prop('checked') ) {
                    this.arrayUsuarios.push("'"+this.usuarios[index].usuario+"'");
                    this.totalSelecionado+=parseInt(this.usuarios[index].cantidad);
                }else{
                    this.totalSelecionado-=parseInt(this.usuarios[index].cantidad);
                    for(var i=0;i<this.arrayUsuarios.length;i++){
                        if(this.arrayUsuarios[i]=="'"+this.usuarios[index].usuario+"'"){
                            this.arrayUsuarios.splice(i,1);
                        }
                    }
                }
            },
            regresar(){
                this.viewForm=true;
            },
            generarPlan(){
                this.loadingModal=true;
                $('#modalCarga').modal({backdrop: 'static', keyboard: false});
                var parametros={
                    cartera:this.datos.cartera,
                    plan:this.datos.nombre,
                    nombreCartera:this.datos.nombreCartera,
                    total:this.totalSelecionado,
                    speech:this.datos.speech,
                    fechaInicio:this.datos.fechaInicio,
                    fechaFin:this.datos.fechaFin,
                    usuarios:this.arrayUsuarios,
                    tramo:this.arrayTramos.length==this.totales.tramo?["'TODOS'"]:this.arrayTramos,
                    departamento:this.arrayDepartamentos.length==this.totales.departamento?["'TODOS'"]:this.arrayDepartamentos,
                    prioridad:this.arrayPrioridad.length==this.totales.prioridad?["'TODOS'"]:this.arrayPrioridad,
                    situacion:this.arraySituacion.length==this.totales.situacion?["'TODOS'"]:this.arraySituacion,
                    call:this.arrayCall.length==this.totales.call?["'TODOS'"]:this.arrayCall,
                    sueldo:this.arraySueldos.length==this.totales.sueldo?["'TODOS'"]:this.arraySueldos,
                    deuda:this.arrayDeuda.length==this.totales.deuda?["'TODOS'"]:this.arrayDeuda,
                    capital:this.arrayCapital.length==this.totales.capital?["'TODOS'"]:this.arrayCapital,
                    importe:this.arrayImporte.length==this.totales.importe?["'TODOS'"]:this.arrayImporte,
                    ubicabilidad:this.arrayUbicabilidad.length==this.totales.ubicabilidad?["'TODOS'"]:this.arrayUbicabilidad,
                    entidad:this.arrayEntidades.length==this.totales.entidad?["'TODOS'"]:this.arrayEntidades,
                    tipoCliente:this.arrayTipo.length==this.totales.tipo?["'TODOS'"]:this.arrayTipo
                    // tramo:this.arrayTramos,
                    // departamento:this.arrayDepartamentos,
                    // prioridad:this.arrayPrioridad,
                    // situacion:this.arraySituacion,
                    // call:this.arrayCall,
                    // sueldo:this.arraySueldos,
                    // deuda:this.arrayDeuda,
                    // capital:this.arrayCapital,
                    // importe:this.arrayImporte,
                    // ubicabilidad:this.arrayUbicabilidad,
                    // entidad:this.arrayEntidades,
                    // tipoCliente:this.arrayTipo
                };
                axios.post("insertarPlan",parametros).then(res=>{
                    if(res.data=="ok"){
                        this.loadingModal=false;
                        this.limpiarCampos();
                        this.viewForm=true;
                        setTimeout(() => $('#modalCarga').modal('hide'), 400);
                        toastr.info('Plan de trabajo registrado con éxito', 'Registro Exitoso!',{"progressBar": true,"positionClass": "toast-bottom-right",});
                    }
                });
            },
            limpiarCampos(){
                this.datos.cartera='';
                this.datos.nombre='';
                this.datos.speech='';
                this.datos.detalle='';
                this.datos.fechaInicio='';
                this.datos.fechaFin='';
                this.totalSelecionado=0;
                this.datos.total=0;
                this.datos.nombreCartera='';
                this.SeleccionarTodo();
            },
            formatoNumero(num,tipo){
                if(tipo=='M'){
                    var nStr=parseFloat(num).toFixed(2);
                }else{
                    var nStr=num;
                }
                nStr += '';
                var x = nStr.split('.');
                var x1 = x[0];
                var x2 = x.length > 1 ? '.' + x[1] : '';
                var rgx = /(\d+)(\d{3})/;
                while (rgx.test(x1)) {
                        x1 = x1.replace(rgx, '$1' + ',' + '$2');
                }
                return x1 + x2
            },
        },
        components: {
            
        }    
    }
</script>

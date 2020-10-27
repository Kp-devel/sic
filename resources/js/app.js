require('./bootstrap');

window.Vue = require('vue');

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
// Vue.component('list-clientes', require('./components/Gestor/Clientes.vue').default);
Vue.component('panel-gestor', require('./components/Gestor/PanelGestor.vue').default);
Vue.component('control-llamadas', require('./components/Admin/ControlLlamadas.vue').default);
Vue.component('control-llamadas-gestor', require('./components/Admin/ControlLlamadasGestor.vue').default);
Vue.component('formRegistrarGestion', require('./components/Gestor/FormRegistrarGestion.vue').default);

// sms
Vue.component('sms-bandeja', require('./components/Sms/bandeja.vue').default);
Vue.component('sms-list-campanas', require('./components/Sms/listCampanas.vue').default);
Vue.component('sms-crear-campana', require('./components/Sms/crearCampana.vue').default);
Vue.component('sms-panel-control', require('./components/Sms/panelControl.vue').default);
Vue.component('sms-lista-negra-numero', require('./components/Sms/listaNegraNumero.vue').default);
Vue.component('sms-lista-negra-archivo', require('./components/Sms/listaNegraArchivo.vue').default);
Vue.component('sms-lista-negra-buscar', require('./components/Sms/listaNegraBuscar.vue').default);

// indicadores
Vue.component('estructura-cartera', require('./components/Indicadores/estructuraCartera.vue').default);
Vue.component('estructura-gestor', require('./components/Indicadores/estructuraGestor.vue').default);
Vue.component('seguimiento-plan', require('./components/Indicadores/seguimientoPlan.vue').default);
Vue.component('form-plan', require('./components/Indicadores/formPlan.vue').default);
Vue.component('indicadores-operativos', require('./components/Indicadores/indicadoresOperativos.vue').default);
Vue.component('reporte-general', require('./components/Indicadores/reporteGeneral.vue').default);
Vue.component('reporte-gestor', require('./components/Indicadores/reporteGestor.vue').default);
Vue.component('reporte-gestion-hora', require('./components/Indicadores/reporteGestionHora.vue').default);
Vue.component('reporte-primyult-gestion', require('./components/Indicadores/reportePrimyUltGestion.vue').default);
Vue.component('reporte-resumen-gestion', require('./components/Indicadores/reporteResumenGestion.vue').default);
Vue.component('timing-proyectado', require('./components/Indicadores/timingProyectado.vue').default);
Vue.component('estados-pdps', require('./components/Indicadores/pdpsEstados.vue').default);
Vue.component('estandar-pdps', require('./components/Indicadores/pdpsEstandar.vue').default);
Vue.component('pdps', require('./components/Indicadores/pdps.vue').default);

// incidencias
Vue.component('form-incidencia', require('./components/Incidencias/formIncidencia.vue').default);
Vue.component('list-incidencias', require('./components/Incidencias/listIncidencias.vue').default);

const app = new Vue({
    el: '#app',
});

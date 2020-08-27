require('./bootstrap');

window.Vue = require('vue');

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
// Vue.component('list-clientes', require('./components/Gestor/Clientes.vue').default);
Vue.component('panel-gestor', require('./components/Gestor/PanelGestor.vue').default);
Vue.component('control-llamadas', require('./components/Admin/ControlLlamadas.vue').default);
Vue.component('control-llamadas-gestor', require('./components/Admin/ControlLlamadasGestor.vue').default);

const app = new Vue({
    el: '#app',
});

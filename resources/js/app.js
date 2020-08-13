require('./bootstrap');

window.Vue = require('vue');

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('list-clientes', require('./components/Gestor/Clientes.vue').default);
Vue.component('control-llamadas', require('./components/Admin/ControlLlamadas.vue').default);

const app = new Vue({
    el: '#app',
});

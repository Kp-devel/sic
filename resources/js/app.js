require('./bootstrap');

window.Vue = require('vue');

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('list-clientes', require('./components/Gestor/Clientes.vue').default);
Vue.component('frm-gestor', require('./components/Gestor/Gestor.vue').default);

const app = new Vue({
    el: '#app',
});

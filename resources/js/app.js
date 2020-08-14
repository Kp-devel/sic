require('./bootstrap');

window.Vue = require('vue');
import Vuetify from 'vuetify'
Vue.use(Vuetify);

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('frm-gestion', require('./components/Gestor/Gestion.vue').default);
//Vue.component('list-clientes', require('./components/Gestor/Clientes.vue').default);
//Vue.component('frm-gestor', require('./components/Gestor/Gestor.vue').default);

const app = new Vue({
    el: '#app',
    vuetify: new Vuetify(),
});

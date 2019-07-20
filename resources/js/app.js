/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

// Vue.prototype.$http = windows.axios;
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('departamento', require('./components/Departamento.vue').default);
Vue.component('municipio', require('./components/Municipio.vue').default);
Vue.component('empleado', require('./components/Empleado.vue').default);
Vue.component('zona', require('./components/Zona.vue').default);
Vue.component('barrio', require('./components/Barrio.vue').default);
Vue.component('cliente', require('./components/Cliente.vue').default);
Vue.component('proyecto', require('./components/Proyecto.vue').default);
Vue.component('servicio', require('./components/Servicio.vue').default);
Vue.component('acceso', require('./components/Acceso.vue').default);
Vue.component('contrato', require('./components/Contrato.vue').default);
Vue.component('factura', require('./components/Factura.vue').default);
Vue.component('financiar', require('./components/Financiamiento.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    data: {
        menu : 0
    },

});


/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('persona', require('./components/Persona.vue').default);
Vue.component('comandoremoto', require('./components/ComandoRemoto.vue').default);
Vue.component('situacion', require('./components/Situacion.vue').default);
Vue.component('incidente', require('./components/TipoIncidente.vue').default);

const app = new Vue({
    el: '#app',
    data :{
        menu : 0
    }
});

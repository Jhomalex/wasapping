require('./bootstrap');
window.Vue = require('vue');
window.axios = require('axios');

import '@fortawesome/fontawesome-free/css/all.css'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
import 'chart.js/dist/Chart.min.js'
import { MdField, MdMenu, MdList } from 'vue-material/dist/components'
import 'vue-material/dist/vue-material.min.css'


Vue.use(MdField);
Vue.use(MdMenu);
Vue.use(MdList);

Vue.use(Vuetify,{
    iconfont: 'fa'
});

import dashboard from './components/Dashboard.vue';
import mensajeria from './components/Mensajeria.vue';
import pedidos from './components/Pedidos.vue';
import contactos from './components/Contactos.vue';



const app = new Vue({
    el: '#app',
    components: {
        dashboard,
        mensajeria,
        pedidos,
        contactos,
    }
});

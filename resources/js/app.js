require('./bootstrap')

window.Vue = require('vue').default

import vuetify from '../plugins/vuetify'
import VueSweetalert2 from 'vue-sweetalert2'
import 'sweetalert2/dist/sweetalert2.min.css'

//Router
import { routes } from './router/index'
import VueRouter from 'vue-router'

const router = new VueRouter({
    mode: 'history',
    hash: false,
    routes
})

//SweetAlert
Vue.use(VueSweetalert2)

//App Component
import App from './App.vue'


const app = new Vue({
    router,
    vuetify,
    el: '#app',
    components: { App }
})

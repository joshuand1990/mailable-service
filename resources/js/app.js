import Vue from 'vue'
import VueRouter from 'vue-router'

import routes from './routes.js'
import Layout from './components/Layout';

Vue.config.productionTip = false;

Vue.use(VueRouter)
Vue.component('layout', Layout)

const router = new VueRouter({
    routes
})

const app = new Vue({
    router
}).$mount('#app');
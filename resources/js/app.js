import Vue from 'vue'
import VueRouter from "vue-router";
import router from './routes'
import Layout from './components/Layout';
import axios from 'axios'
import Vuelidate from 'vuelidate'

Vue.config.productionTip = false;
Vue.prototype.$http = axios;

Vue.use(VueRouter)
Vue.use(Vuelidate)

Vue.directive('focus', {
  inserted: function (el) {
    el.focus()
  }
})

const app = new Vue({
    router,
    render: h => h(Layout)
}).$mount('#app');
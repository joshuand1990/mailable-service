

window.axios = require('axios')
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import Vue from 'vue'
import App from './App.vue'

Vue.config.productionTip = false;

Vue.component('App', App);

const app = new Vue({
    el: '#app'
});
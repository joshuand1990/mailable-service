import Vue from 'vue'
import App from './App.vue'

Vue.config.productionTip = false;

const NotFound = { template: '<p>Page not found</p>' }

Vue.component('App', App);

import routes from './routes.js'
window.routes = routes;
const app = new Vue({
    el: '#app',
    data: {
        currentRoute: window.location.pathname
    },
    computed: {
        ViewComponent () {
          return routes[this.currentRoute] || NotFound
        }
    },
    render (h) { return h(this.ViewComponent) }
});
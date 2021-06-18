import VueRouter from 'vue-router'

import Index from "./components/Index";
import Create from "./components/Create";

const routes = [
  { path: '/', name: 'index', component: Index },
  { path: '/create', name: 'create', component: Create }
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})
export default router
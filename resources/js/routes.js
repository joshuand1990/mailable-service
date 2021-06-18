
import App from "./components/App";

const About = { template: '<p>about page</p>' }

export default [
  { path: '/', name: 'home', component: App },
  { path: '/about', name: 'about', component: About}
]
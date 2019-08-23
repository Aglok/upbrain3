import Vue from 'vue'
import VueRouter from 'vue-router'
import App from './App.vue'
import axios from 'axios';
import moment from 'moment';
import sweetalert from 'sweetalert2';


// LightBootstrap plugin
import LightBootstrap from './light-bootstrap-main'

// router setup
import routes from './routes/routes'
// plugin setup
Vue.use(VueRouter);
Vue.use(LightBootstrap);

require('moment/locale/ru');
Vue.prototype.moment = function (...args) {
    return moment(...args);
};
// Vue.prototype.$http = axios;
// Vue.prototype.$http.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.swal = sweetalert;
// configure router
const router = new VueRouter({
  routes, // short for routes: routes
  linkActiveClass: 'nav-item active'
});

/* eslint-disable no-new */
new Vue({
  el: '#app',
  render: h => h(App),
  router,
});

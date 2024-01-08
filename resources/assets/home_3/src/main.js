// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'

// Components
import './components'
//import 'babel-polyfill'
// Plugins
import './plugins'
import vuetify from './plugins/vuetify'
// Sync router with store
import { sync } from 'vuex-router-sync'

import initDataUser from './init-data'

// Application imports
import App from './App'
import i18n from './i18n'
import router from './router'
import store from './store'
import chartist from "vue-chartist";
import VueSilentbox from 'vue-silentbox'

// Sync store with router
sync(store, router)
//Добавляем глобально библиотеки
Vue.use(VueSilentbox)
Vue.use(chartist)
Vue.use(initDataUser)
Vue.config.productionTip = false

/* eslint-disable no-new */
new Vue({
  i18n,
  vuetify,
  router,
  store,
  render: h => h(App)
}).$mount('#app')

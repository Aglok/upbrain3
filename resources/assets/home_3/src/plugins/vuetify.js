import Vue from 'vue'
import Vuetify from 'vuetify'
import theme from './theme'
import '@fortawesome/fontawesome-free/css/all.css'
import '@mdi/font/css/materialdesignicons.css'


const MY_ICONS = {
  'experience': 'experience',
  'gold': 'gold'
}

Vue.use(Vuetify, {
  iconfont: 'fa',
  theme,
  icons: MY_ICONS
})

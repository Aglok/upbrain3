import Vue from 'vue'
import Vuetify from 'vuetify'
import '@fortawesome/fontawesome-free/css/all.css'
import '@mdi/font/css/materialdesignicons.css'
import themes from './themes'

const MY_ICONS = {
    'experience': 'experience',
    'gold': 'gold'
}

const options = {
    icons:{
        iconfont: 'fa',
        values: MY_ICONS,
    },
    theme: {
        themes: {light: themes.light}
    }
}

Vue.use(Vuetify)

export default new Vuetify(options)
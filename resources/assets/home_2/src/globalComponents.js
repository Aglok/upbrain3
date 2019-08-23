import fgInput from './components/UIComponents/Inputs/formGroupInput.vue'
import DropDown from './components/UIComponents/Dropdown.vue'
import VueSilentbox from 'vue-silentbox'
import AccordionMenu from './components/UIComponents/AccordionMenu.vue'

/**
 * You can register global components here and use them as a plugin in your main Vue instance
 */

const GlobalComponents = {
  install (Vue) {
    Vue.use(VueSilentbox);
    Vue.use(AccordionMenu);
    Vue.component('fg-input', fgInput)
    Vue.component('drop-down', DropDown)
    Vue.component('accordion-menu', AccordionMenu)
  }
}

export default GlobalComponents

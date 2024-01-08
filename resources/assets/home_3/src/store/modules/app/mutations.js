import { set, toggle } from '../../../utils/vuex'

export default {
  setReady: set('ready'),
  setDrawer: set('drawer'),
  setImage: set('image'),
  setColor: set('color'),
  toggleDrawer: toggle('drawer'),
  setUser: set('user'),
  setSubject: set('math'),
  setSlots: set('slots'),
  setItems: set('items_bag'),
  setBattles: set('battles'),
}

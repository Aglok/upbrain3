// https://vuex.vuejs.org/en/modules.html

const requireModule = require.context('.', true, /\.js$/)
const modules = {}

requireModule.keys().forEach(fileName => {
  if (fileName === './index.js') return

  // Replace ./ and .js
  const path = fileName.replace(/(\.\/|\.js)/g, '')
  //moduleName - папка app, imported - файлы внутри app/mutation.js
  const [moduleName, imported] = path.split('/')

  if (!modules[moduleName]) {
    modules[moduleName] = {
      //Для каждого модуля создать собственное пространство имён
      namespaced: true
    }
  }
  //Сохраняем модуль modules[app][mutations] = содержимое модуля
  modules[moduleName][imported] = requireModule(fileName).default
})

export default modules

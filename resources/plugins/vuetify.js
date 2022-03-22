import Vue from 'vue'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'

import es from 'vuetify/lib/locale/es'
  
Vue.use(Vuetify)

const opts = {}

export default new Vuetify({
    lang: {
      locales: { es },
      current: 'es',
    },
    theme: {
        dark: true
    }
})

import Vue from 'vue'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'

Vue.use(Vuetify)

const opts = {
    icons:{
        iconfont: 'mdi',
    },
    breakpoint: {
        thresholds: {
          xs: 640,
          sm: 768,
          md: 1024,
          lg: 1280,
        },
        scrollbarWidth: 10
      }
}

export default new Vuetify(opts)

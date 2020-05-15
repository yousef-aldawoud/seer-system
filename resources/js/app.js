window.Vue = require('vue');

import vuetify from './vuetify'
import 'vuetify/dist/vuetify.min.css'

Vue.component('example', require('./components/ExampleComponent.vue').default);

window.vuetify = vuetify
const app = new Vue({
    vuetify,
    el: '#app',
});
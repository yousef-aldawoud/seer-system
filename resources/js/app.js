window.Vue = require('vue');

import vuetify from './vuetify'
import 'vuetify/dist/vuetify.min.css'

Vue.component('navbar', require('./components/Navbar.vue').default);
Vue.component('search-page', require('./components/SearchPage.vue').default);
Vue.component('search-result', require('./components/SearchResult.vue').default);
Vue.component('example', require('./components/ExampleComponent.vue').default);
Vue.component('login', require('./components/Login.vue').default);

window.vuetify = vuetify
const app = new Vue({
    vuetify,
    el: '#app',
});
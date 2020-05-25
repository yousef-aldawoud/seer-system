window.Vue = require('vue');

import CKEditor from '@ckeditor/ckeditor5-vue';
import vuetify from './vuetify'
import 'vuetify/dist/vuetify.min.css'

Vue.use( CKEditor );
Vue.component('confirm', require('./components/Confirm.vue').default);
Vue.component('admin-posts', require('./components/admin/Posts.vue').default);
Vue.component('admin-users', require('./components/admin/Users.vue').default);
Vue.component('admin-dashboard', require('./components/admin/Dashboard.vue').default);
Vue.component('admin-navbar', require('./components/admin/Navbar.vue').default);
Vue.component('navbar', require('./components/Navbar.vue').default);
Vue.component('search-page', require('./components/SearchPage.vue').default);
Vue.component('search-result', require('./components/SearchResult.vue').default);
Vue.component('example', require('./components/ExampleComponent.vue').default);
Vue.component('login', require('./components/Login.vue').default);
Vue.component('posts', require('./components/Posts.vue').default);
Vue.component('post-edit', require('./components/PostEdit.vue').default);
Vue.component('post-page', require('./components/PostPage.vue').default);
Vue.component('references', require('./components/References.vue').default);
Vue.component('reference-dialog', require('./components/ReferenceDialog.vue').default);
Vue.component('references-dialog', require('./components/ReferencesDialog.vue').default);

window.vuetify = vuetify
const app = new Vue({
    vuetify,
    el: '#app',
});
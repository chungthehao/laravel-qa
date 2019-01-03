
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

// import fontawesome.js file
require('./fontawesome');

window.Vue = require('vue');

import VueIziToast from 'vue-izitoast';
import 'izitoast/dist/css/iziToast.min.css';
import Authorization from './authorization/authorize';

Vue.use(VueIziToast);
Vue.use(Authorization);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('user-info', require('./components/UserInfo.vue'));
// Vue.component('answer', require('./components/Answer.vue')); Chỉ dùng trong Answers.vue component
// Vue.component('favorite', require('./components/Favorite.vue')); // Chỉ dùng trong Vote.vue, ko cần lấy ở đây
// Vue.component('accept', require('./components/Accept.vue')); // Chỉ dùng trong Vote.vue, ko cần lấy ở đây
Vue.component('vote', require('./components/Vote.vue'));
Vue.component('answers', require('./components/Answers.vue'));

const app = new Vue({
    el: '#app'
});

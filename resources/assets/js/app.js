
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
import router from './router';
import Spinner from './components/Spinner.vue';

Vue.use(VueIziToast);
Vue.use(Authorization);


Vue.component('spinner', Spinner);


const app = new Vue({
    el: '#app',
    router
});

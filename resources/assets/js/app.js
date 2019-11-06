
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

    data: { loading: false, interceptor: null },

    created() {
        this.enableInterceptor();
    },

    methods: {
        enableInterceptor() {
            // Add a request interceptor
            this.interceptor = axios.interceptors.request.use(config => {
                // Do something before request is sent
                console.log('Request intercepted');
                this.loading = true;
                return config;
            }, error => {
                // Do something with request error
                this.loading = false;
                return Promise.reject(error);
            });

            // Add a response interceptor
            axios.interceptors.response.use(response => {
                // Any status code that lie within the range of 2xx cause this function to trigger
                // Do something with response data
                console.log('Response intercepted');
                this.loading = false;
                return response;
            }, error => {
                // Any status codes that falls outside the range of 2xx cause this function to trigger
                // Do something with response error
                this.loading = false;
                return Promise.reject(error);
            });
        },
        disableInterceptor() {
            axios.interceptors.request.eject(this.interceptor);
        }
    },

    router
});

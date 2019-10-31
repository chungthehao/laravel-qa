import Vue from 'vue'
import VueRouter from 'vue-router'

import routes from './routes';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes,
    linkActiveClass: 'active' // https://router.vuejs.org/api/#active-class
});

// https://router.vuejs.org/guide/advanced/navigation-guards.html#global-before-guards
router.beforeEach((to, from, next) => {
    // https://router.vuejs.org/guide/advanced/meta.html
    // https://router.vuejs.org/guide/advanced/navigation-guards.html#the-full-navigation-resolution-flow
    if (to.matched.some(record => record.meta.requiresAuth) && !window.Auth.signedIn) {
        window.location = window.Urls.login;
        return;
    }

    next(); // make sure to always call next()!
});

export default router;
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

Vue.config.debug = true;
Vue.config.devtools = true;

import router from "./router";
import store from "./store";

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    router,
    store,
    el: '#app',
    computed: {
        auth() {
            return store.getters.auth
        }
    },
    created() {
        if(new Date(localStorage.getItem('time')) < new Date()) {
            localStorage.removeItem('token');
            localStorage.removeItem('time');
        }
    }
});



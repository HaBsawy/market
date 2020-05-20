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
import axios from "axios";

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    router,
    el: '#app',
    data() {
        return {
            login: localStorage.getItem('token')
        };
    },
    methods: {
        logout() {
            axios.post("http://127.0.0.1:8000/api/logout?token=" + localStorage.getItem('token'))
                .then(response => {
                    console.log(response.data);
                    localStorage.removeItem("token");
                });
        }
    }
});



import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        login: localStorage.getItem('token')
    },
    getters: {
        auth: state => state.login
    },
    mutations: {
        logout(state) {
            state.login = undefined;
        },
        login(state) {
            state.login = localStorage.getItem('token');
        }
    },
    actions: {},
    modules: {}
});

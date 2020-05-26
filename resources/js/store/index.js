import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        login: localStorage.getItem('token'),
        expiredAt: localStorage.getItem('time'),
        auth: {
            username: localStorage.getItem('username'),
            email: localStorage.getItem('email'),
            role: localStorage.getItem('role'),
        }
    },
    getters: {
        login: state => state.login,
        auth: state => state.auth,
        expiredAt: state => state.expiredAt,
    },
    mutations: {
        logout(state) {
            state.login = undefined;
            state.expiredAt = undefined;
            state.auth = {
                username: undefined,
                email: undefined,
                role: undefined,
            };
            localStorage.removeItem('token');
            localStorage.removeItem('time');
            localStorage.removeItem('username');
            localStorage.removeItem('email');
            localStorage.removeItem('role');
        },
        login(state, data) {
            state.login = data.access_token;
            state.expiredAt = data.date;
            state.auth = {
                username: data.user.username,
                email: data.user.email,
                role: data.user.role,
            };
            localStorage.setItem('token', data.access_token);
            localStorage.setItem('time', data.date);
            localStorage.setItem('username', data.user.username);
            localStorage.setItem('email', data.user.email);
            localStorage.setItem('role', data.user.role);
        }
    },
    actions: {},
    modules: {}
});

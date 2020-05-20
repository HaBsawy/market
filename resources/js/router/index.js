import Vue from "vue";
import VueRouter from "vue-router";
import Login from "../views/login";
import Register from "../views/register";

Vue.use(VueRouter);

const routes = [
    {
        path: "/",
        name: "Home",
        // component: Login
    },
    {
        path: "/login",
        name: "Login",
        component: Login
    },
    {
        path: "/register",
        name: "Register",
        component: Register
    }
];

const router = new VueRouter({
    mode: "history",
    base: process.env.BASE_URL,
    routes
});

export default router;

import Vue from "vue";
import VueRouter from "vue-router";
import Home from "../views/home";
import Login from "../views/login";
import Register from "../views/register";
import Category from "../views/Category";
import Product from "../views/Product";
import User from "../views/User";

Vue.use(VueRouter);

const routes = [
    {
        path: "/",
        name: "Home",
        component: Home
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
    },
    {
        path: "/category",
        name: "Category",
        component: Category
    },
    {
        path: "/product",
        name: "Product",
        component: Product
    },
    {
        path: "/user",
        name: "User",
        component: User
    }
];

const router = new VueRouter({
    mode: "history",
    base: process.env.BASE_URL,
    routes
});

export default router;

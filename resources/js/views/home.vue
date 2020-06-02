<template>
    <div>
        <app-header></app-header>
        <section class="content container">
            <app-aside v-if="auth.role === 'admin'"></app-aside>
            <app-products></app-products>
        </section>
    </div>
</template>

<script>
    import AppHeader from "../components/AppHeader";
    import AppAside from "../components/AppAside";
    import store from "../store";
    import AppProducts from "../components/AppProducts";

    export default {
        name: "Home",
        computed: {
            login() {
                return store.getters.login;
            },
            auth() {
                return store.getters.auth
            },
            expiredAt() {
                return store.getters.expiredAt;
            }
        },
        components: {
            AppProducts,
            AppAside,
            AppHeader
        },
        created() {
            if(new Date(this.expiredAt) < new Date()) {
                store.commit('logout');
            }
        }
    }
</script>

<style scoped lang="scss">
    .content {
        padding-top: 150px;
        overflow: hidden;
    }

    @media (max-width: 1199.98px) {
        .content {
            padding-top: 125px;
            overflow: hidden;
        }
    }
</style>

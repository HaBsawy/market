<template>
    <div class="cart">
        <app-header></app-header>
        <alert></alert>
        <section class="content container">
            <h2 class="text-center">My Cart</h2>
            <cart-list></cart-list>
        </section>
    </div>
</template>

<script>
    import AppHeader from "../components/AppHeader";
    import Alert from "../components/Alert/Alert";
    import CartList from "../components/Cart/CartList";
    import store from "../store";
    export default {
        name: "Cart",
        computed: {
            login() {
                return store.getters.login;
            },
            auth() {
                return store.getters.auth;
            },
            expiredAt() {
                return store.getters.expiredAt;
            }
        },
        components: {CartList, Alert, AppHeader},
        created() {
            if(new Date(this.expiredAt) < new Date()) {
                store.commit('logout');
            }

            if (!this.login) {
                this.$router.push('/login');
            }
        }
    }
</script>

<style scoped lang="scss">
    .content {
        padding-top: 150px;
        overflow: hidden;

        h2 {
            margin: 20px 0;
        }
    }

    @media (max-width: 1199.98px) {
        .content {
            padding-top: 125px;
            overflow: hidden;
        }
    }
</style>

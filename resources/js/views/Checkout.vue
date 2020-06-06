<template>
    <div class="checkout">
        <app-header></app-header>
        <alert></alert>
        <section class="content container">
            <h2 class="text-center">Checkouts</h2>
            <checkout-list></checkout-list>
        </section>
    </div>
</template>

<script>
    import AppHeader from "../components/AppHeader";
    import Alert from "../components/Alert/Alert";
    import store from "../store";
    import CheckoutList from "../components/Checkout/CheckoutList";
    export default {
        name: "Checkout",
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
        components: {CheckoutList, Alert, AppHeader},
        created() {
            if(new Date(this.expiredAt) < new Date()) {
                store.commit('logout');
            }

            if (!this.login || this.auth.role !== 'admin') {
                this.$router.push('/');
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

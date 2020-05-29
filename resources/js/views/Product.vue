<template>
    <section class="product">
        <app-header></app-header>
        <div class="content container">
            <alert></alert>
            <h2 class="text-center">Products</h2>
            <add-product></add-product>
            <product-list></product-list>
        </div>
    </section>
</template>

<script>
    import AppHeader from "../components/AppHeader";
    import Alert from "../components/Alert/Alert";
    import AddProduct from "../components/Product/AddProduct";
    import ProductList from "../components/Product/ProductList";
    import store from "../store";
    export default {
        name: "Product",
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
        components: {ProductList, AddProduct, Alert, AppHeader},
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
    .product {

        .content {
            padding-top: 150px;

            h2 {
                margin: 20px 0;
            }
        }
    }

    @media (max-width: 1199.98px) {
        .product .content {
            padding-top: 125px;
            overflow: hidden;
        }
    }
</style>

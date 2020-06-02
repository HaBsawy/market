<template>
    <section class="user">
        <app-header></app-header>
        <div class="content container">
            <alert></alert>
            <h2 class="text-center">Users</h2>
            <user-list></user-list>
        </div>
    </section>
</template>

<script>
    import store from "../store";
    import AppHeader from "../components/AppHeader";
    import Alert from "../components/Alert/Alert";
    import UserList from "../components/User/UserList";

    export default {
        name: "User",
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
        components: {UserList, Alert, AppHeader},
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
    .user {

        .content {
            padding-top: 150px;

            h2 {
                margin: 20px 0;
            }
        }
    }

    @media (max-width: 1199.98px) {
        .user .content {
            padding-top: 125px;
            overflow: hidden;
        }
    }
</style>

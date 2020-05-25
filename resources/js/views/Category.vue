<template>
    <section class="category">
        <app-header></app-header>
        <div class="content container">
            <h2 class="text-center">Categories</h2>
            <add-category></add-category>
            <category-list></category-list>
        </div>
    </section>
</template>

<script>
    import AppHeader from "../components/AppHeader";
    import store from "../store";
    import AddCategory from "../components/Category/AddCategory";
    import CategoryList from "../components/Category/CategoryList";
    export default {
        name: "Category",
        data() {
            return {
                auth: store.getters.auth
            };
        },
        components: {CategoryList, AddCategory, AppHeader},
        created() {
            if (!this.auth) {
                this.$router.push('/');
            }
        }
    }
</script>

<style scoped lang="scss">
    .category {

        .content {
            padding-top: 150px;

            h2 {
                margin: 20px 0;
            }
        }
    }

    @media (max-width: 1199.98px) {
        .category .content {
            padding-top: 125px;
            overflow: hidden;
        }
    }
</style>

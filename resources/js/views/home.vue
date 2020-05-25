<template>
    <div>
        <app-header></app-header>
        <section class="content container">
            <app-aside></app-aside>
        </section>
    </div>
</template>

<script>
    import AppHeader from "../components/AppHeader";
    import AppAside from "../components/AppAside";

    export default {
        name: "Home",
        components: {
            AppAside,
            AppHeader
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

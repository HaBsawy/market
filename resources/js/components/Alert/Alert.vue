<template>
    <section v-if="alert" :class="`alert bg-${alertData.alertType}`">
        <div @click="closeAlert" class="close">
            <i class="fas fa-times"></i>
        </div>
        <h5>{{ alertData.alertType }}</h5>
        <p>{{ alertData.alertMSG }}</p>
    </section>
</template>

<script>
    import store from '../../store';
    export default {
        name: "Alert",
        computed: {
            alert() {
                return store.getters.alert;
            },
            alertData() {
                return store.getters.alertData;
            }
        },
        methods: {
            closeAlert() {
                store.commit('closeAlert');
            }
        }
    }
</script>

<style scoped lang="scss">
    .alert {
        position: fixed;
        top: 50px;
        right: 50px;
        width: 300px;
        color: #fff;
        z-index: 1051;

        p {
            margin: 0;
        }

        .close {
            cursor: pointer;
        }
    }

    @media (max-width: 576px) {
        .alert {
            right: 2.5%;
            width: 95%;
        }
    }
</style>

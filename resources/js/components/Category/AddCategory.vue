<template>
    <div class="new">
        <button @click="toggleCreateModal" class="btn btn-primary">Add New Category</button>
        <div :class="['modal', 'create-modal', {'active' : createModal}]">
            <div class="body">
                <form @submit.prevent="addCategory">
                    <h3>Create New Category</h3>
                    <div class="input-control">
                        <label>Name</label>
                        <input type="text" v-model="newCategory.name" class="form-control" />
                        <p v-if="newCategory.errors.name" class="text-danger">{{ newCategory.errors.name[0] }}</p>
                    </div>
                    <div class="button-control">
                        <button type="button" @click="toggleCreateModal" class="btn btn-secondary">Cancel</button>
                        <button class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from "axios";
    import store from "../../store";

    export default {
        name: "AddCategory",
        data() {
            return {
                createModal: false,
                newCategory: {
                    name: '',
                    errors: {
                        name: null
                    }
                }
            };
        },
        methods: {
            toggleCreateModal() {
                this.createModal = !this.createModal;
            },
            addCategory() {
                axios.post("http://192.168.1.103:8000/api/categories?token=" + localStorage.getItem('token'), {
                    'name': this.newCategory.name
                }).then(response => {
                    this.newCategory = {
                        name: '',
                        errors: {
                            name: null
                        }
                    };
                    this.createModal = false;
                    store.commit('openAlert', {
                        alertType: 'success',
                        alertMSG: response.data.message
                    });
                }).catch(error => {
                    this.newCategory.errors = error.response.data.errors;
                    store.commit('openAlert', {
                        alertType: 'danger',
                        alertMSG: error.response.data.message
                    });
                });
            }
        }
    }
</script>

<style scoped lang="scss">
    .create-modal {
        background-color: rgba(10,10,10,0.5);
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;

        &.active {
            display: block;
        }

        .body {
            margin: 100px auto;
            width: 400px;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            overflow: hidden;

            form {

                .input-control {
                    margin-bottom: 20px;

                    label {
                        display: block;
                        margin: 0;
                    }

                    input {
                        display: block;
                    }

                    p.text-danger {
                        margin-left: 10px;
                    }
                }

                .button-control {
                    float: right;
                }
            }
        }
    }

    @media (max-width: 575.98px) {
        .create-modal .body {
            width: 95%;
        }
    }
</style>

<template>
    <div class="new">
        <button @click="toggleCreateModal" class="btn btn-primary">Add New Product</button>
        <div :class="['modal', 'create-modal', {'active' : createModal}]">
            <div class="body">
                <form @submit.prevent="addProduct">
                    <h3>Create New Product</h3>
                    <div class="row">
                        <div class="col-sm-6 input-control">
                            <label>Name</label>
                            <input type="text" v-model="newProduct.name" class="form-control" />
                            <p v-if="errors.name" class="text-danger">{{ errors.name[0] }}</p>
                        </div>
                        <div class="col-sm-6 input-control">
                            <label>Category</label>
                            <select v-model="newProduct.category_id" class="form-control">
                                <option v-for="category in categories"
                                        :key="`option${category.id}`"
                                        :value="category.id">
                                    {{ category.name }}
                                </option>
                            </select>
                            <p v-if="errors.category_id" class="text-danger">{{ errors.category_id[0] }}</p>
                        </div>
                        <div class="col-sm-6 input-control">
                            <label>Price</label>
                            <input type="number" v-model="newProduct.price" class="form-control" />
                            <p v-if="errors.price" class="text-danger">{{ errors.price[0] }}</p>
                        </div>
                        <div class="col-sm-6 input-control">
                            <label>Stock</label>
                            <input type="number" v-model="newProduct.stock" class="form-control" />
                            <p v-if="errors.stock" class="text-danger">{{ errors.stock[0] }}</p>
                        </div>
                        <div class="col-sm-6">
                            <div class="input-control">
                                <label>Brand</label>
                                <input type="text" v-model="newProduct.brand" class="form-control" />
                                <p v-if="errors.brand" class="text-danger">{{ errors.brand[0] }}</p>
                            </div>
                            <div class="input-control">
                                <label>Min Allowed Stock</label>
                                <input type="number" v-model="newProduct.min_allowed_stock" class="form-control" />
                                <p v-if="errors.min_allowed_stock" class="text-danger">{{ errors.min_allowed_stock[0] }}</p>
                            </div>
                        </div>
                        <div class="col-sm-6 input-control">
                            <label>Description</label>
                            <textarea v-model="newProduct.description" class="form-control"></textarea>
                            <p v-if="errors.description" class="text-danger">{{ errors.description[0] }}</p>
                        </div>
                        <div class="col-sm-12 input-control">
                            <label>Image</label>
                            <input @change="uploadImage" type="file" class="form-control" />
                            <p v-if="errors.image" class="text-danger">{{ errors.image[0] }}</p>
                        </div>
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
        name: "AddProduct",
        data() {
            return {
                createModal: false,
                categories: [],
                newProduct: {
                    name: '',
                    category_id: '',
                    price: '',
                    stock: '',
                    brand: '',
                    min_allowed_stock: '',
                    description: '',
                    image: ''
                },
                errors: {}
            };
        },
        methods: {
            toggleCreateModal() {
                this.createModal = !this.createModal;
            },
            uploadImage(e) {
                this.newProduct.image = e.target.files[0];
            },
            addProduct() {

                const config = {
                    headers: { 'content-type': 'multipart/form-data' }
                };
                let formData = new FormData();
                for (let newProductKey in this.newProduct) {
                    formData.append(newProductKey, this.newProduct[newProductKey]);
                }

                axios.post("http://192.168.1.103:8000/api/products?token=" + localStorage.getItem('token'), formData, config)
                    .then(response => {
                    this.newProduct = {
                        name: '',
                        category_id: '',
                        price: '',
                        stock: '',
                        brand: '',
                        min_allowed_stock: '',
                        description: '',
                        image: ''
                    };
                    this.errors = {};
                    console.log(response.data);
                    this.createModal = false;
                    store.commit('openAlert', {
                        alertType: 'success',
                        alertMSG: response.data.message
                    });
                    this.$root.$emit('getProduct');
                }).catch(error => {
                    this.errors = error.response.data.errors;
                    console.log(error.response.data);
                    store.commit('openAlert', {
                        alertType: 'danger',
                        alertMSG: error.response.data.message
                    });
                });
            }
        },
        created() {
            axios.get("http://192.168.1.103:8000/api/categories?token=" + localStorage.getItem('token'))
                .then(response => {
                    this.categories = response.data;
                });
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
            width: 560px;
            max-height: calc(100% - 200px);
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            overflow-y: auto;

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

                    textarea {
                        display: block;
                        height: 117px;
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
            margin: 50px auto;
            height: calc(100% - 100px);
            overflow-y: auto;
            width: 95%;

            form {
                .input-control {
                    margin-bottom: 10px;
                }
            }
        }
    }
</style>

<template>
    <section class="category-list">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>name</th>
                        <th>category</th>
                        <th>price</th>
                        <th>stock</th>
                        <th>brand</th>
                        <th>min allowed stock</th>
                        <th>description</th>
                        <th>image</th>
                        <th>created by</th>
                        <th>control</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="product in pageProduct" :key="product.id">
                        <td>{{ product.name }}</td>
                        <td>{{ product.category }}</td>
                        <td>{{ product.price }}</td>
                        <td>{{ product.stock }}</td>
                        <td>{{ product.brand }}</td>
                        <td>{{ product.min_allowed_stock }}</td>
                        <td>{{ product.description }}</td>
                        <td>{{ product.image }}</td>
                        <td>{{ product.user }}</td>
                        <td>
                            <button @click="toggleEditModal(product)" class="btn btn-outline-danger btn-sm"><i class="fas fa-edit"></i></button>
                            <button @click="toggleDeleteModal(product)" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div :class="['modal', 'edit-modal', {'active' : editModal}]">
            <div class="body">
                <form @submit.prevent="editProduct">
                    <h3>Edit Product</h3>
                    <div class="row">
                        <div class="col-sm-6 input-control">
                            <label>Name</label>
                            <input type="text" v-model="selectProduct.name" class="form-control" />
                            <p v-if="errors.name" class="text-danger">{{ errors.name[0] }}</p>
                        </div>
                        <div class="col-sm-6 input-control">
                            <label>Category</label>
                            <select v-model="selectProduct.category_id" class="form-control">
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
                            <input type="number" v-model="selectProduct.price" class="form-control" />
                            <p v-if="errors.price" class="text-danger">{{ errors.price[0] }}</p>
                        </div>
                        <div class="col-sm-6 input-control">
                            <label>Stock</label>
                            <input type="number" v-model="selectProduct.stock" class="form-control" />
                            <p v-if="errors.stock" class="text-danger">{{ errors.stock[0] }}</p>
                        </div>
                        <div class="col-sm-6">
                            <div class="input-control">
                                <label>Brand</label>
                                <input type="text" v-model="selectProduct.brand" class="form-control" />
                                <p v-if="errors.brand" class="text-danger">{{ errors.brand[0] }}</p>
                            </div>
                            <div class="input-control">
                                <label>Min Allowed Stock</label>
                                <input type="number" v-model="selectProduct.min_allowed_stock" class="form-control" />
                                <p v-if="errors.min_allowed_stock" class="text-danger">{{ errors.min_allowed_stock[0] }}</p>
                            </div>
                        </div>
                        <div class="col-sm-6 input-control">
                            <label>Description</label>
                            <textarea v-model="selectProduct.description" class="form-control"></textarea>
                            <p v-if="errors.description" class="text-danger">{{ errors.description[0] }}</p>
                        </div>
                        <div class="col-sm-12 input-control">
                            <label>Image</label>
                            <input @change="uploadImage" type="file" class="form-control" />
                            <p v-if="errors.image" class="text-danger">{{ errors.image[0] }}</p>
                        </div>
                    </div>
                    <div class="button-control">
                        <button type="button" @click="toggleEditModal(null)" class="btn btn-secondary">Cancel</button>
                        <button class="btn btn-primary">Edit</button>
                    </div>
                </form>
            </div>
        </div>
        <div :class="['modal', 'delete-modal', {'active' : deleteModal}]">
            <div class="body">
                <form @submit.prevent="deleteProduct">
                    <h3>Delete Product</h3>
                    <div class="input-control">
                        <label>Are you Sure to delete {{ selectProduct.name }} ??</label>
                    </div>
                    <div class="button-control">
                        <button type="button" @click="toggleDeleteModal(null)" class="btn btn-secondary">Cancel</button>
                        <button class="btn btn-primary">Delete</button>
                    </div>
                </form>
            </div>
        </div>
        <ul v-if="totalPages > 1" class="pagination justify-content-end">
            <li :class="['page-item', {'disabled' : thisPage == 1}]"><a class="page-link" @click.prevent="clickPrev" href="#">Previous</a></li>
            <li v-for="page in pages" :key="page" :class="['page-item', {'active' : page == thisPage}]">
                <a class="page-link" @click.prevent="clickN(page)" href="#">{{ page }}</a>
            </li>
            <li :class="['page-item', {'disabled' : thisPage == totalPages}]"><a class="page-link" @click.prevent="clickNext" href="#">Next</a></li>
        </ul>
    </section>
</template>

<script>
    import axios from 'axios';
    import store from "../../store";
    export default {
        name: "ProductList",
        data() {
            return {
                categories: [],
                products: [],
                selectProduct: {},
                errors: {},
                editModal: false,
                deleteModal: false,
                thisPage: 1,
                perPage: 8
            };
        },
        computed: {
            totalPages() {
                return Math.ceil(this.products.length/this.perPage);
            },
            pages() {
                let pages = [];
                for (let i = 1; i <= this.totalPages; i++) {
                    pages.push(i);
                }
                return pages;
            },
            pageProduct() {
                let lowLimit = (this.thisPage - 1) * this.perPage,
                    highLimit = this.thisPage * this.perPage;

                return this.products.slice(lowLimit, highLimit);
            }
        },
        methods: {
            clickPrev() {
                this.thisPage--;
            },
            clickNext() {
                this.thisPage++;
            },
            clickN(n) {
                this.thisPage = n;
            },
            toggleEditModal(product) {
                this.editModal = !this.editModal;
                if(product == null) {
                    this.selectProduct = {
                        name: '',
                    };
                } else {
                    this.selectProduct = {
                        ...product,
                    };
                }
            },
            toggleDeleteModal(product) {
                this.deleteModal = !this.deleteModal;
                if(product == null) {
                    this.selectProduct = {
                        name: ''
                    };
                } else {
                    this.selectProduct = {
                        ...product
                    };
                }
            },
            uploadImage(e) {
                this.selectProduct.image = e.target.files[0];
            },
            editProduct() {
                const config = {
                    headers: { 'content-type': 'multipart/form-data' }
                };
                let formData = new FormData();
                for (let selectProductKey in this.selectProduct) {
                    console.log(selectProductKey, this.selectProduct[selectProductKey]);
                    formData.append(selectProductKey, this.selectProduct[selectProductKey]);
                }
                let url = "http://192.168.1.103:8000/api/products/" + this.selectProduct.id + "?token=" + localStorage.getItem('token')

                console.log(url);
                axios.post(url, formData, config)
                    .then(response => {
                    this.selectProduct = {};
                    this.errors = {};
                    this.editModal = false;
                    store.commit('openAlert', {
                        alertType: 'success',
                        alertMSG: response.data.message
                    });
                }).catch(error => {
                    this.errors = error.response.data.errors;
                    store.commit('openAlert', {
                        alertType: 'danger',
                        alertMSG: error.response.data.message
                    });
                });
            },
            deleteProduct() {
                axios.delete("http://192.168.1.103:8000/api/products/" + this.selectProduct.id + "?token=" + localStorage.getItem('token'))
                    .then(response => {
                    this.selectProduct = {};
                    this.deleteModal = false;
                    store.commit('openAlert', {
                        alertType: 'success',
                        alertMSG: response.data.message
                    });
                });
            }
        },
        created() {
            axios.get("http://192.168.1.103:8000/api/categories?token=" + localStorage.getItem('token'))
                .then(response => {
                    this.categories = response.data;
                });

            axios.get("http://192.168.1.103:8000/api/products?token=" + localStorage.getItem('token'))
                .then(response => {
                    this.products = response.data;
                });
        }
    }
</script>

<style scoped lang="scss">
    .table {
        margin-top: 30px;

        td {
            min-width: 130px
        }
    }

    .pagination {
        margin-top: 20px;
    }

    .modal {
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
        .modal .body {
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

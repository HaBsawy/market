<template>
    <div class="cart-list">
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>name</th>
                    <th>category</th>
                    <th>price</th>
                    <th>number</th>
                    <th>Total Price</th>
                    <th>brand</th>
                    <th>image</th>
                    <th>control</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="product in productsOfCart" :key="product.id">
                    <td>{{ product.name }}</td>
                    <td>{{ product.category }}</td>
                    <td>{{ product.price }}</td>
                    <td>{{ product.number }}</td>
                    <td>{{ product.totalPrice }}</td>
                    <td>{{ product.brand }}</td>
                    <td>
                        <img v-if="product.image" :src="`http://localhost:8000/uploads/${ product.image }`">
                        <img v-else src="http://localhost:8000/images/product.png">
                    </td>
                    <td>
                        <button @click="toggleEditModal(product)" class="btn btn-outline-danger btn-sm"><i class="fas fa-edit"></i></button>
                        <button @click="toggleDeleteModal(product)" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                    </td>
                </tr>
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="3">Number of Products: {{ productsOfCart.length }}</td>
                    <td colspan="4">Total Prices: {{ totalPrice }}</td>
                </tr>
                </tfoot>
            </table>
        </div>
        <div :class="['modal', 'edit-modal', {'active' : editModal}]">
            <div class="body">
                <form @submit.prevent="editProductQuantity(selectProduct)">
                    <h3>Edit Product Quantity</h3>
                    <div class="row">
                        <div class="col-sm-6 input-control">
                            <label>Number</label>
                            <input type="number" v-model="number" min="1" :max="selectProduct.stock" class="form-control" />
                        </div>
                        <div class="col-sm-6 input-control">
                            <label>Total Price</label>
                            <h4>{{ selectProduct.totalPrice }}$</h4>
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
                <form @submit.prevent="deleteFromCart(selectProduct)">
                    <h3>Delete Product From Cart</h3>
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
        <div v-if="productsOfCart.length" class="float-right">
            <button class="btn btn-secondary">Cancel</button>
            <button class="btn btn-primary">Confirm the cart</button>
        </div>
    </div>
</template>

<script>
    import store from "../../store";

    export default {
        name: "CartList",
        data() {
            return {
                editModal: false,
                deleteModal: false,
                selectProduct: {},
                number: 1
            };
        },
        computed: {
            login() {
                return store.getters.login;
            },
            auth() {
                return store.getters.auth;
            },
            expiredAt() {
                return store.getters.expiredAt;
            },
            productsOfCart() {
                return store.getters.cart;
            },
            totalPrice() {
                let total = 0;
                store.getters.cart.forEach(product => {
                    total += parseInt(product.totalPrice);
                });
                return total;
            }
        },
        methods: {
            toggleEditModal(product) {
                this.editModal = !this.editModal;
                this.errors = {};
                if(product == null) {
                    this.selectProduct = {};
                } else {
                    this.selectProduct = {...product};
                    this.number = product.number;
                }
            },
            toggleDeleteModal(product) {
                this.deleteModal = !this.deleteModal;
                if(product == null) {
                    this.selectProduct = {};
                } else {
                    this.selectProduct = {...product};
                    this.number = product.number;
                }
            },
            editProductQuantity(product) {
                store.commit('editProductQuantity', product);
                this.selectProduct = {};
                this.number = 1;
                this.editModal = false;
            },
            deleteFromCart(product) {
                store.commit('deleteFromCart', product);
                this.selectProduct = {};
                this.number = 1;
                this.deleteModal = false;
            }
        },
        watch: {
            number: function () {
                this.selectProduct.totalPrice = parseFloat(this.selectProduct.price) * parseInt(this.number);
                this.selectProduct.number = this.number;
            }
        }
    }
</script>

<style scoped lang="scss">
    .table {
        margin-top: 30px;

        td {
            min-width: 130px;

            img {
                width: 50px;
            }
        }
    }

    .float-right {
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
        .modal .body {
            width: 95%;
        }
    }
</style>

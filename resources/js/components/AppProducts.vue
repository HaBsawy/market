<template>
    <div class="products">
        <div class="row">
            <product-item v-for="product in pageProduct" :key="product.id" :product="product"></product-item>
        </div>
        <div :class="['modal', 'create-modal', {'active' : createModal}]">
            <div class="body">
                <form @submit.prevent="addProductToCart(selectProduct)">
                    <h3>Add {{ selectProduct.name }} to cart</h3>
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
                        <button type="button" @click="closeCreateModal" class="btn btn-secondary">Cancel</button>
                        <button class="btn btn-primary">Add to cart</button>
                    </div>
                </form>
            </div>
        </div>
        <ul v-if="totalPages > 1" class="pagination justify-content-end">
            <li :class="['page-item', {'disabled' : thisPage == 1}]"><a class="page-link" @click.prevent="clickPrev" href="#">Previous</a></li>
            <li v-for="page in paginationItems" :key="page" :class="['page-item', {'active' : page == thisPage}]">
                <a class="page-link" @click.prevent="clickN(page)" href="#">{{ page }}</a>
            </li>
            <li :class="['page-item', {'disabled' : thisPage == totalPages}]"><a class="page-link" @click.prevent="clickNext" href="#">Next</a></li>
        </ul>
    </div>
</template>

<script>
    import ProductItem from "./ProductItem";
    import store from "../store";
    import axios from "axios";

    export default {
        name: "AppProducts",
        components: {ProductItem},
        data() {
            return {
                createModal: false,
                number: 1,
                selectProduct: {},
                products: [],
                thisPage: 1,
                perPage: 12
            };
        },
        mounted() {
            this.$root.$on('addToCart', product => {
                this.createModal = true;
                this.selectProduct = {
                    ...product,
                    totalPrice: product.price
                };
            });
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
            },
            paginationItems() {
                if (this.thisPage < 3) {
                    return [1,2,3,4,5];
                } else {
                    return [this.thisPage - 2, this.thisPage - 1, this.thisPage, this.thisPage + 1, this.thisPage + 2]
                }
            }
        },
        methods: {
            closeCreateModal() {
                this.createModal = false;
                this.selectProduct = {};
                this.number = 1;
            },
            clickPrev() {
                this.thisPage--;
            },
            clickNext() {
                this.thisPage++;
            },
            clickN(n) {
                this.thisPage = n;
            },
            addProductToCart(product) {
                product = {
                    ...product,
                    number: this.number
                };
                if (parseInt(this.number) === NaN || parseInt(this.number) < 1) {
                    store.commit('openAlert', {
                        alertType: 'danger',
                        alertMSG: 'the number must be an integer & greater than 0'
                    });
                } else {
                    store.commit('addToCart', product);
                    this.closeCreateModal();
                }
            }
        },
        created() {
            axios.get("http://192.168.1.103:8000/api/products")
                .then(response => {
                    this.products = response.data;
                });
        },
        watch: {
            number: function() {
                this.selectProduct.totalPrice = parseFloat(this.selectProduct.price) * parseInt(this.number);
            }
        }
    }
</script>

<style scoped lang="scss">
    .products {
        margin: 30px 0 30px 20px;
        width: calc(80% - 20px);
        float: right;
    }

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
            width: 95%;
        }
    }
</style>

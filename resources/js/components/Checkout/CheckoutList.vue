<template>
    <section class="category-list">
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>status</th>
                    <th>created by</th>
                    <th>Total Price</th>
                    <th>control</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="checkout in pageCheckout" :key="checkout.id">
                    <td>{{ checkout.status }}</td>
                    <td>{{ checkout.user }}</td>
                    <td>{{ checkout.totalPrice }}</td>
                    <td>
                        <button v-if="checkout.status !== 'delivered'" @click="toggleEditModal(checkout)" class="btn btn-outline-danger btn-sm"><i class="fas fa-edit"></i></button>
                        <button v-if="checkout.status === 'preparing'" @click="toggleDeleteModal(checkout)" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div :class="['modal', 'edit-modal', {'active' : editModal}]">
            <div class="body">
                <form @submit.prevent="editCheckout">
                    <h3>Edit Checkout</h3>
                    <div class="input-control">
                        <label>Status</label>
                        <select class="form-control" v-model="selectCheckout.status">
                            <option value="preparing">preparing</option>
                            <option value="sending">sending</option>
                            <option value="delivered">delivered</option>
                        </select>
                        <p v-if="errors.status" class="text-danger">{{ errors.status[0] }}</p>
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
                <form @submit.prevent="deleteCheckout">
                    <h3>Delete Checkout</h3>
                    <div class="input-control">
                        <label>Are you Sure to delete Checkout no.{{ selectCheckout.id }} ??</label>
                    </div>
                    <div class="button-control">
                        <button type="button" @click="toggleDeleteModal(null)" class="btn btn-secondary">Cancel</button>
                        <button class="btn btn-primary">Delete</button>
                    </div>
                </form>
            </div>
        </div>
        <ul v-if="totalPages > 1" class="pagination justify-content-end">
            <li :class="['page-item', {'disabled' : thisPage === 1}]"><a class="page-link" @click.prevent="clickPrev" href="#">Previous</a></li>
            <li v-for="page in paginationItems" :key="page" :class="['page-item', {'active' : page === thisPage}]">
                <a class="page-link" @click.prevent="clickN(page)" href="#">{{ page }}</a>
            </li>
            <li :class="['page-item', {'disabled' : thisPage === totalPages}]"><a class="page-link" @click.prevent="clickNext" href="#">Next</a></li>
        </ul>
    </section>
</template>

<script>
    import axios from 'axios';
    import store from "../../store";

    export default {
        name: "CheckoutList",
        data() {
            return {
                checkouts: [],
                selectCheckout: {},
                errors: {},
                editModal: false,
                deleteModal: false,
                thisPage: 1,
                perPage: 10
            };
        },
        computed: {
            totalPages() {
                return Math.ceil(this.checkouts.length/this.perPage);
            },
            pages() {
                let pages = [];
                for (let i = 1; i <= this.totalPages; i++) {
                    pages.push(i);
                }
                return pages;
            },
            pageCheckout() {
                let lowLimit = (this.thisPage - 1) * this.perPage,
                    highLimit = this.thisPage * this.perPage;

                return this.checkouts.slice(lowLimit, highLimit);
            },
            paginationItems() {
                if (this.thisPage < 3) {
                    return [1,2,3,4,5];
                } else {
                    return [this.thisPage - 2, this.thisPage - 1, this.thisPage, this.thisPage + 1, this.thisPage + 2]
                }
            }
        },
        mounted() {
            this.$root.$on('getCheckout', () => {
                axios.get("http://192.168.1.103:8000/api/checkouts?token=" + localStorage.getItem('token'))
                    .then(response => {
                        this.checkouts = response.data;
                    });
            });
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
            toggleEditModal(checkout) {
                this.editModal = !this.editModal;
                this.errors = {};
                if(checkout == null) {
                    this.selectCheckout = {};
                } else {
                    this.selectCheckout = {...checkout};
                }
            },
            toggleDeleteModal(checkout) {
                this.deleteModal = !this.deleteModal;
                if(checkout == null) {
                    this.selectCheckout = {};
                } else {
                    this.selectCheckout = {...checkout};
                }
            },
            editCheckout() {
                let url = "http://192.168.1.103:8000/api/checkouts/" + this.selectCheckout.id + "?token=" + localStorage.getItem('token');
                axios.put(url, {
                    'status': this.selectCheckout.status
                })
                    .then(response => {
                        this.selectCheckout = {};
                        this.errors = {};
                        this.editModal = false;
                        store.commit('openAlert', {
                            alertType: 'success',
                            alertMSG: response.data.message
                        });
                        this.$root.$emit('getCheckout');
                    }).catch(error => {
                    this.errors = error.response.data.errors;
                    store.commit('openAlert', {
                        alertType: 'danger',
                        alertMSG: error.response.data.message
                    });
                });
            },
            deleteCheckout() {
                axios.delete("http://192.168.1.103:8000/api/checkouts/" + this.selectCheckout.id + "?token=" + localStorage.getItem('token'))
                    .then(response => {
                        this.selectCheckout = {};
                        this.errors = {};
                        this.deleteModal = false;
                        store.commit('openAlert', {
                            alertType: 'success',
                            alertMSG: response.data.message
                        });
                        this.$root.$emit('getCheckout');
                    });
            }
        },
        created() {
            axios.get("http://192.168.1.103:8000/api/checkouts?token=" + localStorage.getItem('token'))
                .then(response => {
                    this.checkouts = response.data;
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

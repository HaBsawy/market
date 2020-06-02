<template>
    <section class="category-list">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>name</th>
                        <th>created by</th>
                        <th>control</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="category in pageCategory" :key="category.name">
                        <td>{{ category.name }}</td>
                        <td>{{ category.user }}</td>
                        <td>
                            <button @click="toggleEditModal(category)" class="btn btn-outline-danger btn-sm"><i class="fas fa-edit"></i></button>
                            <button @click="toggleDeleteModal(category)" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div :class="['modal', 'edit-modal', {'active' : editModal}]">
            <div class="body">
                <form @submit.prevent="editCategory">
                    <h3>Edit Category</h3>
                    <div class="input-control">
                        <label>Name</label>
                        <input type="text" v-model="selectCategory.name" class="form-control" />
                        <p v-if="errors.name" class="text-danger">{{ errors.name[0] }}</p>
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
                <form @submit.prevent="deleteCategory">
                    <h3>Delete Category</h3>
                    <div class="input-control">
                        <label>Are you Sure to delete {{ selectCategory.name }} ??</label>
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
            <li v-for="page in pages" :key="page" :class="['page-item', {'active' : page === thisPage}]">
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
        name: "CategoryList",
        data() {
            return {
                categories: [],
                selectCategory: {},
                errors: {},
                editModal: false,
                deleteModal: false,
                thisPage: 1,
                perPage: 4
            };
        },
        computed: {
            totalPages() {
                return Math.ceil(this.categories.length/this.perPage);
            },
            pages() {
                let pages = [];
                for (let i = 1; i <= this.totalPages; i++) {
                    pages.push(i);
                }
                return pages;
            },
            pageCategory() {
                let lowLimit = (this.thisPage - 1) * this.perPage,
                    highLimit = this.thisPage * this.perPage;

                return this.categories.slice(lowLimit, highLimit);
            }
        },
        mounted() {
            this.$root.$on('getCategory', () => {
                axios.get("http://192.168.1.103:8000/api/categories?token=" + localStorage.getItem('token'))
                    .then(response => {
                        this.categories = response.data;
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
            toggleEditModal(category) {
                this.editModal = !this.editModal;
                this.errors = {};
                if(category == null) {
                    this.selectCategory = {
                        name: ''
                    };
                } else {
                    this.selectCategory = {...category};
                }
            },
            toggleDeleteModal(category) {
                this.deleteModal = !this.deleteModal;
                if(category == null) {
                    this.selectCategory = {
                        name: ''
                    };
                } else {
                    this.selectCategory = {...category};
                }
            },
            editCategory() {
                let url = "http://192.168.1.103:8000/api/categories/" + this.selectCategory.id + "?token=" + localStorage.getItem('token');
                axios.put(url, this.selectCategory)
                .then(response => {
                    this.selectCategory = {};
                    this.errors = {};
                    this.editModal = false;
                    store.commit('openAlert', {
                        alertType: 'success',
                        alertMSG: response.data.message
                    });
                    this.$root.$emit('getCategory');
                }).catch(error => {
                    this.selectCategory.errors = error.response.data.errors;
                    store.commit('openAlert', {
                        alertType: 'danger',
                        alertMSG: error.response.data.message
                    });
                });
            },
            deleteCategory() {
                axios.delete("http://192.168.1.103:8000/api/categories/" + this.selectCategory.id + "?token=" + localStorage.getItem('token'))
                    .then(response => {
                    this.selectCategory = {};
                    this.errors = {};
                    this.deleteModal = false;
                    store.commit('openAlert', {
                        alertType: 'success',
                        alertMSG: response.data.message
                    });
                    this.$root.$emit('getCategory');
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

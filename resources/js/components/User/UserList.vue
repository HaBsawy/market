<template>
    <section class="user-list">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>name</th>
                        <th>email</th>
                        <th>role</th>
                        <th>control</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in pageUser" :key="user.email">
                        <td>{{ user.name }}</td>
                        <td>{{ user.email }}</td>
                        <td>{{ user.role }}</td>
                        <td>
                            <button @click="toggleEditModal(user)" class="btn btn-outline-danger btn-sm"><i class="fas fa-edit"></i></button>
                            <button @click="toggleDeleteModal(user)" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div :class="['modal', 'edit-modal', {'active' : editModal}]">
            <div class="body">
                <form @submit.prevent="editUser">
                    <h3>Edit User</h3>
                    <div class="input-control">
                        <label>Role</label>
                        <select class="form-control" v-model="selectUser.role">
                            <option value="customer">Customer</option>
                            <option value="employee">Employee</option>
                            <option value="admin">Admin</option>
                        </select>
                        <p v-if="errors.role" class="text-danger">{{ errors.role[0] }}</p>
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
                <form @submit.prevent="deleteUser">
                    <h3>Delete User</h3>
                    <div class="input-control">
                        <label>Are you Sure to delete {{ selectUser.name }} ??</label>
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
        name: "UserList",
        data() {
            return {
                users: [],
                selectUser: {},
                errors: {},
                editModal: false,
                deleteModal: false,
                thisPage: 1,
                perPage: 10
            };
        },
        computed: {
            totalPages() {
                return Math.ceil(this.users.length/this.perPage);
            },
            pages() {
                let pages = [];
                for (let i = 1; i <= this.totalPages; i++) {
                    pages.push(i);
                }
                return pages;
            },
            pageUser() {
                let lowLimit = (this.thisPage - 1) * this.perPage,
                    highLimit = this.thisPage * this.perPage;

                return this.users.slice(lowLimit, highLimit);
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
            this.$root.$on('getUser', () => {
                axios.get("http://192.168.1.103:8000/api/users?token=" + localStorage.getItem('token'))
                    .then(response => {
                        this.users = response.data;
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
            toggleEditModal(user) {
                this.editModal = !this.editModal;
                this.errors = {};
                if(user == null) {
                    this.selectUser = {};
                } else {
                    this.selectUser = {...user};
                }
            },
            toggleDeleteModal(user) {
                this.deleteModal = !this.deleteModal;
                if(user == null) {
                    this.selectUser = {};
                } else {
                    this.selectUser = {...user};
                }
            },
            editUser() {
                let url = "http://192.168.1.103:8000/api/users/" + this.selectUser.id + "?token=" + localStorage.getItem('token');
                axios.put(url, this.selectUser)
                .then(response => {
                    this.selectUser = {};
                    this.errors = {};
                    this.editModal = false;
                    store.commit('openAlert', {
                        alertType: 'success',
                        alertMSG: response.data.message
                    });
                    this.$root.$emit('getUser');
                }).catch(error => {
                    this.errors = error.response.data.errors;
                    store.commit('openAlert', {
                        alertType: 'danger',
                        alertMSG: error.response.data.message
                    });
                });
            },
            deleteUser() {
                axios.delete("http://192.168.1.103:8000/api/users/" + this.selectUser.id + "?token=" + localStorage.getItem('token'))
                .then(response => {
                    this.selectUser = {};
                    this.errors = {};
                    this.deleteModal = false;
                    store.commit('openAlert', {
                        alertType: 'success',
                        alertMSG: response.data.message
                    });
                    this.$root.$emit('getUser');
                });
            }
        },
        created() {
            axios.get("http://192.168.1.103:8000/api/users?token=" + localStorage.getItem('token'))
                .then(response => {
                    this.users = response.data;
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

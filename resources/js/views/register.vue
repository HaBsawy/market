<template>
    <div class="auth">
        <form @submit.prevent="register">
            <h2>HaBsawy</h2>
            <h3>SIGN UP</h3>
            <div class="form-group">
                <div class="left-icon">
                    <input type="text" class="form-control" v-model="username" placeholder="UserName">
                    <div class="icon">
                        <i class="fas fa-user"></i>
                    </div>
                </div>
                <p v-if="error.errors.username" class="text-danger">{{ error.errors.username[0] }}</p>
            </div>
            <div class="form-group">
                <div class="left-icon">
                    <input type="email" class="form-control" v-model="email" placeholder="Email">
                    <div class="icon">
                        <i class="fas fa-envelope-open"></i>
                    </div>
                </div>
                <p v-if="error.errors.email" class="text-danger">{{ error.errors.email[0] }}</p>
            </div>
            <div class="form-group">
                <div class="left-icon">
                    <input type="password" class="form-control" v-model="password" placeholder="Password">
                    <div class="icon">
                        <i class="fas fa-lock"></i>
                    </div>
                </div>
                <p v-if="error.errors.password" class="text-danger">{{ error.errors.password[0] }}</p>
            </div>
            <div class="form-group">
                <div class="left-icon">
                    <input type="password" class="form-control" v-model="confirmPassword" placeholder="Confirm Password">
                    <div class="icon">
                        <i class="fas fa-lock"></i>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <button class="btn btn-danger btn-block">SIGN UP</button>
            </div>
            <div class="form-group text-center">
                Not a Member ? <router-link to="/login">Sign In here</router-link>
            </div>
            <hr>
            <h4>OR</h4>
            <div class="form-group">
                <a href="http://192.168.1.103:8000/api/redirect">
                    <button type="button" class="btn facebook btn-block"><i class="fab fa-fw fa-facebook-f"></i> Login with facebook</button>
                </a>
            </div>
            <div class="form-group">
                <a href="http://192.168.1.103:8000/api/login/google">
                    <button type="button" class="btn google btn-block"><i class="fab fa-fw fa-google"></i> Login with Google</button>
                </a>
            </div>
        </form>
    </div>
</template>

<script>
    import axios from 'axios';
    import store from "../store";
    export default {
        name: "Register",
        data() {
            return {
                username: "",
                email: "",
                password: "",
                confirmPassword: "",
                error: {
                    errors: {}
                }
            };
        },
        methods: {
            register() {
                axios.post("http://192.168.1.103:8000/api/register", {
                    "username": this.username,
                    "email": this.email,
                    "password": this.password,
                    "password_confirmation": this.confirmPassword
                }).then(response => {
                    store.commit('login', response.data);
                    this.$router.push("/");
                }).catch(error => {
                    this.error = error.response.data;
                });
            }
        },
        created() {
            if (store.getters.login) {
                this.$router.push("/");
            }
        }
    }
</script>

<style scoped lang="scss">
    body {
        /*background: url('../images/authentication-bg.png');*/
        width: 100%;
        height: 100%;
    }

    .auth {
        box-shadow: 0 1px 4px 0 rgba(0,0,0,0.14);
        background-color: #fff;
        width: 400px;
        margin: 50px auto;
        padding: 50px 20px 40px;;

        h2 {
            text-align: center;
            font-size: 30px;
            margin-bottom: 10px;
            font-weight: bold;
        }

        h3 {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        h4 {
            text-align: center;
            font-size: 16px;
            margin-bottom: 10px;
            font-weight: bold;
        }

        hr {
            margin-bottom: 10px;
        }

        .form-group {

            .left-icon {
                position: relative;

                .form-control {
                    padding: 5px 10px 5px 50px
                }

                .icon {
                    position: absolute;
                    top: 6px;
                    left: 18px
                }
            }

            input[type=checkbox] {
                display: none;
            }

            .checkbox {
                cursor: pointer;
                display: inline-block;
                padding: 1px;
                width: 17px;
                height: 17px;
                border: 1px solid #1b4b72;
                line-height: 15px;
                font-size: 12px;
                text-align: center;
                color: #fff;

                &.active {
                    background-color: #e3342f;
                }
            }

            .facebook {
                background-color: #3b5998;
                border: 1px solid #3b5998;
                color: #fff
            }

            .google {
                background-color: #dd4b39;
                border: 1px solid #dd4b39;
                color: #fff;
            }

            p.text-danger {
                margin: 5px 0 0 20px;
            }

            a {
                text-decoration: none;
            }
        }
    }
    @media (max-width: 576px) {
        .auth {
            width: 95%;
        }
    }
</style>

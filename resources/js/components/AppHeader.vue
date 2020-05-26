<template>
    <header>
        <div class="top">
            <div class="container">
                <div class="welcome">
                    <h6 v-if="!login">Welcome to our market</h6>
                    <h6 v-else>Welcome {{ auth.username }}</h6>
                </div>
                <div class="links">
                    <ul>
                        <li v-if="!login">
                            <router-link to="/login">Login</router-link>
                        </li>
                        <li v-if="!login">
                            <router-link to="/register">Register</router-link>
                        </li>
                        <li v-if="login">
                            <a href="#">Profile</a>
                        </li>
                        <li v-if="login">
                            <a href="/logout" @click.prevent="logout">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="bottom">
            <div class="container">
                <div class="logo">
                    <img src="../assets/images/logo.png">
                </div>
                <div class="icons">
                    <div class="cart">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="bg-danger">4</span>
                    </div>
                    <div @click="menuCollapse" class="bars">
                        <i class="fas fa-bars"></i>
                    </div>
                </div>
                <ul :class="{'active' : menu}">
                    <li>
                        <router-link to="/">Home</router-link>
                    </li>
                    <li>
                        <a href="">About</a>
                    </li>
                    <li>
                        <a href="">Phones</a>
                    </li>
                    <li>
                        <a href="">Taps</a>
                    </li>
                    <li>
                        <a href="">LabTops</a>
                    </li>
                    <li>
                        <a href="">Accessories</a>
                    </li>
                    <li>
                        <a href="">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </header>
</template>

<script>
    import store from "../store";
    import axios from "axios";
    export default {
        name: "AppHeader",
        data() {
            return {
                menu: false
            };
        },
        computed: {
            login() {
                return store.getters.login;
            },
            auth() {
                return store.getters.auth;
            }
        },
        methods: {
            menuCollapse: function () {
                this.menu = ! this.menu;
            },
            logout() {
                axios.post("http://192.168.1.103:8000/api/logout?token=" + localStorage.getItem('token'))
                    .then(response => {
                        store.commit('logout');
                        this.$router.push('/login');
                    });
            }
        }
    }
</script>

<style scoped lang="scss">
    $darkColor: #3f3f44;
    $lightColor: #f7f7f7;
    $color1: #cceabb;
    $color2: #fdcb9e;

    header {
        position: fixed;
        width: 100%;

        .top {
            background-color: $darkColor;
            color: $lightColor;
            padding: 10px 0;

            .welcome {
                display: inline-block;

                h6 {
                    font-size: 16px;
                    margin: 0;
                }
            }

            .links {
                float: right;

                ul {
                    list-style: none;

                    li {
                        display: inline-block;

                        a {
                            text-decoration: none;
                            display: block;
                            margin-left: 20px;
                            color: $lightColor;
                        }
                    }
                }
            }
        }

        .bottom {
            background-color: $lightColor;
            padding: 10px 0;
            box-shadow: 0 0 5px $color2;

            .logo {
                display: inline-block;
                width: 200px;

                img {
                    width: 100%;
                }
            }

            .icons {
                float: right;
                font-size: 30px;
                margin: 19px 0 19px 20px;

                div {
                    display: inline-block;
                    cursor: pointer;

                    &.cart {
                        position:relative;

                        span {
                            display: block;
                            position: absolute;
                            top: -5px;
                            right: -10px;
                            width: 24px;
                            height: 24px;
                            line-height: 24px;
                            text-align: center;
                            color: $lightColor;
                            font-size: 12px;
                            border: 1.5px solid $lightColor;
                            border-radius: 50%
                        }
                    }

                    &.bars {
                        display: none;
                    }
                }
            }

            ul {
                margin: 15px 0;
                float: right;
                list-style: none;

                li {
                    display: inline-block;

                    a {
                        text-decoration: none;
                        display: block;
                        padding: 10px 20px;
                        font-size: 20px;
                        font-weight: bold;
                        color: $darkColor;
                    }
                }
            }
        }
    }

    // Small devices (landscape phones, 576px and up)
    @media (max-width: 992px) {
        header {
            .bottom {
                .logo {
                    width: 150px;
                }

                ul {
                    margin: 0;
                    overflow: hidden;
                    height: 0;
                    float: none;
                    transition: 1s all ease;

                    &.active {
                        height: 364px;
                    }

                    li {
                        display: block;
                    }
                }

                .icons {
                    margin: 8px 0 8px 20px;

                    div.bars {
                        display: inline-block;
                        margin-left: 20px;
                    }
                }
            }
        }
    }

    // Extra large devices (large desktops, 1200px and up)
    @media (max-width: 1200px) and (min-width:993px) {
        header {
            .bottom {
                .logo {
                    width: 150px;
                }

                ul {
                    margin: 7px 0;

                    li a {
                        font-size:16px;
                    }
                }

                .icons {
                    margin: 8px 0 8px 20px;
                }
            }
        }
    }
</style>

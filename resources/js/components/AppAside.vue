<template>
    <aside>
        <div class="admin">
            <h3>Hello Admin</h3>
            <ul>
                <li>
                    <router-link to="/category">
                        <i class="fas fa-layer-group fa-fw"></i>Categories
                    </router-link>
                </li>
                <li>
                    <router-link to="/product">
                        <i class="fas fa-laptop fa-fw"></i>Products
                    </router-link>
                </li>
                <li>
                    <router-link to="/user">
                        <i class="fas fa-users fa-fw"></i>Users
                    </router-link>
                </li>
                <li>
                    <a href="#"><i class="fas fa-shopping-bag fa-fw"></i>Checkouts</a>
                </li>
            </ul>
        </div>
    </aside>
</template>

<script>
    export default {
        name: "AppAside",

    }
</script>

<style scoped lang="scss">
    $darkColor: #3f3f44;
    $lightColor: #f7f7f7;
    $color1: #cceabb;
    $color2: #fdcb9e;

    aside {
        width: 20%;
        float: left;
        margin: 30px 0;

        .admin {
            box-shadow: 0 0 10px $color1;
            border-radius: 5px;
            padding: 20px;

            ul {
                list-style: none;
                margin: 0;

                li {
                    a {
                        display: block;
                        margin: 5px 0;
                        text-decoration: none;
                        color: $darkColor;
                        font-size: 16px;

                        i {
                            margin-right: 5px;
                        }
                    }
                }
            }
        }
    }

    // Extra small devices (portrait phones, less than 576px)
    @media (max-width: 575.98px) {
        aside {
            float: none;
            width: 100%;
        }
    }

    // Small devices (landscape phones, 576px and up)
    @media (min-width: 576px) and (max-width: 767.98px) {
        aside {
            float: none;
            width: 100%;
        }
    }

    // Medium devices (tablets, 768px and up)
    @media (min-width: 768px) and (max-width: 991.98px) {
        aside {
            width: 30%;
        }
    }

    // Large devices (desktops, 992px and up)
    @media (min-width: 992px) and (max-width: 1199.98px) {  }
</style>

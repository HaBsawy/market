<template>
    <div class="product col-md-4">
        <div class="con">
            <img src="http://192.168.1.103:8000/images/product.png">
            <div class="body">
                <h4>{{ product.name }}</h4>
                <h4>{{ product.price }}$</h4>
                <h5>{{ product.brand }}</h5>
                <button @click="addToCart(product)" class="btn btn-primary btn-sm">Add to cart</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ProductItem",
        props: {
            product: {
                type: Object,
                default: () => {}
            }
        },
        methods: {
            addToCart(product) {
                this.$root.$emit('addToCart', product);
            }
        }
    }
</script>

<style scoped lang="scss">
    $darkColor: #3f3f44;
    $lightColor: #f7f7f7;
    $color1: #cceabb;
    $color2: #fdcb9e;

    .product {

        .con {
            box-shadow: 0 0 10px $color2;
            margin-bottom: 20px;

            img {
                padding: 10px;
                width: 100%;
            }

            .body {
                padding: 20px;

                h5 {
                    display: inline-block;
                }

                button {
                    float: right
                }
            }
        }
    }
</style>

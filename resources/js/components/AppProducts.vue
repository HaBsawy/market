<template>
    <div class="products">
        <div class="row">
            <product-item v-for="product in pageProduct" :key="product.id" :product="product"></product-item>
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
    import axios from "axios";

    export default {
        name: "AppProducts",
        components: {ProductItem},
        data() {
            return {
                products: [],
                thisPage: 1,
                perPage: 12
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
            clickPrev() {
                this.thisPage--;
            },
            clickNext() {
                this.thisPage++;
            },
            clickN(n) {
                this.thisPage = n;
            }
        },
        created() {
            axios.get("http://192.168.1.103:8000/api/products")
                .then(response => {
                    this.products = response.data;
                });
        }
    }
</script>

<style scoped lang="scss">
    .products {
        margin: 30px 0 30px 20px;
        width: calc(80% - 20px);
        float: left;
    }
</style>

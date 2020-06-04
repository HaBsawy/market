<template>
    <div class="filter">
        <h4>Categories</h4>
        <ul>
            <li v-for="category in categories" :key="`cat_${category.id}`">
                <input :id="`cat_${category.id}`" type="checkbox" v-model="category.check" @change="categoryFilter(category.name)">
                <div :class="['checkbox', {'active': category.check}]" @click="check(category)">
                    <i class="fas fa-check"></i>
                </div>
                <label :for="`cat_${category.id}`" class="text-primary">{{ category.name }}</label>
            </li>
        </ul>
        <hr>
        <h4>Brands</h4>
        <ul>
            <li v-for="brand in brands" :key="`brand_${brand.name}`">
                <input :id="`brand_${brand.name}`" type="checkbox" v-model="brand.check" @change="brandFilter(brand.name)">
                <div :class="['checkbox', {'active': brand.check}]">
                    <i class="fas fa-check"></i>
                </div>
                <label :for="`brand_${brand.name}`" class="text-primary">{{ brand.name }}</label>
            </li>
        </ul>
        <hr>
        <h4>Price Range</h4>
        <h6>{{ value[0] }}$ - {{ value[1] }}$</h6>
        <vue-slider @drag-end="dragEnd" v-model="value" :min="0" :max="10000"></vue-slider>
    </div>
</template>

<script>
    import axios from "axios";
    import VueSlider from 'vue-slider-component'
    import 'vue-slider-component/theme/default.css'

    export default {
        name: "ProductFilter",
        data() {
            return {
                categories: [],
                brands: [
                    {
                        name: 'apple',
                        check: false
                    },
                    {
                        name: 'samsung',
                        check: false
                    },
                    {
                        name: 'oppo',
                        check: false
                    },
                    {
                        name: 'xiaomi',
                        check: false
                    },
                    {
                        name: 'huawei',
                        check: false
                    },
                    {
                        name: 'dell',
                        check: false
                    },
                    {
                        name: 'hp',
                        check: false
                    },
                ],
                value: [0,10000],
                filterCategories: [],
                filterBrands: [],
            };
        },
        components: {
            VueSlider
        },
        methods: {
            categoryFilter(categoryName) {
                if (this.filterCategories.includes(categoryName)) {
                    let i = this.filterCategories.indexOf(categoryName);
                    this.filterCategories.splice(i, 1);
                } else {
                    this.filterCategories.push(categoryName);
                }
            },
            brandFilter(brandName) {
                if (this.filterBrands.includes(brandName)) {
                    let i = this.filterBrands.indexOf(brandName);
                    this.filterBrands.splice(i, 1);
                } else {
                    this.filterBrands.push(brandName);
                }
            },
            dragEnd() {
                this.$root.$emit('filterPrice', this.value);
            }
        },
        watch: {
            filterCategories: function () {
                this.$root.$emit('filterCategory', this.filterCategories);
            },
            filterBrands: function () {
                this.$root.$emit('filterBrand', this.filterBrands);
            },
        },
        async created() {
            await axios.get("http://192.168.1.103:8000/api/categories")
                .then(response => {
                    response.data.forEach(category => {
                        category = {
                            ...category,
                            check: false
                        };
                        this.categories.push(category);
                    })
                });
        }
    }
</script>

<style scoped lang="scss">
    $darkColor: #3f3f44;
    $lightColor: #f7f7f7;
    $color1: #cceabb;
    $color2: #fdcb9e;

    .filter {
        box-shadow: 0 0 10px $color1;
        border-radius: 5px;
        padding: 20px;

        ul {
            list-style: none;
            margin: 0;

            li {
                margin-bottom: 5px;

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

                input[type=checkbox] {
                    display: none;
                }

                label {
                    font-size: 16px;
                    margin: 0;
                    cursor: pointer;
                }

                .checkbox {
                    cursor: pointer;
                    display: inline-block;
                    padding: 1px;
                    width: 17px;
                    height: 17px;
                    border: 1px solid #3490dc;
                    line-height: 15px;
                    font-size: 12px;
                    text-align: center;
                    color: #fff;

                    &.active {
                        background-color: #3490dc;
                    }
                }
            }
        }
    }

    // Extra small devices (portrait phones, less than 576px)
    @media (max-width: 575.98px) {

    }

    // Small devices (landscape phones, 576px and up)
    @media (min-width: 576px) and (max-width: 767.98px) {

    }

    // Medium devices (tablets, 768px and up)
    @media (min-width: 768px) and (max-width: 991.98px) {

    }

    // Large devices (desktops, 992px and up)
    @media (min-width: 992px) and (max-width: 1199.98px) {  }
</style>

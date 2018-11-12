<template>
    <div class="form-group">
        <label for="product">Товар (не обязательно)</label>

        <list-select
            id="product"
            :list="products"
            :selected-item="product"
            option-value="title"
            option-text="title"
            placeholder="Выберите товар"
            @select="product = $event"/>

        <input type="hidden" name="product_id" v-if="!!product.id" :value="product.id">
    </div>
</template>

<script>
    import {ListSelect} from 'vue-search-select';

    export default {
        components: {
            ListSelect
        },
        props: {
            old: String
        },
        data() {
            return {
                product: {
                    id: null
                },
                products: [],
            }
        },
        methods: {
            getProductsList() {
                axios.get(route('admin.product.list'))
                    .then(({data}) => {
                        this.products = data;

                        if (this.old) {
                            this.product = this.products.find(p => p.id === +this.old);
                        }
                    });
            }
        },
        mounted() {
            this.getProductsList();
        }
    }
</script>

<template>
    <div class="form-group">
        <h5>Наборы</h5>

        <kit-item
            v-if="kits.length"
            v-for="kit in kits"
            :item="kit"
            :key="kit.id"
            @delete="deleteKit"/>

        <p v-if="!kits.length">
            <em>Наборы пока не добавлены...</em>
        </p>

        <list-select
            v-if="products.length"
            :list="products"
            :selected-item="selected"
            option-value="title"
            option-text="title"
            placeholder="Выберите товар"
            @select="onSelect"/>

        <div class="mt-3">
            <input type="text" class="form-control" placeholder="Стоимость набора" v-model="newKit.amount">
        </div>

        <div class="mt-3">
            <button class="btn btn-warning"
                    @click.prevent="addKit"
                    :disabled="!newKit.related && !newKit.amount">
                Создать набор
            </button>
        </div>
    </div>
</template>

<script>
    import KitItem from './ProductKitItem';
    import {ListSelect} from 'vue-search-select';

    const defKit = {
        related: null,
        amount: null
    };

    export default {
        components: {
            ListSelect,
            KitItem
        },
        props: {
            product: String
        },
        data() {
            return {
                kits: [],
                products: [],
                selected: {},
                newKit: {}
            }
        },
        methods: {
            getKits() {
                axios.get(route('admin.product.kit.list', {product: this.product}))
                    .then(({data}) => {
                        this.kits = data.kits;
                        this.products = data.products;
                    });
            },
            deleteKit(item) {
                axios.delete(route('admin.product.kit.delete', {
                    product: this.product,
                    kit: item
                })).then(({data}) => {
                    this.kits = data.kits;
                    this.products = data.products;
                });
            },
            addKit() {
                axios.post(route('admin.product.kit.add', {
                    product: this.product
                }), {
                    related_id: this.newKit.product,
                    amount: this.newKit.amount
                }).then(({data}) => {
                    this.kits = data.kits;
                    this.products = data.products;

                    this.selected = {};
                    this.newKit = Object.assign({}, defKit);
                });
            },
            onSelect(product) {
                this.selected = product;
                this.newKit.product = product.id;
            },
        },
        mounted() {
            this.getKits();
            this.newKit = Object.assign({}, defKit);
        }
    }
</script>

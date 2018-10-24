<template>
    <div class="form-group" v-if="visible">
        <label for="series">Модель (не обязательно)</label>

        <list-select
            id="series"
            :list="items"
            :selected-items="selected"
            option-value="id"
            option-text="title"
            placeholder="Выберите модель"
            @select="onSelect"/>

        <input type="hidden" name="series[]"
               v-for="item in selected" :value="item.id" :key="item.id">
    </div>
</template>

<script>
    import {MultiListSelect} from 'vue-search-select';

    export default {
        components: {
            ListSelect: MultiListSelect
        },
        props: {
            old: Array
        },
        data() {
            return {
                brand: null,
                items: [],
                selected: [],
            }
        },
        computed: {
            visible() {
                return !!this.brand;
            }
        },
        methods: {
            onSelect(items) {
                this.selected = items;
            },
            getSeriesList() {
                if (!!this.brand && this.brand > 0) {
                    axios.get(route('admin.product.series.list', {id: this.brand}))
                        .then(({data}) => {
                            this.items = data;
                        });
                }
            },
        },
        mounted() {
            if (this.old && this.old.length) {
                this.selected = this.old;
            }

            if (this.$root.$refs.hasOwnProperty('brand')) {
                this.brand = +this.$root.$refs.brand.value;
                this.getSeriesList();

                Bus.$on('updateBrand', () => {
                    this.brand = +this.$root.$refs.brand.value;
                    this.getSeriesList();
                });
            }
        }
    }
</script>

<style>
    .ui.selection.dropdown .menu > .item {
        margin-bottom: 0;
        border-radius: 0;
    }

    .delete.icon:before {
        font-style: normal;
        font-size: 16px;
        content: '\00D7';
    }
</style>

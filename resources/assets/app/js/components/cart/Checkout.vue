<template>
    <div>
        <div class="form-group">
            <label for="delivery">Доставка</label>

            <div class="custom-select">
                <i class="dropdown icon"></i>
                <select name="delivery"
                        id="delivery"
                        class="form-control"
                        @change="handleDelivery"
                v-model="selected">
                    <option v-for="option in delivery" :value="option.type">
                        {{ option.label }}
                    </option>
                </select>
            </div>
        </div>

        <div class="form-group" v-if="selected === 'np'">
            <label>Город</label>
            <list-select
                :list="cities"
                :selected-item="city"
                option-value="DescriptionRu"
                option-text="DescriptionRu"
                placeholder="Укажите город"
                @select="onSelectCity"/>

            <input type="hidden" name="city" :value="city.DescriptionRu">
        </div>

        <div class="form-group" v-if="warehouses.length && selected === 'np'">
            <label>Отделение</label>
            <list-select
                :list="warehouses"
                :selected-item="warehouse"
                option-value="Description"
                option-text="DescriptionRu"
                placeholder="Укажите отделение"
                @select="onSelectWarehouse"/>

            <input type="hidden" name="warehouse" :value="warehouse.DescriptionRu">
        </div>

        <div class="form-group" v-if="selected === 'courier'">
            <label for="address">Адрес доставки</label>
            <input type="text" id="address" name="address" class="form-control" v-model="address" required>
        </div>

        <div class="form-group">
            <label for="message">Сообщение (не обязательно)</label>
            <textarea name="message" id="message" rows="4" class="form-control"></textarea>
        </div>
    </div>
</template>

<script>
    import {ListSelect} from 'vue-search-select';

    const params = [
        {
            type: 'self',
            label: 'Самовывоз'
        },
        {
            type: 'np',
            label: 'Новая почта'
        },
        {
            type: 'courier',
            label: 'Курьером (только Киев)'
        }
    ];

    export default {
        components: {
            ListSelect
        },
        data() {
            return {
                city: {},
                warehouse: {},
                cities: [],
                warehouses: [],
                selected: params[0].type,
                delivery: params,
                address: ''
            }
        },
        methods: {
            handleDelivery() {
                if (this.selected === 'np') {
                    axios.get('/checkout/cities')
                        .then(({data}) => this.cities = data.data)
                }
            },
            onSelectCity(input) {
                this.city = input;

                axios.get('/checkout/warehouses/' + input.Ref)
                    .then(({data}) => this.warehouses = data.data)
            },
            onSelectWarehouse(input) {
                this.warehouse = input;
            }
        },
        computed: {
            cantSendCheckout() {
                if (this.selected.type === 'np') {
                    return _.isEmpty(this.city) && _.isEmpty(this.warehouse);
                } else if (this.selected.type === 'courier') {
                    return this.address.length;
                }
            }
        }
    }
</script>

<style>
    .ui.selection.dropdown {
        border-radius: 0 !important;
        background-color: #e7ecf2 !important;
        min-height: initial !important;
        height: 40px;
        padding-top: 5px;
        padding-bottom: 5px;
    }

    .dropdown.icon {
        font-family: 'Dropdown';
        cursor: pointer;
        position: absolute;
        width: auto;
        height: auto;
        line-height: 40px;
        top: 0;
        right: 1em;
        z-index: 3;
        margin: 0 -0.78571429em;
        padding: 0 0.78571429em;
        opacity: 0.8;
        -webkit-transition: opacity 0.1s ease;
        transition: opacity 0.1s ease;
        -webkit-backface-visibility: hidden;
        backface-visibility: hidden;
        font-weight: normal;
        font-style: normal;
        text-align: center;
    }

    .dropdown.icon::before {
        content: '\F0D7';
    }
</style>

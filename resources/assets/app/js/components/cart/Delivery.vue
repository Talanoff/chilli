<template>
    <div class="form-group">
        <label for="delivery">Доставка</label>
        <select name="delivery"
                id="delivery"
                class="form-control"
                @change="handleDelivery"
                v-model="selected">
            <option v-for="option in delivery" :value="option">
                {{ option.label }}
            </option>
        </select>

        <div class="mt-4" v-if="selected.type === 'np'">
            <label for="city">Город</label>
            <select name="city" id="city" class="form-control">
                <option v-for="city in cities" :value="city">
                    {{ city.DescriptionRu }}
                </option>
            </select>
        </div>
    </div>
</template>

<script>
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
        data() {
            return {
                cities: [],
                warehouses: [],
                selected: params[0],
                delivery: params
            }
        },
        methods: {
            handleDelivery() {
                if (this.selected.type === 'np') {
                    axios.get('/checkout/cities')
                        .then(({data}) => this.cities = data.cities.data)
                }
            }
        }
    }
</script>

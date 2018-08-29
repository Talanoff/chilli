<template>
    <div>
        <div class="form-group">
            <label>Тип вывода</label>
            <div class="btn-group w-100 attribute-type-selector" role="group">
                <label class="btn "
                       v-for="(t, i) in Object.keys(types)" :key="i"
                       :class="t === type ? 'btn-secondary' : 'btn-outline-secondary'">
                    <input type="radio" name="type" :value="t" v-model="type">
                    {{ types[t] }}
                </label>
            </div>
        </div>

        <div class="form-group">
            <label for="value">Значение</label>
            <input :type="type !== 'text' ? 'hidden' : 'text'"
                   v-model="value" name="value" id="value" class="form-control" required>
            <color-picker v-model="color" v-if="type === 'color'" @input="updateValue"/>
        </div>
    </div>
</template>

<script>
    import {Compact} from 'vue-color';

    export default {
        components: {
            'color-picker': Compact
        },
        props: {
            types: Object,
            exType: String,
            exValue: String
        },
        data() {
            return {
                type: 'text',
                value: '',
                color: {}
            }
        },
        methods: {
            updateValue() {
                this.value = this.color.hex;
            }
        },
        watch: {
            type(curr, old) {
                if (old === 'color') {
                    this.value = '';
                    this.color = {};
                }
            }
        },
        mounted() {
            if (this.exType) this.type = this.exType;
            if (this.exValue) this.value = this.exValue;

            if (this.exType === 'color') {
                this.color = this.exValue;
            }
        }
    }
</script>

<style>
    .vc-slider {
        width: 100% !important;
    }

    .vc-compact {
        width: 245px !important;
    }
</style>

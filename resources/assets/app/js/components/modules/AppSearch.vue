<template>
    <div class="autocomplete flex flex-no-wrap align-center">
        <a href="/search" class="btn btn-search ml-auto"
           @click.prevent="show = !show">
            <svg width="16" height="16">
                <use xlink:href="#glass"></use>
            </svg>
        </a>

        <div class="position-relative text-uppercase flex-1 ml-2" v-if="show">
            <input type="hidden" name="search" :value="word">

            <input type="text" v-model="input" @input="autocomplete" class="form-control autocomplete-input text-uppercase">
            <div class="autocomplete-result text-left">{{ word }}</div>
        </div>
    </div>
</template>

<script>
    const words = [
        'apple',
        'samsung',
        'xiaomi',
        'meizu',
        'motorola',
        'huawei',
        'nokia',
        'lenovo',
        'doogee',
        'blackview',
        'homtom',
        'honor',
        'onex'
    ];

    export default {
        data() {
            return {
                input: '',
                word: '',
                show: false
            }
        },
        methods: {
            autocomplete() {
                const result = words.filter(w => {
                    return this.input.toUpperCase() === w.substr(0, this.input.length).toUpperCase();
                });

                if (result.length) this.word = result[0];
                else this.word = '';

                if (this.input.length === 0) this.word = '';
            }
        },
    }
</script>

<style lang="scss">
    .autocomplete {
        &-input {
            background-color: transparent !important;
            position: relative;
            z-index: 2;
            color: #fff;
            height: 30px;
            padding-top: 0;
            padding-bottom: 0;
        }

        &-result {
            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            z-index: 1;
            opacity: 0.5;
            padding: 6px 20px;
        }
    }
</style>

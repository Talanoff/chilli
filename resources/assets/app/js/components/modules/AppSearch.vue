<template>
    <div class="flex flex-no-wrap align-center">
        <a href="/search" class="btn btn-search ml-auto"
           @click.prevent="show = !show">
            <svg width="16" height="16">
                <use xlink:href="#glass"></use>
            </svg>
        </a>

        <transition name="slide">
            <div class="autocomplete position-relative text-uppercase flex-1 ml-2" v-if="show">
                <input type="hidden" name="search" :value="word">

                <input type="text" v-model="input" @input="autocomplete"
                       class="form-control autocomplete-input text-uppercase"
                       placeholder="Поиск">
                <div class="autocomplete-result text-left">{{ word }}</div>
            </div>
        </transition>
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
                else this.word = this.input;

                if (this.input.length === 0) this.word = '';
            }
        },
    }
</script>

<style lang="scss">
    .autocomplete {
        transition: 0.35s ease;
        &-input {
            background-color: transparent !important;
            position: relative;
            z-index: 2;
            color: #fff;
            height: 30px;
            padding-top: 0;
            padding-bottom: 0;
            border-bottom: 1px solid rgba(#fff, 0.65);

            &:focus {
                box-shadow: none;
            }
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

    .slide-enter {
        opacity: 0;
    }

    .slide-leave-active {
        opacity: 0;
    }

    .slide-enter .slide-container,
    .slide-leave-active .slide-container {
        -webkit-transform: scale(1.1);
        transform: scale(1.1);
    }
</style>

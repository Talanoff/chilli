<template>
    <div class="product-slider flex">
        <div class="product-slider-nav">
            <div class="product-slider-nav__item flex justify-center align-center"
                 v-for="(image, index) in JSON.parse(thumbnails)"
                 @click="toggleSlide(index)"
                 :style="{height: thumbs.length < 5 ? 100 / thumbs.length + '%' : '20%'}"
                 :class="{'is-active': index === current}"
                 :key="index">
                <img :src="image">
            </div>
        </div>

        <div class="product-slider-items">
            <div class="product-slider-items__item flex justify-center align-center"
                 v-for="(image, index) in JSON.parse(images)"
                 :key="index" ref="slider">
                <img :data-flickity-lazyload-src="image">
            </div>
        </div>

        <slot></slot>
    </div>
</template>

<script>
    import Flickity from 'flickity';

    export default {
        props: {
            images: String,
            thumbnails: String
        },
        data() {
            return {
                slider: null,
                current: 0
            }
        },
        methods: {
            toggleSlide(index) {
                this.current = index;
                this.slider.select(index)
            }
        },
        computed: {
            thumbs() {
                return JSON.parse(this.thumbnails);
            }
        },
        mounted() {
            this.slider = new Flickity('.product-slider-items', {
                wrapAround: true,
                pageDots: false,
                prevNextButtons: false,
                lazyLoad: true,
                setGallerySize: false,
                contain: true
            });

            this.slider.on('change', (e) => this.current = e);
        }
    }
</script>

<style lang="scss">
    @import "../../../sass/config/variables";

    .product-slider {
        position: relative;
        height: 320px;

        @media (min-width: map_get($grid-breakpoints, md)) {
            height: 480px;
        }

        @media (min-width: map_get($grid-breakpoints, lg)) {
            height: 530px;
        }

        &-nav {
            flex: 0 0 90px;
            max-width: 90px;
            max-height: 100%;
            overflow-y: auto;

            @media (min-width: map_get($grid-breakpoints, xxl)) {
                flex: 0 0 180px;
                max-width: 180px;
            }

            &__item {
                width: 100%;
                height: 20%;
                padding: 20px;
                background-color: #d6dee9;
                cursor: pointer;
                transition: 0.35s;

                &.is-active {
                    background-color: #fff;
                }

                @media (min-width: map_get($grid-breakpoints, xxl)) {
                    padding: 40px;
                }
            }
        }

        &-items {
            position: relative;
            height: 100%;
            min-height: 320px;
            max-height: 600px;
            flex: 1 0 auto;
            max-width: 100%;

            &__item {
                width: 100%;
                height: 100%;
            }
        }

        img {
            max-height: 100%;
        }
    }
</style>

<template>
    <div class="kits">
        <div class="text-center mb-3" v-if="items.length > 1">
            <svg width="26" height="26"
                 class="kits-carousel-button"
                 @click.prevent="prevItem"
                 :style="{transform: `scale(-1)`}">
                <use xlink:href="#darr"></use>
            </svg>
        </div>

        <transition name="carousel">
            <div class="kits-item flex-md justify-between"
                 v-for="(kit, index) in items"
                 v-if="current === index"
                 :kit="kit"
                 :key="kit.id">

                <product :product="kit.product"></product>

                <div class="flex flex-column justify-center mx-6">
                    <svg width="46" height="46" class="mx-auto">
                        <use xlink:href="#add"></use>
                    </svg>
                </div>

                <product :product="kit.related"></product>

                <div class="flex flex-column justify-center mx-6">
                    <svg width="46" height="46" class="mx-auto">
                        <use xlink:href="#equal"></use>
                    </svg>
                </div>

                <div class="w-md-1/2 w-lg-1/3 w-xl-1/4">
                    <div class="kit-total py-4 text-center flex flex-column justify-center">
                        <div class="kit-sku small text-bold text-uppercase text-muted">Код комплекта {{ kit.sku }}</div>

                        <h5 class="mb-0"><s class="text-muted">{{ kit.old_price }} грн</s></h5>
                        <h4>{{ kit.amount }} грн</h4>

                        <p>Вы экономите <span :style="{color: '#df1f26'}">{{ kit.old_price - kit.amount }} грн</span>
                        </p>

                        <div>
                            <button class="btn btn-secondary" @click="add(kit.id)">
                                КУПИТЬ КОМПЛЕКТ
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </transition>

        <div class="text-center mt-3 text-muted" v-if="items.length > 1">
            {{ current + 1 }}/{{ items.length }}
        </div>

        <div class="text-center mt-3" v-if="items.length > 1">
            <svg width="26" height="26"
                 class="kits-carousel-button"
                 @click.prevent="nextItem">
                <use xlink:href="#darr"></use>
            </svg>
        </div>
    </div>
</template>

<script>
    import Product from './KitsCarouselProduct'

    export default {
        components: {
            Product
        },
        props: {
            kits: {
                type: String,
                required: true
            }
        },
        methods: {
            add(id) {
                this.$store.dispatch('addKitToCart', id);
                VBUS.$emit('openCart');
            },
            nextItem() {
                if (this.current !== this.items.length - 1) {
                    this.current = this.current + 1;
                } else {
                    this.current = 0;
                }
            },
            prevItem() {
                if (this.current !== 0) {
                    this.current = this.current - 1
                } else {
                    this.current = this.items.length - 1;
                }
            }
        },
        data() {
            return {
                items: [],
                current: 0
            }
        },
        mounted() {
            this.items = JSON.parse(this.kits)
        }
    }
</script>

<style>
    .carousel-enter {
        opacity: 0;
    }

    .carousel-leave-active {
        opacity: 0;
        transform: translateY(-100%);
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
    }

    .carousel-enter .carousel-container,
    .carousel-leave-active .carousel-container {
        -webkit-transform: scale(1.1);
        transform: scale(1.1);
    }
</style>

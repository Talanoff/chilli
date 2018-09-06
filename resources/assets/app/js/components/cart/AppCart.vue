<template>
    <div id="app-cart" class="flex align-center">
        <div class="mr-3 text-white" v-if="summary">{{ summary }} грн</div>
        <div class="cart-count" v-if="count">{{ count }}</div>
        <svg width="30" height="30" @click="cartVisible = !cartVisible">
            <use xlink:href="#cart"></use>
        </svg>

        <div class="cart-entry" v-if="cartVisible">
            <div class="cart-entry-item flex" v-for="item in cart" :key="item.id">
                <div class="flex-0">
                    <img :src="item.product.thumbnail" :alt="item.product.title">
                </div>
                <div class="flex-1 flex ml-4">
                    <div class="cart-entry-item__title">
                        {{ item.product.title }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                cartVisible: false
            }
        },
        computed: {
            summary() {
                return this.$store.state.summary;
            },
            count() {
                return this.$store.state.count;
            },
            cart() {
                return this.$store.state.cart;
            }
        },
        mounted() {
            VBUS.$on('openCart', () => this.cartVisible = true);
        }
    }
</script>

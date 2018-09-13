<template>
    <div class="cart-entry-item row no-gutters align-center flex-no-wrap">
        <a :href="product.url" class="column-auto cart-entry-item__thumbnail">
            <img :src="product.thumbnail"
                 :alt="product.title">
        </a>
        <div class="column flex ml-4 cart-entry-item__wrapper">
            <div class="cart-entry-item__title w-3/4">
                <h4 class="text-uppercase mb-1 text-normal">
                    <a :href="product.url">
                        {{ product.title }}
                    </a>
                </h4>
                <p class="mb-0 text-muted smaller text-uppercase">
                    Артикул № {{ product.sku }}
                </p>
            </div>

            <div class="pr-5 w-1/4">
                <h4 class="mb-0 text-normal text-dark">
                    {{ product.price }} грн
                </h4>
            </div>

            <a href="#" class="remove-cart-item in-preview" role="button"
               @click.prevent="removeFromCart"></a>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            item: Number,
            product: {
                type: Object,
                required: true
            }
        },
        methods: {
            removeFromCart() {
                this.$store.dispatch('removeFromCart', this.item)
            }
        }
    }
</script>

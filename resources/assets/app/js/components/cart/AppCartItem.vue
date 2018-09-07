<template>
    <div class="cart-entry-item row no-gutters align-center">
        <a :href="product.url" class="column-auto cart-entry-item__thumbnail">
            <img :src="product.thumbnail"
                 :alt="product.title">
        </a>
        <div class="column flex ml-4">
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

            <div>
                <h4 class="mb-0 text-normal text-dark">
                    {{ product.price }} грн
                </h4>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            product: {
                type: Object,
                required: true
            }
        }
    }
</script>

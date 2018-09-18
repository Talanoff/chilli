<template>
    <div
        class="product-item-wrapper w-md-1/2 w-lg-1/3 w-xl-1/4">
        <a :href="`/product/${product.id}`" class="product-item product-item--squire">
            <figure class="product-item__image"
                    :style="{backgroundImage: `url(${product.thumbnail})`}"></figure>

            <div class="product-item-content">
                <h6 class="product-item__title text-uppercase"
                :class="product.subtitle !== '' ? 'mb-0' : 'mb-4'">
                    {{ product.title }}
                </h6>

                <p class="small text-muted text-uppercase" v-if="product.subtitle !== ''">{{ product.subtitle }}</p>

                <div class="my-4 product-item__stars">
                    <svg width="12" height="12"
                         v-for="star in 5"
                         :class="{'is-filled': star <= product.rate}"
                         :key="star">
                        <use xlink:href="#star"></use>
                    </svg>
                </div>

                <h4 class="product-item__price mb-4">
                    {{ product.price }} грн
                </h4>

                <div class="product-item__colors flex mb-5" v-if="product.colors.length">
                    <div class="mr-2"
                         v-for="color in product.colors" :key="color.value"
                         :style="{backgroundColor: color.value}"></div>
                </div>
            </div>
        </a>
    </div>
</template>

<script>
    export default {
        props: {
            product: Object
        }
    }
</script>

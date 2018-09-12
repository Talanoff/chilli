<template>
    <div class="products flex">
        <div v-for="item in items" :key="item.id"
             class="product-item-wrapper w-md-1/2 w-lg-1/3 w-xl-1/4">
            <a :href="item.product.url" class="product-item product-item--squire">
                <figure class="product-item__image lozad"
                        :style="{backgroundImage: `url(${item.product.thumbnail})`}"></figure>

                <div class="product-item-content">
                    <h6 class="product-item__title text-uppercase"
                    :class="item.product.subtitle ? 'mb-0' : 'mb-4'">
                        {{ item.product.title }}
                    </h6>

                    <p class="small text-muted text-uppercase"
                       v-if="item.product.subtitle">
                        {{ item.product.subtitle }}
                    </p>

                        <div class="product-item__stars my-4 mr-3" v-if="item.product.rate">
                            <svg v-for="star in 5" width="12" height="12"
                                 :class="{'is-filled': star <= item.product.rate}">
                                <use xlink:href="#star"></use>
                            </svg>
                        </div>

                    <h4 class="product-item__price mb-4">
                        {{ item.product.price }} грн
                    </h4>

                    <div class="product-item__colors flex mb-5" v-if="item.product.colors.length">
                        <div v-for="color in item.product.colors" :key="color"
                             :style="{backgroundColor: color}"></div>
                    </div>

                    <div class="flex align-center">
                        <add-to-cart-button
                            class="btn-secondary"
                            :action="addToCartRoute(item.product.slug)"/>

                        <svg class="btn-delete ml-3" @click.prevent="removeFromFavourites(item.id)">
                            <use xlink:href="#delete"></use>
                        </svg>
                    </div>
                </div>
            </a>
        </div>
    </div>
</template>

<script>
    import AddToCartButton from '../cart/AddToCartButton';

    export default {
        components: {
            AddToCartButton
        },
        methods: {
            removeFromFavourites(id) {
                this.$store.dispatch('removeFromFavourites', id)
            },
            addToCartRoute(id) {
                return `/cart/${id}/add`;
            }
        },
        computed: {
            items() {
                return this.$store.state.favourites;
            }
        }
    }
</script>

<style lang="scss">
    .btn-delete {
        width: 30px;
        height: 30px;
        fill: #ab1f23;
        transition: 0.35s;
        position: relative;
        z-index: 10;

        &:hover {
            fill: #32363d;
        }
    }
</style>

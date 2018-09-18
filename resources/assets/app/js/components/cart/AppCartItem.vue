<template>
    <div class="cart-entry-item">
        <template v-if="!!item.product">
            <div class="row no-gutters align-center">
                <div class="column-auto">
                    <a :href="item.product.url" class="cart-entry-item__thumbnail">
                        <img :src="item.product.thumbnail"
                             :alt="item.product.title">
                    </a>
                </div>

                <div class="column pl-4">
                    <div class="flex flex-no-wrap align-center">
                        <div class="flex-1">
                            <h4 class="text-uppercase mb-1 text-normal">
                                <a :href="item.product.url">
                                    {{ item.product.title }}
                                </a>
                            </h4>
                            <p class="mb-0 text-muted smaller text-uppercase">
                                Артикул № {{ item.product.sku }}
                            </p>
                        </div>

                        <div class="position-relative pr-10">
                            <h4 class="mb-0 text-normal text-dark no-wrap">
                                <small>{{ item.quantity }} &times;</small>
                                {{ item.product.price }} грн
                            </h4>

                            <a href="#" class="remove-cart-item in-preview" role="button"
                               @click.prevent="removeFromCart"></a>
                        </div>
                    </div>
                </div>
            </div>
        </template>

        <template v-if="!!item.kit">
            <div class="row no-gutters flex-no-wrap align-center">
                <div class="column-auto position-relative" style="width: 100px; height: 100px;">
                    <img :src="item.kit.product.thumbnail" class="kit-images" alt="">
                    <img :src="item.kit.related.thumbnail" class="kit-images kit-images__related" alt="">
                </div>

                <div class="column pl-4">
                    <div class="flex flex-no-wrap align-center">
                        <div :style="{flex: `1 1 auto`}">
                            <h4 class="text-uppercase mb-1 text-normal">
                                <a :href="item.kit.product.url">
                                    {{ item.kit.product.title }}
                                </a>
                            </h4>
                            <h4 class="text-uppercase mb-1 text-normal">
                                <a :href="item.kit.related.url">
                                    {{ item.kit.related.title }}
                                </a>
                            </h4>
                            <p class="mb-0 text-muted smaller text-uppercase">
                                Набор № {{ item.kit.sku }}
                            </p>
                        </div>

                        <div class="position-relative pr-10" :style="{flex: `0 0 auto`}">
                            <h4 class="mb-0 text-normal text-dark">
                                <small>{{ item.quantity }} &times;</small>
                                {{ item.kit.amount }} грн
                            </h4>
                            <a href="#" class="remove-cart-item in-preview" role="button"
                               @click.prevent="removeFromCart"></a>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>
</template>

<script>
    export default {
        props: {
            item: {
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

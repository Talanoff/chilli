<template>
    <div class="mb-3 flex align-center text-uppercase">
        <span class="mr-4 smaller">Ваша оценка</span>

        <div class="product-item__stars">
            <svg width="12" height="12" v-for="star in 5"
                 @click="rating = star"
                 :class="{'is-filled': star <= rating}"
                 :key="star">
                <use xlink:href="#star"></use>
            </svg>
        </div>

        <input type="hidden" name="rating" :value="rating">
    </div>
</template>

<script>
    export default {
        props: {
            old: String
        },
        data() {
            return {
                rating: +this.old || null
            }
        }
    }
</script>

<style scoped lang="scss">
    .product-item__stars {
        margin-top: -2px;

        svg {
            margin: 0 2px;
            cursor: pointer;

            &:hover {
                fill: mix(#f9c66d, #9e9e9e);
            }
        }
    }
</style>

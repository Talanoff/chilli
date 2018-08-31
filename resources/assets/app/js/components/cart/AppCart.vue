<template>
    <div id="app-cart" class="flex align-center">
        <div class="mr-3 text-white" v-if="summary">{{ summary }} грн</div>
        <div class="cart-count" v-if="count">{{ count }}</div>
        <svg width="30" height="30">
            <use xlink:href="#cart"></use>
        </svg>
    </div>
</template>

<script>
    export default {
        computed: {
            summary() {
                return this.$store.state.summary;
            },
            count() {
                return this.$store.state.count;
            }
        }
    }
</script>

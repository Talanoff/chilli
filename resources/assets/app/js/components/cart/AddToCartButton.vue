<template>
    <button class="btn" v-text="text" @click.prevent="addToCart"></button>
</template>

<script>
    export default {
        props: {
            action: String,
            text: {
                type: String,
                default() {
                    return 'Купить'
                }
            }
        },
        methods: {
            addToCart() {
                this.$store.dispatch('addToCart', {
                    action: this.action
                });
            }
        }
    }
</script>

<template>
    <a href="/favourites"
               class="btn btn-favourites position-relative">
        <span class="favourites-count" v-if="count">{{ count }}</span>
        <svg width="16" height="16">
            <use xlink:href="#like"></use>
        </svg>
    </a>
</template>

<script>
    export default {
        computed: {
            count() {
                return this.$store.state.favourites.length;
            }
        }
    }
</script>

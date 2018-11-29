<template>
    <a href="/favourites" :is="count ? 'a' : 'span'"
       :style="{cursor: count ? 'pointer' : 'auto'}"
       class="btn btn-favourites position-relative">
        <span class="count">{{ count }}</span>
        <svg width="24" height="24" style="margin: 3px;">
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

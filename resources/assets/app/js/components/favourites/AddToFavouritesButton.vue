<template>
    <button class="btn text-bold"
            :class="buttonClasses"
            @click.prevent="addToFavourites">
        <svg class="btn__icon">
            <use xlink:href="#like"></use>
        </svg>
        <svg class="btn__check">
            <use xlink:href="#check"></use>
        </svg>
    </button>
</template>

<script>
    export default {
        props: {
            product: String
        },
        data() {
            return {
                inAction: false
            }
        },
        methods: {
            addToFavourites() {
                const action = this.favourite.length ? `${this.favourite[0].id}/remove` : `${this.product}/add`;

                this.inAction = true;

                this.$store.dispatch('handleFavourites', '/favourites/' + action);

                setTimeout(() => this.inAction = false, 2000);
            }
        },
        computed: {
            favourite() {
                return this.$store.state.favourites.filter(f => f.product.slug === this.product);
            },
            buttonClasses() {
                return (this.inAction ? ' added ' : '') + (this.favourite.length ? 'btn-danger' : 'btn-light');
            }
        }
    }
</script>

<style scoped lang="scss">
    @import "../../../sass/config/variables";

    .btn {
        padding: 0;
        overflow: hidden;
        width: 30px;
        height: 30px;
        border-radius: 50%;

        &__icon,
        &__check {
            transition: 0.5s;
        }

        &__icon {
            width: 24px;
            height: 24px;
            fill: #fff;
            margin: 2px;
            position: relative;
        }

        &__check {
            width: 16px;
            height: 16px;
            fill: #fff;
            transform: translateY(300%);
            position: absolute;
            left: 50%;
            top: 50%;
            margin: -9px 0 0 -8px;
            opacity: 0;
        }

        &.added {
            .btn__icon {
                transform: translateY(-300%);
                opacity: 0;
            }
            .btn__check {
                transform: translateY(0);
                opacity: 1;
            }
        }
    }
</style>

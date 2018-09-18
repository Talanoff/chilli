<template>
    <button class="btn text-bold"
            :class="{'added': inAction}"
            @click.prevent="addToCart">
        <span class="btn__text"><slot>Купить</slot></span>
        <svg class="btn__check">
            <use xlink:href="#check"></use>
        </svg>
    </button>
</template>

<script>
    export default {
        props: {
            action: String,
            kit: {
                type: Boolean,
                default() {
                    return false;
                }
            }
        },
        data() {
            return {
                inAction: false
            }
        },
        methods: {
            addToCart() {
                const route = !this.kit ? 'addToCart' : 'addKitToCart';

                this.inAction = true;
                this.$store.dispatch(route, this.action);

                VBUS.$emit('openCart');

                setTimeout(() => this.inAction = false, 2000);
            }
        }
    }
</script>

<style scoped lang="scss">
    .btn {
        overflow: hidden;
        position: relative;

        &__text,
        &__check {
            transition: 0.5s;
        }

        &__check {
            width: 20px;
            height: 20px;
            fill: #fff;
            transform: translateY(300%);
            position: absolute;
            left: 50%;
            top: 50%;
            margin: -10px 0 0 -10px;
            opacity: 0;
        }

        &.added {
            .btn__text {
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

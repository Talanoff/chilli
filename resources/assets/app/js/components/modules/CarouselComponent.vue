<template>
    <div>
        <slot></slot>
    </div>
</template>

<script>
    import Flickity from 'flickity';

    export default {
        props: {
            params: {
                type: Object,
                default() {
                    return {}
                }
            }
        },
        mounted() {
            new Flickity(this.$el, Object.assign(this.params, {
                arrowShape: {
                    x0: 10,
                    x1: 60, y1: 50,
                    x2: 65, y2: 45,
                    x3: 20
                }
            }))
        }
    }
</script>

<style lang="scss">
    .flickity-page-dots {
        bottom: 10px;

        @media (min-width: 768px) {
            bottom: 30px;
        }

        .dot {
            width: 100%;
            max-width: 20px;
            height: 3px;
            background-color: #636568;
            opacity: 0.5;
            border-radius: 0;
            margin: 0;

            @media (min-width: 768px) {
                max-width: 35px;
            }

            @media (min-width: 1200px) {
                max-width: 75px;
            }

            &.is-selected {
                background-color: #f9c66d;
            }
        }
    }

    .flickity-button {
        background: none;
        top: initial;
        bottom: 15px;
        transition: 0.3s ease;
        transform: none;
        z-index: 20;
        display: block;

        svg {
            fill: #fff;
        }

        &.previous {
            left: initial;
            right: 64px;
        }

        &.next {
            right: 20px;
        }

        &:disabled {
            opacity: 0.5;
            svg {
                fill: #636568;
            }
        }

        &:hover {
            background: none;
            &:not(:disabled) {
                svg {
                    fill: #f9c66d;
                }
            }
        }
    }
</style>

<template>
    <transition name="modal">
        <div class="modal-wrapper">
            <div class="modal" :style="{maxWidth: maxWidth}">
                <div class="modal-close" @click="$emit('close')"></div>

                <div class="modal-entry">
                    <slot></slot>
                </div>
            </div>

            <div class="modal-mask" @click="$emit('close')"></div>
        </div>
    </transition>
</template>

<script>
    export default {
        props: {
            maxWidth: {
                type: String,
                default() {
                    return '60vw';
                }
            }
        }
    }
</script>

<style lang="scss">
    .modal {
        position: fixed;
        left: 20px;
        right: 20px;
        padding: 60px;
        background-color: #fff;
        z-index: 100500;
        top: 50%;
        transform: translateY(-50%);
        margin: 20px auto;
        max-height: 100%;
        overflow: hidden;

        &-wrapper {
            transition: all 0.35s ease;
        }

        &-mask {
            position: fixed;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            z-index: 100499;
            background-color: #000;
            opacity: 0.65;
        }

        &-entry {
            max-height: 100%;
            overflow-y: scroll;
        }

        &-close {
            position: absolute;
            right: 0;
            top: 0;
            width: 40px;
            height: 40px;
            background-color: lighten(#787979, 15%);
            transition: 0.35s ease;
            cursor: pointer;

            &:hover {
                background-color: #ab1f23;
            }

            &::before, &::after {
                position: absolute;
                left: 50%;
                top: 50%;
                border-bottom: 1px solid #fff;
                content: '';
                height: 0;
                width: 20px;
                margin-left: -10px;
            }

            &::before {
                transform: rotate(45deg);
            }

            &::after {
                transform: rotate(-45deg);
            }

            @media (min-width: 1000px) {
                width: 80px;
                height: 80px;

                &::before, &::after {
                    width: 34px;
                    margin-left: -17px;
                }
            }
        }
    }

    // Effects
    .modal-enter {
        opacity: 0;
    }

    .modal-leave-active {
        opacity: 0;
    }

    .modal-enter .modal-container,
    .modal-leave-active .modal-container {
        -webkit-transform: scale(1.1);
        transform: scale(1.1);
    }
</style>

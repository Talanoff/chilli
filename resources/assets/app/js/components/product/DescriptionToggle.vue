<template>
    <div>
        <div class="description-toggle"
             :class="{'hide-content': !fullHeight && !visible}">
            <slot></slot>
        </div>

        <a href="#" class="text-primary small description-toggle__link mt-2"
           v-if="!fullHeight"
           @click.prevent="visible = !visible">
            {{ !visible ? 'Показать больше' : 'Скрыть' }}
        </a>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                fullHeight: true,
                visible: true
            }
        },
        mounted() {
            this.fullHeight = this.visible = this.$el.clientHeight < 150;
        }
    }
</script>

<style lang="scss">
    .description-toggle {
        position: relative;
        max-height: initial;
        transition: 0.35s;

        &.hide-content {
            overflow: hidden;
            max-height: 150px;

            &::after {
                position: absolute;
                left: 0;
                right: 0;
                bottom: 0;
                height: 30px;
                content: '';
                background: linear-gradient(to top, #fff, transparent);
            }
        }
    }
</style>

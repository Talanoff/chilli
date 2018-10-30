<template>
    <div class="nav--mobile" @keyup.esc="visible = false">
        <a href="#" class="btn btn-nav ml-3"
           @click.prevent="visible = !visible"></a>

        <nav v-if="visible">
            <svg width="20" height="20" class="close" @click="visible = !visible">
                <use xlink:href="#close"></use>
            </svg>
            <slot></slot>
        </nav>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                visible: false
            }
        },
    }
</script>

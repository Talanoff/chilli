<template>
    <div class="fast-buy">
        <button class="btn btn-danger text-bold mr-1"
                @click.prevent="showModal = true">
            Быстрая покупка
        </button>

        <modal :style="styles" @close="showModal = false" max-width="480px">
            <slot></slot>
        </modal>
    </div>
</template>

<script>
    import Modal from '../modules/ModalComponent';

    export default {
        components: {
            Modal,
        },
        props: {
            opened: String
        },
        data() {
            return {
                showModal: +this.opened
            }
        },
        computed: {
            styles() {
                if (!this.showModal) {
                    return {
                        opacity: 0,
                        visibility: 'hidden',
                        pointerEvents: 'none'
                    }
                }
            }
        }
    }
</script>

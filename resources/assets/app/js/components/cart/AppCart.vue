<template>
    <div id="app-cart" class="flex align-center">
        <div class="mr-3 text-white" v-if="amount">{{ amount }} грн</div>
        <div class="count" v-if="count">{{ count }}</div>
        <svg width="30" height="30"
             class="cart-icon"
             @click="cartVisible = !cartVisible">
            <use xlink:href="#cart"></use>
        </svg>

        <div class="cart-mask" v-if="cartVisible" @click="cartVisible = false"></div>

        <div class="cart-entry" v-if="cartVisible">
            <div class="cart-entry-header p-4 px-md-8 py-md-6" v-if="cart.length">
                <div class="row flex-no-wrap align-center">
                    <div class="column-auto text-uppercase">
                        <h4 class="mb-0">
                            Вы добавили товар в корзину
                        </h4>
                    </div>
                    <div class="column-auto">
                        <a href="/cart" class="btn btn-link pr-0">
                            В корзину
                            <svg width="20" height="20" class="ml-3">
                                <use xlink:href="#rarr"></use>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <div class="cart-entry-items">
                <div class="p-6 p-md-8 text-center" v-if="cart.length === 0">
                    <p>Ваша корзина пуста</p>
                    <a href="/products" class="btn btn-secondary">
                        В каталог
                    </a>
                </div>

                <app-cart-item v-for="item in cart"
                               :item="item.id"
                               :product="item.product"
                               :key="item.id"/>
            </div>

            <div class="cart-entry-footer p-4 px-md-8 py-md-6" v-if="cart.length">
                <div class="row align-center justify-between">
                    <div class="column-auto">
                        <button class="btn btn-link pl-0" @click.prevent="cartVisible = false">
                            <svg width="20" height="20" class="mr-3">
                                <use xlink:href="#larr"></use>
                            </svg>
                            Продолжить покупки
                        </button>
                    </div>

                    <div class="column-auto mx-3">
                        <h4 class="text-normal mb-0">
                            <span class="text-muted text-uppercase mr-3">Итого</span>
                            {{ amount }} грн
                        </h4>
                    </div>

                    <div class="column text-center mt-2 mt-xxl-0">
                        <a href="/checkout" class="btn btn-secondary">
                            Оформить заказ
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import AppCartItem from './AppCartItem'

    export default {
        components: {
            AppCartItem
        },
        data() {
            return {
                cartVisible: false
            }
        },
        computed: {
            amount() {
                return this.$store.state.amount;
            },
            count() {
                return this.$store.state.count;
            },
            cart() {
                return this.$store.state.cart;
            }
        },
        mounted() {
            VBUS.$on('openCart', () => {
                this.cartVisible = true;

                // if (document.body.scrollTop !== 0 || document.documentElement.scrollTop !== 0) {
                //     document.body.scrollIntoView({block: 'start', behavior: 'smooth'});
                // }
            });

            document.addEventListener('keyup', (e) => {
                if (e.keyCode === 27) {
                    this.cartVisible = false;
                }
            });
        }
    }
</script>

<template>
    <section class="cart">
        <table class="table">
            <tr class="align-center"
                v-for="item in cart" :key="cart.id">
                <td class="p-0 cart-item-image">
                    <a :href="item.product.url">
                        <img :src="item.product.thumbnail"
                             :alt="item.product.title" width="200">
                    </a>
                </td>
                <td class="pl-6">
                    <h4 class="text-uppercase mb-1 text-normal">
                        <a :href="item.product.url">
                            {{ item.product.title }}
                        </a>
                    </h4>
                    <p class="mb-0 text-muted smaller text-uppercase">
                        Артикул № {{ item.product.sku }}
                    </p>
                </td>
                <td>
                    <h4 class="mb-0 text-normal text-dark text-center">
                        {{ item.product.price }} грн
                    </h4>
                </td>
                <td>
                    <div class="product-quantity flex justify-center">
                        <button class="btn btn-dark"
                                :disabled="item.quantity < 2"
                                @click.prevent="changeQuantity(item.id, 'remove')">
                            -
                        </button>
                        <div class="quantity-counter">
                            {{ item.quantity }}
                        </div>
                        <button class="btn btn-dark"
                                @click.prevent="changeQuantity(item.id, 'add')">
                            +
                        </button>
                    </div>
                </td>
                <td class="position-relative">
                    <h4 class="mb-0 text-dark">
                        {{ item.amount }} грн
                    </h4>

                    <a href="#" class="remove" role="button"
                       @click.prevent="removeFromCart(item.id)"></a>
                </td>
            </tr>
        </table>

        <div class="cart-footer flex justify-end align-center p-4 px-md-8 py-md-6" v-if="amount">
            <h4 class="text-normal mb-0 mr-6">
                <span class="text-muted mr-3">Итого:</span>
                <span class="text-bold text-dark">
                    {{ amount }} грн
                </span>
            </h4>

            <a href="/checkout" class="btn btn-secondary" v-if="amount">
                Оформить заказ
            </a>
        </div>

        <div class="cart-footer text-center py-10" v-if="!amount">
            <h5 class="text-normal">
                У Вас в корзине пусто...
            </h5>
            <p class="mb-0">
                <a href="/products" class="btn btn-primary">
                    Перейти к товарам
                </a>
            </p>
        </div>
    </section>
</template>

<script>
    export default {
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
        methods: {
            removeFromCart(id) {
                this.$store.dispatch('removeFromCart', id)
            },
            changeQuantity(id, action) {
                this.$store.dispatch('handleQuantity', {
                    id: id,
                    action: action
                })
            }
        }
    }
</script>

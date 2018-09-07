import Vue from 'vue';
import Vuex from "vuex";

Vue.use(Vuex);

export const store = new Vuex.Store({
    state: {
        cart: [],
        amount: 0,
        count: 0,
        checkout: true
    },
    mutations: {
        storeCart(state, cart) {
            state.cart = cart.cart;
            state.count = cart.summary.count;
            state.amount = cart.summary.amount
        },
        updateCheckout(state, status) {
            state.checkout = status;
        }
    },
    actions: {
        addToCart(context, payload) {
            axios.post(payload.action)
                .then(({data}) => this.commit('storeCart', data));
        },
        handleQuantity(context, payload) {
            axios.post(`/cart/quantity/${payload.id}/${payload.action}`)
                .then(({data}) => this.commit('storeCart', data));
        },
        removeFromCart(context, id) {
            axios.delete(`/cart/delete/${id}`)
                .then(({data}) => this.commit('storeCart', data));
        },
    }
});

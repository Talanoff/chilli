import Vue from 'vue';
import Vuex from "vuex";

Vue.use(Vuex);

export const store = new Vuex.Store({
    state: {
        cart: [],
        summary: 0,
        count: 0
    },
    mutations: {
        storeCart(state, cart) {
            state.cart = cart.cart;
            state.count = cart.summary.count;
            state.summary = cart.summary.summary
        },
    },
    actions: {
        addToCart(context, payload) {
            axios.post(payload.action)
                .then(({data}) => this.commit('storeCart', data));
        }
    }
});

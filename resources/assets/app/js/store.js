import Vue from 'vue';
import Vuex from "vuex";

Vue.use(Vuex);

export const store = new Vuex.Store({
    state: {
        cart: [],
    },
    mutations: {
        storeCart(state, cart) {
            state.cart = cart;
        },
    },
    actions: {
        addToCart(context, payload) {
            axios.post(payload.action)
                .then(({data}) => this.commit('storeCart', data.cart));
        }
    }
});

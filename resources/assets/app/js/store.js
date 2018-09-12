import Vue from 'vue';
import Vuex from "vuex";

Vue.use(Vuex);

export const store = new Vuex.Store({
    state: {
        cart: [],
        amount: 0,
        count: 0,
        checkout: true,
        favourites: []
    },
    mutations: {
        storeCart(state, cart) {
            state.cart = cart.cart;
            state.count = cart.summary.count;
            state.amount = cart.summary.amount;
            state.favourites = cart.favourites
        },
        updateCheckout(state, status) {
            state.checkout = status;
        },
        updateFavourites(state, items) {
            state.favourites = items
        }
    },
    actions: {
        addToCart(context, action) {
            axios.post(action)
                .then(({data}) => this.commit('storeCart', data));
        },
        handleQuantity(context, payload) {
            axios.post(`/cart/quantity/${payload.id}/${payload.action}`)
                .then(({data}) => this.commit('storeCart', data));
        },
        removeFromCart(context, id) {
            axios.delete(`/cart/${id}/delete`)
                .then(({data}) => this.commit('storeCart', data));
        },
        handleFavourites(context, action) {
            axios.post(action)
                .then(({data}) => this.commit('updateFavourites', data))
        },
        removeFromFavourites(context, id) {
            axios.post(`favourites/${id}/remove`)
                .then(({data}) => this.commit('updateFavourites', data));
        }
    }
});

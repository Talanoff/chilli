require('./bootstrap');

import Vue from 'vue';
import {store} from './store';

import AddToCartButton from './components/cart/AddToCartButton'

new Vue({
    el: '#app',
    components: {
        AddToCartButton
    },
    methods: {
        getCart() {
            axios.get('/cart/get')
                .then(({data}) => {
                    if (data.cart) store.commit('storeCart', data.cart);
                });
        }
    },
    created() {
        this.getCart();
    },
    store
});

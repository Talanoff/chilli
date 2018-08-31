require('./bootstrap');

import Vue from 'vue';
import {store} from './store';

import AppCart from './components/cart/AppCart'
import AddToCartButton from './components/cart/AddToCartButton'

new Vue({
    el: '#app',
    components: {
        AddToCartButton,
        AppCart
    },
    methods: {
        getCart() {
            axios.get('/cart/get')
                .then(({data}) => {
                    store.commit('storeCart', data);
                });
        }
    },
    created() {
        this.getCart();
    },
    store
});

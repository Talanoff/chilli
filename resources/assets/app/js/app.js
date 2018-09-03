require('./bootstrap');

import Vue from 'vue';
import {store} from './store';

import AppCart from './components/cart/AppCart';
import AddToCartButton from './components/cart/AddToCartButton';
import StarRating from './components/product/StarRating';
import ProductSlider from './components/product/ProductSlider';

new Vue({
    el: '#app',
    components: {
        AppCart,
        AddToCartButton,
        StarRating,
        ProductSlider
    },
    methods: {
        getCart() {
            axios.get('/cart/get')
                .then(({data}) => {
                    store.commit('storeCart', data);
                });
        }
    },
    mounted() {
        this.getCart();

        const notifications = document.querySelectorAll('.notification');
        if (notifications.length) {
            setTimeout(() => {
                [].forEach.call(notifications, function (n) {
                    n.style.display = 'none';
                });
            }, 4000)
        }
    },
    store
});

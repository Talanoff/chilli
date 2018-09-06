require('./bootstrap');

import Vue from 'vue';
import {store} from './store';
import lozad from 'lozad'

import AppCart from './components/cart/AppCart';
import AddToCartButton from './components/cart/AddToCartButton';
import StarRating from './components/product/StarRating';
import ProductSlider from './components/product/ProductSlider';

window.VBUS = new Vue();

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

        // Handle notifications
        const notifications = document.querySelectorAll('.notification');
        if (notifications.length) {
            setTimeout(() => {
                [].forEach.call(notifications, function (n) {
                    n.style.display = 'none';
                });
            }, 4000)
        }

        // LazyLoad
        const observer = lozad();
        observer.observe();

        // Filters
        const togglers = document.querySelectorAll('.filters-list-item .toggler-link');
        if (togglers.length) {
            [].forEach.call(togglers, t => {
                t.addEventListener('click', event => {
                    event.preventDefault();
                    const link = event.target.hash.substr(1);

                    const el = document.getElementById(link);
                    el.classList.toggle('is-visible');
                    el.parentNode.classList.toggle('is-active');
                });
            });
        }

        if (this.$refs.hasOwnProperty('filter')) {
            const filters = document.querySelector('.filters');

            this.$refs.filter.addEventListener('click', event => {
                event.preventDefault();
                filters.classList.add('is-active');
            });

            const filterOuter = document.addEventListener('click', event => {
                if (!filters.contains(event.target) && event.target !== this.$refs.filter) {
                    filters.classList.remove('is-active');
                    removeEventListener('click', filterOuter);
                }
            })
        }
    },
    store
});

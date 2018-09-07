require('./bootstrap');

import Vue from 'vue';
import {store} from './store';
import lozad from 'lozad'

import AppCart from './components/cart/AppCart';
import AppCartTotal from './components/cart/AppCartTotal';
import AddToCartButton from './components/cart/AddToCartButton';

import StarRating from './components/product/StarRating';
import ProductSlider from './components/product/ProductSlider';

import BirthDay from './components/profile/BirthDay';
import Checkout from './components/cart/CheckoutComponent';

window.VBUS = new Vue();

new Vue({
    el: '#app',
    components: {
        AppCart,
        AppCartTotal,
        AddToCartButton,
        StarRating,
        ProductSlider,
        BirthDay,
        Checkout
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

        const iframes = document.getElementsByTagName('iframe');
        window.onload = function () {
            calculateIframeSize();
        };
        window.onresize = function () {
            calculateIframeSize()
        };

        function calculateIframeSize() {
            [].forEach.call(iframes, (frame) => {
                const parent = getComputedStyle(frame.parentElement);

                let width = frame.width,
                    height = frame.height,
                    ratio = height / width,
                    parentWidth = parseFloat(parent.width) - (parseFloat(parent.paddingLeft) + parseFloat(parent.paddingRight));

                frame.width = parentWidth;
                frame.height = parentWidth * ratio;
            })
        }
    },
    store
});

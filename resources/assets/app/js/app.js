require('./bootstrap');

import Vue from 'vue';
import {store} from './store';

import lozad from 'lozad'; // Lazy load

import AppCart from './components/cart/AppCart';
import AppCartTotal from './components/cart/AppCartTotal';
import AddToCartButton from './components/cart/AddToCartButton';
import Checkout from './components/cart/Checkout';

import StarRating from './components/product/StarRating';
import ProductSlider from './components/product/ProductSlider';
import FastBuy from './components/product/FastBuy';
import KitsCarousel from './components/product/KitsCarousel';

import FavouritesList from './components/favourites/FavouritesList';
import AppFavourites from './components/favourites/AppFavourites';
import AddToFavouritesButton from './components/favourites/AddToFavouritesButton';

import BirthDay from './components/profile/BirthDay';

import Carousel from './components/modules/CarouselComponent';
import AppSearch from './components/modules/AppSearch';
import AppMobileNav from './components/modules/AppMobileNav';

window.VBUS = new Vue();

new Vue({
    el: '#app',
    components: {
        AppCart,
        AppCartTotal,
        AppSearch,
        AddToCartButton,
        StarRating,
        ProductSlider,
        BirthDay,
        Checkout,
        FastBuy,
        Carousel,
        FavouritesList,
        AppFavourites,
        AddToFavouritesButton,
        KitsCarousel,
        AppMobileNav
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
        require('./modules/notifications');

        // Filters
        require('./modules/filters')(this);

        // iFrames
        require('./modules/iframes');

        // Phone mask
        require('./modules/phone-mask');

        // LazyLoad
        const observer = lozad();
        observer.observe();
    },
    store
});

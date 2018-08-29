require('./bootstrap');

import Wysiwyg from './components/Wysiwyg';
import AttributeCreator from './components/AttributeCreator';
import ImagesUploader from './components/ImagesUploader';

const app = new Vue({
    el: '#app',
    components: {
        Wysiwyg,
        AttributeCreator,
        ImagesUploader
    }
});

require('./bootstrap');

import Wysiwyg from './components/Wysiwyg';
import AttributeCreator from './components/AttributeCreator';
import ImagesUploader from './components/ImagesUploader';
import SingleImageUploader from './components/SIngleImageUploader';

import ProductKits from './components/ProductKits';
import ProductSelector from './components/ProductSelector';

new Vue({
    el: '#app',
    components: {
        Wysiwyg,
        AttributeCreator,
        ImagesUploader,
        ProductKits,
        ProductSelector,
        ImageUploader: SingleImageUploader
    },
    mounted() {
        const field = document.getElementById('video-link');

        if (field && this.$refs.type) {
            this.$refs.type.addEventListener('change', function (e) {
                if (e.target.value === 'article') {
                    field.style.display = 'none';
                    document.getElementById('video_url').value = '';
                } else {
                    field.style.display = 'block';
                }
            })
        }
    }
});

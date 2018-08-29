<template>
    <div class="form-group image-uploader">
        <div class="d-flex flex-wrap align-items-center justify-content-center mb-3"
             v-if="images.length > 0">
            <div class="image-preview" v-for="(image, index) in images" :key="index">
                <input type="hidden" name="gallery[]"
                       :value="JSON.stringify(image)"
                       v-if="!image.hasOwnProperty('id')">

                <a @click.prevent="removeImage(index)"
                   class="btn btn-danger btn-delete d-flex justify-content-center align-items-center">
                    <svg width="16" height="16">
                        <use xlink:href="#delete"></use>
                    </svg>
                </a>

                <div class="preview" :style="{backgroundImage: 'url('+ image.url +')'}"></div>
            </div>
        </div>

        <label for="gallery" class="text-center d-block p-4 mb-0">
            <input type="file" id="gallery" multiple accept="image/*" @change="handleImages">
            Загрузить
            <template v-if="images.length">еще</template>
            изображения
        </label>
    </div>
</template>

<script>
    export default {
        props: {
            existedImages: String
        },
        data() {
            return {
                images: []
            }
        },
        methods: {
            handleImages(event) {
                if (event.target.files && event.target.files[0]) {
                    for (let i = 0; i < event.target.files.length; i++) {
                        const reader = new FileReader();

                        reader.onload = function (e) {
                            this.images.push({
                                name: event.target.files[i].name,
                                url: e.target.result,
                            });
                        }.bind(this);

                        reader.readAsDataURL(event.target.files[i]);
                    }
                }
            },
            removeImage(index) {
                if (this.images[index].hasOwnProperty('id')) {
                    axios.delete(route('admin.media.delete', this.images[index].id))
                }

                this.images.splice(index, 1)
            }
        },
        mounted() {
            this.images.push(...JSON.parse(this.existedImages));
        }
    }
</script>

<style lang="scss" scoped>
    .image-uploader {
        position: relative;
        background-color: #f9f9f9;
        padding: 8px;

        [type="file"] {
            position: absolute;
            left: -9999px;
        }

        label {
            transition: 0.35s;
            background-color: rgba(#ccc, 0.1);
            &:hover {
                background-color: rgba(#000, 0.05);
            }
        }
    }

    .image-preview {
        position: relative;
        flex: 0 0 50%;
        max-width: 50%;

        @media (min-width: 992px) {
            flex: 0 0 33%;
            max-width: 33%;
        }

        .preview {
            padding-top: 100%;
            background-size: cover;
            background-position: 50% 50%;
            margin: 2px;
        }

        .btn-delete {
            opacity: 0;
            padding: 0;
            position: absolute;
            top: -3px;
            right: -3px;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            transition: 0.35s;
            transform: scale(0);

            svg {
                margin: auto;
                fill: #fff;
            }
        }

        &:hover {
            .btn-delete {
                opacity: 1;
                visibility: visible;
                transform: scale(1);
            }
        }
    }
</style>

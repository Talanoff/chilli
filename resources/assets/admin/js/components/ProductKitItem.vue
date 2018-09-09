<template>
    <div class="product-kit mb-3 position-relative">
        <a @click.prevent="$emit('delete', item.id)"
           class="btn btn-danger btn-delete d-flex justify-content-center align-items-center">
            <svg width="16" height="16">
                <use xlink:href="#delete"></use>
            </svg>
        </a>

        <div class="row flex-no-wrap align-items-center">
            <div class="col-sm d-flex align-items-center">
                <a :href="item.product.url" class="mr-3 product-kit-thumb">
                    <img :src="item.product.thumbnail" alt="">
                </a>

                <div>
                    <a :href="item.product.url">
                        {{ item.product.title }}
                    </a>
                    <h5 class="mb-0">{{ item.product.price }} грн</h5>
                </div>
            </div>
            <div class="col-sm-auto display-2 font-weight-light px-0">+</div>
            <div class="col-sm d-flex align-items-center">
                <a :href="item.related.url" class="mr-3 product-kit-thumb">
                    <img :src="item.related.thumbnail" alt="">
                </a>

                <div>
                    <a :href="item.related.url">
                        {{ item.related.title }}
                    </a>
                    <h5 class="mb-0">{{ item.related.price }} грн</h5>
                </div>
            </div>
            <div class="col-sm-auto display-2 font-weight-light px-0">=</div>
            <div class="col-sm-auto">
                <h3 class="font-weight-bold mb-0">
                    {{ item.amount }} грн
                </h3>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            item: Object
        }
    }
</script>

<style lang="scss" scoped>
    .product-kit {
        padding: 20px;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;

        &-thumb {
            flex: 0 0 50px;
            width: 50px;
        }

        .font-weight-light {
            font-weight: 100 !important;
        }
    }

    .display-2 {
        line-height: 30px;
    }

    .flex-no-wrap {
        flex-wrap: nowrap !important;
    }

    .btn-delete {
        position: absolute;
        right: -12px;
        top: 50%;
        margin-top: -12px;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        padding: 0;

        svg {
            fill: #fff;
        }
    }
</style>

<div class="product-item-wrapper {{ $classes ?? '' }}">
    <div class="product-item{{ $product_classes ?? '' }}">
        <figure style="background: url({{ $product->getFirstMediaUrl('product', isset($large) ? 'large' : 'medium') }}) 50% 50% / cover no-repeat;"></figure>

        @if ($product->tag)
            <span class="product-item__tag">
            {{ App\Models\Product\Product::$TAGS[$product->tag] }}
        </span>
        @endif

        <h3 class="product-item__title text-uppercase mt-6 mb-4">
            <a href="{{ route('app.product.show', $product) }}">
                {{ $product->title }}
            </a>
        </h3>

        <h4 class="product-item__price mb-4">
            {{ $product->computed_price }} грн
        </h4>

        <add-to-cart-button
            class="btn-secondary"
            action="{{ route('app.cart.add', $product) }}"></add-to-cart-button>
    </div>
</div>

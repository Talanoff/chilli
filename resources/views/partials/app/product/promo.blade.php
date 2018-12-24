<div class="product-item-wrapper {{ $classes ?? '' }}">
    <a href="{{ route('app.product.show', $product) }}"
       class="product-item product-item--promo{{ $product_classes ?? '' }}">
        <figure class="product-item__image lozad"
                data-background-image="{{ $product->getFirstMediaUrl('product', !$large ? 'medium' : 'large') }}"></figure>

        @if ($product->tag)
            <span class="product-item__tag">{{ App\Models\Product\Product::$TAGS[$product->tag] }}</span>
        @endif

        <div class="product-item__content mb-4">
            <h3 class="product-item__title text-uppercase mb-0">
                {{ $product->title }}
            </h3>

            @if ($product->subtitle)
                <div class="product-item__subtitle small text-muted text-uppercase">{{ $product->subtitle }}</div>
            @endif
        </div>

        <div class="product-item__pricy">
            <h4 class="product-item__price mb-4">
                {{ $product->computed_price }} грн
            </h4>

            <add-to-cart-button
                    class="btn-secondary"
                    action="{{ route('app.cart.add', $product) }}"></add-to-cart-button>
        </div>
    </a>
</div>

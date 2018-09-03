@php
    $large = $large ?? false;
    $related = $related ?? false;
@endphp

<div
    class="product-item-wrapper w-md-1/2{{ !$large && $loop->index > 3 || $related ? ' w-xl-1/4' : request()->get('page') > 1 ? ' w-xl-1/4' : '' }}">
    <a href="{{ route('app.product.show', $product) }}" class="product-item product-item--squire">
        <figure class="product-item__link"
                style="background: url({{ $product->getFirstMediaUrl('product', !$large ? 'medium' : 'large') }}) 50% 50% / cover no-repeat;"></figure>

        <div class="product-item-content">
            <h6 class="product-item__title text-uppercase {{ $product->subtitle ? 'mb-0' : 'mb-4' }}">
                {{ $product->title }}
            </h6>

            @if ($product->subtitle)
                <p class="small text-muted text-uppercase">{{ $product->subtitle }}</p>
            @endif

            <div class="my-4">
                @include('partials.app.product.stars', ['stars' => $product->stars])
            </div>

            <h4 class="product-item__price mb-4">
                {{ $product->computed_price }} грн
            </h4>

            @if (count($product->colors))
                <div class="product-item__colors flex mb-5">
                    @foreach($product->colors as $color)
                        <div class="{{ !$loop->last ? 'mr-2' : '' }}"
                             style="background-color: {{ $color->value }};"></div>
                    @endforeach
                </div>
            @endif

            <add-to-cart-button
                class="btn-secondary"
                action="{{ route('app.cart.add', $product) }}"></add-to-cart-button>
        </div>
    </a>
</div>

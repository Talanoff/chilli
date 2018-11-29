@php
    $large = $large ?? false;
    $default = $default ?? false;
@endphp

<div
    class="product-item-wrapper w-md-1/2{{ !$large && $loop->index > 3 || $default ? ' w-lg-1/3 w-xl-1/4' : (request()->get('page') > 1 ? ' w-lg-1/3 w-xl-1/4' : '') }}">
    <a href="{{ route('app.product.show', $product) }}" class="product-item product-item--squire">
        <figure class="product-item__image lozad"
                data-background-image="{{ $product->getFirstMediaUrl('product', !$large ? 'medium' : 'large') }}"></figure>

        <div class="product-item-content">
            <h6 class="product-item__title text-uppercase {{ $product->subtitle ? 'mb-0' : 'mb-4' }}">
                {{ $product->title }}
            </h6>

            @if ($product->subtitle)
                <div class="product-item__subtitle small text-muted text-uppercase">{{ $product->subtitle }}</div>
            @endif

            @if ($product->tag)
                <div class="pt-1">
                    <span class="product-item__tag py-1 px-2">{{ App\Models\Product\Product::$TAGS[$product->tag] }}</span>
                </div>
            @endif

            <div class="my-3">
                @include('partials.app.product.stars', ['stars' => $product->stars])
            </div>

            @if (count($product->colors))
                <div class="product-item__colors flex mb-5">
                    @foreach($product->colors as $color)
                        <div class="{{ !$loop->last ? 'mr-2' : '' }}"
                             style="background-color: {{ $color->value }};"></div>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="product-item__pricy">
            <h4 class="product-item__price mb-3">
                {{ $product->computed_price }} грн
            </h4>

            <add-to-cart-button
                class="btn-secondary"
                action="{{ route('app.cart.add', $product) }}"></add-to-cart-button>
        </div>

        @if ($product->review()->count())
            <svg width="36" height="36" class="product-item__video">
                <use xlink:href="#video"></use>
            </svg>
        @endif
    </a>
</div>

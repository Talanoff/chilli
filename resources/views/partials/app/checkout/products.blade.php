<table class="table">
    @foreach($cart as $item)
        @if ($item->product)
            <tr>
                <td width="{{ $size ?? 200 }}">
                    <a href="{{ route('app.product.show', $item->product) }}">
                        <img src="{{ $item->product->getFirstMediaUrl('product', 'thumb') }}" alt="">
                    </a>
                </td>
                <td>
                    <p class="small text-muted mb-1">Название</p>
                    <h6 class="text-uppercase mb-0">
                        <a href="{{ route('app.product.show', $item->product) }}">{{ $item->product->title }}</a>
                    </h6>
                    <p class="mb-0 small">Артикл № {{ $item->product->sku }}</p>
                </td>
                <td class="text-right">
                    <p class="small text-muted mb-1">Цена</p>
                    <h6 class="mb-0 no-wrap">
                        <span class="text-normal smaller">{{ $item->quantity }} x</span>
                        {{ $item->product->computed_price }} грн
                    </h6>
                </td>
            </tr>
        @else
            <tr>
                <td width="{{ $size ?? 200 }}" class="position-relative">
                    <a href="{{ route('app.product.show', $item->kit->product) }}" class="block">
                        <img src="{{ $item->kit->product->getFirstMediaUrl('product', 'thumb') }}" alt="">
                    </a>

                    <a href="{{ route('app.product.show', $item->kit->related) }}"
                       class="block mt-1">
                        <img src="{{ $item->kit->related->getFirstMediaUrl('product', 'thumb') }}" alt="">
                    </a>
                </td>
                <td>
                    <p class="small text-muted mb-1">Товары</p>
                    <h6 class="text-uppercase mb-1">
                        <a href="{{ route('app.product.show', $item->kit->product) }}">{{ $item->kit->product->title }}</a>
                    </h6>
                    <h6 class="text-uppercase mb-0">
                        <a href="{{ route('app.product.show', $item->kit->related) }}">{{ $item->kit->related->title }}</a>
                    </h6>
                    <p class="mb-0 small">Набор № {{ $item->kit->sku }}</p>
                </td>
                <td class="text-right">
                    <p class="small text-muted mb-1">Цена</p>
                    <h6 class="mb-0 no-wrap">
                        <span class="text-normal smaller">{{ $item->quantity }} x</span>
                        {{ $item->kit->amount }} грн
                    </h6>
                </td>
            </tr>
        @endif
        <tr>
            <td colspan="3">
                <hr class="my-2">
            </td>
        </tr>
    @endforeach
</table>
@isset($amount)
    <h5 class="text-right">
        ИТОГО: {{ $amount }} грн
    </h5>
@endisset

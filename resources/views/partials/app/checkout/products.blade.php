<table class="table">
    @foreach($cart as $item)
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
                <p class="mb-0 small">Артикул № {{ $item->product->sku }}</p>
            </td>
            <td class="text-right">
                <p class="small text-muted mb-1">Цена</p>
                <h6 class="mb-0 no-wrap">
                    <span class="text-normal smaller">{{ $item->quantity }} x</span>
                    {{ $item->product->computed_price }} грн
                </h6>
            </td>
        </tr>
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

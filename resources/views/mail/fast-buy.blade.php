<h4>Артикул №{{$product->id}}. {{ $product->title }}, {{ $product->computed_price }} грн.</h4>

<p><b>Заказчик:</b></p>
<p>{{ $user->name }}</p>
<p>{{ $user->phone }}</p>
@if ($user->email)
    <p>{{ $user->email }}</p>
@endif

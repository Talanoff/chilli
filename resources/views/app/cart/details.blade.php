@extends('layouts.app', ['app_title' => 'Детали заказа'])

@section('content')

    <section class="checkout-details">
        @if($order)
            <h4>ID заказа: {{ $order->id }}</h4>

            <p>
                <span class="order-status order-status--{{ $order->status }}">
                    {{ App\Models\Order\Order::$STATUSES[$order->status] }}
                </span>
            </p>

            @if ($order->delivery === 'np')
                Доставка «Новой Почтой» по адресу:
                {{ $order->city }}, {{ $order->warehouse }}
            @endif

            @if ($order->delivery === 'courier')
                Доставка курьером по адресу:
                {{ $order->address }}
            @endif

            <h5>Детали заказа:</h5>

            <div class="w-lg-3/4 w-xl-1/2">
                @include('partials.app.checkout.products', ['cart' => $order->checkout, 'amount' => $order->amount, 'size' => 100])
            </div>
        @else
            <p class="text-center">
                <img src="{{ asset('images/logo-gray.png') }}" alt="Chilli">
            </p>
            <h4 class="text-center text-normal">
                У Вас нет активных заказов.
            </h4>
        @endif

        <div class="text-center mt-8">
            <a href="{{ route('app.product.index') }}" class="btn btn-primary">
                Вернуться к покупкам
            </a>
        </div>
    </section>

@endsection

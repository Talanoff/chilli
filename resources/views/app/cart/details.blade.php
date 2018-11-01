@extends('layouts.app', ['app_title' => 'Детали заказа'])

@section('content')

    <section class="checkout-details w-lg-3/4 w-xl-1/2 mx-auto">
        @if($order)
            <h1 class="h2 text-center mb-0 text-white">Спасибо!</h1>
            <h4 class="text-center">Ваш заказ принят!</h4>

            <div class="flex">
                <h4>ID заказа: <span class="text-white">{{ $order->id }}</span></h4>

                <div class="ml-6">
                <span class="order-status order-status--{{ $order->status }}">
                    {{ App\Models\Order\Order::$STATUSES[$order->status] }}
                </span>
                </div>
            </div>

            <p class="my-8">
                @if ($order->delivery === 'np')
                    Доставка «Новой Почтой» по адресу:<br>
                    <span class="text-white">{{ $order->city }}, {{ $order->warehouse }}</span>
                @endif

                @if ($order->delivery === 'courier')
                    Доставка курьером по адресу:<br>
                    <span class="text-white">{{ $order->address }}</span>
                @endif
            </p>

            <h5>Детали заказа:</h5>

            <div class="checkout-products">
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

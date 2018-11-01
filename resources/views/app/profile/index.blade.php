@extends('layouts.app', ['app_title' => 'Профиль'])

@section('content')

    <section class="profile w-lg-3/4 w-xl-1/2 mx-auto">
        <h1 class="h3">Добрый день, <span class="text-primary">{{ $user->name }}!</span></h1>

        <div class="flex">
            <a href="{{ route('app.profile.edit') }}" class="btn btn-primary mr-2">
                Редактировать профиль
            </a>
            <a href="{{ route('app.profile.password.request') }}" class="btn btn-secondary">
                Сменить пароль
            </a>
        </div>

        @if (count($orders))
            <div class="mt-10 checkout-products">
                <h4 class="text-white">История заказов</h4>

                @foreach($orders as $order)
                    <article class="{{ !$loop->last ? 'mb-8' : '' }}">
                        <div class="flex">
                            <h4 class="mb-1">ID заказа: <span class="text-white">{{ $order->id }}</span></h4>

                            <div class="ml-6">
                            <span class="order-status order-status--{{ $order->status }}">
                                {{ App\Models\Order\Order::$STATUSES[$order->status] }}
                            </span>
                            </div>
                        </div>
                        <p>
                            от {{ $order->created_at->format('d.m.Y H:i') }}
                        </p>

                        @include('partials.app.checkout.products', ['cart' => $order->checkout, 'amount' => $order->amount, 'size' => 100])
                    </article>
                @endforeach
            </div>

            {{ $orders->links() }}
        @endif
    </section>

@endsection

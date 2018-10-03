@extends('layouts.app', ['app_title' => 'Профиль'])

@section('content')

    <section class="profile py-6">
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
            <div class="my-6">
                <h4 class="text-white">История заказов</h4>

                @foreach($orders as $order)
                    <div class="mb-2">
                        <strong class="text-primary h5">
                            Заказ №{{ $order->id }}
                        </strong>
                        от {{ $order->created_at->format('d.m.Y H:i') }}
                    </div>

                    @include('partials.app.checkout.products', ['cart' => $order->checkout, 'amount' => $order->amount, 'size' => 100])
                @endforeach
            </div>

            {{ $orders->links() }}
        @endif
    </section>

@endsection

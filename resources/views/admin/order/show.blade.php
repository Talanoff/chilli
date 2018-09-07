@extends('layouts.admin', ['app_title' => 'Заказ № ' . $order->id])

@section('content')

    <section class="content">

        <h1 class="h2 d-flex align-items-center">
            {{ 'Заказ № ' . $order->id }}
        </h1>

        <p>
            <span
                class="px-2 py-1 bg-{{ $order->status === 'processing' ? 'warning' : ($order->status === 'finished' ? 'success' : 'danger') }}">
            {{ App\Models\Order\Order::$STATUSES[$order->status] }}
            </span>
        </p>

        <div class="mt-5 row">
            <div class="col-md">
                <h5>Покупатель:</h5>
                <table class="table table-borderless table-sm">
                    <tr>
                        <td width="100" class="pl-0">Имя:</td>
                        <td>
                            <a href="{{ route('admin.user.show', $order->user) }}">
                                {{ $order->user->name }}
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td class="pl-0">Телефон:</td>
                        <td>{{ $order->user->phone }}</td>
                    </tr>
                    <tr>
                        <td class="pl-0">E-mail:</td>
                        <td>
                            <a href="mailto:{{ $order->user->email }}">
                                {{ $order->user->email }}
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td class="pl-0">Д.Р.</td>
                        <td>{{ $order->user->birthday->format('d.m.Y') }}</td>
                    </tr>
                </table>
            </div>

            <div class="col-md mt-4 mt-md-0">
                <h5>Доставка:</h5>

                @if ($order->delivery === 'np')
                    Доставка «Новой Почтой» по адресу:
                    {{ $order->city }}, {{ $order->warehouse }}
                @endif

                @if ($order->delivery === 'courier')
                    Доставка курьером по адресу:
                    {{ $order->address }}
                @endif

                @if ($order->delivery === 'self')
                    Самовывоз
                @endif
            </div>
        </div>

        <table class="table mt-5">
            @foreach($order->checkout as $item)
                <tr>
                    <td width="100">
                        <img src="{{ $item->product->getFirstMediaUrl('product', 'thumb') }}" alt="">
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
            @endforeach
        </table>

        <h5 class="text-right">
            ИТОГО: <strong>{{ $order->amount }} грн</strong>
        </h5>

    </section>

@endsection

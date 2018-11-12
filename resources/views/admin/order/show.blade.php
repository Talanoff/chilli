@extends('layouts.admin', ['app_title' => 'Заказ № ' . $order->id])

@section('content')

    <section class="content">

        <h1 class="h2 d-flex align-items-center">
            {{ 'Заказ № ' . $order->id }}
        </h1>

        <p>
            <span
                class="rounded px-2 py-1 bg-{{ $order->status !== 'declined' ? 'warning' : ($order->status === 'finished' ? 'success' : 'danger') }}">
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
                        <td>
                            <a href="tel:{{ $order->user->phone }}" class="link link-underline">
                                {{ $order->user->formatted_phone }}
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td class="pl-0">E-mail:</td>
                        <td>
                            <a href="mailto:{{ $order->user->email }}" class="link link-underline">
                                {{ $order->user->email }}
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td class="pl-0">Д.Р.</td>
                        <td>{{ optional($order->user->birthday)->format('d.m.Y') }}</td>
                    </tr>
                </table>
            </div>

            <div class="col-md mt-4 mt-md-0">
                <h5>Доставка:</h5>

                @if ($order->delivery === 'np')
                    <strong>Доставка «Новой Почтой» по адресу:</strong><br>
                    {{ $order->city }}, {{ $order->warehouse }}
                @endif

                @if ($order->delivery === 'courier')
                    <strong>Доставка курьером по адресу:</strong><br>
                    {{ $order->address }}
                @endif

                @if ($order->delivery === 'self')
                    Самовывоз
                @endif

                <h5 class="mt-4">Оплата:</h5>
                <p>{{ App\Models\Order\Order::$PAYMENT[$order->payment] }}</p>
            </div>
        </div>

        <table class="table mt-5">
            @foreach($order->checkout as $item)
                @if ($item->product)
                    <tr>
                        <td width="100">
                            <a href="{{ route('app.product.show', $item->product) }}">
                                <img src="{{ $item->product->getFirstMediaUrl('product', 'thumb') }}" alt="">
                            </a>
                        </td>
                        <td>
                            <p class="small text-muted mb-3">Артикул № {{ $item->product->sku }}</p>
                            <h6 class="text-uppercase mb-0">
                                <a href="{{ route('app.product.show', $item->product) }}"
                                   class="link link-underline">{{ $item->product->title }}</a>
                            </h6>
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
                        <td width="100" class="position-relative">
                            <div class="d-flex pt-4">
                                <a href="{{ route('app.product.show', $item->kit->product) }}" class="d-block">
                                    <img src="{{ $item->kit->product->getFirstMediaUrl('product', 'thumb') }}" alt="">
                                </a>

                                <a href="{{ route('app.product.show', $item->kit->related) }}"
                                   class="d-block ">
                                    <img src="{{ $item->kit->related->getFirstMediaUrl('product', 'thumb') }}" alt="">
                                </a>
                            </div>
                        </td>
                        <td>
                            <p class="small text-muted mb-3">Набор № {{ $item->kit->sku }}</p>
                            <h6 class="text-uppercase mb-2">
                                <a href="{{ route('app.product.show', $item->kit->product) }}"
                                   class="link link-underline">{{ $item->kit->product->title }}</a>
                            </h6>
                            <h6 class="text-uppercase mb-0">
                                <a href="{{ route('app.product.show', $item->kit->related) }}"
                                   class="link link-underline">{{ $item->kit->related->title }}</a>
                            </h6>
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
            @endforeach
        </table>

        <h5 class="text-right">
            ИТОГО: <strong>{{ $order->amount }} грн</strong>
        </h5>

        <div class="mt-5 row">
            <form action="{{ route('admin.order.update', $order) }}" method="post" class="col-lg-5 d-flex">
                @csrf

                <select name="status" id="status" class="form-control mr-2">
                    @foreach(App\Models\Order\Order::$STATUSES as $key => $status)
                        <option value="{{ $key }}" {{ $key === $order->$status ? 'selected' : '' }}>
                            {{ $status }}
                        </option>
                    @endforeach
                </select>

                <button class="btn btn-primary">Сохранить</button>
            </form>
        </div>

    </section>

@endsection

@extends('layouts.admin', ['app_title' => 'Заказы'])

@section('content')

    <section class="content">

        <h1 class="mb-5 h2 d-flex align-items-center">
            Заказы
        </h1>

        @forelse($orders as $order)
            <div class="item">
                <div class="item-id">{{ $order->id }}</div>
                <div class="item-header row">
                    <div class="col">
                        <h4>
                            <a href="{{ route('admin.order.show', $order) }}"
                               class="link link-underline">
                                Заказ № {{ $order->id }}
                            </a>
                        </h4>
                        <h5>
                            {{ $order->created_at->format('j.m.Y \в H:i') }}
                            <small class="text-muted">({{ $order->created_at->diffForHumans() }})</small>
                        </h5>
                        <div class="mt-4">
                            Пользователь:
                            <a href="{{ route('admin.user.show', $order->user) }}"
                               class="link link-underline">
                                {{ $order->user->name }}
                            </a>
                        </div>
                    </div>
                    <div class="col-auto">
                        <h3 class="font-weight-bold">{{ $order->amount }} грн</h3>
                        <p>
                            <span
                                class="rounded px-2 py-1 bg-{{ $order->status !== 'declined' ? 'warning' : ($order->status === 'finished' ? 'success' : 'danger') }}">
                            {{ App\Models\Order\Order::$STATUSES[$order->status] }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        @empty
            <em>Заказов пока нет... <strong>Работаем усердней!</strong></em>
        @endforelse

    </section>

    {{ $orders->appends(request()->except('page'))->links() }}

@endsection

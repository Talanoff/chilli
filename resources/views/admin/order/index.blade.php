@extends('layouts.admin', ['app_title' => 'Заказы'])

@section('content')

    <section class="content">

        <div class="mb-5 d-lg-flex align-items-center">
            <h1 class="h2 mb-0">Заказы</h1>

            <form method="post" action="{{ route('admin.order.search') }}"
                  class="ml-lg-5 flex-grow-1">
                @csrf
                <div class="d-flex">
                    <div class="flex-grow-1 mr-2">
                        <input type="search" name="search" placeholder="№ заказа или имя пользователя"
                               class="form-control" value="{{ $search ?? '' }}">
                    </div>
                    <div>
                        <button class="btn btn-secondary">Найти</button>
                    </div>
                </div>
            </form>
        </div>

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
                                class="rounded px-2 py-1 bg-{{ $order->status === 'declined' ? 'danger' : ($order->status === 'finished' ? 'success' : 'warning') }}">
                            {{ App\Models\Order\Order::$STATUSES[$order->status] }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        @empty
            @if (!$search)
                <em>Заказов пока нет... <strong>Работаем усердней!</strong></em>
            @else
                <em>Такого заказа не найдено.</em>
            @endif
        @endforelse

    </section>

    {{ $orders->appends(request()->except('page'))->links() }}

@endsection

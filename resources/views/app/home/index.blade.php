@extends('layouts.app', ['app_title' => 'Главная'])

@section('content')

    <section class="products products--home flex">
        @forelse($products as $product)
            @php
                $classes = '';
                $product_classes = '';
                $large = false;

                if ($loop->index === 0) {
                    $classes = 'is-large';
                    $product_classes = ' h-100';
                    $large = true;
                }

                if ($loop->index > 0 && $loop->index < 3) {
                    $classes = 'grouped-products h-50';
                }

                if ($product->tag !== 'absolute_hit') {
                    $product_classes .= ' tag-rotated';
                }

                if ($loop->index > 2 && $loop->index < 5) {
                    $classes = 'is-small';
                    $product_classes .= ' h-100';
                }

                if ($loop->last) {
                    $classes .= 'is-medium is-last';
                }
            @endphp

            @if ($loop->index === 1)
                <div class="is-medium">
                    @endif

                    @if ($loop->index === 3)
                </div><!-- 2/3 close -->

                <div class="product-item-wrapper is-large">
                    <a href="{{ route('app.product.index', ['sort' => 'leaders']) }}"
                       class="product-item product-item--leaders justify-start">
                        <figure></figure>
                        <h3 class="product-item__title text-uppercase mb-3">Лидеры продаж</h3>
                        <p class="text-muted small text-uppercase">
                            Самые продаваемы товары
                        </p>
                    </a>
                </div>

                <div class="product-item-wrapper is-medium">
                    <a href="{{ route('app.product.index') }}"
                       class="product-item product-item--all justify-start">
                        <figure></figure>
                        <h3 class="product-item__title text-uppercase mb-3">Смотреть все товары</h3>
                        <p class="text-muted small text-uppercase">
                            Перейти в каталог
                        </p>
                    </a>
                </div>
            @endif

            @include('partials.app.product.promo', ['classes' => $classes, 'large' => $large])
        @empty
            <div class="w-1">
                Продукты пока не добавлены...
            </div>
        @endforelse
    </section>

@endsection

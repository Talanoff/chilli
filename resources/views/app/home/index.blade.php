@extends('layouts.app', ['app_title' => 'Главная'])

@section('content')

    @if (session()->has('success'))
        <div class="notification notification-success">
            {{ session()->get('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="notification notification-danger">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif


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
                    <a href="{{ route('app.product.index', ['leaders' => 'true']) }}"
                       class="product-item product-item--promo product-item--leaders justify-start">
                        <figure class="product-item__link"></figure>
                        <h3 class="product-item__title text-uppercase mb-3">Лидеры продаж</h3>
                        <p class="text-muted small text-uppercase">
                            Самые продаваемы товары
                        </p>
                    </a>
                </div>

                <div class="product-item-wrapper is-medium">
                    <a href="{{ route('app.product.index') }}"
                       class="product-item product-item--promo product-item--all justify-start">
                        <figure class="product-item__link"></figure>
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

    @if (count($reviews))
        <section class="reviews-promo flex">
            <div class="reviews-promo__slider">
                <carousel id="reviews-carousel">
                    @each('partials.app.review.promo', $reviews, 'review')
                </carousel>
            </div>

            <a href="{{ route('app.review.index') }}" class="reviews-promo__all text-uppercase">
                <strong>смотреть все обзоры</strong>
            </a>
        </section>
    @endif

    <section class="about flex py-8">
        <div class="w-md-1/2 pr-8">
            <h3 class="text-uppercase text-white">
                <span class="decorator decorator--right">
                    {{ $settings['about'][0]->name }}
                </span>
            </h3>

            <p class="mb-0">{!! nl2br($settings['about'][0]->value) !!}</p>

            <h3 class="text-uppercase text-white mt-10">
                <span class="decorator decorator--right">
                    {{ $settings['mission'][0]->name }}
                </span>
            </h3>

            <p class="mb-0">{!! nl2br($settings['mission'][0]->value) !!}</p>
        </div>

        @if (count($settings['advantages']))
            <div class="w-md-1/2">
                <div class="row">
                    @foreach($settings['advantages'] as $advantage)
                        <div class="column w-md-1/2">
                            <h4>
                                <span class="decorator decorator--right">
                                {{ $advantage['name'] }}
                                </span>
                            </h4>
                            <p>{{ $advantage['value'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </section>

@endsection

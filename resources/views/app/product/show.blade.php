@extends('layouts.app', ['app_title' => $title])

@section('content')

    @if (session()->has('success'))
        <div class="notification notification-success">
            {{ session()->get('success') }}
        </div>
    @endif

    <section class="product flex justify-between">
        <product-slider class="w-lg-1/2" images="{{ $images }}" thumbnails="{{ $thumbnails }}">
            @if ($product->tag)
                <span class="product-tag">{{ App\Models\Product\Product::$TAGS[$product->tag] }}</span>
            @endif
        </product-slider>

        <div class="product-details w-lg-1/2">
            <h1 class="h3 mb-0 text-uppercase">{{ $product->title }}</h1>

            @if ($product->subtitle)
                <p class="text-uppercase smaller text-primary">{{ $product->subtitle }}</p>
            @endif

            <p class="text-muted mt-4 text-uppercase">Артикул № {{ $product->sku }}</p>

            <hr class="my-4">

            @if ($product->description)
                <div class="mb-6">
                    <h4 class="text-uppercase">Описание</h4>
                    {!! $product->description !!}
                </div>
            @endif

            @if (count($characteristics))
                <h4 class="text-uppercase">Характеристики</h4>

                <table class="table product-attributes">
                    @foreach($characteristics as $key => $values)
                        <tr>
                            <td>
                                <strong>{{ $key }}</strong>
                            </td>
                            <td>
                                {{ implode(', ', $values) }}
                            </td>
                        </tr>
                    @endforeach
                </table>
            @endif

            <div class="my-6 text-uppercase text-{{ $product->quantity > 0 ? 'dark text-bold' : 'muted' }}">
                {{ $product->quantity > 0 ? 'Есть' : 'Нет' }} в наличии
            </div>

            @if (count($product->colors))
                <div class="product-colors flex align-center my-6 text-uppercase">
                    <span class="mr-3" style="margin-top: 3px;">Цвет</span>
                    @foreach($product->colors as $color)
                        <div class="{{ !$loop->last ? 'mr-2' : '' }}"
                             style="background-color: {{ $color->value }};"></div>
                    @endforeach
                </div>
            @endif

            <div class="row">
                <div class="column w-xxl-1/2 flex align-center">
                    <span class="mr-3 text-uppercase">Цена</span>
                    <h3 class="mb-0 text-dark product-price">{{ $product->computed_price }} грн</h3>
                </div>
                <div class="column w-xxl-1/2 flex mt-xl-3">
                    <button class="btn btn-danger text-bold mr-1">
                        Быстрая покупка
                    </button>

                    <add-to-cart-button class="btn-secondary ml-1" action="{{ route('app.cart.add', $product) }}">
                        В корзину
                    </add-to-cart-button>
                </div>
            </div>
        </div>
    </section>

    @if (count($product->recommended))
        <section class="recommended mt-10">
            <h4 class="text-white text-uppercase mb-2">Возможно вам будет интересно</h4>

            <div class="products flex">
                @foreach($product->recommended as $product)
                    @include('partials.app.product.single', ['default' => true])
                @endforeach
            </div>
        </section>
    @endif

    @include('partials.app.comment.comments')

@endsection

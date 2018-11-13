@extends('layouts.app', ['app_title' => 'Детали заказа'])

@section('content')

    <section class="checkout-details w-lg-3/4 w-xl-1/2 mx-auto">
        <h1 class="h2 text-center mb-0 text-white">Спасибо!</h1>
        <h4 class="text-center">Ваш заказ принят!</h4>

        <div class="checkout-products">
            <table class="table">
                <tr>
                    <td width="100">
                        <a href="{{ route('app.product.show', $product) }}">
                            <img src="{{ $product->getFirstMediaUrl('product', 'thumb') }}" alt="">
                        </a>
                    </td>
                    <td>
                        <p class="small text-muted mb-1">Название</p>
                        <h6 class="text-uppercase mb-0">
                            <a href="{{ route('app.product.show', $product) }}">{{ $product->title }}</a>
                        </h6>
                        <p class="mb-0 small">Артикул № {{ $product->sku }}</p>
                    </td>
                    <td class="text-right">
                        <p class="small text-muted mb-1">Цена</p>
                        <h6 class="mb-0 no-wrap">
                            {{ $product->computed_price }} грн
                        </h6>
                    </td>
                </tr>
            </table>

            <div class="mt-8 text-center">
                <a href="{{ route('app.product.index') }}" class="btn btn-primary">
                    Вернуться к покупкам
                </a>
            </div>
        </div>
    </section>

@endsection

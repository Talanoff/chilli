@extends('layouts.app', ['app_title' => 'Корзина'])

@section('content')

    <app-cart-total></app-cart-total>

    @if (count($viewed))
        <h3 class="mt-8 text-white text-uppercase">
            Просмотренные товары
        </h3>
        <div class="products flex">
            @foreach($viewed as $product)
                @include('partials.app.product.single', ['default' => true])
            @endforeach
        </div>
    @endif

@endsection

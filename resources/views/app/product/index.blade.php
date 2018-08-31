@extends('layouts.app', ['app_title' => $title])

@section('content')

    <section class="products flex">
        @each('partials.app.product.single', $products, 'product')
    </section>

@endsection

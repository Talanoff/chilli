@extends('layouts.app', ['app_title' => 'Результаты поиска'])

@section('content')

    <section class="products products-list flex">
        @forelse($products as $product)
            @include('partials.app.product.single', ['default' => true])
        @empty
            @include('partials.app.layout.empty')
        @endforelse
    </section>

    {{ $products->appends(request()->except('page'))->links() }}

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

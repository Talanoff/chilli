@extends('layouts.app', ['app_title' => $title])

@section('content')

    <div class="mb-6 text-center none-lg">
        <a href="#filter" class="filter-link filter-link--mobile" ref="filter">
            Фильтр
            <svg width="26" height="26" class="ml-2 filter-icon">
                <use xlink:href="#filter"></use>
            </svg>
        </a>
    </div>

    @include('partials.app.product.filters')

    @if (request()->has('model'))
        <h1 class="h3 text-white">
            @if (request()->has('category'))
                {{ \App\Models\Product\Category::whereSlug(request()->get('category'))->first()->title }}
            @else
                Чехлы
            @endif
            для {{ $series->first()->title }}

            @if (!request()->has('category'))
                и защитные стекла
            @endif
        </h1>
    @endif

    <section class="products products-list flex">
        @if (count($products) || $latest)
            @if (request()->get('page') < 2 && $latest)
                @include('partials.app.product.single', ['large' => true, 'product' => $latest])
            @endif

            @if (count($products))
                @foreach($products as $product)
                    @include('partials.app.product.single')
                @endforeach
            @endif
        @else
            @include('partials.app.layout.empty')
        @endif
    </section>

    {{ $products->appends(request()->except('page'))->links() }}

    @if (request()->has('model') && $series->first()->description)
        <div class="my-8">
            {!! $series->first()->description !!}
        </div>
    @endif

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

@if (request()->get('page') < 2 && $latest)
    @push('scripts')
        <script>
            if (window.innerWidth > 1200) {
                var products = document.querySelectorAll('.products-list .product-item-wrapper');

                if (products.length > 1) {
                    var wrapper = document.createElement('div');
                    wrapper.className = 'w-lg-1/2 flex';

                    products[1].parentNode.insertBefore(wrapper, products[1]);

                    let i = 1;
                    while (i < products.length && i < 5) {
                        wrapper.appendChild(products[i]);
                        i++;
                    }
                }
            }
        </script>
    @endpush
@endif

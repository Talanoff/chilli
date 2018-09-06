@extends('layouts.app', ['app_title' => $title])

@section('content')

    <section class="products products-list flex">
        @if (request()->get('page') < 2 && $latest)
            @include('partials.app.product.single', ['large' => true, 'product' => $latest])
        @endif

        @forelse($products as $product)
            @include('partials.app.product.single')
        @empty
            @include('partials.app.product.empty')
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

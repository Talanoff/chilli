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
                @include('partials.app.product.single', ['related' => true])
            @endforeach
        </div>
    @endif

@endsection

@if (request()->get('page') < 2)
    @push('scripts')
        <script>
            if (window.innerWidth > 1200) {
                var products = document.querySelectorAll('.products-list .product-item-wrapper');

                if (products.length) {
                    var wrapper = document.createElement('div');
                    wrapper.className = 'w-lg-1/2 flex';

                    products[1].parentNode.insertBefore(wrapper, products[1]);
                    wrapper.appendChild(products[1]);
                    wrapper.appendChild(products[2]);
                    wrapper.appendChild(products[3]);
                    wrapper.appendChild(products[4]);
                }
            }
        </script>
    @endpush
@endif

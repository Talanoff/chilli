@extends('layouts.app', ['app_title' => 'Главная'])

@section('content')

    <section class="products flex">
        @forelse($products as $product)
            @if ($loop->index === 0)
                @include('partials.app.product.promo', ['classes' => 'w-md-1/2 w-xl-2/3', 'large' => true])
            @endif
        @empty
            <div class="w-1">
                Продукты пока не добавлены...
            </div>
        @endforelse
    </section>

@endsection

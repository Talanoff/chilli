@extends('layouts.app', ['app_title' => $title])

@section('content')

    @if (session()->has('success'))
        <div class="notification notification-success">
            {{ session()->get('success') }}
        </div>
    @endif

    <section class="product flex justify-between">
        <product-slider class="w-lg-1/2" images="{{ $images }}" thumbnails="{{ $thumbnails }}"></product-slider>

        <div class="product-details w-lg-1/2">
            <h1 class="h3 mb-0 text-uppercase">{{ $product->title }}</h1>

            @if ($product->subtitle)
                <p class="text-uppercase smaller text-primary">{{ $product->subtitle }}</p>
            @endif

            <p class="text-muted mt-4 text-uppercase">артикул № {{ $product->sku }}</p>

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
                    @include('partials.app.product.single', ['related' => true])
                @endforeach
            </div>
        </section>
    @endif

    <section class="comments mt-10">
        <h4 class="text-white text-uppercase mb-2">Отзывы</h4>

        <div class="mb-4 flex align-center">
            @include('partials.app.product.stars', ['stars' => $product->stars])
            <span class="text-uppercase smaller">
                {{ count($product->comments) }}
                {{ count($product->comments) === 1 ? 'отзыв' : count($product->comments) > 1 && count($product->comments) < 4 ? 'отзыва' : 'отзывов' }}
            </span>
        </div>

        @forelse($product->comments as $comment)
            <div class="comments-item">
                <div class="row">
                    <div class="column">
                        <h6 class="text-uppercase text-white no-wrap">{{ $comment->user->name }}</h6>
                        {{ nl2br($comment->message) }}
                    </div>
                    <div class="column-auto smaller text-uppercase">
                        {{ $comment->created_at->formatLocalized('%d %B %Y') }}
                        <div class="mt-2">
                            @include('partials.app.product.stars', ['stars' => $comment->user->productRating($product)])
                        </div>
                    </div>
                </div>
            </div>
        @empty
            Отзывов пока нет... Будьте первым!
        @endforelse
    </section>

    <section class="leave-comment mt-10">
        <h4 class="text-white text-uppercase mb-2">Оставить отзыв</h4>

        <form action="{{ route('app.product.comment', $product) }}" class="w-lg-50" method="post">
            @csrf

            @guest
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <input type="text" name="name" class="form-control"
                           placeholder="Ваше имя" value="{{ old('name') }}" required>
                    <div class="small text-danger">
                        {{ $errors->has('name') ? $errors->get('name')[0] : '' }}
                    </div>
                </div>

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <input type="text" name="email" class="form-control"
                           placeholder="E-mail" value="{{ old('email') }}" required>
                    <div class="small text-danger">
                        {{ $errors->has('email') ? $errors->get('email')[0] : '' }}
                    </div>
                </div>
            @endguest

            <div class="form-group{{ $errors->has('message') ? ' has-error' : '' }}">
                <textarea name="message" class="form-control"
                          placeholder="Сообщение" required>{{ old('message') }}</textarea>
                <div class="small text-danger">
                    {{ $errors->has('message') ? $errors->get('message')[0] : '' }}
                </div>
            </div>

            <div class="row">
                <div class="column">
                    <star-rating old="{{ old('rating') }}"></star-rating>

                    <label class="small flex">
                        <input type="checkbox" name="confirmation" required>
                        <span class="ml-1">Отправляя отзыв, вы соглашаетесь с правилами модерации</span>
                    </label>
                </div>
                <div class="column-auto">
                    <button class="btn btn-primary">
                        Оставить отзыв
                    </button>
                </div>
            </div>
        </form>
    </section>

@endsection

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

            <div class="product-shared">
                <add-to-favourites-button product="{{ $product->slug }}"></add-to-favourites-button>
            </div>
        </product-slider>

        <div class="product-details w-lg-1/2">
            <h1 class="h3 mb-0 text-uppercase">{{ $product->title }}</h1>

            @if ($product->subtitle)
                <p class="text-uppercase smaller text-primary">{{ $product->subtitle }}</p>
            @endif

            <p class="text-muted mt-4 text-uppercase">Артикл № {{ $product->sku }}</p>

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

            <div class="my-6 text-uppercase text-bold text-{{ $product->quantity > 0 ? 'dark' : 'danger' }}">
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
                    <h3 class="mb-0 {{ $product->quantity < 1 ? 'text-muted' : 'text-dark' }} product-price">{{ $product->computed_price }}
                        грн</h3>
                </div>
                <div class="column w-xxl-1/2 flex mt-xl-3">
                    @if ($product->quantity)
                        <fast-buy opened="{{ count($errors) }}">
                            <form action="{{ route('app.product.fast-buy', $product) }}" method="post">
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
                                        <input type="email" name="email" class="form-control"
                                               placeholder="E-mail" value="{{ old('email') }}" required>
                                        <div class="small text-danger">
                                            {{ $errors->has('email') ? $errors->get('email')[0] : '' }}
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                                        <input type="tel" name="phone" class="form-control"
                                               placeholder="Телефон" value="{{ old('phone') }}" required>
                                        <div class="small text-danger">
                                            {{ $errors->has('phone') ? $errors->get('phone')[0] : '' }}
                                        </div>
                                    </div>
                                @else
                                    <h5 class="text-uppercase">
                                        Быстрая покупка
                                    </h5>

                                    <p>Вы авторизированы, как {{ auth()->user()->name }}. Для оформления заказа будут
                                        использованы Ваши контактные данные.</p>

                                    <button class="btn btn-secondary">Продолжить</button>
                                @endguest
                            </form>
                        </fast-buy>

                        <add-to-cart-button
                            class="btn-secondary ml-1"
                            action="{{ route('app.cart.add', $product) }}">
                            В корзину
                        </add-to-cart-button>
                    @else
                        @if (auth()->check() && !auth()->user()->notifications()->count())
                            <form action="{{ route('app.notification.add', $product) }}" method="post">
                                @csrf

                                @guest
                                    <div class="form-group{{ $errors->has('email') ? ' is-invalid' : '' }}">
                                        <label for="email">Ваше e-mail</label>
                                        <input type="text" class="form-control" id="email" name="email"
                                               value="{{ old('email') }}" required>
                                        @if($errors->has('email'))
                                            <div class="mt-1 text-danger">
                                                {{ $errors->first('email') }}
                                            </div>
                                        @endif
                                    </div>
                                @endguest

                                <button class="btn btn-primary">Уведомить о наличии</button>
                            </form>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </section>

    @if (count($product->kits))
        <h4 class="text-white text-uppercase text-center mt-10 mb-2">Вместе дешевле</h4>

        </div><!-- .container -->

        <section id="kits">
            <div class="container">
                <kits-carousel
                    kits="{{ json_encode(\App\Http\Resources\KitResource::collection($product->kits)) }}"></kits-carousel>
            </div>
        </section>

        <div class="container">
            @endif

            @if ($product->review)
                <section class="reviews reviews--single">
                    @include('partials.app.review.promo', ['review' => $product->review])
                </section>
    @endif

    @include('partials.app.product.recommended', ['recommended' => $product->recommended])
    @include('partials.app.comment.product')

@endsection

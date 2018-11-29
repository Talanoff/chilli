@extends('layouts.app', ['app_title' => 'Оформление заказа'])

@section('content')

    <section class="checkout">
        <div class="row">
            <div class="column w-md-2/3">
                <form action="{{ route('app.checkout.store') }}" method="post">
                    @csrf

                    @guest
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <input type="text" name="name" class="form-control"
                                   placeholder="Ваше имя" value="{{ old('name') }}" required>
                            <div class="small text-danger">
                                {{ $errors->has('name') ? $errors->get('name')[0] : '' }}
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                            <input type="tel" name="phone" class="form-control"
                                   placeholder="Телефон" value="{{ old('phone') }}" required>
                            <div class="small text-danger">
                                {{ $errors->has('phone') ? $errors->get('phone')[0] : '' }}
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <input type="email" name="email" class="form-control"
                                   placeholder="E-mail (не обязательно)" value="{{ old('email') }}">
                            <div class="small text-danger">
                                {{ $errors->has('email') ? $errors->get('email')[0] : '' }}
                            </div>
                        </div>
                    @else
                        <h3>Добрый день, {{ auth()->user()->name }}!</h3>
                    @endguest

                    <div class="form-group">
                        <label for="payment">Форма оплаты</label>
                        <select name="payment" id="payment" class="form-control" required>
                            @foreach(App\Models\Order\Order::$PAYMENT as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>

                    <checkout params="{{ json_encode(App\Models\Order\Order::$DELIVERY) }}"></checkout>
                </form>
            </div>

            <div class="column w-md-1/3 checkout-products">
                <h6 class="text-uppercase">В корзине:</h6>

                @include('partials.app.checkout.products', ['size' => 80])

                <div class="text-center">
                    <a href="{{ route('app.cart.index') }}" class="btn btn-secondary">
                        Редактировать заказ
                    </a>
                </div>
            </div>
        </div>
    </section>

@endsection

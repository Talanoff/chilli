@extends('layouts.auth')

@section('content')

    <form method="POST" action="{{ route('register') }}" class="auth-form">
        @csrf

        <div class="form-group">
            <label for="name">Ваше имя</label>

            <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                   name="name" value="{{ old('name') }}"
                   placeholder="Сергей Иванов" required autofocus>

            @if ($errors->has('name'))
                <div class="small text-danger" role="alert">
                    <strong>{{ $errors->first('name') }}</strong>
                </div>
            @endif
        </div>

        <div class="form-group">
            <label for="email">E-mail</label>

            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                   name="email" value="{{ old('email') }}"
                   placeholder="email@gmail.com" required>

            @if ($errors->has('email'))
                <div class="small text-danger" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </div>
            @endif
        </div>

        <div class="form-group">
            <label for="phone">Телефон</label>

            <input id="phone" type="tel" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}"
                   name="phone" value="{{ old('phone') }}"
                   placeholder="+380 (___) ___-__-__" required>

            @if ($errors->has('phone'))
                <div class="small text-danger" role="alert">
                    <strong>{{ $errors->first('phone') }}</strong>
                </div>
            @endif
        </div>

        <div class="form-group row">
            <div class="column w-100 w-lg-1/2">
                <label for="password">Пароль</label>

                <input id="password" type="password"
                       class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                       name="password" value="{{ old('password') }}" required>

                @if ($errors->has('password'))
                    <div class="small text-danger" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </div>
                @endif
            </div>
            <div class="column w-100 w-lg-1/2 mt-4 mt-lg-0">
                <label for="password-confirm">Повторите пароль</label>

                <input id="password-confirm" type="password"
                       class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}"
                       name="password_confirmation" value="{{ old('password_confirmation') }}" required>

                @if ($errors->has('password_confirmation'))
                    <div class="small text-danger" role="alert">
                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                    </div>
                @endif
            </div>
        </div>

        <div class="form-group mt-6 mb-0">
            <button type="submit" class="btn btn-primary">
                Регистрация
            </button>
        </div>
    </form>

    <div class="mt-10">
        <h4 class="flex align-center mb-0">
            <span class="mr-4">Уже есть аккаунт?</span>
            <a href="{{ route('login') }}" class="btn btn-secondary">
                Войти
            </a>
        </h4>
    </div>

@endsection

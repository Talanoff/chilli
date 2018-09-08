@extends('layouts.auth')

@section('content')

    <form method="POST" action="{{ route('login') }}" class="auth-form">
        @csrf

        <div class="form-group">
            <label for="email">E-Mail</label>

            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                   name="email" value="{{ old('email') }}" required autofocus>

            @if ($errors->has('email'))
                <div class="small text-danger" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </div>
            @endif
        </div>

        <div class="form-group">
            <label for="password">Пароль</label>

            <input id="password" type="password"
                   class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

            @if ($errors->has('password'))
                <div class="small text-danger" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </div>
            @endif
        </div>

        <div class="form-group">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember"
                       id="remember" {{ old('remember') ? 'checked' : '' }}>

                <label class="form-check-label" for="remember">
                    Запомнить меня
                </label>
            </div>
        </div>

        <div class="form-group mb-0">
            <button type="submit" class="btn btn-primary">
                Войти
            </button>

            <a class="btn btn-link smaller" href="{{ route('password.request') }}">
                Забыли пароль?
            </a>
        </div>
    </form>

    <div class="mt-10">
        <h4 class="flex align-center mb-0">
            <span class="mr-4">Еще нет аккаунта?</span>
            <a href="{{ route('register') }}" class="btn btn-secondary">
                Регистрация
            </a>
        </h4>
    </div>

@endsection

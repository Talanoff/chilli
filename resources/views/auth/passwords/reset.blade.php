@extends('layouts.auth')

@section('content')
    <form method="POST" action="{{ route('password.request') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="form-group row">
            <label for="email">E-mail</label>

            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                   name="email" value="{{ old('email') }}"
                   placeholder="email@gmail.com" required autofocus>

            @if ($errors->has('email'))
                <div class="small text-danger" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
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

        <div class="form-group mb-0 mt-6">
            <button type="submit" class="btn btn-primary">
                Сбросить пароль
            </button>
        </div>
    </form>
@endsection

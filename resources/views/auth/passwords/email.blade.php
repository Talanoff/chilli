@extends('layouts.auth')

@section('content')

    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="form-group">
            <label for="email">E-mail аккаунта, для сброса пароля</label>

            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                   name="email" value="{{ old('email') }}"
                   placeholder="email@gmail.com" required>

            @if ($errors->has('email'))
                <div class="small text-danger" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </div>
            @endif
        </div>

        <div class="form-group mb-0 mt-6">
            <button type="submit" class="btn btn-primary">
                Отправить ссылку
            </button>
        </div>
    </form>
@endsection

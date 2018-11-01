@extends('layouts.app', ['app_title' => 'Профиль'])

@section('content')

    <section class="profile py-6 w-lg-3/4 w-xl-1/2 mx-auto">
        <h1 class="h3">Редактирование профиля</h1>

        <form action="{{ route('app.profile.update') }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('patch')

            <div class="form-group">
                <label for="name">Имя</label>

                <input id="name" type="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                       name="name" value="{{ old('name') ?? $user->name }}"
                       placeholder="Ваше имя" required>

                @if ($errors->has('name'))
                    <div class="small text-danger" role="alert">
                        <strong>{{ $errors->first('name') }}</strong>
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="phone">Телефон</label>

                <input id="phone" type="tel" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}"
                       name="phone" value="{{ old('phone') ?? $user->phone }}"
                       placeholder="+38 (___) ___-__-__" required>

                @if ($errors->has('phone'))
                    <div class="small text-danger" role="alert">
                        <strong>{{ $errors->first('phone') }}</strong>
                    </div>
                @endif
            </div>

            <birth-day stored-date="{{ $user->birthday }}"></birth-day>

            <button class="btn btn-primary mt-5">
                Обновить
            </button>
        </form>
    </section>

@endsection

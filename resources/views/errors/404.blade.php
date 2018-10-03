@extends('layouts.simple', ['app_title' => 'Ошибка'])

@section('content')

    <section class="errors mihv-100 flex flex-column justify-center">
        <div class="text-center">
            <p><img src="{{ asset('images/logo-gray.png') }}" alt="404"></p>
            <h1>Упс... Пока не созрело...</h1>
            <a href="{{ url()->previous() ?? route('app.home') }}" class="btn btn-primary">Вернуться на сайт</a>
        </div>
    </section>

@endsection

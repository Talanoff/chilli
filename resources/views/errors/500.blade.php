@extends('layouts.simple', ['app_title' => 'Ошибка'])

@section('content')

    <section class="errors mihv-100 flex flex-column justify-center">
        <div class="text-center">
            <h1>Что-то пошло не так...</h1>
            <a href="{{ url()->previous() ?? route('app.home') }}" class="btn btn-primary">Вернуться на сайт</a>
        </div>
    </section>

@endsection

@extends('layouts.admin', ['app_title' => 'Подписки'])

@section('content')

    <section class="content">
        <h1 class="mb-5 h2 d-flex align-items-center">
            Подписки
        </h1>

        @forelse($subscribes as $subscribe)
            <div class="{{ !$loop->last ? 'mb-5' : '' }}">
                <h4>Список №{{ $loop->iteration }}</h4>
                {{ implode(', ', $subscribe) }}
            </div>
        @empty
            <p class="mb-0"><em>Подписок пока нет.</em></p>
        @endforelse
    </section>

@endsection

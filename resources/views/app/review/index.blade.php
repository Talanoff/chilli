@extends('layouts.app', ['app_title' => 'Обзоры'])

@section('content')

    <section class="reviews">
        @forelse($reviews as $review)
            <a href="{{ route('app.review.show', $review) }}">
                {{ $review->title }}
            </a>
        @empty
            @include('partials.app.layout.empty')
        @endforelse
    </section>

@endsection

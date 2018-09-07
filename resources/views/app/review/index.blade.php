@extends('layouts.app', ['app_title' => 'Обзоры'])

@section('content')

    @forelse($reviews as $review)
        <a href="{{ route('app.review.show', $review) }}">
            {{ $review->title }}
        </a>
    @empty
    @endforelse

@endsection

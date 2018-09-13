@extends('layouts.app', ['app_title' => $review->title])

@section('meta')
    @include('partials.app.meta.meta', ['image' => $review->thumbnail])
@endsection

@section('content')

    <section class="review">
        @if ($review->video_url)
            <iframe width="1140" height="641.25"
                    src="https://www.youtube.com/embed/{{ $review->video_id }}?color=white&rel=0"
                    frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
        @elseif($review->hasMedia('review'))
            <img src="{{ $review->getFirstMediaUrl('review') }}" alt="{{ $review->title }}">
        @endif

        <div class="review-entry my-10">
            <h1 class="h3 text-uppercase text-white">
                <span class="decorator decorator--right">{{ $review->title }}</span>
            </h1>

            {!! $review->description !!}
        </div>
    </section>

    @include('partials.app.product.recommended')
    @include('partials.app.comment.review')

@endsection

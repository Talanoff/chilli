@extends('layouts.app', ['app_title' => $review->title])

@section('content')

    <section class="review">
        <iframe width="1140" height="641.25"
                src="https://www.youtube.com/embed/{{ $review->video_id }}?color=white&rel=0"
                frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
    </section>

    @include('partials.app.comment.review')

@endsection

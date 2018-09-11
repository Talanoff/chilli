@extends('layouts.app', ['app_title' => 'Обзоры'])

@section('content')

    <section class="reviews flex">
        @forelse($reviews as $review)
            @if (request()->get('page') < 2)
                @if ($loop->index === 1)
                    <div class="w-md-1 w-lg-1/3 flex">@endif
                        @if ($loop->index === 3)</div>@endif
            @endif

            @include('partials.app.review.item', ['large' => $loop->index === 0])
        @empty
            @include('partials.app.layout.empty')
        @endforelse
    </section>

    {{ $reviews->appends(request()->except('page'))->links() }}

@endsection

@extends('layouts.app', ['app_title' => 'Избранное'])

@section('content')

    @if (session()->has('success'))
        <div class="notification notification-success">
            {{ session()->get('success') }}
        </div>
    @endif

    <section class="favourites">
        @if (count($favourites))
            <favourites-list></favourites-list>
        @else
            @include('partials.app.layout.empty')
        @endif
    </section>

@endsection

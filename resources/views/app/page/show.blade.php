@extends('layouts.app', ['app_title' => $page->title])

@section('content')

    <section class="page py-6">
        <h1 class="h3 text-uppercase text-white">
            <span class="decorator decorator--right">{{ $page->title }}</span>
        </h1>

        {!! $page->body !!}
    </section>

@endsection

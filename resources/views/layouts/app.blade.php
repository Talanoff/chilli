<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Chilli') . (isset($app_title) ? ' | ' . $app_title : '') }}</title>

    @yield('meta')

    <link rel="stylesheet" href="{{ asset('css/loader.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="canonical" href="{{ url()->current() }}"/>
</head>
<body>
@include('partials.app.layout.loader')

<div id="app" v-cloak>
    @include('partials.app.layout.svg')
    @include('partials.app.layout.header')

    <main>
        <div class="container position-relative">
            @include('partials.app.layout.aside-left')
            @include('partials.app.product.filters')
            @yield('content')
            @include('partials.app.layout.aside-right')
        </div>
    </main>

    @include('partials.app.layout.footer')
</div>

<script src="{{ asset('js/app.js') }}" defer></script>
@stack('scripts')
</body>
</html>

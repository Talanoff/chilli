<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Chilli') . (isset($app_title) ? ' | ' . $app_title : '') }}</title>

    <link rel="stylesheet" href="{{ asset('css/loader.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="canonical" href="{{ url()->current() }}"/>

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/favicons/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicons/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('images/favicons/site.webmanifest') }}">
    <link rel="mask-icon" href="{{ asset('images/favicons/safari-pinned-tab.svg') }}" color="#5bbad5">
    <link rel="shortcut icon" href="{{ asset('images/favicons/favicon.ico') }}">
    <meta name="msapplication-TileColor" content="#ffc40d">
    <meta name="msapplication-config" content="{{ asset('images/favicons/browserconfig.xml') }}">
    <meta name="theme-color" content="#1d2024">
    @include('partials.app.meta.meta')
</head>
<body>
@include('partials.app.layout.loader')

<div id="app" v-cloak>
    @include('partials.app.layout.svg')
    @include('partials.app.layout.header')

    <main>
        <div class="container position-relative">
            @include('partials.app.layout.aside-left')
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

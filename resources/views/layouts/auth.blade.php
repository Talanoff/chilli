<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Chilli') . (isset($app_title) ? ' | ' . $app_title : '') }}</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    @include('partials.app.layout.svg')

    <main>

        <div class="flex mihv-100 position-relative">
            <a href="{{ route('app.home') }}" class="auth-logo">
                <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }}">
            </a>
            <div class="w-md-1/2 flex flex-column justify-center auth-container">
                <section class="auth container">
                    @yield('content')
                </section>
            </div>
            <div class="w-md-1/2"
                 style="background: url({{ asset('images/auth/' . rand(1,3) .'.jpg') }}) 50% 50% / cover no-repeat;"></div>
        </div>

    </main>
</div>

<script src="{{ asset('js/app.js') }}" defer></script>
@stack('scripts')
</body>
</html>
